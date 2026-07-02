@extends('layouts.app')

@section('title', 'Add Service | AutoShop Manager')
@section('meta_description', 'Create a new reusable service preset with a default labor cost.')
@section('page_title', 'Add Service')

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
                    <x-label for="name" value="Service Name" />
                    <x-input id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Engine Oil Change" required />
                    <x-error :messages="$errors->get('name')" />
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
                    <x-label for="default_labor_cost" value="Default Labor Cost (Optional)" />
                    <div class="relative mt-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input id="default_labor_cost" name="default_labor_cost" type="number" step="0.01" value="{{ old('default_labor_cost') }}"
                            placeholder="0.00"
                            class="w-full rounded-2xl border border-[var(--app-border)] bg-transparent py-3 pl-8 pr-4 outline-none focus:border-[var(--app-accent)] focus:ring-2 focus:ring-[var(--app-accent)]/20 transition shadow-sm">
                    </div>
                    <x-error :messages="$errors->get('default_labor_cost')" />
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-[var(--app-border)]">
                <button type="submit"
                    class="rounded-xl bg-[var(--app-accent)] px-8 py-3 text-sm font-bold text-black transition hover:opacity-90">
                    Create Service
                </button>
                <a href="{{ route('presets.index') }}"
                    class="inline-flex items-center rounded-xl border border-[var(--app-border)] px-6 py-2.5 text-sm font-medium text-[var(--app-text)] transition hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
