<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class SystemController extends Controller
{
    public function database()
    {
        $connection = DB::connection();
        $tables = collect(Schema::getTableListing())->map(fn (string $table) => [
            'name' => $table,
            'rows' => DB::table($table)->count(),
        ]);
        $databaseName = str_replace('\\', '/', $connection->getDatabaseName());

        return view('system.database', [
            'driver' => $connection->getDriverName(),
            'databaseName' => basename($databaseName),
            'serverVersion' => $connection->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION),
            'tables' => $tables,
        ]);
    }

    public function logs(Request $request)
    {
        $filters = $request->validate([
            'action' => 'nullable|string|max:80',
        ]);

        $logs = AuditLog::with('user')
            ->when($filters['action'] ?? null, fn ($query, $action) => $query->where('action', $action))
            ->latest()
            ->paginate(20)
            ->withQueryString();
        $actions = AuditLog::query()->distinct()->orderBy('action')->pluck('action');

        return view('system.logs', compact('logs', 'actions'));
    }

    public function backups()
    {
        return view('system.backups', [
            'supported' => DB::connection()->getDriverName() === 'sqlite',
        ]);
    }

    public function downloadBackup()
    {
        abort_unless(DB::connection()->getDriverName() === 'sqlite', 501, 'Database backups are currently supported for SQLite only.');

        $filename = 'smartlog-backup-'.now()->format('Ymd-His-u').'.sqlite';
        $path = storage_path('app/backups/'.$filename);
        File::ensureDirectoryExists(dirname($path));

        $quotedPath = "'".str_replace("'", "''", $path)."'";
        DB::statement('VACUUM INTO '.$quotedPath);

        return response()->download($path, $filename, ['Content-Type' => 'application/vnd.sqlite3'])
            ->deleteFileAfterSend();
    }

    public function security()
    {
        $debugEnabled = (bool) config('app.debug');
        $sessionDriver = (string) config('session.driver');
        $hasAppKey = filled(config('app.key'));

        $checks = [
            [
                'label' => 'Application encryption key',
                'ok' => $hasAppKey,
                'detail' => $hasAppKey ? 'Configured' : 'Missing',
            ],
            [
                'label' => 'Debug mode',
                'ok' => !$debugEnabled,
                'detail' => $debugEnabled ? 'Enabled; disable before production' : 'Disabled',
            ],
            [
                'label' => 'Session storage',
                'ok' => $sessionDriver !== 'array',
                'detail' => ucfirst($sessionDriver).' driver',
            ],
            [
                'label' => 'Administrative pages',
                'ok' => true,
                'detail' => 'Restricted to authenticated administrators',
            ],
        ];

        return view('system.security', compact('checks'));
    }
}
