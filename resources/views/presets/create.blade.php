@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="font-display text-3xl font-semibold">Add Service Preset</h1>
            <p class="mt-1 text-sm text-[var(--app-muted)]">Create a new service preset with default labor cost</p>
        </div>

        <form action="{{ route('presets.store') }}" method="POST"
            class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-8 sm:p-10 space-y-8">
            @csrf

            <div class="grid gap-6">
                <div>
                    <label class="block text-sm font-semibold mb-2 text-[var(--app-text)]">Service Name (English)</label>
                    <input type="text" name="name" required maxlength="100"
                        class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-bg)] px-5 py-3 text-sm transition focus:border-[var(--app-accent)] focus:outline-none focus:ring-1 focus:ring-[var(--app-accent)]"
                        placeholder="Oil Change" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold mb-2 text-[var(--app-text)]">Category</label>
                    <select name="category" required
                        class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-bg)] px-5 py-3 text-sm transition focus:border-[var(--app-accent)] focus:outline-none focus:ring-1 focus:ring-[var(--app-accent)]">
                        <option value="">Select Category</option>
                        <option value="Maintenance" {{ old('category') === 'Maintenance' ? 'selected' : '' }}>Maintenance
                        </option>
                        <option value="Tires" {{ old('category') === 'Tires' ? 'selected' : '' }}>Tires</option>
                        <option value="Suspension" {{ old('category') === 'Suspension' ? 'selected' : '' }}>Suspension
                        </option>
                        <option value="Brakes" {{ old('category') === 'Brakes' ? 'selected' : '' }}>Brakes</option>
                        <option value="Electrical" {{ old('category') === 'Electrical' ? 'selected' : '' }}>Electrical
                        </option>
                        <option value="Engine" {{ old('category') === 'Engine' ? 'selected' : '' }}>Engine</option>
                        <option value="Inspection" {{ old('category') === 'Inspection' ? 'selected' : '' }}>Inspection
                        </option>
                    </select>
                    @error('category')
                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-[var(--app-text)]">Default Labor Cost (Rs.)</label>
                    <input type="number" name="default_labor_cost" required step="1" min="0"
                        class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-bg)] px-5 py-3 text-sm transition focus:border-[var(--app-accent)] focus:outline-none focus:ring-1 focus:ring-[var(--app-accent)]"
                        placeholder="2500" value="{{ old('default_labor_cost') }}">
                    @error('default_labor_cost')
                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-[var(--app-border)]">
                <button type="submit"
                    class="rounded-xl bg-[var(--app-accent)] px-8 py-3 text-sm font-bold text-black transition hover:opacity-90">
                    Create Service
                </button>
                <a href="{{ route('presets.index') }}"
                    class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] px-8 py-3 text-sm font-semibold text-[var(--app-text)] transition hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
