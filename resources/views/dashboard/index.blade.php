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
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
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
                                        <x-status-badge :status="$job->status" />
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
                                    <x-payment-badge :status="$job->payment_status" />
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
