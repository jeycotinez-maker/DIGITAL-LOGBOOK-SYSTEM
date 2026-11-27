@extends('layouts.app')
@section('title','Students')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading"><div><div class="eyebrow">USER MANAGEMENT</div><h1>Students</h1><p>Browse student accounts by name, PN ID, or batch.</p></div></header>
        <section class="panel">
            <form class="filter-row" method="GET">
                <label>Search student<input name="q" value="{{ request('q') }}" placeholder="Name or PN ID"></label>
                <label>Batch year<input name="batch" value="{{ request('batch') }}" placeholder="e.g. 2028"></label>
                <button class="btn btn-primary">Search</button>
            </form>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>PN ID</th><th>Student</th><th>Email</th><th>Batch</th><th>Block</th><th>Details</th></tr></thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr><td>{{ $student->pn_id ?? '—' }}</td><td>{{ $student->name }}</td><td>{{ $student->email }}</td><td>{{ $student->batch_year ?? '—' }}</td><td>{{ $student->block_section ?? '—' }}</td><td><a href="{{ route('students.show',$student) }}">View →</a></td></tr>
                        @empty
                            <tr><td colspan="6" class="empty">No students found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">{{ $students->links() }}</div>
        </section>
    </main>
</div>
@endsection
