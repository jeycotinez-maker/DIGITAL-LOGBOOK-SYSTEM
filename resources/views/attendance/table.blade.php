<div class="table-wrap"><table><thead><tr><th>Date</th>@if(isset($records->first()->student))<th>Scholar</th><th>PN ID</th>@endif<th>Time In</th><th>Time Out</th><th>Status</th></tr></thead><tbody>
@forelse($records as $record)<tr><td>{{ $record->date?->format('M d, Y') }}</td>@if($record->student)<td>{{ $record->student->name }}</td><td>{{ $record->student->pn_id }}</td>@endif<td>{{ $record->time_in?->format('h:i A') }}</td><td>{{ $record->time_out?->format('h:i A') ?? '—' }}</td><td><span class="badge {{ $record->time_out?'badge-muted':'badge-green' }}">{{ $record->time_out?'Complete':'Inside' }}</span></td></tr>
@empty<tr><td colspan="6" class="empty">No attendance records found.</td></tr>@endforelse
</tbody></table></div>
