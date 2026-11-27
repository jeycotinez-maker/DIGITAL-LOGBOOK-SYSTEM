<aside class="sidebar">
 <a class="side-brand" href="{{ route('dashboard') }}">
  <svg class="side-logo" viewBox="0 0 64 64" aria-hidden="true"><path d="M32 12c-6-5-16-5-24-2v36c8-3 18-3 24 2 6-5 16-5 24-2V10c-8-3-18-3-24 2z" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linejoin="round"/><path d="M32 12v36" stroke="currentColor" stroke-width="3.5"/><path d="M14 20c4-1 9-1 13 1M14 28c4-1 9-1 13 1M37 21c4-2 9-2 13-1M37 29c4-2 9-2 13-1" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" fill="none"/></svg>
  <span class="side-title">SMART<br>LOGBOOK<br>TRACKER</span>
  <small class="side-tag">Track. Monitor. Ensure.</small>
 </a>
<nav>
 <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard*')?'active':'' }}">⌂ <span>Dashboard</span></a>
 @if(auth()->user()->role==='student')
 <a href="{{ route('attendance.mine') }}" class="{{ request()->routeIs('attendance.mine')?'active':'' }}">◷ <span>My Logs</span></a>
 <a href="{{ route('academic.edit') }}" class="{{ request()->routeIs('academic.*')?'active':'' }}">✎ <span>Academic Info</span></a>
 @else
 <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*')?'active':'' }}">♙ <span>Students</span></a>
 <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.index')?'active':'' }}">◷ <span>Logbook Records</span></a>
 <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*')?'active':'' }}">▤ <span>Reports</span></a>
 @endif
 @if(auth()->user()->role==='admin')<a href="{{ route('settings.academic') }}" class="{{ request()->routeIs('settings.*')?'active':'' }}">⚙ <span>Academic Control</span></a>@endif
</nav><div class="side-bottom"><form method="POST" action="{{ route('logout') }}">@csrf<button>⇥ <span>Logout</span></button></form></div></aside>
