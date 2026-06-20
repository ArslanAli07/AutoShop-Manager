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
                    <span aria-hidden="true">⚡</span>
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
