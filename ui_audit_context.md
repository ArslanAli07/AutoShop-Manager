
# UI Audit Context — AutoShop Manager

---

## 1. Full View File Contents

### `resources/views/layouts/app.blade.php`

```blade
<!-- SEO: semantic HTML, dynamic titles, meta descriptions, ARIA roles applied -->
<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#0D0D0D">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <title>@yield('title', 'AutoShop Manager')</title>
    <meta name="description" content="@yield('meta_description', 'Professional auto shop job card management system for PKR pricing, bilingual Urdu support, and complete customer and vehicle tracking.')" <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=IBM+Plex+Sans:wght@300;400;500;600;700&family=Noto+Nastaliq+Urdu:wght@400;600&display=swap"
        rel="stylesheet">

    <script>
        (function() {
            const storageKey = 'autoshop-theme';
            const storedTheme = localStorage.getItem(storageKey);
            const preferredTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const activeTheme = storedTheme || preferredTheme;

            document.documentElement.classList.toggle('dark', activeTheme === 'dark');
            document.documentElement.dataset.theme = activeTheme;
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[var(--app-bg)] text-[var(--app-text)] antialiased">
    <div class="relative min-h-screen lg:grid lg:grid-cols-[15rem_minmax(0,1fr)]">
        <aside role="complementary" aria-label="Main navigation sidebar" data-sidebar data-open="false"
            class="fixed inset-y-0 left-0 z-40 flex w-60 -translate-x-full flex-col border-r border-[var(--app-border)] bg-[var(--app-surface)]/95 backdrop-blur-xl transition-transform duration-300 ease-out lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:w-auto lg:translate-x-0 lg:self-start lg:shadow-none">
            <div class="flex items-center gap-3 border-b border-[var(--app-border)] px-6 py-5">
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl border border-[color:color-mix(in_srgb,var(--app-accent)_30%,transparent)] bg-[color:color-mix(in_srgb,var(--app-accent)_14%,transparent)] text-sm font-bold text-[var(--app-accent)]">
                    AS
                </div>
                <div>
                    <div class="font-display text-lg font-bold tracking-wide">AutoShop</div>
                </div>
            </div>

            <nav role="navigation" aria-label="Main application navigation" class="flex-1 px-4 py-5 overflow-y-auto">
                @php
                    $navItems = [
                        [
                            'url'   => route('dashboard'),
                            'label' => 'Dashboard',
                            'match' => 'dashboard',
                            'svg'   => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
                        ],
                        [
                            'url'   => route('intake.create'),
                            'label' => 'Quick Intake',
                            'match' => 'intake.*',
                            'svg'   => '<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>',
                        ],
                        [
                            'url'   => route('customers.index'),
                            'label' => 'Customers',
                            'match' => 'customers.*',
                            'svg'   => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                        ],
                        [
                            'url'   => route('cars.index'),
                            'label' => 'Cars',
                            'match' => 'cars.*',
                            'svg'   => '<path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v9a2 2 0 0 1-2 2h-2"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>',
                        ],
                        [
                            'url'   => route('jobs.index'),
                            'label' => 'Job Cards',
                            'match' => 'jobs.*',
                            'svg'   => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/>',
                        ],
                        [
                            'url'   => route('presets.index'),
                            'label' => 'Services',
                            'match' => 'presets.*',
                            'svg'   => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
                        ],
                        [
                            'url'   => route('parts.index'),
                            'label' => 'Parts',
                            'match' => 'parts.*',
                            'svg'   => '<polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"/><line x1="12" y1="22" x2="12" y2="15.5"/><polyline points="22 8.5 12 15.5 2 8.5"/>',
                        ],
                        [
                            'url'   => route('reports.revenue'),

                            'label' => 'Reports',
                            'match' => 'reports.*',
                            'svg'   => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>',
                        ],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    @php $isActive = request()->routeIs($item['match']); @endphp
                    <a href="{{ $item['url'] }}"
                        class="mt-1 flex items-center gap-3 rounded-2xl border px-3 py-3 text-sm font-medium transition
                            {{ $isActive
                                ? 'border-[var(--app-accent)]/30 bg-[color:color-mix(in_srgb,var(--app-accent)_10%,transparent)] text-[var(--app-accent)]'
                                : 'border-transparent text-[var(--app-text)] hover:border-[var(--app-border)] hover:bg-[color:color-mix(in_srgb,var(--app-accent)_5%,transparent)]' }}"
                        @if ($isActive) aria-current="page" @endif>
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            {!! $item['svg'] !!}
                        </svg>
                        <span class="block font-display text-base leading-tight">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- Mode box removed --}}
        </aside>

        <div class="flex min-h-screen min-w-0 flex-1 flex-col">
            <header role="banner"
                class="sticky top-0 z-30 border-b border-[var(--app-border)] bg-[color:color-mix(in_srgb,var(--app-bg)_76%,transparent)] backdrop-blur-xl">
                <div
                    class="mx-auto flex w-full max-w-[90rem] items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button type="button" data-sidebar-toggle
                            class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] text-[var(--app-text)] transition hover:border-[var(--app-accent)] lg:hidden"
                            aria-label="Toggle navigation sidebar">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 stroke-current" stroke-width="1.8"
                                stroke-linecap="round" aria-hidden="true">
                                <path d="M4 6h16" />
                                <path d="M4 12h16" />
                                <path d="M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <h1 class="font-display text-xl font-bold tracking-wide">@yield('page_title', 'Dashboard')</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" data-theme-toggle aria-label="Toggle dark/light theme"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[var(--app-border)] bg-[var(--app-surface)] text-[var(--app-text)] transition hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]">
                            <svg class="h-5 w-5 stroke-current theme-icon-light" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="5"></circle>
                                <line x1="12" y1="1" x2="12" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="23"></line>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                <line x1="1" y1="12" x2="3" y2="12"></line>
                                <line x1="21" y1="12" x2="23" y2="12"></line>
                                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                            </svg>
                            <svg class="h-5 w-5 stroke-current theme-icon-dark" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            @if (session('success') || session('error') || $errors->any())
                <div class="px-4 py-4 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div role="alert"
                            class="rounded-lg border border-(--app-border) bg-(--app-surface) px-4 py-3 text-sm text-green-700">
                            {{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div role="alert"
                            class="rounded-lg border border-(--app-border) bg-(--app-surface) px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div role="alert"
                            class="rounded-lg border border-(--app-border) bg-(--app-surface) px-4 py-3 text-sm text-red-700">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            <main role="main" class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                <div class="mx-auto w-full max-w-[90rem]">
                    @yield('content')
                </div>
            </main>
        </div>

        <div data-sidebar-backdrop
            class="pointer-events-none fixed inset-0 z-30 bg-black/50 opacity-0 transition-opacity duration-300 lg:hidden">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggles = document.querySelectorAll('[data-sidebar-toggle]');
            const sidebar = document.querySelector('[data-sidebar]');
            const backdrop = document.querySelector('[data-sidebar-backdrop]');
            let isOpen = false;

            function toggleSidebar() {
                isOpen = !isOpen;
                
                if (isOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    backdrop.classList.remove('pointer-events-none', 'opacity-0');
                    backdrop.classList.add('opacity-100');
                } else {
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.remove('opacity-100');
                    backdrop.classList.add('pointer-events-none', 'opacity-0');
                }
            }

            toggles.forEach(btn => btn.addEventListener('click', toggleSidebar));
            backdrop.addEventListener('click', toggleSidebar);
        });
    </script>
</body>

</html>

```

### `resources/views/dashboard/index.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Dashboard | AutoShop Manager — Arslan\'s Workshop')
@section('meta_description', 'Live overview of active jobs, today\'s revenue, unpaid invoices, and recent customer
    activity at Arslan\'s Workshop.')
@section('page_title', 'Dashboard')

