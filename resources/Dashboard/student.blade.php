@extends('layouts.app')
@section('title','Student Dashboard')
@section('content')
@php
    $u = auth()->user();
    $display = $u->first_name
        ? trim($u->first_name.' '.($u->middle_name ? mb_substr($u->middle_name, 0, 1).'. ' : '').$u->last_name)
        : $u->name;
@endphp
<div class="app-shell">@include('components.sidebar')<main class="dashboard">
 <div class="page-heading"><div><h1>Student Dashboard</h1><p>View your records, anytime.</p></div></div>

 <section class="panel profile-card">
  <div class="profile-avatar">{{ strtoupper(mb_substr($u->first_name ?? $u->name, 0, 1)) }}</div>
  <div class="profile-info">
   <h2>{{ $display }}</h2>
   <p>PN ID: <b>{{ $u->pn_id }}</b></p>
   <p>Batch: <b>{{ $u->batch_year }}</b> &nbsp;|&nbsp; Section: <b>{{ $u->block_section }}</b></p>
   <p>School Year: <b>{{ $u->school_year }}</b> &nbsp;|&nbsp; Semester: <b>{{ $u->semester }}</b></p>
  </div>
  <span class="readonly-badge">🔒 Read-Only Access</span>
 </section>

 <div class="two-col">
  <section class="panel">
   <div class="panel-head"><h2>◷ Recent Logbook Activity</h2><a href="{{ route('attendance.mine') }}">View All →</a></div>
   <ul class="activity-list">
    @forelse($events as $e)
     <li>
      <span class="act-icon {{ $e['type'] === 'IN' ? 'in' : 'out' }}">{{ $e['type'] === 'IN' ? '↑' : '→' }}</span>
      <span class="act-time">{{ $e['at']->format('M d, Y') }} · {{ $e['at']->format('h:i A') }}</span>
      <span class="badge {{ $e['type'] === 'IN' ? 'badge-green' : 'badge-blue' }}">{{ $e['type'] }}</span>
     </li>
    @empty
     <li class="empty">No logbook activity yet.</li>
    @endforelse
   </ul>
  </section>

  <section class="panel">
   <div class="panel-head"><h2>▤ Your Academic Information</h2></div>
   <dl class="info-list">
    <dt>Batch Year:</dt><dd>{{ $u->batch_year }}</dd>
    <dt>Section:</dt><dd>{{ $u->block_section }}</dd>
    <dt>School Year:</dt><dd>{{ $u->school_year }}</dd>
    <dt>Semester:</dt><dd>{{ $u->semester }}</dd>
   </dl>
   <a class="btn btn-blue" href="{{ route('academic.edit') }}">✎ Update</a>
  </section>
 </div>
</main></div>
@endsection