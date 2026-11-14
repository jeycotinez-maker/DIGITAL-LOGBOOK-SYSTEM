@extends('layouts.app')
@section('title', ucfirst($role).' registration')
@section('content')
<main class="auth-wrap"><a class="back-link" href="{{ route('home') }}">← Back</a><div class="auth-card">
 <div class="eyebrow">{{ strtoupper($role) }} ACCOUNT</div><h1>Create your {{ $role }} account</h1><p class="muted">{{ $role === 'student' ? 'Complete the information below. Your PN ID will be generated automatically.' : 'Enter your name, email, and password to register.' }}</p>
 <form method="POST" action="{{ route('register.submit') }}" class="form-stack">@csrf
  <input type="hidden" name="role" value="{{ $role }}">
  <label>Full name<input name="name" value="{{ old('name') }}" required placeholder="Surname, First Name Middle Name"></label>
  <label>Official email<input type="email" name="email" value="{{ old('email') }}" required placeholder="name@organization.org"></label>
  @if($role === 'student')
  <div class="form-two"><label>Batch year<input name="batch_year" value="{{ old('batch_year',date('Y')) }}" inputmode="numeric" maxlength="4" required></label><label>Block section<input name="block_section" value="{{ old('block_section') }}" required placeholder="e.g. A"></label></div>
  <div class="form-two"><label>School year<input name="school_year" value="{{ old('school_year','2026-2027') }}" required></label><label>Semester<select name="semester" required><option value="1st Semester">1st Semester</option><option value="2nd Semester">2nd Semester</option><option value="Summer">Summer</option></select></label></div>
  @endif
  <label>Password<input type="password" name="password" required minlength="8"></label><label>Confirm password<input type="password" name="password_confirmation" required minlength="8"></label>
  <button class="btn btn-primary full">Register</button>
 </form><p class="form-foot">Already registered? <a href="{{ route('login') }}">Log in</a></p>
</div></main>
@endsection
