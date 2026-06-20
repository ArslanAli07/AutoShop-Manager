@extends('layouts.app')

@section('title', 'Service Presets | AutoShop Manager')
@section('meta_description', 'Manage reusable service presets with default labor costs.')
@section('page_title', 'Services')

@section('content')
    <div class="space-y-5">

        {{-- Toolbar --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-[var(--app-muted)]">Manage common services and their default labor costs</p>
            <a href="{{ route('presets.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-[var(--app-accent)] px-5 py-2.5 text-sm font-semibold text-black transition hover:opacity-90">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Service
            </a>
        </div>

        {{-- Table --}}
        <div class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[var(--app-border)] bg-[color:color-mix(in_srgb,var(--app-accent)_5%,var(--app-surface))]">
                        <th class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">Service Name</th>
                        <th class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">Category</th>
                        <th class="px-6 py-4 text-left font-semibold text-[var(--app-text)]">Default Labor Cost</th>
                        <th class="px-6 py-4 text-right font-semibold text-[var(--app-text)]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--app-border)]">
                    @forelse ($presets as $preset)
                        <tr class="hover:bg-[color:color-mix(in_srgb,var(--app-accent)_3%,transparent)] transition">
                            <td class="px-6 py-4">
                                <div class="font-medium">{{ $preset->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[var(--app-muted)]">{{ $preset->category }}</td>
                            <td class="px-6 py-4 text-sm">Rs. {{ number_format($preset->default_labor_cost) }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('presets.edit', $preset) }}" class="text-[var(--app-accent)] font-medium hover:underline">Edit</a>
                                    <form action="{{ route('presets.destroy', $preset) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this service preset?')"
                                            class="text-sm text-[var(--app-muted)] hover:text-red-600 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-[var(--app-muted)]">
                                No service presets yet.
                                <a href="{{ route('presets.create') }}" class="font-medium text-[var(--app-accent)]">Create one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $presets->links() }}
    </div>
@endsection
