<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
class DashboardController extends Controller {
    public function index() {
        $role = auth()->user()->role;
        return redirect()->route('dashboard.role', ['role'=>$role]);
    }
    public function show(string $role) {
        abort_unless(auth()->user()->role === $role || (auth()->user()->role === 'admin' && $role === 'staff'), 403);
        $today = now()->toDateString();
        $stats = [
            'students'=>User::where('role','student')->count(),
            'inside'=>Attendance::whereDate('date',$today)->whereNull('time_out')->count(),
            'today'=>Attendance::whereDate('date',$today)->count(),
            'completed'=>Attendance::whereDate('date',$today)->whereNotNull('time_out')->count()
        ];
        $recent = Attendance::with('student')->latest('time_in')->limit(8)->get();
        $myRecent = auth()->user()->attendances()->latest('date')->limit(8)->get();
        return view('dashboards.'.$role, compact('stats','recent','myRecent'));
    }
}
