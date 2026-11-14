@extends('layouts.app')
@section('title','Manage Scholars')
@section('content')
<div class="app-shell">@include('components.sidebar')<main class="dashboard"><div class="page-heading"><div><div class="eyebrow">USER MANAGEMENT</div><h1>Scholars</h1><p>Browse scholar accounts, grouped by batch and name.</p></div></div>
<section class="panel"><form class="filter-row"><label>Search scholar<input name="q" value="{{ request('q') }}" placeholder="Name or PN ID"></label><label>Batch year<input name="batch" value="{{ request('batch') }}" placeholder="e.g. 2028"></label><button class="btn btn-primary">Search</button></form>
<div class="table-wrap"><table><thead><tr><th>PN ID</th><th>Scholar name</th><th>Email</th><th>Batch</th><th>Block</th><th>Details</th></tr></thead><tbody>@forelse($students as $s)<tr><td>{{ $s->pn_id }}</td><td>{{ $s->name }}</td><td>{{ $s->email }}</td><td>{{ $s->batch_year }}</td><td>{{ $s->block_section }}</td><td><a href="{{ route('students.show',$s) }}">View →</a></td></tr>@empty<tr><td colspan="6" class="empty">No scholars found.</td></tr>@endforelse</tbody></table></div><div class="pagination">{{ $students->links() }}</div></section>
</main></div>
@endsection
