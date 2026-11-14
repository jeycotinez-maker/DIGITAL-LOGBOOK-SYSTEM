@extends('layouts.app')
@section('title','Choose your role')
@section('content')
<main class="auth-wrap"><a class="back-link" href="{{ route('home') }}">← Back</a><div class="auth-card wide">
 <div class="eyebrow">PN DIGITAL LOGBOOK</div><h1>Choose your role</h1><p class="muted">Select the account type you want to access.</p>
 <div class="role-grid">
  @foreach(['student'=>'Student','staff'=>'Staff / Social Worker','admin'=>'Administrator'] as $key=>$label)
   <a class="role-card" href="{{ $mode==='signup' ? route('register',['role'=>$key]) : route('login',['role'=>$key]) }}"><span class="role-icon">{{ $key==='student'?'🎓':($key==='staff'?'🗂️':'🛡️') }}</span><h2>{{ $label }}</h2><p>{{ $key==='student'?'View your own attendance records.':($key==='staff'?'Monitor scholars and attendance.':'Manage users, settings and reports.') }}</p><span class="circle-arrow">→</span></a>
  @endforeach
 </div>
</div></main>
@endsection
