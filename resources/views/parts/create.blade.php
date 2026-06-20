@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="font-display text-3xl font-semibold">Add Part</h1>
            <p class="mt-1 text-sm text-[var(--app-muted)]">Create a new part reference with pricing</p>
        </div>

        <form action="{{ route('parts.store') }}" method="POST"
            class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-8 sm:p-10 space-y-8">
            @csrf

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold mb-2 text-[var(--app-text)]">Part Name</label>
                    <input type="text" name="name" required maxlength="100"
                        class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-bg)] px-5 py-3 text-sm transition focus:border-[var(--app-accent)] focus:outline-none focus:ring-1 focus:ring-[var(--app-accent)]"
                        placeholder="Oil Filter" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-[var(--app-text)]">Part Number</label>
                    <input type="text" name="part_number" maxlength="50"
                        class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-bg)] px-5 py-3 text-sm transition focus:border-[var(--app-accent)] focus:outline-none focus:ring-1 focus:ring-[var(--app-accent)]"
                        placeholder="OIL-FILTER-001" value="{{ old('part_number') }}">
                    @error('part_number')
                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold mb-2 text-[var(--app-text)]">Default Price (Rs.)</label>
                    <input type="number" name="default_price" required step="1" min="0"
                        class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-bg)] px-5 py-3 text-sm transition focus:border-[var(--app-accent)] focus:outline-none focus:ring-1 focus:ring-[var(--app-accent)]"
                        placeholder="1500" value="{{ old('default_price') }}">
                    @error('default_price')
                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-[var(--app-text)] invisible">Options</label>
                    <div class="flex items-center h-[46px]">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="needs_reorder" value="1"
                                class="h-5 w-5 rounded border border-[var(--app-border)] bg-[var(--app-bg)] text-[var(--app-accent)] transition focus:ring-1 focus:ring-[var(--app-accent)] focus:ring-offset-0"
                                {{ old('needs_reorder') ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-[var(--app-text)] group-hover:text-[var(--app-accent)] transition">Needs Reorder</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-[var(--app-border)]">
                <button type="submit"
                    class="rounded-xl bg-[var(--app-accent)] px-8 py-3 text-sm font-bold text-black transition hover:opacity-90">
                    Create Part
                </button>
                <a href="{{ route('parts.index') }}"
                    class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] px-8 py-3 text-sm font-semibold text-[var(--app-text)] transition hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