@section('content')
    <div class="space-y-14">

        {{-- ── Header ──────────────────────────────────────────────── --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="font-display text-xl font-bold text-[var(--app-text)]">
                    {{ now()->format('l') }},
                    <span class="text-[var(--app-muted)] font-normal">{{ now()->format('d M Y') }}</span>
                </h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('customers.create') }}" id="btn-new-customer"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] px-5 py-2.5 text-sm font-bold text-[var(--app-text)] shadow-sm transition hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    New Customer
                </a>
                <a href="{{ route('intake.create') }}" id="btn-quick-intake"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--app-accent)]/35 bg-[color:color-mix(in_srgb,var(--app-accent)_8%,var(--app-surface))] px-5 py-2.5 text-sm font-bold text-[var(--app-accent)] shadow-sm transition hover:border-[var(--app-accent)] hover:bg-[color:color-mix(in_srgb,var(--app-accent)_12%,var(--app-surface))]">
                    <span aria-hidden="true">⚡</span>
                    Quick Intake
                </a>
                <a href="{{ route('jobs.create') }}" id="btn-new-job"
                    class="inline-flex items-center gap-2 rounded-xl bg-[var(--app-accent)] px-5 py-2.5 text-sm font-bold text-black shadow-sm transition hover:opacity-90">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Job Card
                </a>
            </div>
        </div>

        {{-- ── Stat Cards ───────────────────────────────────────────── --}}
        <section aria-label="Key statistics">
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Active Jobs --}}
                <a href="{{ route('jobs.index') }}" id="stat-active-jobs"
                    class="relative rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-4 transition hover:border-blue-400/50 hover:shadow-lg hover:shadow-blue-500/5 group block">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-[var(--app-muted)]">Active Jobs</p>
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500/10 text-blue-400 transition group-hover:bg-blue-500/20">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </span>
                    </div>
                    <p class="font-display text-3xl font-bold text-[var(--app-text)]">{{ $activeJobs }}</p>
                    <p class="mt-1 text-[11px] text-[var(--app-muted)]">Cars in shop now</p>
                </a>

                {{-- Today's Revenue --}}
                <div id="stat-today-revenue"
                    class="relative rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-[var(--app-muted)]">Today's Revenue
                        </p>
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500/10 text-emerald-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>
                    <p class="font-display text-3xl font-bold text-[var(--app-text)]">{{ number_format($todayRevenue) }}</p>
                    <p class="mt-1 text-[11px] text-[var(--app-muted)]">PKR received today</p>
                </div>

                {{-- This Month --}}
                <div id="stat-month-revenue"
                    class="relative rounded-2xl border border-[var(--app-accent)]/25 bg-[color:color-mix(in_srgb,var(--app-accent)_5%,var(--app-surface))] p-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-[var(--app-muted)]">
                            {{ now()->format('M') }} Revenue</p>
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-[var(--app-accent)]/15 text-[var(--app-accent)]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </span>
                    </div>
                    <p class="font-display text-3xl font-bold text-[var(--app-accent)]">{{ number_format($monthRevenue) }}
                    </p>
                    <p class="mt-1 text-[11px] text-[var(--app-muted)]">PKR this month</p>
                </div>

                {{-- Unpaid --}}
                <a href="{{ route('jobs.index', ['payment_status' => 'unpaid']) }}" id="stat-unpaid"
                    class="relative rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-4 transition hover:border-red-400/50 group block">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-[var(--app-muted)]">Unpaid</p>
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-500/10 text-red-400 transition group-hover:bg-red-500/20">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </span>
                    </div>
                    <p class="font-display text-3xl font-bold text-[var(--app-text)]">{{ $unpaidCount }}</p>
                    <p class="mt-1 text-[11px] text-red-400 font-medium">Rs. {{ number_format($unpaidTotal, 0) }} due</p>
                </a>

            </div>
        </section>

        {{-- ── Active Jobs + Top Customers ─────────────────────────── --}}
        <div class="grid gap-6 xl:grid-cols-3">

            {{-- Active Jobs Table --}}
            <section
                class="xl:col-span-2 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden"
                aria-label="Active jobs in workshop">
                <div class="flex items-center justify-between px-6 py-5 border-b border-[var(--app-border)]">
                    <div>
                        <h2 class="font-display text-lg font-semibold text-[var(--app-text)]">Active Jobs</h2>
                        <p class="text-xs text-[var(--app-muted)] mt-0.5">Cars currently in the workshop</p>
                    </div>
                    <a href="{{ route('jobs.index') }}"
                        class="text-xs font-semibold text-[var(--app-accent)] hover:underline">View all →</a>
                </div>

                @if ($activeJobsList->count() > 0)
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-[var(--app-border)]">
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest text-[var(--app-muted)]">
                                    Job</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest text-[var(--app-muted)]">
                                    Customer</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest text-[var(--app-muted)]">
                                    Vehicle</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest text-[var(--app-muted)]">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[var(--app-border)]">
                            @foreach ($activeJobsList as $job)
                                <tr class="transition hover:bg-[var(--app-bg)]">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('jobs.show', $job->id) }}"
                                            class="font-semibold text-[var(--app-accent)] hover:underline">
                                            {{ $job->job_number }}
                                        </a>
                                        <p class="text-xs text-[var(--app-muted)] mt-0.5">
                                            {{ $job->date_in?->format('d M Y') }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-[var(--app-text)]">{{ $job->customer?->name ?? '—' }}</td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-[var(--app-text)]">
                                            {{ $job->car?->plate_number ?? '—' }}</p>
                                        <p class="text-xs text-[var(--app-muted)] mt-0.5">{{ $job->car?->make }}
                                            {{ $job->car?->model }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-block rounded-full px-3 py-1 text-xs font-semibold
                                    @if ($job->status === 'received') bg-blue-500/15 text-blue-400
                                    @elseif($job->status === 'in_progress') bg-amber-500/15 text-amber-400
                                    @elseif($job->status === 'ready') bg-emerald-500/15 text-emerald-400
                                    @else bg-gray-500/15 text-gray-400 @endif">
                                            @if ($job->status === 'received') Car Received
                                            @elseif ($job->status === 'in_progress') Repairing
                                            @elseif ($job->status === 'ready') Ready for Pickup
                                            @elseif ($job->status === 'delivered') Delivered
                                            @else Cancelled @endif
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <svg class="h-12 w-12 text-[var(--app-border)] mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-sm font-medium text-[var(--app-muted)]">No active jobs right now</p>
                        <a href="{{ route('jobs.create') }}"
                            class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-[var(--app-accent)] hover:underline">
                            + Create a job card
                        </a>
                    </div>
                @endif
            </section>

            {{-- Top Customers --}}
            <section class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden"
                aria-label="Top customers by visits">
                <div class="flex items-center justify-between px-6 py-5 border-b border-[var(--app-border)]">
                    <div>
                        <h2 class="font-display text-lg font-semibold text-[var(--app-text)]">Top Customers</h2>
                        <p class="text-xs text-[var(--app-muted)] mt-0.5">Ranked by visits</p>
                    </div>
                    <a href="{{ route('customers.index') }}"
                        class="text-xs font-semibold text-[var(--app-accent)] hover:underline">All →</a>
                </div>
                <ul class="divide-y divide-[var(--app-border)]">
                    @forelse($topCustomers as $i => $customer)
                        <li class="flex items-center gap-4 px-6 py-4 transition hover:bg-[var(--app-bg)]">
                            <span
                                class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full text-sm font-bold
                        @if ($i === 0) bg-[var(--app-accent)]/20 text-[var(--app-accent)]
                        @elseif($i === 1) bg-gray-400/15 text-gray-400
                        @elseif($i === 2) bg-amber-700/15 text-amber-600
                        @else bg-[var(--app-border)] text-[var(--app-muted)] @endif">
                                {{ $i + 1 }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('customers.show', $customer->id) }}"
                                    class="block truncate text-sm font-semibold text-[var(--app-text)] hover:text-[var(--app-accent)] transition">
                                    {{ $customer->name }}
                                </a>
                                <p class="text-xs text-[var(--app-muted)] mt-0.5">
                                    {{ $customer->jobs_count }} visit{{ $customer->jobs_count !== 1 ? 's' : '' }}
                                </p>
                            </div>
                            <p class="flex-shrink-0 text-sm font-semibold text-[var(--app-accent)]">
                                Rs.&nbsp;{{ number_format($customer->jobs_sum_amount_paid ?? 0) }}
                            </p>
                        </li>
                    @empty
                        <li class="px-6 py-12 text-center text-sm text-[var(--app-muted)]">No customers yet</li>
                    @endforelse
                </ul>
            </section>

        </div>

        {{-- ── Recent Receipts ──────────────────────────────────────── --}}
        <section class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden"
            aria-label="Recent job card receipts">
            <div class="flex items-center justify-between px-6 py-5 border-b border-[var(--app-border)]">
                <div>
                    <h2 class="font-display text-lg font-semibold text-[var(--app-text)]">Recent Receipts</h2>
                    <p class="text-xs text-[var(--app-muted)] mt-0.5">Last 5 job cards</p>
                </div>
                <a href="{{ route('jobs.index') }}"
                    class="text-xs font-semibold text-[var(--app-accent)] hover:underline">View all →</a>
            </div>

            @if ($recentJobs->count() > 0)
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-[var(--app-border)]">
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest text-[var(--app-muted)]">
                                Job</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest text-[var(--app-muted)]">
                                Customer</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest text-[var(--app-muted)]">
                                Vehicle</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest text-[var(--app-muted)]">
                                Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-widest text-[var(--app-muted)]">
                                Payment</th>
                            <th scope="col" class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--app-border)]">
                        @foreach ($recentJobs as $job)
                            <tr class="transition hover:bg-[var(--app-bg)]">
                                <td class="px-6 py-4">
                                    <a href="{{ route('jobs.show', $job->id) }}"
                                        class="font-semibold text-[var(--app-accent)] hover:underline">
                                        {{ $job->job_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-[var(--app-text)]">{{ $job->customer?->name ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-[var(--app-text)]">{{ $job->car?->plate_number ?? '—' }}
                                    </p>
                                    <p class="text-xs text-[var(--app-muted)] mt-0.5">{{ $job->car?->make }}
                                        {{ $job->car?->model }}</p>
                                </td>
                                <td class="px-6 py-4 text-[var(--app-muted)]">{{ $job->date_in?->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold
                                @if ($job->payment_status === 'paid') bg-emerald-500/15 text-emerald-400
                                @elseif($job->payment_status === 'partial') bg-amber-500/15 text-amber-400
                                @else bg-red-500/15 text-red-400 @endif">
                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                    @if ($job->payment_status === 'paid') bg-emerald-400
                                    @elseif($job->payment_status === 'partial') bg-amber-400
                                    @else bg-red-400 @endif">
                                        </span>
                                        {{ ucfirst($job->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('jobs.show', $job->id) }}"
                                            class="text-xs font-semibold text-[var(--app-muted)] hover:text-[var(--app-text)] transition">View</a>
                                        <a href="{{ route('jobs.print', $job->id) }}" target="_blank"
                                            class="text-xs font-semibold text-[var(--app-muted)] hover:text-[var(--app-text)] transition">Print</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <svg class="h-12 w-12 text-[var(--app-border)] mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-sm font-medium text-[var(--app-muted)]">No job cards yet</p>
                    <a href="{{ route('jobs.create') }}"
                        class="mt-4 text-sm font-semibold text-[var(--app-accent)] hover:underline">
                        Create your first job card →
                    </a>
                </div>
            @endif
        </section>

    </div>
@endsection

```

### `resources/views/jobs/index.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Job Cards | AutoShop Manager')
@section('meta_description', 'Manage service job cards, track status, and manage payments.')

@section('content')
        {{-- Toolbar --}}
        <div class="mb-5 space-y-3">
            {{-- Main bar --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <form method="GET" action="{{ route('jobs.index') }}" id="jobs-search-form"
                    class="flex flex-1 items-center gap-2 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5">
                    <svg class="h-4 w-4 flex-shrink-0 text-[var(--app-muted)]" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by customer, phone, or plate…"
                        class="flex-1 bg-transparent text-sm outline-none placeholder-[var(--app-muted)]">
                    {{-- Hidden filter values carried along --}}
                    @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                    @if(request('payment_status'))<input type="hidden" name="payment_status" value="{{ request('payment_status') }}">@endif
                    @if(request('date_from'))<input type="hidden" name="date_from" value="{{ request('date_from') }}">@endif
                    @if(request('date_to'))<input type="hidden" name="date_to" value="{{ request('date_to') }}">@endif
                    @if(request('search') || request('status') || request('payment_status') || request('date_from') || request('date_to'))
                        <a href="{{ route('jobs.index') }}" aria-label="Clear all filters"
                            class="flex-shrink-0 text-[var(--app-muted)] hover:text-[var(--app-text)] transition">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </a>
                    @endif
                </form>

                {{-- Filter toggle --}}
                <button type="button" onclick="document.getElementById('jobs-filter-row').classList.toggle('hidden')"
                    class="inline-flex items-center gap-2 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 text-sm font-medium text-[var(--app-text)] transition hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/>
                    </svg>
                    Filters
                    @if(request('payment_status') || request('date_from') || request('date_to'))
                        <span class="h-2 w-2 rounded-full bg-[var(--app-accent)]"></span>
                    @endif
                </button>

                <a href="{{ route('jobs.create') }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-[var(--app-accent)] px-5 py-2.5 text-sm font-semibold text-black transition hover:opacity-90 flex-shrink-0">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    New Job
                </a>
            </div>

            {{-- Status Quick Filters --}}
            @php
                $currentStatus = request('status', '');
                $statuses = [
                    '' => 'All Statuses',
                    'received' => 'Received',
                    'in_progress' => 'In Progress',
                    'ready' => 'Ready',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled',
                ];
            @endphp
            <div class="flex flex-wrap gap-2 my-1">
                @foreach($statuses as $value => $label)
                    <a href="{{ request()->fullUrlWithQuery(['status' => $value ?: null]) }}"
                        class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-xs font-semibold border transition duration-150
                            {{ $currentStatus === $value
                                ? 'border-[var(--app-accent)] bg-[color:color-mix(in_srgb,var(--app-accent)_15%,var(--app-surface))] text-[var(--app-accent)] shadow-sm'
                                : 'border-[var(--app-border)] bg-[var(--app-surface)] text-[var(--app-text)] hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Expandable filter row --}}
            <form method="GET" action="{{ route('jobs.index') }}" id="jobs-filter-row"
                class="{{ (request('payment_status') || request('date_from') || request('date_to')) ? '' : 'hidden' }} rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-4">
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label for="payment_status" class="block text-xs font-semibold mb-1.5 text-[var(--app-muted)] uppercase tracking-wide">Payment</label>
                        <select id="payment_status" name="payment_status"
                            class="w-full rounded-xl border border-[var(--app-border)] bg-[var(--app-bg)] px-4 py-2.5 text-sm focus:border-[var(--app-accent)] focus:outline-none">
                            <option value="">All payments</option>
                            <option value="paid" @selected(request('payment_status') === 'paid')>Paid</option>
                            <option value="unpaid" @selected(request('payment_status') === 'unpaid')>Unpaid</option>
                            <option value="partial" @selected(request('payment_status') === 'partial')>Partial</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_from" class="block text-xs font-semibold mb-1.5 text-[var(--app-muted)] uppercase tracking-wide">From Date</label>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                            class="w-full rounded-xl border border-[var(--app-border)] bg-[var(--app-bg)] px-4 py-2.5 text-sm focus:border-[var(--app-accent)] focus:outline-none">
                    </div>
                    <div>
                        <label for="date_to" class="block text-xs font-semibold mb-1.5 text-[var(--app-muted)] uppercase tracking-wide">To Date</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}"
                            class="w-full rounded-xl border border-[var(--app-border)] bg-[var(--app-bg)] px-4 py-2.5 text-sm focus:border-[var(--app-accent)] focus:outline-none">
                    </div>
                </div>
                <div class="mt-4 flex gap-3">
                    <button type="submit"
                        class="rounded-xl bg-[var(--app-accent)] px-6 py-2 text-sm font-bold text-black transition hover:opacity-90">
                        Apply Filters
                    </button>
                    <a href="{{ route('jobs.index') }}"
                        class="rounded-xl border border-[var(--app-border)] px-6 py-2 text-sm font-semibold text-[var(--app-text)] transition hover:text-[var(--app-accent)]">
                        Clear All
                    </a>
                </div>
            </form>
        </div>

        <!-- Jobs Table -->
        <div class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden">
            @forelse($jobs as $job)
                @if ($loop->first)
                    <table class="w-full text-sm">
                        <thead class="border-b border-[var(--app-border)] bg-[var(--app-bg)]">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'job_number', 'direction' => $sortField === 'job_number' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center gap-1 hover:text-[var(--app-accent)]">
                                        Job # @if ($sortField === 'job_number')
                                            <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">Customer
                                </th>
                                <th scope="col" class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">Vehicle
                                </th>
                                <th scope="col" class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'date_in', 'direction' => $sortField === 'date_in' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center gap-1 hover:text-[var(--app-accent)]">
                                        Date In @if ($sortField === 'date_in')
                                            <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-4 text-right font-semibold text-[var(--app-text)]">Total
                                </th>
                                <th scope="col" class="px-6 py-4 text-center font-semibold text-[var(--app-text)]">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => $sortField === 'status' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center justify-center gap-1 hover:text-[var(--app-accent)]">
                                        Status @if ($sortField === 'status')
                                            <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-4 text-center font-semibold text-[var(--app-text)]">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'payment_status', 'direction' => $sortField === 'payment_status' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center justify-center gap-1 hover:text-[var(--app-accent)]">
                                        Payment @if ($sortField === 'payment_status')
                                            <span class="text-xs">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-4 text-right font-semibold text-[var(--app-text)]">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                @endif

                @php
                    $laborTotal = $job->services->sum('labor_cost');
                    $partsTotal = $job->parts->sum(function ($part) {
                        return $part->quantity * $part->unit_price;
                    });
                    $grandTotal = $laborTotal + $partsTotal;
                @endphp

                <tr
                    class="border-b border-[var(--app-border)] hover:bg-[color:color-mix(in_srgb,var(--app-accent)_5%,transparent)] transition">
                    <td class="px-6 py-4">
                        <a href="{{ route('jobs.show', $job->id) }}"
                            class="font-semibold text-[var(--app-accent)] hover:underline">
                            {{ $job->job_number }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        @if ($job->customer)
                            <a href="{{ route('customers.show', $job->customer->id) }}"
                                class="text-[var(--app-text)] font-medium hover:text-[var(--app-accent)]">
                                {{ $job->customer->name }}
                            </a>
                            <div class="text-xs text-[var(--app-muted)] mt-0.5">{{ $job->customer->phone }}</div>
                        @else
                            <span class="text-[var(--app-muted)] italic">Deleted Customer</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if ($job->car)
                            <a href="{{ route('cars.show', $job->car->id) }}"
                                class="text-[var(--app-text)] font-medium hover:text-[var(--app-accent)]">
                                {{ $job->car->plate_number }}
                            </a>
                            <div class="text-xs text-[var(--app-muted)] mt-0.5">{{ $job->car->make }} {{ $job->car->model }}
                            </div>
                        @else
                            <span class="text-[var(--app-muted)] italic">Deleted Vehicle</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-[var(--app-text)]">
                        {{ $job->date_in->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right font-semibold text-[var(--app-text)]">
                        Rs. {{ number_format($grandTotal, 0) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full border border-[var(--app-border)] bg-[var(--app-bg)] px-2.5 py-1 text-xs font-semibold text-[var(--app-text)]">
                            <span
                                class="h-1.5 w-1.5 rounded-full flex-shrink-0 
                                @if ($job->status === 'received') bg-blue-500
                                @elseif ($job->status === 'in_progress') bg-yellow-500
                                @elseif ($job->status === 'ready') bg-green-500
                                @elseif ($job->status === 'delivered') bg-gray-400
                                @else bg-red-500 @endif"></span>
                            @if ($job->status === 'received') Car Received
                            @elseif ($job->status === 'in_progress') Repairing
                            @elseif ($job->status === 'ready') Ready for Pickup
                            @elseif ($job->status === 'delivered') Delivered
                            @else Cancelled @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full border border-[var(--app-border)] bg-[var(--app-bg)] px-2.5 py-1 text-xs font-semibold text-[var(--app-text)]">
                            <span
                                class="h-1.5 w-1.5 rounded-full flex-shrink-0 
                                @if ($job->payment_status === 'paid') bg-green-500
                                @elseif ($job->payment_status === 'partial') bg-yellow-500
                                @else bg-red-500 @endif"></span>
                            {{ ucfirst($job->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('jobs.edit', $job->id) }}"
                                class="text-[var(--app-accent)] hover:text-[var(--app-accent)] opacity-70 hover:opacity-100 transition"
                                aria-label="Edit job">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('jobs.destroy', $job->id) }}" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this job?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 opacity-70 hover:opacity-100 transition"
                                    aria-label="Delete job">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                @if ($loop->last)
                    </tbody>
                    </table>
                @endif
            @empty
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-[var(--app-muted)] opacity-50" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 font-medium text-[var(--app-text)]">No job cards found</h3>
                    <p class="mt-1 text-sm text-[var(--app-muted)]">Get started by creating a new job card</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($jobs->hasPages())
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        @endif
    </section>
@endsection

```

### `resources/views/jobs/show.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Job Card ' . $job->job_number . ' | AutoShop Manager')
@section('meta_description', 'View and manage job card details, services, parts, and payment status.')

@section('content')
    <section aria-label="Job card details" class="w-full space-y-6">

        {{-- Flash Success --}}
        @if (session('success'))
            <div id="flash-success"
                class="mb-4 flex items-center gap-3 rounded-2xl border border-green-500/30 bg-green-500/10 px-5 py-4 text-base text-green-400 shadow-sm transition-all duration-300">
                <svg class="h-6 w-6 flex-shrink-0 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Header: Perfect Symmetrical Layout (Approved - Keep Intact) --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 border-b border-[var(--app-border)] pb-6 w-full">
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-3xl font-extrabold tracking-tight text-[var(--app-text)]">{{ $job->job_number }}</h1>
                    
                    {{-- Status Badges: Spacious Paddings & High-Fidelity SVG Icons --}}
                    <div class="flex flex-wrap items-center gap-2">
                        {{-- Job Status Pill --}}
                        <span class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-sm font-bold shadow-sm
                            @if ($job->status === 'received') border-blue-500/30 bg-blue-500/10 text-blue-400
                            @elseif ($job->status === 'in_progress') border-amber-500/30 bg-amber-500/10 text-amber-400
                            @elseif ($job->status === 'ready') border-emerald-500/30 bg-emerald-500/10 text-emerald-400
                            @elseif ($job->status === 'delivered') border-gray-500/30 bg-gray-500/10 text-gray-400
                            @else border-red-500/30 bg-red-500/10 text-red-400 @endif">
                            @if ($job->status === 'received')
                                <svg class="h-4 w-4 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z" />
                                </svg>
                                Car Received
                            @elseif ($job->status === 'in_progress')
                                <svg class="h-4 w-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Repairing
                            @elseif ($job->status === 'ready')
                                <svg class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Ready for Pickup
                            @elseif ($job->status === 'delivered')
                                <svg class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Delivered
                            @else
                                <svg class="h-4 w-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancelled
                            @endif
                        </span>

                        {{-- Payment Status Pill --}}
                        <span class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-sm font-bold shadow-sm
                            @if ($job->payment_status === 'paid') border-emerald-500/30 bg-emerald-500/10 text-emerald-400
                            @elseif ($job->payment_status === 'partial') border-amber-500/30 bg-amber-500/10 text-amber-400
                            @else border-red-500/30 bg-red-500/10 text-red-400 @endif">
                            @if ($job->payment_status === 'paid')
                                <svg class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Fully Paid
                            @elseif($job->payment_status === 'partial')
                                <svg class="h-4 w-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" />
                                </svg>
                                Partially Paid
                            @else
                                <svg class="h-4 w-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Unpaid
                            @endif
                        </span>
                    </div>
                </div>
                <p class="text-base text-[var(--app-muted)] flex items-center gap-1.5">
                    <svg class="h-5 w-5 text-[var(--app-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Job Card &mdash; Created <span class="font-bold text-[var(--app-text)]">{{ $job->created_at->format('M d, Y H:i') }}</span>
                </p>
            </div>

            {{-- Actions Buttons --}}
            <div class="flex flex-wrap items-center gap-3">
                {{-- Quick Progress Action Button --}}
                @if ($job->status === 'received')
                    <form method="POST" action="{{ route('jobs.update-status', $job->id) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="in_progress">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-base font-bold text-white transition hover:bg-blue-700 shadow-sm hover:shadow cursor-pointer">
                            ⚙️ Start Repairing
                        </button>
                    </form>
                @elseif ($job->status === 'in_progress')
                    <form method="POST" action="{{ route('jobs.update-status', $job->id) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="ready">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[var(--app-accent)] px-5 py-2.5 text-base font-bold text-black transition hover:opacity-90 shadow-sm hover:shadow cursor-pointer">
                            ✅ Mark Ready
                        </button>
                    </form>
                @elseif ($job->status === 'ready')
                    <form method="POST" action="{{ route('jobs.update-status', $job->id) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="delivered">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-base font-bold text-white transition hover:bg-emerald-700 shadow-sm hover:shadow cursor-pointer">
                            🔑 Deliver
                        </button>
                    </form>
                @endif

                <a href="{{ route('jobs.print', $job->id) }}" target="_blank"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] px-5 py-2.5 text-base font-bold text-[var(--app-text)] transition hover:bg-[var(--app-bg)] shadow-sm">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Receipt
                </a>
                @if ($job->payment_status !== 'paid')
                    <button onclick="document.getElementById('payment-modal').classList.remove('hidden')"
                        class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-5 py-2.5 text-base font-bold text-white transition hover:bg-green-700 shadow-sm hover:shadow">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Record Payment
                    </button>
                @endif
                <a href="{{ route('jobs.edit', $job->id) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[var(--app-accent)] px-5 py-2.5 text-base font-bold text-black transition hover:opacity-90 shadow-sm">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <!-- strictly Horizontal 3-Column Profile Row (Forced Flex-Row side-by-side) -->
        <div class="flex flex-row gap-6 w-full mb-6">

            {{-- Customer Card --}}
            <div class="flex-1 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-5 shadow-sm flex flex-col">
                {{-- Card Header --}}
                <div class="flex items-center justify-between border-b border-[var(--app-border)] pb-3 mb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-[var(--app-muted)]">Customer</h3>
                    <span class="text-base">👤</span>
                </div>
                {{-- Full-width label/value rows --}}
                <div class="flex flex-col gap-3 flex-1 justify-center">
                    @if ($job->customer)
                        <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Name</span>
                            <a href="{{ route('customers.show', $job->customer->id) }}"
                                class="text-sm font-black text-[var(--app-accent)] hover:underline">
                                {{ $job->customer->name }}
                            </a>
                        </div>
                        <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Phone</span>
                            <span class="text-sm font-bold text-[var(--app-text)]">📞 {{ $job->customer->phone }}</span>
                        </div>
                        <div class="flex items-start justify-between w-full py-1.5">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Address</span>
                            <span class="text-sm font-bold text-[var(--app-text)] text-right max-w-[60%]">📍 {{ $job->customer->address }}</span>
                        </div>
                    @else
                        <div class="flex flex-1 items-center justify-center">
                            <p class="text-sm italic text-[var(--app-muted)]">Deleted Customer</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Vehicle Card --}}
            <div class="flex-1 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-5 shadow-sm flex flex-col">
                {{-- Card Header --}}
                <div class="flex items-center justify-between border-b border-[var(--app-border)] pb-3 mb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-[var(--app-muted)]">Vehicle</h3>
                    <span class="text-base">🚗</span>
                </div>
                {{-- Full-width label/value rows --}}
                <div class="flex flex-col gap-3 flex-1 justify-center">
                    @if ($job->car)
                        <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Plate No.</span>
                            <a href="{{ route('cars.show', $job->car->id) }}"
                                class="text-sm font-black text-[var(--app-accent)] hover:underline">
                                {{ $job->car->plate_number }}
                            </a>
                        </div>
                        <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Make & Model</span>
                            <span class="text-sm font-bold text-[var(--app-text)]">{{ $job->car->make }} {{ $job->car->model }}</span>
                        </div>
                        <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Color</span>
                            <span class="text-sm font-bold text-[var(--app-text)]">🎨 {{ $job->car->color }}</span>
                        </div>
                        <div class="flex items-center justify-between w-full py-1.5">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Year</span>
                            <span class="text-sm font-bold text-[var(--app-text)]">📅 {{ $job->car->year }}</span>
                        </div>
                    @else
                        <div class="flex flex-1 items-center justify-center">
                            <p class="text-sm italic text-[var(--app-muted)]">Deleted Vehicle</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Dates & Mileage Card --}}
            <div class="flex-1 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-5 shadow-sm flex flex-col">
                {{-- Card Header --}}
                <div class="flex items-center justify-between border-b border-[var(--app-border)] pb-3 mb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-[var(--app-muted)]">Dates & Mileage</h3>
                    <span class="text-base">📊</span>
                </div>
                {{-- Full-width label/value rows --}}
                <div class="flex flex-col gap-3 flex-1 justify-center">
                    <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Date In</span>
                        <span class="text-sm font-bold text-[var(--app-text)]">{{ $job->date_in->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Mileage In</span>
                        <span class="text-sm font-bold text-[var(--app-accent)]">{{ $job->mileage_in ? number_format($job->mileage_in) . ' km' : 'N/A' }}</span>
                    </div>
                    @if ($job->date_out)
                        <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Date Out</span>
                            <span class="text-sm font-bold text-[var(--app-text)]">{{ $job->date_out->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between w-full py-1.5">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Mileage Out</span>
                            <span class="text-sm font-bold text-[var(--app-accent)]">{{ $job->mileage_out ? number_format($job->mileage_out) . ' km' : 'N/A' }}</span>
                        </div>
                    @else
                        <div class="flex items-center justify-between w-full py-1.5">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Date Out</span>
                            <span class="text-sm font-semibold text-[var(--app-muted)] italic">Not yet delivered</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Services & Parts: Side-by-Side Responsive Grid -->
        <div class="grid gap-6 lg:grid-cols-2 w-full">
            {{-- Services Table --}}
            <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] shadow-sm overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="border-b border-[var(--app-border)] bg-[var(--app-bg)] px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-base font-bold">
                            <span>🛠️</span>
                            <h2 class="text-[var(--app-text)] font-extrabold">Services Performed</h2>
                        </div>
                        <span class="rounded-full bg-[var(--app-border)] px-3 py-1 text-xs font-extrabold text-[var(--app-text)]">
                            {{ $job->services->count() }} Items
                        </span>
                    </div>
                    @if ($job->services->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-[var(--app-border)] bg-[var(--app-bg)]/30">
                                        <th scope="col" class="px-5 py-2.5 text-left font-bold uppercase tracking-wider text-xs text-[var(--app-muted)]">Description</th>
                                        <th scope="col" class="px-5 py-2.5 text-right font-bold uppercase tracking-wider text-xs text-[var(--app-muted)] w-36">Labor Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[var(--app-border)]/50">
                                    @foreach ($job->services as $service)
                                        <tr class="hover:bg-[var(--app-bg)]/40 transition-colors">
                                            <td class="px-5 py-3">
                                                @if ($service->servicePreset)
                                                    <div class="font-extrabold text-[var(--app-text)]">{{ $service->servicePreset->name }}</div>
                                                    @if ($service->description)
                                                        <div class="text-xs text-[var(--app-muted)] mt-1 font-semibold leading-normal">{{ $service->description }}</div>
                                                    @endif
                                                @else
                                                    <div class="font-extrabold text-[var(--app-text)]">{{ $service->description ?? 'Custom Service' }}</div>
                                                @endif
                                            </td>
                                            <td class="px-5 py-3 text-right font-extrabold text-[var(--app-text)]">
                                                Rs. {{ number_format($service->labor_cost, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center text-sm text-[var(--app-muted)] flex flex-col items-center justify-center gap-2">
                            <span>🔧</span>
                            <span class="font-semibold">No services added to this job card</span>
                        </div>
                    @endif
                </div>
                
                {{-- Services Subtotal --}}
                @if ($job->services->count() > 0)
                    <div class="bg-[var(--app-bg)]/45 border-t border-[var(--app-border)] px-6 py-3 flex items-center justify-between text-sm font-extrabold">
                        <span class="text-[var(--app-muted)] uppercase tracking-wider text-xs">Labor Subtotal</span>
                        <span class="text-[var(--app-text)]">Rs. {{ number_format($laborTotal, 2) }}</span>
                    </div>
                @endif
            </div>

            {{-- Parts Table --}}
            <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] shadow-sm overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="border-b border-[var(--app-border)] bg-[var(--app-bg)] px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-base font-bold">
                            <span>📦</span>
                            <h2 class="text-[var(--app-text)] font-extrabold">Parts Replaced</h2>
                        </div>
                        <span class="rounded-full bg-[var(--app-border)] px-3 py-1 text-xs font-extrabold text-[var(--app-text)]">
                            {{ $job->parts->count() }} Items
                        </span>
                    </div>
                    @if ($job->parts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-[var(--app-border)] bg-[var(--app-bg)]/30">
                                        <th scope="col" class="px-5 py-2.5 text-left font-bold uppercase tracking-wider text-xs text-[var(--app-muted)]">Part Name & Number</th>
                                        <th scope="col" class="px-5 py-2.5 text-center font-bold uppercase tracking-wider text-xs text-[var(--app-muted)] w-20">Qty</th>
                                        <th scope="col" class="px-5 py-2.5 text-right font-bold uppercase tracking-wider text-xs text-[var(--app-muted)] w-28">Price</th>
                                        <th scope="col" class="px-5 py-2.5 text-right font-bold uppercase tracking-wider text-xs text-[var(--app-muted)] w-32">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[var(--app-border)]/50">
                                    @foreach ($job->parts as $part)
                                        @php $total = $part->quantity * $part->unit_price; @endphp
                                        <tr class="hover:bg-[var(--app-bg)]/40 transition-colors">
                                            <td class="px-5 py-3">
                                                @if ($part->partsReference)
                                                    <div class="font-extrabold text-[var(--app-text)]">{{ $part->partsReference->name }}</div>
                                                    @if ($part->partsReference->part_number)
                                                        <div class="text-xs text-[var(--app-muted)] mt-1 font-mono">#{{ $part->partsReference->part_number }}</div>
                                                    @endif
                                                @else
                                                    <div class="font-extrabold text-[var(--app-text)]">{{ $part->part_name ?? 'Custom Part' }}</div>
                                                    @if ($part->part_number)
                                                        <div class="text-xs text-[var(--app-muted)] mt-1 font-mono">#{{ $part->part_number }}</div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-5 py-3 text-center font-bold">{{ number_format($part->quantity, 1) }}</td>
                                            <td class="px-5 py-3 text-right text-[var(--app-muted)] font-semibold">Rs. {{ number_format($part->unit_price) }}</td>
                                            <td class="px-5 py-3 text-right font-extrabold text-[var(--app-text)]">Rs. {{ number_format($total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center text-sm text-[var(--app-muted)] flex flex-col items-center justify-center gap-2">
                            <span>📦</span>
                            <span class="font-semibold">No parts added to this job card</span>
                        </div>
                    @endif
                </div>

                {{-- Parts Subtotal --}}
                @if ($job->parts->count() > 0)
                    <div class="bg-[var(--app-bg)]/45 border-t border-[var(--app-border)] px-6 py-3 flex items-center justify-between text-sm font-extrabold">
                        <span class="text-[var(--app-muted)] uppercase tracking-wider text-xs">Parts Subtotal</span>
                        <span class="text-[var(--app-text)]">Rs. {{ number_format($partsTotal, 2) }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Super Sleek Horizontal Totals Summary Strip (Centered horizontally & Larger Fonts) -->
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6 shadow-sm w-full">
            <div class="flex flex-row items-center justify-center gap-6 md:gap-12 text-center">
                <div class="flex items-center gap-2 text-base md:text-lg">
                    <span class="font-extrabold text-[var(--app-muted)] uppercase tracking-wider">Labor Total:</span>
                    <span class="font-bold text-[var(--app-text)]">Rs. {{ number_format($laborTotal, 2) }}</span>
                </div>
                <div class="h-6 w-px bg-[var(--app-border)]"></div>
                <div class="flex items-center gap-2 text-base md:text-lg">
                    <span class="font-extrabold text-[var(--app-muted)] uppercase tracking-wider">Parts Total:</span>
                    <span class="font-bold text-[var(--app-text)]">Rs. {{ number_format($partsTotal, 2) }}</span>
                </div>
                <div class="h-6 w-px bg-[var(--app-border)]"></div>
                <div class="bg-[color:color-mix(in_srgb,var(--app-accent)_10%,transparent)] px-5 py-2.5 rounded-xl border border-[color:color-mix(in_srgb,var(--app-accent)_35%,transparent)] flex items-center gap-2 text-lg md:text-xl">
                    <span class="font-extrabold text-[var(--app-accent)] uppercase tracking-wider">Grand Total:</span>
                    <span class="font-black text-[var(--app-text)]">Rs. {{ number_format($grandTotal, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Notes Section --}}
        @if ($job->notes)
            <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] shadow-sm p-5 w-full">
                <h3 class="text-sm font-extrabold text-[var(--app-text)] mb-3 flex items-center gap-2">
                    <span>📝</span>
                    <span>Service Notes</span>
                </h3>
                <p class="text-sm text-[var(--app-text)] whitespace-pre-wrap leading-relaxed bg-[var(--app-bg)]/45 p-4 rounded-xl border border-[var(--app-border)]/50 font-medium">
                    {{ $job->notes }}
                </p>
            </div>
        @endif

        <!-- Consolidated Unified Footer Section: strictly horizontal row on all viewports -->
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] shadow-md p-6 w-full flex flex-row flex-wrap items-center justify-center gap-8 md:gap-14">
            {{-- Payment Breakdown (Left side - Large fonts) --}}
            <div class="flex flex-row items-center justify-center gap-6 md:gap-8">
                <div class="space-y-0.5 text-center">
                    <p class="text-xs font-extrabold text-[var(--app-muted)] uppercase tracking-wider">Total Amount</p>
                    <p class="text-xl font-black text-[var(--app-text)]">Rs. {{ number_format($grandTotal, 2) }}</p>
                </div>
                <div class="h-8 w-px bg-[var(--app-border)]"></div>
                <div class="space-y-0.5 text-center">
                    <p class="text-xs font-extrabold text-[var(--app-muted)] uppercase tracking-wider">Amount Paid</p>
                    <p class="text-xl font-black text-[var(--app-accent)]">Rs. {{ number_format($job->amount_paid, 2) }}</p>
                </div>
                <div class="h-8 w-px bg-[var(--app-border)]"></div>
                <div class="space-y-0.5 text-center">
                    <p class="text-xs font-extrabold text-[var(--app-muted)] uppercase tracking-wider">Balance Due</p>
                    <p class="text-xl font-black @if ($grandTotal - $job->amount_paid <= 0) text-green-500 @else text-red-500 @endif">
                        Rs. {{ number_format(max(0, $grandTotal - $job->amount_paid), 2) }}
                    </p>
                </div>
            </div>

            {{-- Vertical Separator --}}
            <div class="h-10 w-px bg-[var(--app-border)]"></div>

            {{-- Action Buttons (Right side - Horizontal row) --}}
            <div class="flex flex-row flex-wrap items-center justify-center gap-3">
                <a href="{{ route('jobs.print', $job->id) }}" target="_blank"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--app-border)] px-5 py-2.5 text-sm font-bold text-[var(--app-text)] transition hover:bg-[var(--app-bg)] shadow-sm bg-[var(--app-surface)] justify-center">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Receipt
                </a>
                <a href="{{ route('jobs.edit', $job->id) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[var(--app-accent)] px-6 py-2.5 text-sm font-bold text-black transition hover:opacity-90 shadow-sm justify-center">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Job Card
                </a>
                <a href="{{ route('jobs.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--app-border)] px-5 py-2.5 text-sm font-bold text-[var(--app-text)] transition hover:bg-[var(--app-bg)] shadow-sm bg-[var(--app-surface)] justify-center">
                    Back to List
                </a>
            </div>
        </div>
    </section>

    {{-- Payment Modal --}}
    <div id="payment-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center" aria-modal="true"
        role="dialog" aria-labelledby="modal-title">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            onclick="document.getElementById('payment-modal').classList.add('hidden')"></div>

        {{-- Modal Card --}}
        <div
            class="relative z-10 w-full max-w-md mx-4 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6 shadow-2xl">
            <h2 id="modal-title" class="text-lg font-semibold text-[var(--app-text)] mb-1">Record Payment</h2>
            <p class="text-sm text-[var(--app-muted)] mb-5">
                Job: <strong class="text-[var(--app-text)]">{{ $job->job_number }}</strong> &mdash;
                Grand Total: <strong class="text-[var(--app-accent)]">Rs. {{ number_format($grandTotal) }}</strong>
            </p>

            @php
                $balanceDue = max(0, (float) $grandTotal - (float) $job->amount_paid);
            @endphp

            <form method="POST" action="{{ route('jobs.payment', $job->id) }}" class="space-y-4">
                @csrf
                <div>
                    <label for="amount_paid" class="block text-sm font-semibold text-[var(--app-text)] mb-2">
                        Amount Being Paid (Rs.)
                    </label>
                    <input type="number" id="amount_paid" name="amount_paid" min="0.01" step="0.01"
                        inputmode="decimal" max="{{ number_format($balanceDue, 2, '.', '') }}"
                        value="{{ number_format($balanceDue, 2, '.', '') }}" required
                        class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-bg)] px-5 py-3 text-sm transition focus:border-[var(--app-accent)] focus:outline-none focus:ring-1 focus:ring-[var(--app-accent)]"
                        placeholder="Amount in Rs." />

                    <p class="mt-2 text-xs text-[var(--app-muted)]">
                        Already paid: Rs. {{ number_format($job->amount_paid, 2) }} &bull;
                        Balance due: Rs. {{ number_format($balanceDue, 2) }} &bull;
                        Max: Rs. {{ number_format($balanceDue, 2) }}
                    </p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 rounded-lg bg-green-600 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700">
                        ✓ Confirm Payment
                    </button>
                    <button type="button" onclick="document.getElementById('payment-modal').classList.add('hidden')"
                        class="flex-1 rounded-lg border border-[var(--app-border)] py-2.5 text-sm font-medium text-[var(--app-text)] transition hover:bg-[var(--app-bg)]">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-dismiss flash message after 4 seconds
        const flash = document.getElementById('flash-success');
        if (flash) setTimeout(() => flash.style.opacity = '0', 3500);
    </script>
@endsection

```

### `resources/views/jobs/create.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Create Job Card | AutoShop Manager')
@section('meta_description', 'Create a new service job card with services and parts.')

@section('content')
    @php
        $preselectedCustomerId = old('customer_id', request()->query('customer') ?? request()->query('customer_id'));
        $preselectedCarId = old('car_id', request()->query('car') ?? request()->query('car_id'));

        if (!$preselectedCustomerId && $preselectedCarId) {
            $foundCar = \App\Models\Car::withTrashed()->find($preselectedCarId);
            if ($foundCar) {
                $preselectedCustomerId = $foundCar->customer_id;
            }
        }
    @endphp

    <section aria-label="Create new job card" class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-[var(--app-text)]">New Job Card</h1>
            <p class="mt-1 text-sm text-[var(--app-muted)]">Create a new service job with customer, vehicle, services, and
                parts</p>
        </div>

        <form method="POST" action="{{ route('jobs.store') }}" class="space-y-6">
            @csrf

            <!-- Customer & Vehicle Selection -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <h2 class="mb-4 text-lg font-semibold text-[var(--app-text)]">Customer & Vehicle</h2>

                <div class="grid gap-4 lg:grid-cols-2">
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-[var(--app-text)]">
                            Customer *
                        </label>
                        <select id="customer_id" name="customer_id" required style="color-scheme: dark;"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none"
                            onchange="updateCars()">
                            <option value="">Select customer owner...</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @selected($preselectedCustomerId == $customer->id)>
                                    {{ $customer->name }} ({{ $customer->phone }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
 
                    <div>
                        <label for="car_id" class="block text-sm font-medium text-[var(--app-text)]">
                            Vehicle *
                        </label>
                        <select id="car_id" name="car_id" required style="color-scheme: dark;"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none">
                            <option value="">Select vehicle...</option>
                        </select>
                        @error('car_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 lg:grid-cols-2 pt-4">
                    <div>
                        <label for="date_in" class="block text-sm font-medium text-[var(--app-text)]">
                            Date In *
                        </label>
                        <input type="date" id="date_in" name="date_in"
                            value="{{ old('date_in', today()->format('Y-m-d')) }}" required
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                        @error('date_in')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mileage_in" class="block text-sm font-medium text-[var(--app-text)]">
                            Mileage In (km)
                        </label>
                        <input type="number" id="mileage_in" name="mileage_in" min="0" placeholder="125000"
                            value="{{ old('mileage_in') }}"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] placeholder-[var(--app-muted)] focus:border-[var(--app-accent)] focus:outline-none" />
                        @error('mileage_in')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-[var(--app-text)]">Services</h2>
                    <button type="button" onclick="addService()" class="text-sm text-[var(--app-accent)] hover:underline">
                        + Add Service
                    </button>
                </div>

                <div id="services-container" class="space-y-3">
                    <!-- Services will be added here -->
                </div>

                @error('services')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parts -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-[var(--app-text)]">Parts</h2>
                    <button type="button" onclick="addPart()" class="text-sm text-[var(--app-accent)] hover:underline">
                        + Add Part
                    </button>
                </div>

                <div id="parts-container" class="space-y-3">
                    <!-- Parts will be added here -->
                </div>

                @error('parts')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <label for="notes" class="block text-sm font-medium text-[var(--app-text)]">
                    Notes
                </label>
                <textarea id="notes" name="notes" placeholder="Special instructions, known issues, customer requests…"
                    class="mt-2 w-full min-h-24 rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] placeholder-[var(--app-muted)] focus:border-[var(--app-accent)] focus:outline-none">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex gap-3 pt-4">
                <button type="submit"
                    class="rounded-lg bg-[var(--app-accent)] px-6 py-2 font-semibold text-black transition hover:opacity-90">
                    Save Job Card
                </button>
                <a href="{{ route('jobs.index') }}"
                    class="rounded-lg border border-[var(--app-border)] px-6 py-2 text-sm font-medium text-[var(--app-text)] transition hover:bg-[var(--app-bg)]">
                    Cancel
                </a>
            </div>
        </form>
    </section>

    <!-- Service Presets Data (for JavaScript) -->
    <script type="application/json" id="service-presets-data">
        {!! json_encode($servicePresets->mapWithKeys(fn($p) => [$p->id => ['name' => $p->name, 'default_labor_cost' => $p->default_labor_cost]])) !!}
    </script>

    <!-- Parts Reference Data (for JavaScript) -->
    <script type="application/json" id="parts-reference-data">
        {!! json_encode($partReferences->mapWithKeys(fn($p) => [$p->id => ['name' => $p->name, 'default_price' => $p->default_price, 'part_number' => $p->part_number]])) !!}
    </script>

    <!-- Cars Data (for JavaScript) -->
    <script type="application/json" id="cars-data">
        {!! json_encode($customers->mapWithKeys(fn($c) => [$c->id => $c->cars->map(fn($car) => ['id' => $car->id, 'plate_number' => $car->plate_number, 'make' => $car->make, 'model' => $car->model])->toArray()])) !!}
    </script>

    <script>
        const servicePresets = JSON.parse(document.getElementById('service-presets-data').textContent);
        const partsReference = JSON.parse(document.getElementById('parts-reference-data').textContent);
        const carsData = JSON.parse(document.getElementById('cars-data').textContent);
        let serviceCount = 0;
        let partCount = 0;

        function updateCars() {
            const customerId = document.getElementById('customer_id').value;
            const carSelect = document.getElementById('car_id');
            carSelect.innerHTML = '<option value="">Select vehicle...</option>';

            if (customerId && carsData[customerId]) {
                carsData[customerId].forEach(car => {
                    const option = document.createElement('option');
                    option.value = car.id;
                    option.textContent = `${car.plate_number} - ${car.make} ${car.model}`;
                    carSelect.appendChild(option);
                });
            }
        }

        // Auto-run on page load for pre-filled customers
        document.addEventListener('DOMContentLoaded', () => {
            const customerSelect = document.getElementById('customer_id');
            if (customerSelect && customerSelect.value) {
                updateCars();
                
                // Read car_id from URL, Old input, or preselected PHP variable
                const urlParams = new URLSearchParams(window.location.search);
                const preselectedCarId = urlParams.get('car') || urlParams.get('car_id') || "{{ $preselectedCarId }}";
                
                const carSelect = document.getElementById('car_id');
                if (preselectedCarId && carSelect.querySelector(`option[value="${preselectedCarId}"]`)) {
                    carSelect.value = preselectedCarId;
                } else if (carSelect.options.length === 2) {
                    // Auto-select if customer has exactly one car (length is 2: index 0 is placeholder, index 1 is car)
                    carSelect.selectedIndex = 1;
                }
            }
        });

        function addService() {
            const container = document.getElementById('services-container');
            const index = serviceCount++;
            const html = `
                <div class="service-row flex gap-2 items-end" id="service-${index}">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Service or Preset</label>
                        <select name="services[${index}][service_preset_id]" class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" onchange="fillServiceDetails(${index})">
                            <option value="">Select or enter custom</option>
                            ${Object.entries(servicePresets).map(([id, preset]) => `<option value="${id}">${preset.name} - Rs. ${preset.default_labor_cost}</option>`).join('')}
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Description</label>
                        <input type="text" name="services[${index}][description]" placeholder="Description or notes" class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] placeholder-[var(--app-muted)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <div class="w-24">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Labor Cost</label>
                        <input type="number" name="services[${index}][labor_cost]" min="0" step="1" placeholder="2500" value="0" required class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <button type="button" onclick="removeService(${index})" class="px-2 py-1 text-red-500 hover:text-red-700 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function fillServiceDetails(index) {
            const select = document.querySelector(`[name="services[${index}][service_preset_id]"]`);
            const presetId = select.value;
            if (presetId && servicePresets[presetId]) {
                document.querySelector(`[name="services[${index}][labor_cost]"]`).value = servicePresets[presetId]
                    .default_labor_cost;
            }
        }

        function removeService(index) {
            document.getElementById(`service-${index}`).remove();
        }

        function addPart() {
            const container = document.getElementById('parts-container');
            const index = partCount++;
            const html = `
                <div class="part-row flex gap-2 items-end" id="part-${index}">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Part or Reference</label>
                        <select name="parts[${index}][parts_reference_id]" class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" onchange="fillPartDetails(${index})">
                            <option value="">Select or enter custom</option>
                            ${Object.entries(partsReference).map(([id, part]) => `<option value="${id}">${part.name} (${part.part_number || 'N/A'}) - Rs. ${part.default_price}</option>`).join('')}
                        </select>
                    </div>
                    <div class="w-24">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Qty</label>
                        <input type="number" name="parts[${index}][quantity]" min="1" step="1" placeholder="1" value="1" required class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <div class="w-28">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Unit Price</label>
                        <input type="number" name="parts[${index}][unit_price]" min="0" step="1" placeholder="1500" value="0" required class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <button type="button" onclick="removePart(${index})" class="px-2 py-1 text-red-500 hover:text-red-700 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function fillPartDetails(index) {
            const select = document.querySelector(`[name="parts[${index}][parts_reference_id]"]`);
            const partId = select.value;
            if (partId && partsReference[partId]) {
                document.querySelector(`[name="parts[${index}][unit_price]"]`).value = partsReference[partId].default_price;
            }
        }

        function removePart(index) {
            document.getElementById(`part-${index}`).remove();
        }
    </script>
@endsection

```

### `resources/views/jobs/edit.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Edit Job Card ' . $job->job_number . ' | AutoShop Manager')
@section('meta_description', 'Edit service job card details, services, parts, and payment status.')

@section('content')
    <section aria-label="Edit job card" class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-[var(--app-text)]">Edit {{ $job->job_number }}</h1>
            <p class="mt-1 text-sm text-[var(--app-muted)]">Update job details, services, parts, and status</p>
        </div>

        <form method="POST" action="{{ route('jobs.update', $job->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Customer & Vehicle Selection -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <h2 class="mb-4 text-lg font-semibold text-[var(--app-text)]">Customer & Vehicle</h2>

                <div class="grid gap-4 lg:grid-cols-2">
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-[var(--app-text)]">
                            Customer *
                        </label>
                        <select id="customer_id" name="customer_id" required style="color-scheme: dark;"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none"
                            onchange="updateCars()">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @selected($job->customer_id === $customer->id)>
                                    {{ $customer->name }} ({{ $customer->phone }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
 
                    <div>
                        <label for="car_id" class="block text-sm font-medium text-[var(--app-text)]">
                            Vehicle *
                        </label>
                        <select id="car_id" name="car_id" required style="color-scheme: dark;"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none">
                            <option value="{{ $job->car->id }}" selected>
                                {{ $job->car->plate_number }} - {{ $job->car->make }} {{ $job->car->model }}
                            </option>
                        </select>
                        @error('car_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 lg:grid-cols-4 pt-4">
                    <div>
                        <label for="date_in" class="block text-sm font-medium text-[var(--app-text)]">
                            Date In *
                        </label>
                        <input type="date" id="date_in" name="date_in" value="{{ $job->date_in->format('Y-m-d') }}"
                            required
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                        @error('date_in')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mileage_in" class="block text-sm font-medium text-[var(--app-text)]">
                            Mileage In
                        </label>
                        <input type="number" id="mileage_in" name="mileage_in" min="0"
                            value="{{ $job->mileage_in }}"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>

                    <div>
                        <label for="date_out" class="block text-sm font-medium text-[var(--app-text)]">
                            Date Out
                        </label>
                        <input type="date" id="date_out" name="date_out" value="{{ $job->date_out?->format('Y-m-d') }}"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>

                    <div>
                        <label for="mileage_out" class="block text-sm font-medium text-[var(--app-text)]">
                            Mileage Out
                        </label>
                        <input type="number" id="mileage_out" name="mileage_out" min="0"
                            value="{{ $job->mileage_out }}"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                </div>
            </div>

            <!-- Status & Payment -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6 mb-6">
                <h2 class="mb-6 text-lg font-semibold text-[var(--app-text)]">Status & Payment</h2>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <label for="status" class="block text-sm font-medium text-[var(--app-text)]">
                            Job Status *
                        </label>
                        <select id="status" name="status" required style="color-scheme: dark;"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none">
                            <option value="received" @selected($job->status === 'received')>Car Received</option>
                            <option value="in_progress" @selected($job->status === 'in_progress')>Repairing</option>
                            <option value="ready" @selected($job->status === 'ready')>Ready for Pickup</option>
                            <option value="delivered" @selected($job->status === 'delivered')>Delivered</option>
                            <option value="cancelled" @selected($job->status === 'cancelled')>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
 
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-[var(--app-text)]">
                            Payment Status *
                        </label>
                        <select id="payment_status" name="payment_status" required style="color-scheme: dark;"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none">
                            <option value="paid" @selected($job->payment_status === 'paid')>Paid</option>
                            <option value="unpaid" @selected($job->payment_status === 'unpaid')>Unpaid</option>
                            <option value="partial" @selected($job->payment_status === 'partial')>Partial</option>
                        </select>
                        @error('payment_status')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
 
                    <div>
                        <label for="amount_paid" class="block text-sm font-medium text-[var(--app-text)]">
                            Amount Paid *
                        </label>
                        <input type="number" id="amount_paid" name="amount_paid" min="0" step="1"
                            value="{{ $job->amount_paid }}" required
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                        @error('amount_paid')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-[var(--app-text)]">Services</h2>
                    <button type="button" onclick="addService()" class="text-sm text-[var(--app-accent)] hover:underline">
                        + Add Service
                    </button>
                </div>

                <div id="services-container" class="space-y-3">
                    @foreach ($job->services as $index => $service)
                        <div class="service-row flex gap-2 items-end" id="service-{{ $index }}">
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Service or
                                    Preset</label>
                                <select name="services[{{ $index }}][service_preset_id]"
                                    class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none"
                                    onchange="fillServiceDetails({{ $index }})">
                                    <option value="">Select or enter custom</option>
                                    @foreach ($servicePresets as $preset)
                                        <option value="{{ $preset->id }}" @selected($service->service_preset_id === $preset->id)>
                                            {{ $preset->name }} - Rs. {{ $preset->default_labor_cost }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Description</label>
                                <input type="text" name="services[{{ $index }}][description]"
                                    value="{{ $service->description }}" placeholder="Description or notes"
                                    class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] placeholder-[var(--app-muted)] focus:border-[var(--app-accent)] focus:outline-none" />
                            </div>
                            <div class="w-24">
                                <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Labor Cost</label>
                                <input type="number" name="services[{{ $index }}][labor_cost]" min="0"
                                    step="1" value="{{ $service->labor_cost }}" required
                                    class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                            </div>
                            <button type="button" onclick="removeService({{ $index }})"
                                class="px-2 py-1 text-red-500 hover:text-red-700 transition">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                @error('services')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parts -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-[var(--app-text)]">Parts</h2>
                    <button type="button" onclick="addPart()" class="text-sm text-[var(--app-accent)] hover:underline">
                        + Add Part
                    </button>
                </div>

                <div id="parts-container" class="space-y-3">
                    @foreach ($job->parts as $index => $part)
                        <div class="part-row flex gap-2 items-end" id="part-{{ $index }}">
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Part or
                                    Reference</label>
                                <select name="parts[{{ $index }}][parts_reference_id]"
                                    class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none"
                                    onchange="fillPartDetails({{ $index }})">
                                    <option value="">Select or enter custom</option>
                                    @foreach ($partReferences as $reference)
                                        <option value="{{ $reference->id }}" @selected($part->parts_reference_id === $reference->id)>
                                            {{ $reference->name }} ({{ $reference->part_number || 'N/A' }}) - Rs.
                                            {{ $reference->default_price }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-24">
                                <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Qty</label>
                                <input type="number" name="parts[{{ $index }}][quantity]" min="1"
                                    step="1" value="{{ $part->quantity }}" required
                                    class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                            </div>
                            <div class="w-28">
                                <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Unit Price</label>
                                <input type="number" name="parts[{{ $index }}][unit_price]" min="0"
                                    step="1" value="{{ $part->unit_price }}" required
                                    class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                            </div>
                            <button type="button" onclick="removePart({{ $index }})"
                                class="px-2 py-1 text-red-500 hover:text-red-700 transition">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                @error('parts')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <label for="notes" class="block text-sm font-medium text-[var(--app-text)]">
                    Notes
                </label>
                <textarea id="notes" name="notes" placeholder="Special instructions, known issues, customer requests…"
                    class="mt-2 w-full min-h-24 rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] placeholder-[var(--app-muted)] focus:border-[var(--app-accent)] focus:outline-none">{{ old('notes', $job->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex gap-3 pt-4">
                <button type="submit"
                    class="rounded-lg bg-[var(--app-accent)] px-6 py-2 font-semibold text-black transition hover:opacity-90">
                    Update Job Card
                </button>
                <a href="{{ route('jobs.show', $job->id) }}"
                    class="rounded-lg border border-[var(--app-border)] px-6 py-2 text-sm font-medium text-[var(--app-text)] transition hover:bg-[var(--app-bg)]">
                    Cancel
                </a>
            </div>
        </form>
    </section>

    <!-- Service Presets Data (for JavaScript) -->
    <script type="application/json" id="service-presets-data">
        {!! json_encode($servicePresets->mapWithKeys(fn($p) => [$p->id => ['name' => $p->name, 'default_labor_cost' => $p->default_labor_cost]])) !!}
    </script>

    <!-- Parts Reference Data (for JavaScript) -->
    <script type="application/json" id="parts-reference-data">
        {!! json_encode($partReferences->mapWithKeys(fn($p) => [$p->id => ['name' => $p->name, 'default_price' => $p->default_price, 'part_number' => $p->part_number]])) !!}
    </script>

    <!-- Cars Data (for JavaScript) -->
    <script type="application/json" id="cars-data">
        {!! json_encode($cars->mapWithKeys(fn($c) => [$c->id => ['id' => $c->id, 'plate_number' => $c->plate_number, 'make' => $c->make, 'model' => $c->model, 'customer_id' => $c->customer_id]])) !!}
    </script>

    <script>
        const servicePresets = JSON.parse(document.getElementById('service-presets-data').textContent);
        const partsReference = JSON.parse(document.getElementById('parts-reference-data').textContent);
        const carsData = JSON.parse(document.getElementById('cars-data').textContent);
        let serviceCount = {{ $job->services->count() }};
        let partCount = {{ $job->parts->count() }};

        function updateCars() {
            const customerId = document.getElementById('customer_id').value;
            const carSelect = document.getElementById('car_id');
            carSelect.innerHTML = '<option value="">Select vehicle...</option>';

            for (const [carId, car] of Object.entries(carsData)) {
                if (car.customer_id == customerId) {
                    const option = document.createElement('option');
                    option.value = car.id;
                    option.textContent = `${car.plate_number} - ${car.make} ${car.model}`;
                    carSelect.appendChild(option);
                }
            }
        }

        function addService() {
            const container = document.getElementById('services-container');
            const index = serviceCount++;
            const html = `
                <div class="service-row flex gap-2 items-end" id="service-${index}">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Service or Preset</label>
                        <select name="services[${index}][service_preset_id]" class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" onchange="fillServiceDetails(${index})">
                            <option value="">Select or enter custom</option>
                            ${Object.entries(servicePresets).map(([id, preset]) => `<option value="${id}">${preset.name} - Rs. ${preset.default_labor_cost}</option>`).join('')}
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Description</label>
                        <input type="text" name="services[${index}][description]" placeholder="Description or notes" class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] placeholder-[var(--app-muted)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <div class="w-24">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Labor Cost</label>
                        <input type="number" name="services[${index}][labor_cost]" min="0" step="1" placeholder="2500" value="0" required class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <button type="button" onclick="removeService(${index})" class="px-2 py-1 text-red-500 hover:text-red-700 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function fillServiceDetails(index) {
            const select = document.querySelector(`[name="services[${index}][service_preset_id]"]`);
            const presetId = select.value;
            if (presetId && servicePresets[presetId]) {
                document.querySelector(`[name="services[${index}][labor_cost]"]`).value = servicePresets[presetId]
                    .default_labor_cost;
            }
        }

        function removeService(index) {
            document.getElementById(`service-${index}`).remove();
        }

        function addPart() {
            const container = document.getElementById('parts-container');
            const index = partCount++;
            const html = `
                <div class="part-row flex gap-2 items-end" id="part-${index}">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Part or Reference</label>
                        <select name="parts[${index}][parts_reference_id]" class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" onchange="fillPartDetails(${index})">
                            <option value="">Select or enter custom</option>
                            ${Object.entries(partsReference).map(([id, part]) => `<option value="${id}">${part.name} (${part.part_number || 'N/A'}) - Rs. ${part.default_price}</option>`).join('')}
                        </select>
                    </div>
                    <div class="w-24">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Qty</label>
                        <input type="number" name="parts[${index}][quantity]" min="1" step="1" placeholder="1" value="1" required class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <div class="w-28">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Unit Price</label>
                        <input type="number" name="parts[${index}][unit_price]" min="0" step="1" placeholder="1500" value="0" required class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <button type="button" onclick="removePart(${index})" class="px-2 py-1 text-red-500 hover:text-red-700 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function fillPartDetails(index) {
            const select = document.querySelector(`[name="parts[${index}][parts_reference_id]"]`);
            const partId = select.value;
            if (partId && partsReference[partId]) {
                document.querySelector(`[name="parts[${index}][unit_price]"]`).value = partsReference[partId].default_price;
            }
        }

        function removePart(index) {
            document.getElementById(`part-${index}`).remove();
        }
    </script>
@endsection

```

---

## 2. Tailwind Configuration

**No `tailwind.config.js` exists.** The project uses Tailwind CSS v4 with CSS-based configuration. See Section 3 for the `@theme` block in `resources/css/app.css`.

---

## 3. Custom CSS / resources/css/app.css

```css
@import "tailwindcss";

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';
@source '../**/*.blade.php';
@source '../**/*.js';

@theme {
    --font-sans:
        "IBM Plex Sans", ui-sans-serif, system-ui, sans-serif,
        "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol",
        "Noto Color Emoji";
    --font-display: "Syne", ui-sans-serif, system-ui, sans-serif;
}

:root {
    --app-bg: #f5f4f0;
    --app-surface: #ffffff;
    --app-border: #e0ddd5;
    --app-accent: #c4960a;
    --app-text: #111111;
    --app-muted: #888888;
}

html.dark {
    --app-bg: #0d0d0d;
    --app-surface: #161616;
    --app-border: #2a2a2a;
    --app-accent: #e8c84a;
    --app-text: #f2f2f2;
    --app-muted: #6b6b6b;
}

html {
    color-scheme: light;
    font-size: 15.5px;
}

html.dark {
    color-scheme: dark;
}

body {
    background:
        radial-gradient(
            circle at top left,
            rgba(196, 150, 10, 0.09),
            transparent 34%
        ),
        radial-gradient(
            circle at top right,
            rgba(0, 0, 0, 0.03),
            transparent 30%
        ),
        var(--app-bg);
    color: var(--app-text);
    font-family: var(--font-sans);
    text-transform: uppercase;
}

h1,
h2,
h3,
h4,
.font-display {
    font-family: var(--font-display);
}

/* Form inputs keep normal casing while typing,
   but displayed values are uppercased by the body rule */
input,
textarea,
select {
    text-transform: none;
}

::selection {
    background: rgba(196, 150, 10, 0.24);
    color: var(--app-text);
}

/* ── Theme toggle label ─────────────────────────── */
/* Light mode: show "Light", hide "Dark" */
.theme-label-dark {
    display: none;
}
.theme-label-light {
    display: inline;
}

/* Dark mode: show "Dark", hide "Light" */
html[data-theme="dark"] .theme-label-light {
    display: none;
}
html[data-theme="dark"] .theme-label-dark {
    display: inline;
}

/* ── Theme toggle icons ─────────────────────────── */
/* Light mode: show sun, hide moon */
.theme-icon-dark {
    display: none;
}
.theme-icon-light {
    display: inline;
}

/* Dark mode: show moon, hide sun */
html[data-theme="dark"] .theme-icon-light {
    display: none;
}
html[data-theme="dark"] .theme-icon-dark {
    display: inline;
}

/* ── Select & Option Dark Mode Fix ──────────────── */
select {
    background-color: var(--app-surface) !important;
    color: var(--app-text) !important;
}

html.dark select {
    color-scheme: dark !important;
    background-color: var(--app-surface) !important;
    color: var(--app-text) !important;
}

```

---

## 4. Emoji Characters in Inline Markup

The following emoji characters are used inline in Blade templates across the codebase:

**resources/views/dashboard/index.blade.php:**
- Line 30: ⚡ (high voltage sign) — Quick Intake button icon
- Lines 11, 43, 125, 254: Unicode box-drawing characters in Blade comments

**resources/views/jobs/show.blade.php:**
- Line 105: ⚙️ (gear) — "Start Repairing" button text
- Line 114: ✅ (check mark button) — "Mark Ready" button text
- Line 123: 🔑 (key) — "Deliver" button text
- Line 162: 👤 (bust in silhouette) — Customer card header icon
- Line 176: 📞 (telephone receiver) — Customer phone display
- Line 180: 📍 (round pushpin) — Customer address display
- Line 195: 🚗 (car) — Vehicle card header icon
- Line 213: 🎨 (artist palette) — Car color display
- Line 217: 📅 (calendar) — Car year display
- Line 232: 📊 (bar chart) — Dates & Mileage card header icon
- Line 271: 🛠️ (hammer and wrench) — Services section header icon
- Line 310: 🔧 (wrench) — Empty services state
- Line 330: 📦 (package) — Parts section header icon
- Line 375: 📦 (package) — Empty parts state
- Line 415: 📝 (memo) — Notes section header icon
- Line 515: ✓ (check mark) — Confirm Payment button

**resources/views/jobs/index.blade.php:**
- Lines 126, 138, 148, 156: ▲/▼ (sort direction indicators)

**resources/views/jobs/print.blade.php:**
- Line 466: ⏰ (alarm clock) — Next service reminder
- Lines 54, 281: Unicode box-drawing in CSS comments

**resources/views/customers/show.blade.php:**
- Line 19: 📞 (telephone receiver) — Phone heading
- Line 53: 👤 (bust in silhouette) — Customer card header icon
- Line 62: 📞 (telephone receiver) — Phone value
- Line 66: 📍 (round pushpin) — Address value
- Line 79: 📊 (bar chart) — Job history header icon
- Line 101: 🚗 (car) — Vehicles card header icon

**resources/views/cars/show.blade.php:**
- Line 19: 🚗 (car) — Plate heading
- Line 54: 🚗 (car) — Vehicle card header icon
- Line 82: 👤 (bust in silhouette) — Owner card header icon
- Line 96: 📞 (telephone) — Phone value
- Line 100: 📍 (round pushpin) — Address value
- Line 115: 📊 (bar chart) — Job history header icon

**resources/views/intake_create.blade.php:**
- Line 192: ⚡ (high voltage sign) — Quick Intake button icon

**resources/views/reports/outstanding.blade.php:**
- Line 60: 🎉 (party popper) — Empty state celebration

---

## 5. Installed Icon Packages

### composer.json
No icon packages are installed. The `require` section contains only `laravel/framework` and `laravel/tinker`. No `blade-ui-kit/blade-icons`, `blade-heroicons`, or any other Blade icon package is present.

### package.json
No icon packages are installed. The `devDependencies` contain only `@tailwindcss/vite`, `concurrently`, `laravel-vite-plugin`, `tailwindcss`, and `vite`. No `heroicons`, `lucide`, `font-awesome`, or any other icon library.

**Conclusion: No icon package is installed.** All icons in the project are either inline SVG paths (in navigation, buttons, stat cards, etc.) or Unicode emoji characters (used decoratively in card headers and data display labels).

---

## 6. Contents of resources/views/components/

**The `resources/views/components/` directory does not exist.** There are no reusable Blade components (no `.blade.php` files under `resources/views/components/`). All UI patterns (cards, badges, buttons, pills, tables) are built with copy-pasted inline Tailwind utility classes in every view file. There is no component-based abstraction layer.

