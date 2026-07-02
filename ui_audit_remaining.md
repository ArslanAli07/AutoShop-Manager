# resources/views/customers/index.blade.php

```blade
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
```

# resources/views/customers/create.blade.php

```blade
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
```

# resources/views/cars/index.blade.php

```blade
@extends('layouts.app')

@section('title', 'Cars | AutoShop Manager')
@section('meta_description', 'Browse all registered vehicles with their owners, make, model, and service visit history.')
@section('page_title', 'Cars')

@section('content')
    <div class="space-y-5">

        {{-- Toolbar --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <form method="get" action="{{ route('cars.index') }}" class="flex flex-1 items-center gap-2 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5">
                <svg class="h-4 w-4 flex-shrink-0 text-[var(--app-muted)]" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input name="q" value="{{ request('q') }}"
                    placeholder="Search by plate, make, model, or owner…"
                    class="flex-1 bg-transparent text-sm outline-none placeholder-[var(--app-muted)]">
                @if(request('q'))
                    <a href="{{ route('cars.index') }}" aria-label="Clear search"
                        class="flex-shrink-0 text-[var(--app-muted)] hover:text-[var(--app-text)] transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                @endif
            </form>
            <a href="{{ route('cars.create') }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-[var(--app-accent)] px-5 py-2.5 text-sm font-semibold text-black transition hover:opacity-90 flex-shrink-0">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Car
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)]">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-[var(--app-border)] bg-[color:color-mix(in_srgb,var(--app-accent)_5%,var(--app-surface))]">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-[var(--app-text)]">Plate</th>
                            <th class="px-6 py-4 font-semibold text-[var(--app-text)]">Make</th>
                            <th class="px-6 py-4 font-semibold text-[var(--app-text)]">Model</th>
                            <th class="px-6 py-4 font-semibold text-[var(--app-text)]">Owner</th>
                            <th class="px-6 py-4 font-semibold text-[var(--app-text)] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cars as $car)
                            <tr class="border-t border-[var(--app-border)] hover:bg-[color:color-mix(in_srgb,var(--app-accent)_3%,transparent)] transition">
                                <td class="px-6 py-4 font-medium">{{ $car->plate_number }}</td>
                                <td class="px-6 py-4 text-[var(--app-muted)]">{{ $car->make }}</td>
                                <td class="px-6 py-4 text-[var(--app-muted)]">{{ $car->model }}</td>
                                <td class="px-6 py-4">{{ $car->customer?->name }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <a href="{{ route('cars.show', $car) }}" class="text-[var(--app-accent)] font-medium hover:underline">View</a>
                                        <a href="{{ route('cars.edit', $car) }}" class="text-[var(--app-muted)] hover:text-[var(--app-text)] transition">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-[var(--app-muted)]">No cars found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-[var(--app-border)] px-6 py-4">
                {{ $cars->links() }}
            </div>
        </div>
    </div>
@endsection
```

# resources/views/cars/create.blade.php

```blade
@extends('layouts.app')

@section('title', 'Add New Car | AutoShop Manager')
@section('meta_description',
    'Register a new vehicle in the system. Enter vehicle details, owner information, and
    specifications.')
@section('page_title', 'New Car')

@section('content')
    <div class="max-w-2xl mx-auto">
        <form action="{{ route('cars.store') }}" method="post"
            class="space-y-5 rounded-[2rem] border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
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
                    class="rounded-2xl bg-[var(--app-accent)] px-6 py-2 text-sm font-semibold text-white transition hover:opacity-90">Save
                    Car</button>
                <a href="{{ route('cars.index') }}"
                    class="text-sm font-medium text-[var(--app-muted)] transition hover:text-[var(--app-text)]">Cancel</a>
            </div>
        </form>
    </div>
@endsection
```

# resources/views/presets/index.blade.php

```blade
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
```

# resources/views/presets/create.blade.php

```blade
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
```

# resources/views/parts/index.blade.php

```blade
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
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[var(--app-border)] bg-[var(--app-bg)] px-2.5 py-1 text-xs font-semibold text-[var(--app-text)]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500 flex-shrink-0"></span>
                                        Reorder
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-[var(--app-border)] bg-[var(--app-bg)] px-2.5 py-1 text-xs font-semibold text-[var(--app-text)]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500 flex-shrink-0"></span>
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
```

# resources/views/parts/create.blade.php

```blade
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
```

# resources/views/reports/revenue.blade.php

