<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
 <title>@yield('title','SmartLog') · PN Digital Logbook</title>
 <link rel="stylesheet" href="{{ asset('css/style.css') }}">
 <script defer src="{{ asset('js/app.js') }}"></script>
</head>
<body>
<header class="topbar">
 <a class="brand" href="{{ route('home') }}"><span class="brand-mark">PN</span><span><b>PN Digital Logbook</b><small>Track. Monitor. Stay Accountable.</small></span></a>
 <div class="top-actions">
 @auth <span class="user-chip">{{ auth()->user()->name }} · {{ ucfirst(auth()->user()->role) }}</span>
 <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline btn-sm">Log out</button></form>
 @endauth
 </div>
</header>
@if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert error"><b>Please check the following:</b><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@yield('content')
<footer class="footer">Passerelles Numériques Philippines · SmartLog</footer>
</body></html>
