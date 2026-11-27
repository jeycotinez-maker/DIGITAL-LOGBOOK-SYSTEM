@extends('layouts.app')
@section('title','Academic Information')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading"><div><div class="eyebrow">STUDENT PORTAL</div><h1>Academic Information</h1><p>Your current account information.</p></div></header>
        <section class="panel">
            <div class="stats-grid">
                <div class="stat"><span>Batch year</span><strong>{{ $user->batch_year ?? '—' }}</strong></div>
                <div class="stat"><span>Block section</span><strong>{{ $user->block_section ?? '—' }}</strong></div>
                <div class="stat"><span>School year</span><strong>{{ $user->school_year ?? '—' }}</strong></div>
                <div class="stat"><span>Semester</span><strong>{{ $user->semester ?? '—' }}</strong></div>
            </div>
            <p class="muted">Contact a staff member if this information needs to be updated.</p>
        </section>
    </main>
</div>
@endsection
