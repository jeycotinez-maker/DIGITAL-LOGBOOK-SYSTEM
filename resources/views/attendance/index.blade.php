@extends('layouts.app')
@section('title','Logbook Records')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading"><div><div class="eyebrow">CENTER MONITORING</div><h1>Logbook Records</h1><p>Search scholar attendance activity.</p></div></header>
        <section class="panel">
            <form class="filter-row" method="GET">
                <label>Student or PN ID<input name="q" value="{{ request('q') }}" placeholder="Search name or PN ID"></label>
                <label>Date<input type="date" name="date" value="{{ request('date') }}"></label>
                <button class="btn btn-primary">Filter</button>
            </form>
            @include('attendance.table',['records'=>$records])
            <div class="pagination">{{ $records->links() }}</div>
        </section>
    </main>
</div>
@endsection
