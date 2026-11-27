@extends('layouts.app')
@section('title','System Logs')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading">
            <div><div class="eyebrow">SYSTEM ADMINISTRATION</div><h1>System Logs</h1><p>Recent account and attendance activity recorded by the application.</p></div>
        </header>
        <section class="panel">
            <form class="filter-row" method="GET" action="{{ route('system.logs') }}">
                <label>
                    Activity type
                    <select name="action">
                        <option value="">All activity</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" @selected(request('action') === $action)>{{ str_replace('_', ' ', ucfirst($action)) }}</option>
                        @endforeach
                    </select>
                </label>
                <div class="admin-filter-actions">
                    <button class="btn btn-primary btn-sm" type="submit">Filter</button>
                    <a class="btn btn-outline btn-sm" href="{{ route('system.logs') }}">Clear</a>
                </div>
            </form>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Date / Time</th><th>Activity</th><th>User</th><th>Details</th><th>IP Address</th></tr></thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->created_at?->format('M j, Y g:i:s A') }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($log->action)) }}</td>
                                <td>{{ $log->user?->name ?? 'Deleted user' }}</td>
                                <td class="log-details">{{ $log->details ? json_encode($log->details, JSON_UNESCAPED_SLASHES) : '—' }}</td>
                                <td>{{ $log->ip_address ?: '—' }}</td>
                            </tr>
                        @empty
                            <tr><td class="empty" colspan="5">No audit log entries found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">{{ $logs->links() }}</div>
        </section>
    </main>
</div>
@endsection
