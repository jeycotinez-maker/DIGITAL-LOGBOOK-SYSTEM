@extends('layouts.app')
@section('title','Student Details')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <a class="back-link" href="{{ route('students.index') }}">← Students</a>
        <header class="page-heading"><div><div class="eyebrow">STUDENT PROFILE</div><h1>{{ $user->name }}</h1><p>{{ $user->pn_id ?? 'No PN ID' }} · Batch {{ $user->batch_year ?? '—' }} · Block {{ $user->block_section ?? '—' }}</p></div></header>
        <section class="panel"><h2>Attendance history</h2>@include('attendance.table',['records'=>$records])<div class="pagination">{{ $records->links() }}</div></section>
    </main>
</div>
@endsection
