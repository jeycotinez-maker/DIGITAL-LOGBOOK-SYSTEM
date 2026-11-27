@extends('layouts.app')
@section('title','Student Dashboard')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading">
            <div>
                <div class="eyebrow">STUDENT PORTAL</div>
                <h1>Welcome, {{ auth()->user()->name }}</h1>
                <p>PN ID: {{ auth()->user()->pn_id ?? 'Not assigned' }} · Batch {{ auth()->user()->batch_year ?? '—' }} · Block {{ auth()->user()->block_section ?? '—' }}</p>
            </div>
            <span class="status-pill">Student account</span>
        </header>
        <section class="action-grid">
            <form method="POST" action="{{ route('attendance.timein') }}" class="action-card">
                @csrf
                <h2>Time In</h2>
                <p>Record your arrival at the center.</p>
                <button class="btn btn-green full">Record Time In</button>
            </form>
            <form method="POST" action="{{ route('attendance.timeout') }}" class="action-card">
                @csrf
                <h2>Time Out</h2>
                <p>Record your departure from the center.</p>
                <button class="btn btn-red full">Record Time Out</button>
            </form>
            <a class="action-card" href="{{ route('attendance.mine') }}">
                <h2>Attendance History</h2>
                <p>Review your previous logbook records.</p>
                <span class="btn btn-blue full">View History</span>
            </a>
        </section>
        <section class="panel">
            <div class="panel-head"><h2>Recent logbook activity</h2><a href="{{ route('attendance.mine') }}">View history →</a></div>
            @forelse($events as $event)
                <div class="stat">
                    <span>{{ $event['type'] === 'IN' ? 'Time In' : 'Time Out' }}</span>
                    <strong>{{ $event['at']->format('M d, Y h:i A') }}</strong>
                </div>
            @empty
                <p class="empty">No attendance records yet. Your logbook activity will appear here.</p>
            @endforelse
        </section>
    </main>
</div>
@endsection
