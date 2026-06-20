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
