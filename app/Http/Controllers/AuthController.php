<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
class AuthController extends Controller {
    public function roles(string $mode) { return view('auth.roles', compact('mode')); }
    public function showLogin(?string $role = null) { return view('auth.login', compact('role')); }
    public function showRegister() { return view('auth.register'); }
    public function login(Request $request) {
        $data = $request->validate(['identity'=>'required|string','password'=>'required|string','role'=>'nullable|in:student,staff,admin']);
        $field = filter_var($data['identity'], FILTER_VALIDATE_EMAIL) ? 'email' : 'pn_id';
        $credentials = [$field => $data['identity'], 'password'=>$data['password']];
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['identity'=>'The supplied credentials do not match our records.'])->onlyInput('identity');
        }
        $request->session()->regenerate();
        if (!empty($data['role']) && Auth::user()->role !== $data['role']) {
            Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
            return back()->withErrors(['identity'=>'This account does not belong to the selected role.']);
        }
        return redirect()->intended(route('dashboard'));
    }
    public function register(Request $request) {
        $data = $request->validate([
            'name'=>'required|string|min:3|max:120',
            'email'=>'required|email:rfc,dns|max:190|unique:users,email',
            'password'=>['required','confirmed',Password::min(8)->letters()->numbers()],
            'batch_year'=>'required|digits:4',
            'block_section'=>'required|string|max:40',
            'school_year'=>'required|string|max:30',
            'semester'=>'required|string|max:30'
        ]);
        $allowed = config('smartlog.allowed_email_domain');
        if ($allowed && strtolower(substr(strrchr($data['email'], '@'), 1)) !== strtolower($allowed)) {
            return back()->withErrors(['email'=>"Please use your approved {$allowed} email address."])->withInput();
        }
        $user = DB::transaction(function () use ($data) {
            $last = User::where('batch_year', $data['batch_year'])->lockForUpdate()->max('pn_id');
            $sequence = $last ? ((int)substr($last, -2) + 1) : 1;
            if ($sequence > 99) throw \Illuminate\Validation\ValidationException::withMessages(['batch_year'=>'The PN ID sequence for this batch is full. Contact an administrator.']);
            return User::create([
                'name'=>$data['name'], 'email'=>$data['email'], 'password'=>$data['password'],
                'role'=>'student', 'batch_year'=>$data['batch_year'],
                'pn_id'=>$data['batch_year'].str_pad((string)$sequence, 2, '0', STR_PAD_LEFT),
                'block_section'=>$data['block_section'], 'school_year'=>$data['school_year'], 'semester'=>$data['semester']
            ]);
        });
        Auth::login($user);
        $request->session()->regenerate();
        AuditLog::create(['user_id'=>$user->id,'action'=>'student_registered','target_type'=>'user','target_id'=>$user->id,'details'=>['pn_id'=>$user->pn_id]]);
        return redirect()->route('dashboard')->with('success','Account created. Your PN ID is '.$user->pn_id.'.');
    }
    public function logout(Request $request) {
        Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
