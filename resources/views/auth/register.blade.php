@extends('layouts.app')
@section('title','Scholar registration')
@section('content')
<main class="auth-wrap"><a class="back-link" href="{{ route('home') }}">← Back</a><div class="auth-card">
 <div class="eyebrow">SCHOLAR ACCOUNT</div><h1>Create your account</h1><p class="muted">Complete the information below. Your PN ID will be generated automatically.</p>
 <form method="POST" action="{{ route('register.submit') }}" class="form-stack">@csrf
  <label>Full name<input name="name" value="{{ old('name') }}" required placeholder="Surname, First Name Middle Name"></label>
  <label>Official email<input type="email" name="email" value="{{ old('email') }}" required placeholder="name@organization.org"></label>
  <div class="form-two"><label>Batch year<input name="batch_year" value="{{ old('batch_year',date('Y')) }}" inputmode="numeric" maxlength="4" required></label><label>Block section<input name="block_section" value="{{ old('block_section') }}" required placeholder="e.g. A"></label></div>
  <div class="form-two"><label>School year<input name="school_year" value="{{ old('school_year','2026-2027') }}" required></label><label>Semester<select name="semester" required><option value="1st Semester">1st Semester</option><option value="2nd Semester">2nd Semester</option><option value="Summer">Summer</option></select></label></div>
  <label>Password<input type="password" name="password" required minlength="8"></label><label>Confirm password<input type="password" name="password_confirmation" required minlength="8"></label>
  <button class="btn btn-primary full">Register</button>
 </form><p class="form-foot">Already registered? <a href="{{ route('login') }}">Log in</a></p>
</div></main>
@endsection
