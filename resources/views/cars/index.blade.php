@extends('layouts.app')

@section('title', 'Cars | AutoShop Manager')
@section('meta_description', 'Browse all registered vehicles with their owners, make, model, and service visit history.')
@section('page_title', 'Cars')

@section('content')
    <div class="space-y-5">

        {{-- Toolbar --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <form method="get" action="{{ route('cars.index') }}" class="flex flex-1 items-center gap-2 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5">
                <svg class="h-4 w-4 flex-shrink-0 text-[var(--app-muted)]" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input name="q" value="{{ request('q') }}"
                    placeholder="Search by plate, make, model, or owner…"
                    class="flex-1 bg-transparent text-sm outline-none placeholder-[var(--app-muted)]">
                @if(request('q'))
                    <a href="{{ route('cars.index') }}" aria-label="Clear search"
                        class="flex-shrink-0 text-[var(--app-muted)] hover:text-[var(--app-text)] transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                @endif
            </form>
            <a href="{{ route('cars.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-[var(--app-accent)] px-5 py-2.5 text-sm font-semibold text-black transition hover:opacity-90 flex-shrink-0">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Car
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)]">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-[var(--app-border)] bg-[color:color-mix(in_srgb,var(--app-accent)_5%,var(--app-surface))]">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-[var(--app-text)]">Plate</th>
                            <th class="px-6 py-4 font-semibold text-[var(--app-text)]">Make</th>
                            <th class="px-6 py-4 font-semibold text-[var(--app-text)]">Model</th>
                            <th class="px-6 py-4 font-semibold text-[var(--app-text)]">Owner</th>
                            <th class="px-6 py-4 font-semibold text-[var(--app-text)] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cars as $car)
                            <tr class="border-t border-[var(--app-border)] hover:bg-[color:color-mix(in_srgb,var(--app-accent)_3%,transparent)] transition">
                                <td class="px-6 py-4 font-medium">{{ $car->plate_number }}</td>
                                <td class="px-6 py-4 text-[var(--app-muted)]">{{ $car->make }}</td>
                                <td class="px-6 py-4 text-[var(--app-muted)]">{{ $car->model }}</td>
                                <td class="px-6 py-4">{{ $car->customer?->name }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <a href="{{ route('cars.show', $car) }}" class="text-[var(--app-accent)] font-medium hover:underline">View</a>
                                        <a href="{{ route('cars.edit', $car) }}" class="text-[var(--app-muted)] hover:text-[var(--app-text)] transition">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <svg class="mx-auto h-12 w-12 text-[var(--app-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    <h3 class="mt-2 font-medium text-[var(--app-text)]">No cars found</h3>
                                    <p class="mt-1 text-sm text-[var(--app-muted)]">Get started by adding a new vehicle to the system.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('cars.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-[var(--app-accent)] px-5 py-2.5 text-sm font-bold text-black transition hover:opacity-90 shadow-sm hover:shadow">
                                            + Add Vehicle
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-[var(--app-border)] px-6 py-4">
                {{ $cars->links() }}
            </div>
        </div>
    </div>
@endsection
