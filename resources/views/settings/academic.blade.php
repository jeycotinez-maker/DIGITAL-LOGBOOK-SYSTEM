@extends('layouts.app')
@section('title','Academic Settings')
@section('content')
<div class="app-shell">
    @include('components.sidebar')
    <main class="dashboard">
        <header class="page-heading"><div><div class="eyebrow">SYSTEM CONFIGURATION</div><h1>Academic Settings</h1><p>Set the current academic period and update window.</p></div></header>
        <section class="panel form-panel">
            <form method="POST" action="{{ route('settings.academic.update') }}" class="form-stack">
                @csrf
                <label>School year<input name="school_year" value="{{ old('school_year',$setting->school_year ?? '2026-2027') }}" required></label>
                <label>Semester
                    <select name="semester" required>
                        <option value="1st Semester" {{ old('semester',$setting->semester ?? '') === '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                        <option value="2nd Semester" {{ old('semester',$setting->semester ?? '') === '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                        <option value="Summer" {{ old('semester',$setting->semester ?? '') === 'Summer' ? 'selected' : '' }}>Summer</option>
                    </select>
                </label>
                <label>Academic information update period
                    <select name="update_open" required>
                        <option value="0" {{ old('update_open',(int)($setting->update_open ?? 0)) === 0 ? 'selected' : '' }}>Closed</option>
                        <option value="1" {{ old('update_open',(int)($setting->update_open ?? 0)) === 1 ? 'selected' : '' }}>Open</option>
                    </select>
                </label>
                <label>Update deadline (optional)
                    <input type="datetime-local" name="update_deadline" value="{{ old('update_deadline',$setting->update_deadline?->format('Y-m-d\\TH:i')) }}">
                </label>
                <button class="btn btn-primary">Save settings</button>
            </form>
        </section>
    </main>
</div>
@endsection
