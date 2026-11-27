<?php
namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard.role', ['role' => auth()->user()->role]);
    }

    public function show(Request $request, string $role)
    {
        $user = $request->user();
        abort_unless($user->role === $role || ($user->role === 'admin' && $role === 'staff'), 403);

        if ($role === 'student') {
            // Turn each trip into separate OUT / IN events, newest first (the mockup lists them this way).
            $events = $user->attendances()->latest('time_out')->limit(3)->get()
                ->flatMap(fn ($a) => array_filter([
                    $a->time_in ? ['type' => 'IN', 'at' => $a->time_in] : null,
                    $a->time_out ? ['type' => 'OUT', 'at' => $a->time_out] : null,
                ]))
                ->sortByDesc('at')->take(3)->values();

            return view('dashboards.student', ['events' => $events]);
        }

        if ($role === 'admin') {
            return $this->adminDashboard($request);
        }

        $date    = $request->input('date', today()->toDateString());
        $isToday = $date === today()->toDateString();

        $students = User::where('role', 'student')
            ->with(['attendances' => fn ($q) => $q->where('date', $date)->orderBy('time_in')])
            ->orderBy('batch_year')->orderBy('block_section')
            ->orderBy('name')
            ->get();

        $grouped = $students->groupBy(['batch_year', 'block_section']);

        // Each student falls into exactly one group for the selected date.
        $stats = ['students' => $students->count(), 'logged' => 0, 'not_returned' => 0, 'no_logbook' => 0];
        foreach ($students as $s) {
            $latest = $s->attendances->last();
            if (!$latest) {
                $stats['no_logbook']++;
            } elseif (!$latest->time_out) {
                $stats['not_returned']++;
            } else {
                $stats['logged']++;
            }
        }

        return view('dashboards.'.$role, compact('grouped', 'stats', 'date', 'isToday'));
    }

    private function adminDashboard(Request $request)
    {
        $filters = $request->validate([
            'q' => 'nullable|string|max:120',
            'batch' => 'nullable|string|max:4',
            'section' => 'nullable|string|max:40',
            'status' => 'nullable|in:inside,outside,not_logged_in',
        ]);

        $studentsQuery = User::where('role', 'student');
        $totalStudents = (clone $studentsQuery)->count();
        $inside = (clone $studentsQuery)->whereHas('latestAttendance', fn ($query) => $query->whereNull('time_out'))->count();
        $outside = (clone $studentsQuery)->whereHas('latestAttendance', fn ($query) => $query->whereNotNull('time_out'))->count();
        $notLoggedIn = max(0, $totalStudents - $inside - $outside);

        $query = (clone $studentsQuery)->with(['latestAttendance', 'latestTimeOut']);
        if (!empty($filters['q'])) {
            $query->where(fn ($studentQuery) => $studentQuery
                ->where('name', 'like', '%'.$filters['q'].'%')
                ->orWhere('pn_id', 'like', '%'.$filters['q'].'%'));
        }
        if (!empty($filters['batch'])) {
            $query->where('batch_year', $filters['batch']);
        }
        if (!empty($filters['section'])) {
            $query->where('block_section', $filters['section']);
        }
        if (($filters['status'] ?? null) === 'inside') {
            $query->whereHas('latestAttendance', fn ($attendanceQuery) => $attendanceQuery->whereNull('time_out'));
        } elseif (($filters['status'] ?? null) === 'outside') {
            $query->whereHas('latestAttendance', fn ($attendanceQuery) => $attendanceQuery->whereNotNull('time_out'));
        } elseif (($filters['status'] ?? null) === 'not_logged_in') {
            $query->whereDoesntHave('latestAttendance');
        }

        $students = $query->orderBy('batch_year')->orderBy('block_section')->orderBy('name')->paginate(10)->withQueryString();
        $now = now();
        $students->getCollection()->transform(function (User $student) use ($now) {
            $latest = $student->latestAttendance;
            $lastTimeOut = $student->latestTimeOut?->time_out;
            $status = !$latest ? 'not_logged_in' : ($latest->time_out ? 'outside' : 'inside');
            $durationMinutes = null;

            if ($status === 'outside' && $lastTimeOut) {
                $durationMinutes = intdiv(abs($now->getTimestamp() - $lastTimeOut->getTimestamp()), 60);
            }

            $student->setAttribute('dashboard_status', $status);
            $student->setAttribute('dashboard_time_out', $lastTimeOut);
            $student->setAttribute('dashboard_duration', $durationMinutes === null ? '—' : $this->formatDuration($durationMinutes));

            return $student;
        });

        $batches = (clone $studentsQuery)->whereNotNull('batch_year')->distinct()->orderBy('batch_year')->pluck('batch_year');
        $sections = (clone $studentsQuery)->whereNotNull('block_section')->distinct()->orderBy('block_section')->pluck('block_section');
        $activity = AuditLog::with('user')->latest()->limit(5)->get();
        $databaseConnection = DB::connection();
        $databaseHealthy = $databaseConnection->getPdo() !== null;

        return view('dashboards.admin', compact(
            'students',
            'totalStudents',
            'inside',
            'outside',
            'notLoggedIn',
            'batches',
            'sections',
            'activity',
            'databaseHealthy'
        ));
    }

    private function formatDuration(int $minutes): string
    {
        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        if ($hours > 0 && $remainingMinutes > 0) {
            return $hours.'h '.$remainingMinutes.'m';
        }

        return $hours > 0 ? $hours.'h' : $remainingMinutes.'m';
    }
}