```blade
@extends('reports.layout')

@section('report_content')
    
    {{-- Summary Cards --}}
    <div class="mb-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <h3 class="text-sm font-medium text-[var(--app-muted)]">Money Collected</h3>
            <p class="mt-2 text-2xl font-bold text-[var(--app-text)]">Rs. {{ number_format($totalRevenue) }}</p>
        </div>
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <h3 class="text-sm font-medium text-[var(--app-muted)]">Total Invoiced (Includes Unpaid)</h3>
            <p class="mt-2 text-2xl font-bold text-[var(--app-text)]">Rs. {{ number_format($totalInvoiced) }}</p>
        </div>
        <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
            <h3 class="text-sm font-medium text-[var(--app-muted)]">Average Job Value</h3>
            <p class="mt-2 text-2xl font-bold text-[var(--app-text)]">Rs. {{ number_format($avgJobValue) }}</p>
        </div>
    </div>

    {{-- Line Chart --}}
    <div class="mb-8 rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
        <h3 class="mb-4 text-sm font-bold text-[var(--app-text)]">Revenue Trend</h3>
        <div class="relative h-72 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Jobs Table --}}
    <div class="rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] overflow-hidden">
        <div class="p-6 border-b border-[var(--app-border)]">
            <h3 class="text-sm font-bold text-[var(--app-text)]">Jobs in this Period</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-[var(--app-border)] bg-[var(--app-bg)] text-[var(--app-muted)]">
                        <th class="px-6 py-4 font-medium">Date</th>
                        <th class="px-6 py-4 font-medium">Job Number</th>
                        <th class="px-6 py-4 font-medium">Customer</th>
                        <th class="px-6 py-4 font-medium text-right">Amount Paid</th>
                        <th class="px-6 py-4 font-medium text-right">Payment Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--app-border)] text-[var(--app-text)]">
                    @forelse($jobs as $job)
                        <tr class="transition hover:bg-[var(--app-bg)]">
                            <td class="px-6 py-4">{{ $job->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('jobs.show', $job->id) }}" class="font-medium text-[var(--app-accent)] hover:underline">
                                    {{ $job->job_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $job->customer->name }}</td>
                            <td class="px-6 py-4 text-right font-medium">Rs. {{ number_format($job->amount_paid) }}</td>
                            <td class="px-6 py-4 text-right">
                                @if($job->payment_status === 'paid')
                                    <span class="inline-flex rounded-full bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-400">Paid</span>
                                @elseif($job->payment_status === 'partial')
                                    <span class="inline-flex rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Partial</span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-400">Unpaid</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-[var(--app-muted)]">No jobs found in this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            
            // Get root CSS variables for colors to make it theme-aware
            const style = getComputedStyle(document.body);
            const accentColor = style.getPropertyValue('--app-accent').trim() || '#E8C84A';
            const gridColor = style.getPropertyValue('--app-border').trim() || '#E5E7EB';
            const textColor = style.getPropertyValue('--app-muted').trim() || '#6B7280';

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['labels']) !!},
                    datasets: [{
                        label: 'Money Collected (Rs.)',
                        data: {!! json_encode($chartData['data']) !!},
                        borderColor: accentColor,
                        backgroundColor: accentColor + '20', // Add transparency
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: accentColor,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: { size: 13, family: "'Inter', sans-serif" },
                            bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                            callbacks: {
                                label: function(context) {
                                    return 'Rs. ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: textColor,
                                font: { family: "'Inter', sans-serif" }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: gridColor,
                                drawBorder: false
                            },
                            ticks: {
                                color: textColor,
                                font: { family: "'Inter', sans-serif" },
                                callback: function(value) {
                                    if (value >= 1000) {
                                        return value / 1000 + 'k';
                                    }
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
```

# resources/views/intake_create.blade.php

