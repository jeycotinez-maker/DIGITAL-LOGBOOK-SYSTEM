@extends('layouts.app')
@section('title','Log in')
@section('content')
<main class="auth-wrap">
    <a class="back-link" href="{{ route('roles','login') }}">← Change role</a>
    <section class="auth-card">
        <div class="eyebrow">SECURE ACCESS</div>
        <h1>{{ $role ? ucfirst($role).' Login' : 'Welcome back' }}</h1>
        <p class="muted">Use your PN ID or registered email address.</p>
        <form method="POST" action="{{ route('login.submit') }}" class="form-stack">
            @csrf
            @if($role)<input type="hidden" name="role" value="{{ $role }}">@endif
            <label>PN ID or email
                <input name="identity" value="{{ old('identity') }}" required autofocus>
            </label>
            <label>Password
                <input type="password" name="password" required>
            </label>
            <label class="check"><input type="checkbox" name="remember"> Remember me</label>
            <button class="btn btn-primary full">Log in</button>
        </form>
        <p class="form-foot">New scholar? <a href="{{ route('register', ['role' => 'student']) }}">Create an account</a></p>
    </section>
</main>
@endsection
