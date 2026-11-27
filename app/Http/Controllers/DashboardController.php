<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
                    ['type' => 'OUT', 'at' => $a->time_out],
                ]))
                ->sortByDesc('at')->take(3)->values();

            return view('dashboards.student', ['events' => $events]);
        }

        $date    = $request->input('date', today()->toDateString());
        $isToday = $date === today()->toDateString();

        // 2 queries in total: all students + all of their records for the chosen date.
        $students = User::where('role', 'student')->where('status', 'active')
            ->with(['attendances' => fn ($q) => $q->where('date', $date)->orderBy('time_out')])
            ->orderBy('batch_year')->orderBy('block_section')
            ->orderBy('last_name')->orderBy('first_name')->orderBy('middle_name')
            ->get();

        $grouped = $students->groupBy(['batch_year', 'block_section']);

        // Each student falls into exactly one group for the selected date.
        $stats = ['students' => $students->count(), 'logged' => 0, 'not_returned' => 0, 'no_logbook' => 0];
        foreach ($students as $s) {
            if ($s->attendances->isEmpty())                             $stats['no_logbook']++;
            elseif ($s->attendances->contains(fn ($a) => !$a->time_in)) $stats['not_returned']++;
            else                                                        $stats['logged']++;
        }

        return view('dashboards.'.$role, compact('grouped', 'stats', 'date', 'isToday'));
    }
}