@extends('layouts.app')

@section('title', 'Parts Reference | AutoShop Manager')
@section('meta_description', 'Manage parts inventory with pricing, part numbers, and reorder status tracking.')
@section('page_title', 'Parts')

@section('content')
    <div class="space-y-5">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-[var(--app-muted)]">Manage parts inventory and pricing</p>
            <a href="{{ route('parts.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-[var(--app-accent)] px-5 py-2.5 text-sm font-semibold text-black transition hover:opacity-90">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Part
            </a>
        </div>

        {{-- Table --}}
        <div class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[var(--app-border)] bg-[color:color-mix(in_srgb,var(--app-accent)_5%,var(--app-surface))]">
                        <th class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">Part Name</th>
                        <th class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">Part Number</th>
                        <th class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">Default Price</th>
                        <th class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">Status</th>
                        <th class="px-6 py-4 text-right font-semibold text-[var(--app-text)]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--app-border)]">
                    @forelse ($parts as $part)
                        <tr class="hover:bg-[color:color-mix(in_srgb,var(--app-accent)_3%,transparent)] transition">
                            <td class="px-6 py-4 font-medium">{{ $part->name }}</td>
                            <td class="px-6 py-4 text-sm text-[var(--app-muted)]">{{ $part->part_number ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">Rs. {{ number_format($part->default_price) }}</td>
                            <td class="px-6 py-4">
                                @if ($part->needs_reorder)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500/10 px-3 py-1 text-xs font-semibold text-red-500">
                                        <span class="h-1.5 w-1.5 flex-shrink-0 rounded-full bg-red-400"></span>
                                        Reorder
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-500">
                                        <span class="h-1.5 w-1.5 flex-shrink-0 rounded-full bg-emerald-400"></span>
                                        In Stock
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('parts.edit', $part) }}" class="text-[var(--app-accent)] font-medium hover:underline">Edit</a>
                                    <form action="{{ route('parts.destroy', $part) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this part?')"
                                            class="text-sm text-[var(--app-muted)] hover:text-red-600 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-[var(--app-muted)]">
                                No parts yet.
                                <a href="{{ route('parts.create') }}" class="font-medium text-[var(--app-accent)]">Add one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $parts->links() }}
    </div>
@endsection
