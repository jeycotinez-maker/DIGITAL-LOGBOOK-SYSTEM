<?php
namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AttendanceController extends Controller {
    public function mine(Request $request) {
        $user = $request->user();
        abort_unless($user instanceof User, 401);
        $records = $user->attendances()->when($request->filled('date'), fn($q)=>$q->whereDate('date',$request->date))->latest('date')->paginate(15);
        return view('attendance.mine', compact('records'));
    }
    public function timeIn(Request $request) {
        $actor = $request->user();
        abort_unless($actor instanceof User, 401);
        $actorId = $actor->getAuthIdentifier();
        $data = $request->validate(['pn_id'=>'nullable|string','remarks'=>'nullable|string|max:250']);
        $target = $actor->isStaff() && $request->filled('pn_id') ? User::where('pn_id',$data['pn_id'])->where('role','student')->firstOrFail() : $actor;
        DB::transaction(function () use ($target,$data,$actorId) {
            $open = Attendance::where('student_id',$target->getKey())->whereNull('time_out')->lockForUpdate()->first();
            if ($open) abort(422, 'This scholar already has an open attendance session. Record Time Out first.');
            $row = Attendance::create(['student_id'=>$target->getKey(),'date'=>now()->toDateString(),'time_in'=>now(),'status'=>'inside','time_in_by'=>$actorId,'remarks'=>$data['remarks'] ?? null]);
            AuditLog::create(['user_id'=>$actorId,'action'=>'time_in','target_type'=>'attendance','target_id'=>$row->getKey(),'details'=>['student'=>$target->pn_id]]);
        });
        return back()->with('success','Time In recorded successfully.');
    }
    public function timeOut(Request $request) {
        $actor = $request->user();
        abort_unless($actor instanceof User, 401);
        $actorId = $actor->getAuthIdentifier();
        $data = $request->validate(['pn_id'=>'nullable|string']);
        $target = $actor->isStaff() && $request->filled('pn_id') ? User::where('pn_id',$data['pn_id'])->where('role','student')->firstOrFail() : $actor;
        $row = Attendance::where('student_id',$target->getKey())->whereNull('time_out')->latest('time_in')->first();
        if (!$row) return back()->withErrors(['attendance'=>'No open Time In record was found.']);
        $row->update(['time_out'=>now(),'status'=>'outside','time_out_by'=>$actorId]);
        AuditLog::create(['user_id'=>$actorId,'action'=>'time_out','target_type'=>'attendance','target_id'=>$row->getKey(),'details'=>['student'=>$target->pn_id]]);
        return back()->with('success','Time Out recorded successfully.');
    }
    public function index(Request $request) {
        $records = Attendance::with('student')->when($request->filled('date'),fn($q)=>$q->whereDate('date',$request->date))
            ->when($request->filled('q'),fn($q)=>$q->whereHas('student',fn($s)=>$s->where('name','like','%'.$request->q.'%')->orWhere('pn_id',$request->q)))
            ->latest('time_in')->paginate(20)->withQueryString();
        return view('attendance.index',compact('records'));
    }
}
