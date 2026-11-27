@extends('layouts.app')
@section('title','Database')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading">
            <div><div class="eyebrow">SYSTEM ADMINISTRATION</div><h1>Database</h1><p>Connection health and live table row counts.</p></div>
            <span class="health-indicator health-ok">Connected</span>
        </header>
        <section class="stats-grid system-summary">
            <div class="stat"><span>Connection</span><strong>{{ strtoupper($driver) }}</strong></div>
            <div class="stat"><span>Database</span><strong class="system-summary-value">{{ $databaseName }}</strong></div>
            <div class="stat"><span>Database version</span><strong class="system-summary-value">{{ $serverVersion }}</strong></div>
            <div class="stat"><span>Tables</span><strong>{{ $tables->count() }}</strong></div>
        </section>
        <section class="panel">
            <div class="panel-head"><h2>Database Tables</h2></div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Table</th><th>Rows</th></tr></thead>
                    <tbody>
                        @forelse($tables as $table)
                            <tr><td>{{ $table['name'] }}</td><td>{{ number_format($table['rows']) }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="empty">No tables were found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
@endsection
