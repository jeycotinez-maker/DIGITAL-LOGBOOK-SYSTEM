<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AcademicSettingController;
use App\Http\Controllers\SystemController;
use Illuminate\Http\Request;

Route::get('/', fn () => auth()->check()
    ? redirect()->route('dashboard')
    : view('welcome'))->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/roles/{mode}', [AuthController::class, 'roles'])->whereIn('mode', ['login','signup'])->name('roles');
    Route::get('/login/{role?}', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register/{role?}', [AuthController::class, 'showRegister'])
        ->whereIn('role', ['student','staff','admin'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/{role}', [DashboardController::class, 'show'])->whereIn('role', ['student','staff','admin'])->name('dashboard.role');
    Route::get('/my-attendance', [AttendanceController::class, 'mine'])->middleware('role:student')->name('attendance.mine');
    Route::get('/academic-info', fn (Request $request) => view('students.academic', ['user' => $request->user()]))
        ->middleware('role:student')->name('academic.edit');
    Route::post('/attendance/time-in', [AttendanceController::class, 'timeIn'])->middleware('role:student,staff,admin')->name('attendance.timein');
    Route::post('/attendance/time-out', [AttendanceController::class, 'timeOut'])->middleware('role:student,staff,admin')->name('attendance.timeout');
    Route::get('/attendance', [AttendanceController::class, 'index'])->middleware('role:staff,admin')->name('attendance.index');
    Route::get('/students', [StudentController::class, 'index'])->middleware('role:staff,admin')->name('students.index');
    Route::get('/students/{user}', [StudentController::class, 'show'])->middleware('role:staff,admin')->name('students.show');
    Route::get('/reports', [ReportController::class, 'index'])->middleware('role:staff,admin')->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->middleware('role:admin,staff')->name('reports.export');
    Route::get('/settings/academic', [AcademicSettingController::class, 'edit'])->middleware('role:admin')->name('settings.academic');
    Route::post('/settings/academic', [AcademicSettingController::class, 'update'])->middleware('role:admin')->name('settings.academic.update');
    Route::get('/database', [SystemController::class, 'database'])->middleware('role:admin')->name('system.database');
    Route::get('/system-logs', [SystemController::class, 'logs'])->middleware('role:admin')->name('system.logs');
    Route::get('/backups', [SystemController::class, 'backups'])->middleware('role:admin')->name('system.backups');
    Route::get('/backups/download', [SystemController::class, 'downloadBackup'])->middleware('role:admin')->name('system.backups.download');
    Route::get('/security', [SystemController::class, 'security'])->middleware('role:admin')->name('system.security');
});
