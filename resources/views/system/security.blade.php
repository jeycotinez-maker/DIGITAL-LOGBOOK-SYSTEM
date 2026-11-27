@extends('layouts.app')
@section('title','Security')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading">
            <div><div class="eyebrow">SYSTEM ADMINISTRATION</div><h1>Security</h1><p>Basic application configuration checks. Review warnings before deployment.</p></div>
        </header>
        <section class="panel">
            <div class="panel-head"><h2>Security checks</h2></div>
            <div class="security-check-list">
                @foreach($checks as $check)
                    <div class="security-check">
                        <span class="health-indicator {{ $check['ok'] ? 'health-ok' : 'health-error' }}">{{ $check['ok'] ? 'OK' : 'Review' }}</span>
                        <div><strong>{{ $check['label'] }}</strong><p class="muted">{{ $check['detail'] }}</p></div>
                    </div>
                @endforeach
            </div>
            <p class="muted security-footnote">These checks report the current application configuration; they are not a substitute for a full security assessment.</p>
        </section>
    </main>
</div>
@endsection
