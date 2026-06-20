@extends('layouts.app')

@section('title', 'Vehicle: ' . $car->plate_number . ' | AutoShop Manager')
@section('meta_description',
    'View vehicle details, owner information, and complete service history including dates,
    services performed, and costs.')
@section('page_title', $car->plate_number)

@section('content')
    <div class="space-y-6 w-full">
        
        {{-- Header: Perfect Symmetrical Layout (Matching Job Cards style) --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 border-b border-[var(--app-border)] pb-6 w-full">
            <div class="space-y-3">
                <div class="text-xs font-extrabold uppercase tracking-[0.2em] text-[var(--app-muted)]">Vehicle Profile</div>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-3xl font-extrabold tracking-tight text-[var(--app-text)]">{{ $car->make }} {{ $car->model }}</h1>
                    <span class="inline-flex items-center gap-2 rounded-xl border border-[var(--app-border)] px-4 py-2 text-sm font-bold shadow-sm bg-[var(--app-surface)] text-[var(--app-text)]">
                        🚗 <span class="font-black text-[var(--app-accent)]">{{ $car->plate_number }}</span>
                    </span>
                </div>
            </div>
            
            {{-- Action Buttons --}}
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('jobs.create', ['car' => $car->id]) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[var(--app-accent)] px-5 py-2.5 text-base font-bold text-black transition hover:opacity-90 shadow-sm cursor-pointer">
                    Add New Job Card
                </a>
                <a href="{{ route('cars.edit', $car) }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] px-5 py-2.5 text-base font-bold text-[var(--app-text)] transition hover:bg-[var(--app-bg)] shadow-sm">
                    Edit
                </a>
                <form action="{{ route('cars.destroy', $car) }}" method="post" class="inline-block"
                    onsubmit="return confirm('Delete this car?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-2.5 text-base font-bold text-red-500 transition hover:bg-red-500/20 shadow-sm cursor-pointer">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- strictly Horizontal 3-Column Profile Row (Forced Flex-Row side-by-side) -->
        <div class="flex flex-row gap-6 w-full mb-6">

            {{-- Vehicle Details Card --}}
            <div class="flex-1 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-5 shadow-sm flex flex-col">
                {{-- Card Header --}}
                <div class="flex items-center justify-between border-b border-[var(--app-border)] pb-3 mb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-[var(--app-muted)]">Vehicle Details</h3>
                    <span class="text-base">🚗</span>
                </div>
                {{-- Full-width label/value rows --}}
                <div class="flex flex-col gap-3 flex-1 justify-center">
                    <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Make & Model</span>
                        <span class="text-sm font-bold text-[var(--app-text)]">{{ $car->make }} {{ $car->model }}</span>
                    </div>
                    <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Plate Number</span>
                        <span class="text-sm font-black text-[var(--app-accent)]">{{ $car->plate_number }}</span>
                    </div>
                    <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Year</span>
                        <span class="text-sm font-bold text-[var(--app-text)]">{{ $car->year ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between w-full py-1.5">
                        <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Color</span>
                        <span class="text-sm font-bold text-[var(--app-text)]">{{ $car->color ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Owner Details Card --}}
            <div class="flex-1 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-5 shadow-sm flex flex-col">
                {{-- Card Header --}}
                <div class="flex items-center justify-between border-b border-[var(--app-border)] pb-3 mb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-[var(--app-muted)]">Owner Details</h3>
                    <span class="text-base">👤</span>
                </div>
                {{-- Full-width label/value rows --}}
                <div class="flex flex-col gap-3 flex-1 justify-center">
                    @if ($car->customer)
                        <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Name</span>
                            <a href="{{ route('customers.show', $car->customer->id) }}"
                                class="text-sm font-black text-[var(--app-accent)] hover:underline">
                                {{ $car->customer->name }}
                            </a>
                        </div>
                        <div class="flex items-center justify-between w-full py-1.5 border-b border-[var(--app-border)]/40">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Phone</span>
                            <span class="text-sm font-bold text-[var(--app-text)]">📞 {{ $car->customer->phone }}</span>
                        </div>
                        <div class="flex items-start justify-between w-full py-1.5">
                            <span class="text-xs font-extrabold uppercase tracking-wide text-[var(--app-muted)]">Address</span>
                            <span class="text-sm font-bold text-[var(--app-text)] text-right max-w-[60%]">📍 {{ $car->customer->address }}</span>
                        </div>
                    @else
                        <div class="flex flex-1 items-center justify-center">
                            <p class="text-sm italic text-[var(--app-muted)]">No Owner Assigned</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Shop Statistics Card --}}
            <div class="flex-1 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-5 shadow-sm flex flex-col">
                {{-- Card Header --}}
                <div class="flex items-center justify-between border-b border-[var(--app-border)] pb-3 mb-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-[var(--app-muted)]">Shop Stats</h3>
                    <span class="text-base">📊</span>
                </div>
                {{-- Full-width label/value rows --}}
                <div class="flex flex-col gap-3 flex-1 justify-center">
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

        </div>

        {{-- Service History Card --}}
        <section class="rounded-[2rem] border border-[var(--app-border)] bg-[var(--app-surface)] p-6 shadow-sm w-full">
            <div class="flex items-center justify-between gap-4 border-b border-[var(--app-border)] pb-4 mb-6">
                <div>
                    <div class="text-xs font-extrabold uppercase tracking-[0.2em] text-[var(--app-muted)]">Service History</div>
                    <h3 class="mt-1 font-display text-2xl font-black text-[var(--app-text)]">Vehicle Visits</h3>
                </div>
                <a href="{{ route('jobs.create', ['car' => $car->id]) }}"
                    class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 text-sm font-bold text-[var(--app-text)] transition hover:bg-[var(--app-bg)] shadow-sm">
                    Add New Job Card
                </a>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[var(--app-muted)] font-bold border-b border-[var(--app-border)] bg-[var(--app-bg)]/30">
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Date In</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Date Out</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Services</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Parts</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Total spent</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Payment</th>
                            <th class="px-4 py-3 font-extrabold uppercase tracking-wider text-xs">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--app-border)]/50">
                        @forelse ($jobs as $job)
                            <tr class="hover:bg-[var(--app-bg)]/30 transition-colors">
                                <td class="px-4 py-3.5 font-bold text-[var(--app-text)]">{{ $job->date_in?->format('d M, Y') }}</td>
                                <td class="px-4 py-3.5 font-semibold text-[var(--app-muted)]">{{ $job->date_out?->format('d M, Y') ?? '—' }}</td>
                                <td class="px-4 py-3.5 font-semibold text-[var(--app-text)] max-w-xs truncate">{{ $job->services->pluck('description')->implode(', ') ?: '—' }}</td>
                                <td class="px-4 py-3.5 font-semibold text-[var(--app-text)] max-w-xs truncate">{{ $job->parts->pluck('part_name')->implode(', ') ?: '—' }}</td>
                                <td class="px-4 py-3.5 font-black text-[var(--app-text)]">Rs. {{ number_format($job->grand_total, 2) }}</td>
                                <td class="px-4 py-3.5 font-bold">
                                    <span class="inline-flex rounded-xl px-2.5 py-1 text-xs font-bold
                                        @if($job->payment_status === 'paid') bg-emerald-500/20 text-emerald-400
                                        @elseif($job->payment_status === 'partial') bg-amber-500/20 text-amber-400
                                        @else bg-red-500/20 text-red-400 @endif">
                                        {{ ucfirst($job->payment_status) }}
                                    </span>
                                </td>
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
                                <td colspan="7" class="py-8 text-center text-sm font-semibold text-[var(--app-muted)]">No service history yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
