@extends('layouts.app')
@section('title','Administrator Dashboard')
@section('content')
<div class="app-shell">@include('components.sidebar')<main class="dashboard">
 <div class="page-heading"><div><div class="eyebrow">SYSTEM ADMINISTRATION</div><h1>Welcome, Administrator!</h1><p>Manage scholars, attendance, academic setup and reports.</p></div><span class="status-pill">Administrator access</span></div>
 <div class="stats-grid"><div class="stat"><span>Total scholars</span><strong>{{ $stats['students'] }}</strong></div><div class="stat"><span>Currently inside</span><strong>{{ $stats['inside'] }}</strong></div><div class="stat"><span>Today's attendance</span><strong>{{ $stats['today'] }}</strong></div><div class="stat"><span>Completed sessions</span><strong>{{ $stats['completed'] }}</strong></div></div>
 <div class="quick-grid"><a class="quick-card" href="{{ route('students.index') }}"><b>♙ Manage Scholars</b><span>Search scholar accounts and records</span></a><a class="quick-card" href="{{ route('attendance.index') }}"><b>◷ Attendance Records</b><span>Monitor Time In and Time Out</span></a><a class="quick-card" href="{{ route('reports.index') }}"><b>▤ Reports</b><span>Filter and export attendance data</span></a><a class="quick-card" href="{{ route('settings.academic') }}"><b>⚙ Academic Settings</b><span>Configure academic year and semester</span></a></div>
 <section class="panel"><div class="panel-head"><h2>Recent logbook activity</h2><a href="{{ route('attendance.index') }}">All records →</a></div>@include('attendance.table', ['records'=>$recent])</section>
</main></div>
@endsection
