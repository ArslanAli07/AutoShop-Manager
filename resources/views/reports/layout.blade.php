@extends('layouts.app')

@section('title', 'Reports & Analytics | AutoShop Manager')
@section('meta_description', 'View business insights, revenue, outstanding payments, and job statuses.')
@section('page_title', 'Reports & Analytics')

@section('content')
    <div class="max-w-6xl">
        {{-- Reports Navigation & Filters --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            
            {{-- Tabs --}}
            <nav class="flex gap-2 overflow-x-auto pb-2 sm:pb-0" aria-label="Tabs">
                <a href="{{ route('reports.revenue', request()->only('period')) }}"
                    class="rounded-xl px-4 py-2 text-sm font-semibold transition
                    {{ request()->routeIs('reports.revenue') ? 'bg-[var(--app-accent)] text-black' : 'text-[var(--app-muted)] hover:bg-[var(--app-surface)] hover:text-[var(--app-text)]' }}">
                    Revenue
                </a>
                <a href="{{ route('reports.outstanding', request()->only('period')) }}"
                    class="rounded-xl px-4 py-2 text-sm font-semibold transition
                    {{ request()->routeIs('reports.outstanding') ? 'bg-[var(--app-accent)] text-black' : 'text-[var(--app-muted)] hover:bg-[var(--app-surface)] hover:text-[var(--app-text)]' }}">
                    Outstanding
                </a>
                <a href="{{ route('reports.job_status', request()->only('period')) }}"
                    class="rounded-xl px-4 py-2 text-sm font-semibold transition
                    {{ request()->routeIs('reports.job_status') ? 'bg-[var(--app-accent)] text-black' : 'text-[var(--app-muted)] hover:bg-[var(--app-surface)] hover:text-[var(--app-text)]' }}">
                    Job Status
                </a>
                <a href="{{ route('reports.services_parts', request()->only('period')) }}"
                    class="rounded-xl px-4 py-2 text-sm font-semibold transition
                    {{ request()->routeIs('reports.services_parts') ? 'bg-[var(--app-accent)] text-black' : 'text-[var(--app-muted)] hover:bg-[var(--app-surface)] hover:text-[var(--app-text)]' }}">
                    Services & Parts
                </a>
            </nav>

            {{-- Date Filter --}}
            @if(!request()->routeIs('reports.outstanding'))
                <form method="GET" class="flex items-center gap-2">
                    <label for="period" class="text-sm text-[var(--app-muted)]">Timeframe:</label>
                    <select name="period" id="period" onchange="this.form.submit()"
                        class="rounded-lg border border-[var(--app-border)] bg-[var(--app-surface)] px-3 py-1.5 text-sm font-medium outline-none focus:border-[var(--app-accent)]">
                        <option value="today" {{ (request('period') ?? 'month') === 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ (request('period') ?? 'month') === 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ (request('period') ?? 'month') === 'month' ? 'selected' : '' }}>This Month</option>
                        <option value="year" {{ (request('period') ?? 'month') === 'year' ? 'selected' : '' }}>This Year</option>
                    </select>
                </form>
            @endif
        </div>

        {{-- Report Content --}}
        <div class="mt-4">
            @yield('report_content')
        </div>
    </div>
@endsection
