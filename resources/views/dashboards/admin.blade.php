@extends('layouts.app')
@section('title','Administrator Dashboard')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard admin-dashboard">
        <header class="page-heading">
            <div>
                <div class="eyebrow">MAIN SERVER DASHBOARD</div>
                <h1>Administrator Dashboard</h1>
                <p>Live student attendance and system activity.</p>
            </div>
            <span class="status-pill">{{ now()->format('D, M j · g:i A') }}</span>
        </header>

        <section class="stats-grid" aria-label="Live student totals">
            <div class="stat"><span>Total students</span><strong>{{ $totalStudents }}</strong></div>
            <div class="stat"><span>Currently inside</span><strong>{{ $inside }}</strong></div>
            <div class="stat"><span>Currently outside</span><strong>{{ $outside }}</strong></div>
            <div class="stat"><span>Not logged in</span><strong>{{ $notLoggedIn }}</strong></div>
        </section>

        <section class="panel">
            <div class="panel-head admin-panel-head">
                <div>
                    <h2>Student Logbook</h2>
                    <p class="muted">Attendance status reflects each student’s latest logbook entry.</p>
                </div>
            </div>
            <form class="filter-row admin-filter-row" method="GET" action="{{ route('dashboard.role', ['role' => 'admin']) }}">
                <label>
                    Search name or PN ID
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Name or PN ID">
                </label>
                <label>
                    Batch
                    <select name="batch">
                        <option value="">All batches</option>
                        @foreach($batches as $batch)
                            <option value="{{ $batch }}" @selected(request('batch') === (string) $batch)>{{ $batch }}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Section
                    <select name="section">
                        <option value="">All sections</option>
                        @foreach($sections as $section)
                            <option value="{{ $section }}" @selected(request('section') === (string) $section)>{{ $section }}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Status
                    <select name="status">
                        <option value="">All statuses</option>
                        <option value="inside" @selected(request('status') === 'inside')>Inside</option>
                        <option value="outside" @selected(request('status') === 'outside')>Outside</option>
                        <option value="not_logged_in" @selected(request('status') === 'not_logged_in')>Not logged in</option>
                    </select>
                </label>
                <div class="admin-filter-actions">
                    <button class="btn btn-primary btn-sm" type="submit">Apply filters</button>
                    <a class="btn btn-outline btn-sm" href="{{ route('dashboard.role', ['role' => 'admin']) }}">Clear</a>
                    <button class="btn btn-light btn-sm" type="submit">Refresh</button>
                </div>
            </form>

            <div class="table-wrap">
                <table class="admin-student-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>PN ID</th>
                            <th>Batch / Section</th>
                            <th>Last Time Out</th>
                            <th>Last Time In</th>
                            <th>Status</th>
                            <th>Outside Duration</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td><strong>{{ $student->name }}</strong></td>
                                <td>{{ $student->pn_id ?: '—' }}</td>
                                <td>{{ $student->batch_year ?: '—' }} / {{ $student->block_section ?: '—' }}</td>
                                <td>{{ $student->dashboard_time_out?->format('M j, Y g:i A') ?? '—' }}</td>
                                <td>{{ $student->latestAttendance?->time_in?->format('M j, Y g:i A') ?? '—' }}</td>
                                <td>
                                    @if($student->dashboard_status === 'inside')
                                        <span class="badge badge-green">Inside</span>
                                    @elseif($student->dashboard_status === 'outside')
                                        <span class="badge badge-blue">Outside</span>
                                    @else
                                        <span class="badge badge-muted">Not logged in</span>
                                    @endif
                                </td>
                                <td>{{ $student->dashboard_duration }}</td>
                                <td><a class="btn btn-light btn-sm" href="{{ route('students.show', $student) }}">View</a></td>
                            </tr>
                        @empty
                            <tr><td class="empty" colspan="8">No students match these filters.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="admin-table-footer">
                <span class="muted">
                    @if($students->total())
                        Showing {{ $students->firstItem() }}–{{ $students->lastItem() }} of {{ $students->total() }} students
                    @else
                        No student records found
                    @endif
                </span>
                <div class="pagination">{{ $students->links() }}</div>
            </div>
        </section>

        <section class="admin-system-grid">
            <div class="panel admin-activity">
                <div class="panel-head"><h2>System Activity</h2><a href="{{ route('system.logs') }}">View all</a></div>
                @forelse($activity as $log)
                    <div class="activity-row">
                        <span class="activity-mark {{ str_starts_with($log->action, 'time_') ? 'activity-mark-blue' : '' }}"></span>
                        <div>
                            <strong>
                                @switch($log->action)
                                    @case('time_in') Student signed in @break
                                    @case('time_out') Student signed out @break
                                    @case('user_logged_in') User logged in @break
                                    @case('user_logged_out') User logged out @break
                                    @case('student_registered') Student account created @break
                                    @case('staff_registered') Staff account created @break
                                    @case('admin_registered') Admin account created @break
                                    @default {{ str_replace('_', ' ', ucfirst($log->action)) }}
                                @endswitch
                            </strong>
                            <span>{{ data_get($log->details, 'student', $log->user?->name ?? 'System') }}</span>
                        </div>
                        <time>{{ $log->created_at?->format('g:i A') }}</time>
                    </div>
                @empty
                    <p class="empty">No system activity has been recorded yet.</p>
                @endforelse
            </div>
            <div class="panel admin-health">
                <div class="panel-head"><h2>Database Health</h2><a href="{{ route('system.database') }}">Details</a></div>
                <span class="health-indicator {{ $databaseHealthy ? 'health-ok' : 'health-error' }}">
                    {{ $databaseHealthy ? 'Connected' : 'Unavailable' }}
                </span>
                <p class="muted">Connection: {{ config('database.default') }}</p>
                <hr>
                <div class="panel-head"><h2>Server Status</h2></div>
                <span class="health-indicator health-ok">Online</span>
                <p class="muted">This dashboard is responding to requests.</p>
            </div>
        </section>
    </main>
</div>
@endsection
