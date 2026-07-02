@extends('layouts.app')

@section('title', 'Edit Customer: ' . $customer->name . ' | AutoShop Manager')
@section('meta_description', 'Update customer information including contact details, address, and notes.')
@section('page_title', 'Edit Customer')

@section('content')
    <div class="max-w-2xl mx-auto">
        <form action="{{ route('customers.update', $customer) }}" method="post"
            class="space-y-5 rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            @csrf
            @method('PUT')
            <div class="grid gap-5">
                <div>
                    <x-label for="name" value="Customer Name" />
                    <x-input id="name" name="name" value="{{ old('name', $customer->name) }}" placeholder="Full name" required />
                    <x-error :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-label for="phone" value="Phone Number" />
                    <x-input id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" placeholder="0300-0000000" required />
                    <x-error :messages="$errors->get('phone')" />
                </div>
                <div>
                    <x-label for="address" value="Address" />
                    <textarea id="address" name="address" placeholder="Street, area, city"
                        class="mt-1 min-h-24 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)] focus:ring-2 focus:ring-[var(--app-accent)]/20 transition shadow-sm">{{ old('address', $customer->address) }}</textarea>
                    <x-error :messages="$errors->get('address')" />
                </div>
                <div>
                    <x-label for="notes" value="Notes" />
                    <textarea id="notes" name="notes" placeholder="Any special notes about this customer"
                        class="mt-1 min-h-24 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)] focus:ring-2 focus:ring-[var(--app-accent)]/20 transition shadow-sm">{{ old('notes', $customer->notes) }}</textarea>
                    <x-error :messages="$errors->get('notes')" />
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4">
                <button type="submit"
                    class="rounded-2xl bg-[var(--app-accent)] px-6 py-2 text-sm font-semibold text-black transition hover:opacity-90">Update
                    Customer</button>
                <a href="{{ route('customers.show', $customer) }}"
                    class="inline-flex items-center rounded-xl border border-[var(--app-border)] px-6 py-2.5 text-sm font-medium text-[var(--app-text)] transition hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]">Cancel</a>
            </div>
        </form>
    </div>
@endsection