```blade
@extends('layouts.app')

@section('title', 'Quick Intake | AutoShop Manager')
@section('meta_description', 'Quickly onboard a walk-in customer, vehicle, and create a job card in seconds.')
@section('page_title', 'Quick Intake')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h2 class="font-display text-2xl font-bold text-[var(--app-text)]">Create a new Job Card in under 30 seconds</h2>
            <p class="mt-2 text-sm text-[var(--app-muted)]">
                This flow is for <span class="font-semibold text-[var(--app-text)]">new walk-in customers</span>. If the
                customer already exists, use
                <a href="{{ route('jobs.create') }}" class="font-semibold text-[var(--app-accent)] hover:underline">Create Job
                    Card</a>.
            </p>
        </div>

        <form action="{{ route('intake.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Customer Details --}}
            <section class="rounded-[2rem] border border-[var(--app-border)] bg-[var(--app-surface)] p-6"
                aria-label="Customer details">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="font-display text-lg font-semibold text-[var(--app-text)]">Customer Details</h3>
                        <p class="text-xs text-[var(--app-muted)] mt-1">Name, phone, and optional address</p>
                    </div>
                </div>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="customer_name" class="block text-sm font-medium">Customer Name</label>
                        <input id="customer_name" name="customer_name" value="{{ old('customer_name') }}"
                            placeholder="Full name"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]"
                            required>
                        @error('customer_name')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_phone" class="block text-sm font-medium">Phone Number</label>
                        <input id="customer_phone" name="customer_phone" type="tel" inputmode="tel"
                            value="{{ old('customer_phone') }}" placeholder="0300-0000000"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]"
                            required>
                        @error('customer_phone')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_address" class="block text-sm font-medium">Address (Optional)</label>
                        <input id="customer_address" name="customer_address" value="{{ old('customer_address') }}"
                            placeholder="Street, area, city"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]">
                        @error('customer_address')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Vehicle Details --}}
            <section class="rounded-[2rem] border border-[var(--app-border)] bg-[var(--app-surface)] p-6"
                aria-label="Vehicle details">
                <h3 class="font-display text-lg font-semibold text-[var(--app-text)]">Vehicle Details</h3>
                <p class="text-xs text-[var(--app-muted)] mt-1">Plate number and basic vehicle info</p>

                <div class="mt-5 grid gap-5 sm:grid-cols-2">
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

                    <div>
                        <label for="year" class="block text-sm font-medium">Year (Optional)</label>
                        <input id="year" name="year" type="number" min="1900" max="2099"
                            value="{{ old('year') }}" placeholder="2020"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]">
                        @error('year')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="make" class="block text-sm font-medium">Make</label>
                        <input id="make" name="make" value="{{ old('make') }}" placeholder="Toyota"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]"
                            required>
                        @error('make')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="model" class="block text-sm font-medium">Model</label>
                        <input id="model" name="model" value="{{ old('model') }}" placeholder="Corolla"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]"
                            required>
                        @error('model')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Job Details --}}
            <section class="rounded-[2rem] border border-[var(--app-border)] bg-[var(--app-surface)] p-6"
                aria-label="Job details">
                <h3 class="font-display text-lg font-semibold text-[var(--app-text)]">Job Details</h3>
                <p class="text-xs text-[var(--app-muted)] mt-1">Mileage and initial customer complaint</p>

                <div class="mt-5 grid gap-5">
                    <div>
                        <label for="mileage_in" class="block text-sm font-medium">Current Mileage (km)</label>
                        <input id="mileage_in" name="mileage_in" type="number" min="0"
                            value="{{ old('mileage_in') }}" placeholder="125000"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]">
                        @error('mileage_in')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium">Initial Notes / Complaints</label>
                        <textarea id="notes" name="notes" placeholder="Brake noise, AC issue, engine vibration…"
                            class="mt-1 min-h-28 w-full rounded-2xl border border-[var(--app-border)] bg-transparent px-4 py-3 outline-none focus:border-[var(--app-accent)]">{{ old('notes') }}</textarea>
                        @error('notes')
                            <span class="mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Services --}}
            <section class="rounded-[2rem] border border-[var(--app-border)] bg-[var(--app-surface)] p-6"
                aria-label="Services details">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-display text-lg font-semibold text-[var(--app-text)]">Services</h3>
                        <p class="text-xs text-[var(--app-muted)] mt-1">Labor items performed</p>
                    </div>
                    <button type="button" onclick="addService()" class="text-sm font-semibold text-[var(--app-accent)] hover:underline">
                        + Add Service
                    </button>
                </div>

                <div id="services-container" class="space-y-4 mt-5">
                    <!-- Services will be added here -->
                </div>

                @error('services')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </section>

            {{-- Parts --}}
            <section class="rounded-[2rem] border border-[var(--app-border)] bg-[var(--app-surface)] p-6"
                aria-label="Parts details">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-display text-lg font-semibold text-[var(--app-text)]">Parts</h3>
                        <p class="text-xs text-[var(--app-muted)] mt-1">Components used</p>
                    </div>
                    <button type="button" onclick="addPart()" class="text-sm font-semibold text-[var(--app-accent)] hover:underline">
                        + Add Part
                    </button>
                </div>

                <div id="parts-container" class="space-y-4 mt-5">
                    <!-- Parts will be added here -->
                </div>

                @error('parts')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </section>

            <div class="flex flex-wrap items-center gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-2xl bg-[var(--app-accent)] px-6 py-2.5 text-sm font-bold text-black transition hover:opacity-90">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>
                    </svg>
                    Create Job Card
                </button>
                <a href="{{ route('dashboard') }}"
                    class="text-sm font-medium text-[var(--app-muted)] transition hover:text-[var(--app-text)]">Cancel</a>
            </div>
        </form>
    </div>
    <!-- Service Presets Data (for JavaScript) -->
    <script type="application/json" id="service-presets-data">
        {!! json_encode($servicePresets->mapWithKeys(fn($p) => [$p->id => ['name' => $p->name, 'default_labor_cost' => $p->default_labor_cost]])) !!}
    </script>

    <!-- Parts Reference Data (for JavaScript) -->
    <script type="application/json" id="parts-reference-data">
        {!! json_encode($partReferences->mapWithKeys(fn($p) => [$p->id => ['name' => $p->name, 'default_price' => $p->default_price, 'part_number' => $p->part_number]])) !!}
    </script>

    <script>
        const servicePresets = JSON.parse(document.getElementById('service-presets-data').textContent);
        const partsReference = JSON.parse(document.getElementById('parts-reference-data').textContent);
        let serviceCount = 0;
        let partCount = 0;

        function addService() {
            const container = document.getElementById('services-container');
            const index = serviceCount++;
            const html = `
                <div class="service-row flex gap-2 items-end" id="service-${index}">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Service or Preset</label>
                        <select name="services[${index}][service_preset_id]" style="color-scheme: dark;" class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 outline-none focus:border-[var(--app-accent)]" onchange="fillServiceDetails(${index})">
                            <option value="">Select or enter custom</option>
                            ${Object.entries(servicePresets).map(([id, preset]) => `<option value="${id}">${preset.name} - Rs. ${preset.default_labor_cost}</option>`).join('')}
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Description</label>
                        <input type="text" name="services[${index}][description]" placeholder="Description or notes" class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 outline-none focus:border-[var(--app-accent)]" />
                    </div>
                    <div class="w-32">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Labor Cost</label>
                        <input type="number" name="services[${index}][labor_cost]" min="0" step="1" placeholder="2500" value="0" required class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 outline-none focus:border-[var(--app-accent)]" />
                    </div>
                    <button type="button" onclick="removeService(${index})" class="px-2 py-3 text-red-500 hover:text-red-700 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function fillServiceDetails(index) {
            const select = document.querySelector(`[name="services[${index}][service_preset_id]"]`);
            const presetId = select.value;
            if (presetId && servicePresets[presetId]) {
                document.querySelector(`[name="services[${index}][labor_cost]"]`).value = servicePresets[presetId]
                    .default_labor_cost;
            }
        }

        function removeService(index) {
            document.getElementById(`service-${index}`).remove();
        }

        function addPart() {
            const container = document.getElementById('parts-container');
            const index = partCount++;
            const html = `
                <div class="part-row flex gap-2 items-end" id="part-${index}">
                    <div class="w-3/5">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Part or Reference</label>
                        <select name="parts[${index}][parts_reference_id]" style="color-scheme: dark;" class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 outline-none focus:border-[var(--app-accent)]" onchange="fillPartDetails(${index})">
                            <option value="">Select or enter custom</option>
                            ${Object.entries(partsReference).map(([id, part]) => `<option value="${id}">${part.name} (${part.part_number || 'N/A'}) - Rs. ${part.default_price}</option>`).join('')}
                        </select>
                    </div>
                    <div class="w-20">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Qty</label>
                        <input type="number" name="parts[${index}][quantity]" min="1" step="1" placeholder="1" value="1" required class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 outline-none focus:border-[var(--app-accent)]" />
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Unit Price</label>
                        <input type="number" name="parts[${index}][unit_price]" min="0" step="1" placeholder="1500" value="0" required class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 outline-none focus:border-[var(--app-accent)]" />
                    </div>
                    <button type="button" onclick="removePart(${index})" class="px-2 py-3 text-red-500 hover:text-red-700 transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function fillPartDetails(index) {
            const select = document.querySelector(`[name="parts[${index}][parts_reference_id]"]`);
            const partId = select.value;
            if (partId && partsReference[partId]) {
                document.querySelector(`[name="parts[${index}][unit_price]"]`).value = partsReference[partId].default_price;
            }
        }

        function removePart(index) {
            document.getElementById(`part-${index}`).remove();
        }
    </script>
@endsection
```

# Other Unaudited Blade Files
- welcome.blade.php
- cars/edit.blade.php
- components/payment-badge.blade.php
- components/status-badge.blade.php
- customers/edit.blade.php
- parts/edit.blade.php
- presets/edit.blade.php
- reports/job_status.blade.php
- reports/layout.blade.php
- reports/services_parts.blade.php
