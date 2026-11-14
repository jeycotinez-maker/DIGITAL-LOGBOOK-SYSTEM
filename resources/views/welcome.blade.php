@extends('layouts.app')
@section('title','Welcome')
@section('content')
<main class="landing">
 <section class="hero">
  <div class="eyebrow">PASSERELLES NUMÉRIQUES PHILIPPINES</div>
  <div class="hero-logo">PN</div>
  <h1>PN Student<br>Digital Logbook</h1>
  <p>Track. Monitor. Stay Accountable.</p>
  <div class="hero-actions"><a class="btn btn-primary btn-large" href="{{ route('roles','signup') }}">Create an account</a><a class="btn btn-light btn-large" href="{{ route('roles','login') }}">Log in</a></div>
 </section>
 <section class="feature-row">
  <article class="feature"><span>01</span><h3>Digital Attendance</h3><p>Record Time In and Time Out with system-generated timestamps.</p></article>
  <article class="feature"><span>02</span><h3>Live Monitoring</h3><p>Authorized staff can review current attendance and scholar records.</p></article>
  <article class="feature"><span>03</span><h3>Attendance History</h3><p>Scholars can securely review their own attendance history.</p></article>
 </section>
</main>
@endsection
