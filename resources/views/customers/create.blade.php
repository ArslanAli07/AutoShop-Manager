@extends('layouts.app')

@section('title', 'Add New Customer | AutoShop Manager')
@section('meta_description', 'Register a new customer in the system. Enter customer contact information and details.')
@section('page_title', 'New Customer')

@section('content')
    <div class="max-w-2xl mx-auto">
        <form action="{{ route('customers.store') }}" method="post"
            class="space-y-5 rounded-[2rem] border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            @csrf
            <div class="grid gap-5">
                <div>
                    <label for="name" class="block text-sm font-medium">Customer Name</label>
                    <input id="name" name="name" value="{{ old('name') }}"
                        placeholder="Full name"
                        class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]"
                        required>
                    @error('name')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium">Phone Number</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}"
                        placeholder="0300-0000000"
                        class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]"
                        required>
                    @error('phone')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium">Address</label>
                    <textarea id="address" name="address" placeholder="Street, area, city"
                        class="mt-1 min-h-24 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]">{{ old('address') }}</textarea>
                    @error('address')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium">Notes</label>
                    <textarea id="notes" name="notes" placeholder="Any special notes about this customer"
                        class="mt-1 min-h-24 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4">
                <button type="submit"
                    class="rounded-2xl bg-[var(--app-accent)] px-6 py-2 text-sm font-semibold text-white transition hover:opacity-90">Save
                    Customer</button>
                <a href="{{ route('customers.index') }}"
                    class="text-sm font-medium text-[var(--app-muted)] transition hover:text-[var(--app-text)]">Cancel</a>
            </div>
        </form>
    </div>
@endsection
