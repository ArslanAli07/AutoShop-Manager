@extends('layouts.app')

@section('title', 'Create Job Card | AutoShop Manager')
@section('meta_description', 'Create a new service job card with services and parts.')

@section('content')
    @php
        $preselectedCustomerId = old('customer_id', request()->query('customer') ?? request()->query('customer_id'));
        $preselectedCarId = old('car_id', request()->query('car') ?? request()->query('car_id'));

        if (!$preselectedCustomerId && $preselectedCarId) {
            $foundCar = \App\Models\Car::withTrashed()->find($preselectedCarId);
            if ($foundCar) {
                $preselectedCustomerId = $foundCar->customer_id;
            }
        }
    @endphp

    <section aria-label="Create new job card" class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-[var(--app-text)]">New Job Card</h1>
            <p class="mt-1 text-sm text-[var(--app-muted)]">Create a new service job with customer, vehicle, services, and
                parts</p>
        </div>

        <form method="POST" action="{{ route('jobs.store') }}" class="space-y-6">
            @csrf

            <!-- Customer & Vehicle Selection -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <h2 class="mb-4 text-lg font-semibold text-[var(--app-text)]">Customer & Vehicle</h2>

                <div class="grid gap-4 lg:grid-cols-2">
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-[var(--app-text)]">
                            Customer *
                        </label>
                        <select id="customer_id" name="customer_id" required style="color-scheme: dark;"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none"
                            onchange="updateCars()">
                            <option value="">Select customer owner...</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @selected($preselectedCustomerId == $customer->id)>
                                    {{ $customer->name }} ({{ $customer->phone }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
 
                    <div>
                        <label for="car_id" class="block text-sm font-medium text-[var(--app-text)]">
                            Vehicle *
                        </label>
                        <select id="car_id" name="car_id" required style="color-scheme: dark;"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none">
                            <option value="">Select vehicle...</option>
                        </select>
                        @error('car_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 lg:grid-cols-2 pt-4">
                    <div>
                        <label for="date_in" class="block text-sm font-medium text-[var(--app-text)]">
                            Date In *
                        </label>
                        <input type="date" id="date_in" name="date_in"
                            value="{{ old('date_in', today()->format('Y-m-d')) }}" required
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                        @error('date_in')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mileage_in" class="block text-sm font-medium text-[var(--app-text)]">
                            Mileage In (km)
                        </label>
                        <input type="number" id="mileage_in" name="mileage_in" min="0" placeholder="125000"
                            value="{{ old('mileage_in') }}"
                            class="mt-1 w-full rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] placeholder-[var(--app-muted)] focus:border-[var(--app-accent)] focus:outline-none" />
                        @error('mileage_in')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-[var(--app-text)]">Services</h2>
                    <button type="button" onclick="addService()" class="text-sm text-[var(--app-accent)] hover:underline">
                        + Add Service
                    </button>
                </div>

                <div id="services-container" class="space-y-3">
                    <!-- Services will be added here -->
                </div>

                @error('services')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parts -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-[var(--app-text)]">Parts</h2>
                    <button type="button" onclick="addPart()" class="text-sm text-[var(--app-accent)] hover:underline">
                        + Add Part
                    </button>
                </div>

                <div id="parts-container" class="space-y-3">
                    <!-- Parts will be added here -->
                </div>

                @error('parts')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <label for="notes" class="block text-sm font-medium text-[var(--app-text)]">
                    Notes
                </label>
                <textarea id="notes" name="notes" placeholder="Special instructions, known issues, customer requests…"
                    class="mt-2 w-full min-h-24 rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] px-3 py-2 text-sm text-[var(--app-text)] placeholder-[var(--app-muted)] focus:border-[var(--app-accent)] focus:outline-none">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex gap-3 pt-4">
                <button type="submit"
                    class="rounded-lg bg-[var(--app-accent)] px-6 py-2 font-semibold text-black transition hover:opacity-90">
                    Save Job Card
                </button>
                <a href="{{ route('jobs.index') }}"
                    class="rounded-lg border border-[var(--app-border)] px-6 py-2 text-sm font-medium text-[var(--app-text)] transition hover:bg-[var(--app-bg)]">
                    Cancel
                </a>
            </div>
        </form>
    </section>

    <!-- Service Presets Data (for JavaScript) -->
    <script type="application/json" id="service-presets-data">
        {!! json_encode($servicePresets->mapWithKeys(fn($p) => [$p->id => ['name' => $p->name, 'default_labor_cost' => $p->default_labor_cost]])) !!}
    </script>

    <!-- Parts Reference Data (for JavaScript) -->
    <script type="application/json" id="parts-reference-data">
        {!! json_encode($partReferences->mapWithKeys(fn($p) => [$p->id => ['name' => $p->name, 'default_price' => $p->default_price, 'part_number' => $p->part_number]])) !!}
    </script>

    <!-- Cars Data (for JavaScript) -->
    <script type="application/json" id="cars-data">
        {!! json_encode($customers->mapWithKeys(fn($c) => [$c->id => $c->cars->map(fn($car) => ['id' => $car->id, 'plate_number' => $car->plate_number, 'make' => $car->make, 'model' => $car->model])->toArray()])) !!}
    </script>

    <script>
        const servicePresets = JSON.parse(document.getElementById('service-presets-data').textContent);
        const partsReference = JSON.parse(document.getElementById('parts-reference-data').textContent);
        const carsData = JSON.parse(document.getElementById('cars-data').textContent);
        let serviceCount = 0;
        let partCount = 0;

        function updateCars() {
            const customerId = document.getElementById('customer_id').value;
            const carSelect = document.getElementById('car_id');
            carSelect.innerHTML = '<option value="">Select vehicle...</option>';

            if (customerId && carsData[customerId]) {
                carsData[customerId].forEach(car => {
                    const option = document.createElement('option');
                    option.value = car.id;
                    option.textContent = `${car.plate_number} - ${car.make} ${car.model}`;
                    carSelect.appendChild(option);
                });
            }
        }

        // Auto-run on page load for pre-filled customers
        document.addEventListener('DOMContentLoaded', () => {
            const customerSelect = document.getElementById('customer_id');
            if (customerSelect && customerSelect.value) {
                updateCars();
                
                // Read car_id from URL, Old input, or preselected PHP variable
                const urlParams = new URLSearchParams(window.location.search);
                const preselectedCarId = urlParams.get('car') || urlParams.get('car_id') || "{{ $preselectedCarId }}";
                
                const carSelect = document.getElementById('car_id');
                if (preselectedCarId && carSelect.querySelector(`option[value="${preselectedCarId}"]`)) {
                    carSelect.value = preselectedCarId;
                } else if (carSelect.options.length === 2) {
                    // Auto-select if customer has exactly one car (length is 2: index 0 is placeholder, index 1 is car)
                    carSelect.selectedIndex = 1;
                }
            }
        });

        function addService() {
            const container = document.getElementById('services-container');
            const index = serviceCount++;
            const html = `
                <div class="service-row flex gap-2 items-end" id="service-${index}">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Service or Preset</label>
                        <select name="services[${index}][service_preset_id]" class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" onchange="fillServiceDetails(${index})">
                            <option value="">Select or enter custom</option>
                            ${Object.entries(servicePresets).map(([id, preset]) => `<option value="${id}">${preset.name} - Rs. ${preset.default_labor_cost}</option>`).join('')}
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Description</label>
                        <input type="text" name="services[${index}][description]" placeholder="Description or notes" class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] placeholder-[var(--app-muted)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <div class="w-24">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Labor Cost</label>
                        <input type="number" name="services[${index}][labor_cost]" min="0" step="1" placeholder="2500" value="0" required class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <button type="button" onclick="removeService(${index})" class="px-2 py-1 text-red-500 hover:text-red-700 transition">
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
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Part or Reference</label>
                        <select name="parts[${index}][parts_reference_id]" class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" onchange="fillPartDetails(${index})">
                            <option value="">Select or enter custom</option>
                            ${Object.entries(partsReference).map(([id, part]) => `<option value="${id}">${part.name} (${part.part_number || 'N/A'}) - Rs. ${part.default_price}</option>`).join('')}
                        </select>
                    </div>
                    <div class="w-24">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Qty</label>
                        <input type="number" name="parts[${index}][quantity]" min="1" step="1" placeholder="1" value="1" required class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <div class="w-28">
                        <label class="block text-xs font-medium text-[var(--app-muted)] mb-1">Unit Price</label>
                        <input type="number" name="parts[${index}][unit_price]" min="0" step="1" placeholder="1500" value="0" required class="w-full rounded border border-[var(--app-border)] bg-[var(--app-bg)] px-2 py-1 text-sm text-[var(--app-text)] focus:border-[var(--app-accent)] focus:outline-none" />
                    </div>
                    <button type="button" onclick="removePart(${index})" class="px-2 py-1 text-red-500 hover:text-red-700 transition">
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
