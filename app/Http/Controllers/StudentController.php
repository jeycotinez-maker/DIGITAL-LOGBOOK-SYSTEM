<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
class StudentController extends Controller {
    public function index(Request $request) {
        $students = User::where('role','student')->when($request->filled('q'),fn($q)=>$q->where(fn($s)=>$s->where('name','like','%'.$request->q.'%')->orWhere('pn_id',$request->q)))
            ->when($request->filled('batch'),fn($q)=>$q->where('batch_year',$request->batch))
            ->orderBy('batch_year')->orderBy('name')->paginate(20)->withQueryString();
        return view('students.index',compact('students'));
    }
    public function show(User $user) {
        abort_unless($user->role === 'student',404);
        $records = $user->attendances()->latest('date')->paginate(15);
        return view('students.show',compact('user','records'));
    }
}
