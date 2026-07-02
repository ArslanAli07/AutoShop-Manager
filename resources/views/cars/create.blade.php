@extends('layouts.app')

@section('title', 'Add New Car | AutoShop Manager')
@section('meta_description',
    'Register a new vehicle in the system. Enter vehicle details, owner information, and
    specifications.')
@section('page_title', 'New Car')

@section('content')
    <div class="max-w-2xl mx-auto">
        <form action="{{ route('cars.store') }}" method="post"
            class="space-y-5 rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            @csrf
            <div class="grid gap-5">
                <div>
                    <label for="customer_id" class="block text-sm font-medium">Owner</label>
                    <select id="customer_id" name="customer_id" style="color-scheme: dark;"
                        class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-3 outline-none focus:border-[var(--app-accent)] text-[var(--app-text)]"
                        required>
                        <option value="" class="bg-[var(--app-surface)] text-[var(--app-text)]">Select owner</option>
                        @foreach ($customers as $cust)
                            <option value="{{ $cust->id }}" class="bg-[var(--app-surface)] text-[var(--app-text)]">{{ $cust->name }} — {{ $cust->phone }}</option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="plate_number" class="block text-sm font-medium">Plate Number</label>
                    <input id="plate_number" name="plate_number" value="{{ old('plate_number') }}"
                        placeholder="LEA-1234"
                        class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]"
                        required>
                    @error('plate_number')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label for="make" class="block text-sm font-medium">Make</label>
                        <input id="make" name="make" value="{{ old('make') }}"
                            placeholder="Toyota"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]"
                            required>
                        @error('make')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="model" class="block text-sm font-medium">Model</label>
                        <input id="model" name="model" value="{{ old('model') }}"
                            placeholder="Corolla"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]"
                            required>
                        @error('model')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium">Year</label>
                    <input id="year" name="year" value="{{ old('year') }}" placeholder="2020"
                        class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]"
                        type="number" min="1900" max="2099">
                    @error('year')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="color" class="block text-sm font-medium">Color</label>
                    <input id="color" name="color" value="{{ old('color') }}"
                        placeholder="White"
                        class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]">
                    @error('color')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit"
                    class="rounded-2xl bg-[var(--app-accent)] px-6 py-2 text-sm font-semibold text-black transition hover:opacity-90">Save
                    Car</button>
                <a href="{{ route('cars.index') }}"
                    class="inline-flex items-center rounded-xl border border-[var(--app-border)] px-6 py-2.5 text-sm font-medium text-[var(--app-text)] transition hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]">Cancel</a>
            </div>
        </form>
    </div>
@endsection
