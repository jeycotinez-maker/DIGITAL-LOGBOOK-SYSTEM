<aside class="sidebar"><a class="side-brand" href="{{ route('dashboard') }}"><span class="brand-mark">PN</span><b>Digital Logbook</b></a>
<nav>
 <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard*')?'active':'' }}">⌂ <span>Dashboard</span></a>
 @if(auth()->user()->role==='student')
 <a href="{{ route('attendance.mine') }}" class="{{ request()->routeIs('attendance.mine')?'active':'' }}">◷ <span>My Attendance</span></a>
 @else
 <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*')?'active':'' }}">♙ <span>Scholars</span></a>
 <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.index')?'active':'' }}">◷ <span>Attendance Records</span></a>
 <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*')?'active':'' }}">▤ <span>Reports</span></a>
 @endif
 @if(auth()->user()->role==='admin')<a href="{{ route('settings.academic') }}">⚙ <span>Academic Settings</span></a>@endif
</nav><div class="side-bottom"><form method="POST" action="{{ route('logout') }}">@csrf<button>⇥ <span>Log out</span></button></form></div></aside>
