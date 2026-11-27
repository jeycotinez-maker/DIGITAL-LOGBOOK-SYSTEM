<form class="filter-row" method="GET" action="{{ route('dashboard.role',['role'=>auth()->user()->role]) }}">
    <label>Activity date<input type="date" name="date" value="{{ $date }}"></label>
    <button class="btn btn-primary">Filter</button>
</form>
@forelse($grouped as $batch => $blocks)
    @foreach($blocks as $block => $scholars)
        <section class="panel">
            <div class="panel-head"><h2>Batch {{ $batch ?: 'Unassigned' }} · Block {{ $block ?: 'Unassigned' }}</h2></div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>PN ID</th><th>Student</th><th>Time In</th><th>Time Out</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach($scholars as $scholar)
                            @php($latest = $scholar->attendances->last())
                            <tr>
                                <td>{{ $scholar->pn_id ?? '—' }}</td>
                                <td><a href="{{ route('students.show',$scholar) }}">{{ $scholar->name }}</a></td>
                                <td>{{ $latest?->time_in?->format('h:i A') ?? '—' }}</td>
                                <td>{{ $latest?->time_out?->format('h:i A') ?? '—' }}</td>
                                <td><span class="badge {{ $latest && !$latest->time_out ? 'badge-warn' : 'badge-green' }}">{{ $latest ? ($latest->time_out ? 'Outside' : 'Inside') : 'No entry' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endforeach
@empty
    <section class="panel"><p class="empty">No student accounts found.</p></section>
@endforelse
