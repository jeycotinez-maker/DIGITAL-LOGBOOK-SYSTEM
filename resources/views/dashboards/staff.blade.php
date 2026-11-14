@extends('layouts.app')
@section('title','Staff Dashboard')
@section('content')
<div class="app-shell">@include('components.sidebar')<main class="dashboard">
 <div class="page-heading"><div>
    <div class="eyebrow">MONITORING PORTAL</div>
    <h1>Staff Dashboard</h1>
    <p>Monitor scholar attendance and center activity.</p>
</div><span class="status-pill">Staff access</span></div>
 <div class="stats-grid">
    <div class="stat">
        <span>Total scholars</span>
 <strong>{{ $stats['students'] }}</strong>
</div>
 <div class="stat">
    <span>Currently inside</span>
    <strong>{{ $stats['inside'] }}</strong>
</div><div class="stat">
    <span>Today's entries</span>
    <strong>{{ $stats['today'] }}</strong>
</div><div class="stat">
    <span>Completed sessions</span>
    <strong>{{ $stats['completed'] }}</strong>
</div>
</div>
 <section class="panel">
    <div class="panel-head">
        <h2>Recent logbook activity</h2>
        <a href="{{ route('attendance.index') }}">All records →</a>
    </div>@include('attendance.table', ['records'=>$recent])</section>
 </main></div>
@endsection
