<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
 <title>@yield('title','Smart Logbook Tracker') · Smart Logbook Tracker</title>
 <link rel="stylesheet" href="{{ asset('css/style.css') }}">
 <script defer src="{{ asset('js/app.js') }}"></script>
</head>
<body class="{{ auth()->check() ? 'is-auth' : 'is-guest' }}">
@guest
<header class="topbar">
 <a class="brand" href="{{ route('home') }}"><span class="brand-mark">PN</span><span><b>Smart Logbook Tracker</b><small>Track. Monitor. Ensure.</small></span></a>
</header>
@endguest
@auth
<div class="user-float">
 <span class="avatar">{{ strtoupper(mb_substr(auth()->user()->first_name ?? auth()->user()->name, 0, 1)) }}</span>
 <span class="user-meta"><b>{{ auth()->user()->name }}</b><small>{{ ucfirst(auth()->user()->role) }}</small></span>
</div>
@endauth
@if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert error"><b>Please check the following:</b><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@yield('content')
@guest<footer class="footer">Passerelles Numériques Philippines · Smart Logbook Tracker</footer>@endguest
</body></html>
