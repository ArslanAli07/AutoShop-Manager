@extends('layouts.app')

@section('title', 'Customer: ' . $customer->name . ' | AutoShop Manager')
@section('meta_description',
    'View complete customer profile including contact info, registered vehicles, and full
    service history with costs.')
@section('page_title', $customer->name)

@section('content')
    <div class="space-y-6 w-full">

        {{-- Header: Matching Job Cards & Vehicle Profile style --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 border-b border-[var(--app-border)] pb-6 w-full">
            <div class="space-y-3">
                <div class="text-xs font-extrabold uppercase tracking-[0.2em] text-[var(--app-muted)]">Customer Profile</div>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-3xl font-extrabold tracking-tight text-[var(--app-text)]">{{ $customer->name }}</h1>
                    <span class="inline-flex items-center gap-2 rounded-xl border border-[var(--app-border)] px-4 py-2 text-sm font-bold shadow-sm bg-[var(--app-surface)] text-[var(--app-text)]">
                        <span class="font-black text-[var(--app-accent)]">{{ $customer->phone }}</span>
                    </span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('jobs.create', ['customer' => $customer->id]) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[var(--app-accent)] px-5 py-2.5 text-base font-bold text-black transition hover:opacity-90 shadow-sm cursor-pointer">
                    Add New Job Card
                </a>
                <a href="{{ route('customers.edit', $customer) }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] px-5 py-2.5 text-base font-bold text-[var(--app-text)] transition hover:bg-[var(--app-bg)] shadow-sm">
                    Edit
                </a>
                <form action="{{ route('customers.destroy', $customer) }}" method="post" class="inline-block"
                    onsubmit="return confirm('Delete this customer?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-2.5 text-base font-bold text-red-500 transition hover:bg-red-500/20 shadow-sm cursor-pointer">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Horizontal 3-Card Row --}}
        <div class="flex flex-row gap-6 w-full">

            {{-- Customer Info Card --}}
            <div class="flex-1 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-5 shadow-sm flex flex-col">
                <div class="flex items-center justify-between border-b border-[var(--app-border)] pb-3 mb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-[var(--app-muted)]">Customer Info</h3>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="flex flex-col gap-3 flex-1 justify-center">
                    <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Name</span>
                        <span class="text-sm font-black text-[var(--app-text)]">{{ $customer->name }}</span>
                    </div>
                    <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Phone</span>
                        <span class="text-sm font-bold text-[var(--app-text)]">{{ $customer->phone }}</span>
                    </div>
                    <div class="flex items-start justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Address</span>
                        <span class="text-sm font-bold text-[var(--app-text)] text-right max-w-[60%]">{{ $customer->address ?? '—' }}</span>
                    </div>
                    <div class="flex items-start justify-between w-full py-1.5">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Notes</span>
                        <span class="text-sm font-semibold text-[var(--app-muted)] text-right max-w-[60%] italic">{{ $customer->notes ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Shop Stats Card --}}
            <div class="flex-1 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-5 shadow-sm flex flex-col">
                <div class="flex items-center justify-between border-b border-[var(--app-border)] pb-3 mb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-[var(--app-muted)]">Shop Stats</h3>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                    </svg>
                </div>
                <div class="flex flex-col gap-3 flex-1 justify-center">
                    <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Registered Cars</span>
                        <span class="text-sm font-black text-[var(--app-accent)]">{{ $customer->cars->count() }} Cars</span>
                    </div>
                    <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Total Visits</span>
                        <span class="text-sm font-black text-[var(--app-accent)]">{{ $jobs->count() }} Visits</span>
                    </div>
                    <div class="flex items-center justify-between w-full py-1.5">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Total Spent</span>
                        <span class="text-sm font-black text-[var(--app-text)]">Rs. {{ number_format($totalSpent, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Registered Cars Card --}}
            <div class="flex-1 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-5 shadow-sm flex flex-col">
                <div class="flex items-center justify-between border-b border-[var(--app-border)] pb-3 mb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-[var(--app-muted)]">Registered Cars</h3>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v9a2 2 0 0 1-2 2h-2"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>
                    </svg>
                </div>
                <div class="flex flex-col gap-2 flex-1 justify-center">
                    @forelse ($customer->cars as $car)
                        <a href="{{ route('cars.show', $car) }}"
                            class="flex items-center justify-between w-full py-2 px-3 rounded-xl border border-[var(--app-border)]/60 hover:border-[var(--app-accent)] hover:bg-[var(--app-bg)]/30 transition-all">
                            <span class="text-sm font-black text-[var(--app-accent)]">{{ $car->plate_number }}</span>
                            <span class="text-xs font-semibold text-[var(--app-muted)]">{{ $car->make }} {{ $car->model }}{{ $car->year ? ' • ' . $car->year : '' }}</span>
                        </a>
                    @empty
                        <div class="flex flex-1 items-center justify-center">
                            <p class="text-sm italic text-[var(--app-muted)]">No cars registered yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Service History Card --}}
        <section class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6 shadow-sm w-full">
            <div class="flex items-center justify-between gap-4 border-b border-[var(--app-border)] pb-4 mb-6">
                <div>
                    <div class="text-xs font-extrabold uppercase tracking-[0.2em] text-[var(--app-muted)]">Service History</div>
                    <h3 class="mt-1 font-display text-2xl font-black text-[var(--app-text)]">All Visits</h3>
                </div>
                <a href="{{ route('jobs.create', ['customer' => $customer->id]) }}"
                    class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 text-sm font-bold text-[var(--app-text)] transition hover:bg-[var(--app-bg)] shadow-sm">
                    Add New Job Card
                </a>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[var(--app-muted)] font-bold border-b border-[var(--app-border)] bg-[var(--app-bg)]/30">
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Date In</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Car</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Services</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Parts</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Total</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--app-border)]/50">
                        @forelse ($jobs as $job)
                            <tr class="hover:bg-[var(--app-bg)]/30 transition-colors">
                                <td class="px-4 py-3.5 font-bold text-[var(--app-text)]">{{ $job->date_in?->format('d M, Y') }}</td>
                                <td class="px-4 py-3.5">
                                    <div class="font-extrabold text-[var(--app-accent)]">{{ $job->car?->plate_number }}</div>
                                    <div class="text-xs font-semibold text-[var(--app-muted)]">{{ $job->car?->make }} {{ $job->car?->model }}</div>
                                </td>
                                <td class="px-4 py-3.5 font-semibold text-[var(--app-text)] max-w-xs truncate">
                                    {{ $job->services->pluck('description')->implode(', ') ?: '—' }}
                                </td>
                                <td class="px-4 py-3.5 font-semibold text-[var(--app-text)] max-w-xs truncate">
                                    {{ $job->parts->pluck('part_name')->implode(', ') ?: '—' }}
                                </td>
                                <td class="px-4 py-3.5 font-black text-[var(--app-text)]">Rs. {{ number_format($job->grand_total, 2) }}</td>
                                <td class="px-4 py-3.5 font-bold">
                                    <span class="inline-flex rounded-xl px-2.5 py-1 text-xs font-bold
                                        @if($job->status === 'received') bg-blue-500/20 text-blue-400
                                        @elseif($job->status === 'in_progress') bg-amber-500/20 text-amber-400
                                        @elseif($job->status === 'ready') bg-emerald-500/20 text-emerald-400
                                        @elseif($job->status === 'delivered') bg-gray-500/20 text-gray-400
                                        @else bg-red-500/20 text-red-400 @endif">
                                        @if ($job->status === 'received') Car Received
                                        @elseif ($job->status === 'in_progress') Repairing
                                        @elseif ($job->status === 'ready') Ready for Pickup
                                        @elseif ($job->status === 'delivered') Delivered
                                        @else Cancelled @endif
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-sm font-semibold text-[var(--app-muted)]">No job history yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>
@endsection
