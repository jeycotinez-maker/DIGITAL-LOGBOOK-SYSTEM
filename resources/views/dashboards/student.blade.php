@extends('layouts.app')
@section('title','Scholar Dashboard')
@section('content')
<div class="app-shell">@include('components.sidebar')<main class="dashboard">
 <div class="page-heading"><div><div class="eyebrow">SCHOLAR PORTAL</div><h1>Welcome, {{ auth()->user()->name }}!</h1><p>PN ID: <b>{{ auth()->user()->pn_id }}</b> · Batch {{ auth()->user()->batch_year }} · Block {{ auth()->user()->block_section }}</p></div><span class="status-pill">Scholar account</span></div>
 <div class="action-grid">
  <form method="POST" action="{{ route('attendance.timein') }}" class="action-card">@csrf<h2>↪ Time In</h2><p>Record your arrival at the center.</p><button class="btn btn-green full">Record Time In</button></form>
  <form method="POST" action="{{ route('attendance.timeout') }}" class="action-card">@csrf<h2>⇥ Time Out</h2><p>Record your departure from the center.</p><button class="btn btn-red full">Record Time Out</button></form>
  <a class="action-card" href="{{ route('attendance.mine') }}"><h2>◷ Attendance History</h2><p>Review your previous logbook records.</p><span class="btn btn-blue full">View History</span></a>
 </div>
 <section class="panel"><div class="panel-head"><h2>Recent attendance</h2><a href="{{ route('attendance.mine') }}">View all →</a></div>@include('attendance.table', ['records'=>$myRecent])</section>
</main></div>
@endsection
