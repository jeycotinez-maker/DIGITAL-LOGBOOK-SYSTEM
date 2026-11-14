@extends('layouts.app')
@section('title','Attendance Records')
@section('content')
<div class="app-shell">@include('components.sidebar')<main class="dashboard"><div class="page-heading"><div><div class="eyebrow">CENTER MONITORING</div><h1>Attendance Records</h1><p>Search and monitor scholar attendance.</p></div></div>
<section class="panel"><form class="filter-row"><label>Scholar / PN ID<input name="q" value="{{ request('q') }}" placeholder="Search name or PN ID"></label><label>Date<input type="date" name="date" value="{{ request('date') }}"></label><button class="btn btn-primary">Filter</button></form>
<div class="table-wrap"><table><thead><tr><th>Date</th><th>PN ID</th><th>Scholar</th><th>Batch / Block</th><th>Time In</th><th>Time Out</th><th>Status</th></tr></thead><tbody>@forelse($records as $r)<tr><td>{{ $r->date->format('M d, Y') }}</td><td>{{ $r->student->pn_id }}</td><td>{{ $r->student->name }}</td><td>{{ $r->student->batch_year }} / {{ $r->student->block_section }}</td><td>{{ $r->time_in->format('h:i A') }}</td><td>{{ $r->time_out?->format('h:i A') ?? '—' }}</td><td><span class="badge {{ $r->time_out?'badge-muted':'badge-green' }}">{{ $r->time_out?'Outside':'Inside' }}</span></td></tr>@empty<tr><td colspan="7" class="empty">No matching records.</td></tr>@endforelse</tbody></table></div><div class="pagination">{{ $records->links() }}</div></section>
</main></div>
@endsection
