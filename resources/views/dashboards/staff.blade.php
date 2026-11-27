@extends('layouts.app')
@section('title','Staff Dashboard')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading">
            <div><div class="eyebrow">MONITORING PORTAL</div><h1>Staff Dashboard</h1><p>Monitor scholar attendance for {{ $date }}.</p></div>
            <span class="status-pill">{{ $isToday ? "Today's activity" : 'Selected date' }}</span>
        </header>
        <div class="stats-grid">
            <div class="stat"><span>Total scholars</span><strong>{{ $stats['students'] }}</strong></div>
            <div class="stat"><span>Logged today</span><strong>{{ $stats['logged'] }}</strong></div>
            <div class="stat"><span>Currently inside</span><strong>{{ $stats['not_returned'] }}</strong></div>
            <div class="stat"><span>No logbook entry</span><strong>{{ $stats['no_logbook'] }}</strong></div>
        </div>
        @include('dashboards.partials.scholar-groups')
    </main>
</div>
@endsection
