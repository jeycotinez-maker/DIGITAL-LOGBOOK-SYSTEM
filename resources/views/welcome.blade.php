@extends('layouts.app')
@section('title','Welcome')
@section('content')
<main class="landing">
    <section class="hero">
        <div class="eyebrow">PASSERELLES NUMÉRIQUES PHILIPPINES</div>
        <div class="hero-logo">PN</div>
        <h1>PN Student<br>Digital Logbook</h1>
        <p>Track. Monitor. Stay Accountable.</p>
        <div class="hero-actions">
            <a class="btn btn-primary btn-large" href="{{ route('roles','signup') }}">Create an account</a>
            <a class="btn btn-light btn-large" href="{{ route('roles','login') }}">Log in</a>
        </div>
    </section>
</main>
@endsection
