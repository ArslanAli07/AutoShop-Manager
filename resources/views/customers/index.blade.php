@extends('layouts.app')

@section('title', 'Customers | AutoShop Manager')
@section('meta_description', 'Manage all customers with search by name and phone. View customer profiles, contact information, and service history.')
@section('page_title', 'Customers')

@section('content')
    <div class="space-y-5">

        {{-- Toolbar --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <form method="get" class="flex flex-1 items-center gap-2 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5">
                <svg class="h-4 w-4 flex-shrink-0 text-[var(--app-muted)]" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input id="search-q" name="q" value="{{ request('q') }}"
                    placeholder="Search by name or phone…"
                    class="flex-1 bg-transparent text-sm outline-none placeholder-[var(--app-muted)]">
                @if(request('q'))
                    <a href="{{ route('customers.index') }}" aria-label="Clear search"
                        class="flex-shrink-0 text-[var(--app-muted)] hover:text-[var(--app-text)] transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                @endif
            </form>
            <a href="{{ route('customers.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-[var(--app-accent)] px-5 py-2.5 text-sm font-semibold text-black transition hover:opacity-90 flex-shrink-0">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Customer
            </a>
        </div>

        {{-- Table --}}
        <section class="overflow-hidden rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)]" aria-label="Customers list">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-[var(--app-border)] bg-[color:color-mix(in_srgb,var(--app-accent)_5%,var(--app-surface))]">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold text-[var(--app-text)]">Name</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-[var(--app-text)]">Phone</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-[var(--app-text)]">Cars</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-[var(--app-text)]">Visits</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-[var(--app-text)]">Last Visit</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-[var(--app-text)] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr class="border-t border-[var(--app-border)] hover:bg-[color:color-mix(in_srgb,var(--app-accent)_3%,transparent)] transition">
                                <td class="px-6 py-4 font-medium">{{ $customer->name }}</td>
                                <td class="px-6 py-4 text-[var(--app-muted)]">{{ $customer->phone }}</td>
                                <td class="px-6 py-4">{{ $customer->cars_count }}</td>
                                <td class="px-6 py-4">{{ $customer->jobs_count }}</td>
                                <td class="px-6 py-4 text-[var(--app-muted)]">
                                    {{ $customer->jobs_max_date_in ? \Illuminate\Support\Carbon::parse($customer->jobs_max_date_in)->format('d M, Y') : '—' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <a href="{{ route('customers.show', $customer) }}" class="text-[var(--app-accent)] font-medium hover:underline">View</a>
                                        <a href="{{ route('customers.edit', $customer) }}" class="text-[var(--app-muted)] hover:text-[var(--app-text)] transition">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-[var(--app-muted)]">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-[var(--app-border)] px-6 py-4">
                {{ $customers->links() }}
            </div>
        </section>
    </div>
@endsection
