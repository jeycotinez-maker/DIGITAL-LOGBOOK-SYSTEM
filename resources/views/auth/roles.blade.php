@extends('layouts.app')
@section('title','Choose your role')
@section('content')
<main class="auth-wrap">
    <a class="back-link" href="{{ route('home') }}">← Back</a>
    <section class="auth-card wide">
        <div class="eyebrow">PN DIGITAL LOGBOOK</div>
        <h1>{{ $mode === 'signup' ? 'Create an account' : 'Choose your role' }}</h1>
        <p class="muted">{{ $mode === 'signup' ? 'Select the account type to register.' : 'Select the account type to log in.' }}</p>
        <div class="role-grid">
            @foreach(['student'=>'Student','staff'=>'Staff / Social Worker','admin'=>'Administrator'] as $key=>$label)
                <a class="role-card" href="{{ $mode === 'signup' ? route('register',['role'=>$key]) : route('login',['role'=>$key]) }}">
                    <span class="role-icon">{{ $key === 'student' ? '🎓' : ($key === 'staff' ? '🗂️' : '🛡️') }}</span>
                    <h2>{{ $label }}</h2>
                    <p>{{ $key === 'student' ? 'View personal attendance and academic information.' : ($key === 'staff' ? 'Monitor scholar attendance and activity.' : 'Manage academic settings and reports.') }}</p>
                    <span class="circle-arrow">→</span>
                </a>
            @endforeach
        </div>
    </section>
</main>
@endsection
