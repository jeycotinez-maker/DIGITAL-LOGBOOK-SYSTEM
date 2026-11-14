@extends('layouts.app')
@section('title','My Attendance')
@section('content')
<div class="app-shell">@include('components.sidebar')<main class="dashboard"><div class="page-heading"><div><div class="eyebrow">SCHOLAR PORTAL</div><h1>Attendance History</h1><p>View your personal attendance records. These records are read-only.</p></div></div>
<section class="panel"><form class="filter-row" method="GET"><label>Filter by date<input type="date" name="date" value="{{ request('date') }}"></label><button class="btn btn-primary">Search</button><a class="btn btn-outline" href="{{ route('attendance.mine') }}">Clear</a></form>@include('attendance.table',['records'=>$records])<div class="pagination">{{ $records->links() }}</div></section>
</main></div>
@endsection
