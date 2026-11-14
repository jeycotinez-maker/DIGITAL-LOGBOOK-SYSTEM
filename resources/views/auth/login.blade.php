@extends('layouts.app')
@section('title','Log in')
@section('content')
<main class="auth-wrap"><a class="back-link" href="{{ route('roles','login') }}">← Change role</a><div class="auth-card">
 <div class="eyebrow">SECURE ACCESS</div><h1>{{ $role ? ucfirst($role).' Login' : 'Welcome back' }}</h1><p class="muted">Use your PN ID or registered email address.</p>
 <form method="POST" action="{{ route('login.submit') }}" class="form-stack">@csrf
  <input type="hidden" name="role" value="{{ $role }}">
  <label>PN ID or email<input name="identity" value="{{ old('identity') }}" required autofocus placeholder="e.g. 202801 or name@email.com"></label>
  <label>Password<input type="password" name="password" required placeholder="Enter your password"></label>
  <label class="check"><input type="checkbox" name="remember"> Remember me</label>
  <button class="btn btn-primary full">Log in</button>
 </form><p class="form-foot">New scholar? <a href="{{ route('register') }}">Create an account</a></p>
</div></main>
@endsection
