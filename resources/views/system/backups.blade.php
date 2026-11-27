@extends('layouts.app')
@section('title','Backups')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading">
            <div><div class="eyebrow">SYSTEM ADMINISTRATION</div><h1>Database Backups</h1><p>Create a consistent snapshot of the current database.</p></div>
        </header>
        <section class="panel backup-panel">
            <div class="backup-icon">⇩</div>
            <h2>Download a database backup</h2>
            @if($supported)
                <p class="muted">A fresh SQLite snapshot will be generated and downloaded. It includes the current user, attendance, and system log records. The temporary server-side file is removed after download.</p>
                <a class="btn btn-primary" href="{{ route('system.backups.download') }}">Create and download backup</a>
            @else
                <p class="alert error">This download action currently supports SQLite databases only. Your configured database is not SQLite.</p>
            @endif
        </section>
    </main>
</div>
@endsection
