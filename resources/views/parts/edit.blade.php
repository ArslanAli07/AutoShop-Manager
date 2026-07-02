@extends('layouts.app')

@section('page_title', 'Edit Part')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="font-display text-3xl font-semibold">Edit Part</h1>
            <p class="mt-1 text-sm text-[var(--app-muted)]">Update part reference details</p>
        </div>

        <form action="{{ route('parts.update', $part) }}" method="POST"
            class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-8 sm:p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <x-label for="name" value="Part Name" />
                    <x-input id="name" name="name" value="{{ old('name', $part->name) }}" placeholder="e.g. Oil Filter" required />
                    <x-error :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-label for="part_number" value="Part Number (Optional)" />
                    <x-input id="part_number" name="part_number" value="{{ old('part_number', $part->part_number) }}" placeholder="e.g. FL-500S" />
                    <x-error :messages="$errors->get('part_number')" />
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <x-label for="default_price" value="Default Price (Optional)" />
                    <div class="relative mt-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input id="default_price" name="default_price" type="number" step="0.01" value="{{ old('default_price', $part->default_price) }}"
                            placeholder="0.00"
                            class="w-full rounded-2xl border border-[var(--app-border)] bg-transparent py-3 pl-8 pr-4 outline-none focus:border-[var(--app-accent)] focus:ring-2 focus:ring-[var(--app-accent)]/20 transition shadow-sm">
                    </div>
                    <x-error :messages="$errors->get('default_price')" />
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-[var(--app-text)] invisible">Options</label>
                    <div class="flex items-center h-[46px]">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="needs_reorder" value="1"
                                class="h-5 w-5 rounded border border-[var(--app-border)] bg-[var(--app-bg)] text-[var(--app-accent)] transition focus:ring-1 focus:ring-[var(--app-accent)] focus:ring-offset-0"
                                {{ old('needs_reorder', $part->needs_reorder) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-[var(--app-text)] group-hover:text-[var(--app-accent)] transition">Needs Reorder</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-[var(--app-border)]">
                <button type="submit"
                    class="rounded-xl bg-[var(--app-accent)] px-8 py-3 text-sm font-bold text-black transition hover:opacity-90">
                    Update Part
                </button>
                <a href="{{ route('parts.index') }}"
                    class="inline-flex items-center rounded-xl border border-[var(--app-border)] px-6 py-2.5 text-sm font-medium text-[var(--app-text)] transition hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
