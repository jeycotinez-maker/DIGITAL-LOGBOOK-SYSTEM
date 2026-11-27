@extends('layouts.app')
@section('title','Reports')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading"><div><div class="eyebrow">REPORTING</div><h1>Attendance Reports</h1><p>Review and export attendance records by date range.</p></div></header>
        <section class="panel">
            <form class="filter-row" method="GET">
                <label>From<input type="date" name="from" value="{{ $from }}"></label>
                <label>To<input type="date" name="to" value="{{ $to }}"></label>
                <button class="btn btn-primary">Generate</button>
                <a class="btn btn-outline" href="{{ route('reports.export',['from'=>$from,'to'=>$to]) }}">Export CSV</a>
            </form>
            @include('attendance.table',['records'=>$records])
            <div class="pagination">{{ $records->links() }}</div>
        </section>
    </main>
</div>
@endsection
