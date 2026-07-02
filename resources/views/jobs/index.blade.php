@extends('layouts.app')

@section('title', 'Job Cards | AutoShop Manager')
@section('meta_description', 'Manage service job cards, track status, and manage payments.')
@section('page_title', 'Job Cards')

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
                        <x-status-badge :status="$job->status" />
                    </td>
                    <td class="px-6 py-4 text-center">
                        <x-payment-badge :status="$job->payment_status" />
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
                    <div class="mt-6">
                        <a href="{{ route('jobs.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-[var(--app-accent)] px-5 py-2.5 text-sm font-bold text-black transition hover:opacity-90 shadow-sm hover:shadow">
                            + Create Job Card
                        </a>
                    </div>
                </div>
            @endforelse
        </div>


        @if ($jobs->hasPages())
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        @endif
    </section>
@endsection
