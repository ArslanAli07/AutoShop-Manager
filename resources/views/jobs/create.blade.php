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

    <section aria-label="Create new job card" class="max-w-4xl mx-auto pb-10" x-data="jobForm(
        @js($cars->groupBy('customer_id')), 
        @js($servicePresets->keyBy('id')), 
        @js($partReferences->keyBy('id')), 
        '{{ $preselectedCarId }}'
    )">
        <div class="mb-6">
            <h1 class="text-3xl font-semibold text-[var(--app-text)]">New Job Card</h1>
            <p class="mt-1 text-sm text-[var(--app-muted)]">Create a new service job with customer, vehicle, services, and
                parts</p>
        </div>

        <form method="POST" action="{{ route('jobs.store') }}" class="space-y-6">
            @csrf


            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <h2 class="mb-4 text-lg font-semibold text-[var(--app-text)]">Customer & Vehicle</h2>

                <div class="grid gap-4 lg:grid-cols-2">
                    <div>
                        <x-label for="customer_id" value="Customer" />
                        <select id="customer_id" name="customer_id" required x-model="customerId" @change="updateCars()"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-3 outline-none focus:border-[var(--app-accent)] focus:ring-2 focus:ring-[var(--app-accent)]/20 shadow-sm transition">
                            <option value="">Select a customer...</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $preselectedCustomerId) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->phone }})
                                </option>
                            @endforeach
                        </select>
                        <x-error :messages="$errors->get('customer_id')" />
                    </div>

                    <div>
                        <x-label for="car_id" value="Vehicle" />
                        <select id="car_id" name="car_id" required x-model="carId"
                            class="mt-1 w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-3 outline-none focus:border-[var(--app-accent)] focus:ring-2 focus:ring-[var(--app-accent)]/20 shadow-sm transition">
                            <option value="">Select vehicle...</option>
                            <template x-for="car in availableCars" :key="car.id">
                                <option :value="car.id" x-text="`${car.plate_number} - ${car.make} ${car.model}`"></option>
                            </template>
                        </select>
                        <x-error :messages="$errors->get('car_id')" />
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


            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-[var(--app-text)]">Services / Labor</h2>
                    <button type="button" @click="addService()" class="text-sm font-bold text-[var(--app-accent)] hover:opacity-80 transition">
                        + Add Service
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(service, index) in services" :key="service.id">
                        <div class="flex gap-2 items-end">
                            <div class="flex-1">
                                <x-label class="mb-1 text-xs" value="Service or Preset" />
                                <select :name="`services[${index}][service_preset_id]`" x-model="service.preset_id" @change="updateService(index)" class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 outline-none focus:border-[var(--app-accent)]">
                                    <option value="">Select or enter custom</option>
                                    <template x-for="(preset, id) in servicePresets" :key="id">
                                        <option :value="id" x-text="`${preset.name} - Rs. ${preset.default_labor_cost}`"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="flex-1">
                                <x-label class="mb-1 text-xs" value="Description" />
                                <x-input :name="`services[${index}][description]`" x-model="service.desc" placeholder="Notes..." class="py-2.5" />
                            </div>
                            <div class="w-32">
                                <x-label class="mb-1 text-xs" value="Labor Cost" />
                                <x-input type="number" :name="`services[${index}][labor_cost]`" x-model="service.cost" required class="py-2.5" />
                            </div>
                            <button type="button" @click="removeService(index)" class="px-2 py-3 text-red-500 hover:text-red-700 transition">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </template>
                </div>

                @error('services')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>


            <div class="rounded-xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-[var(--app-text)]">Parts</h2>
                    <button type="button" @click="addPart()" class="text-sm font-bold text-[var(--app-accent)] hover:opacity-80 transition">
                        + Add Part
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(part, index) in parts" :key="part.id">
                        <div class="flex gap-2 items-end">
                            <div class="w-3/5">
                                <x-label class="mb-1 text-xs" value="Part or Reference" />
                                <select :name="`parts[${index}][parts_reference_id]`" x-model="part.ref_id" @change="updatePart(index)" class="w-full rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] px-4 py-2.5 outline-none focus:border-[var(--app-accent)]">
                                    <option value="">Select or enter custom</option>
                                    <template x-for="(ref, id) in partsReference" :key="id">
                                        <option :value="id" x-text="`${ref.name} - Rs. ${ref.default_price}`"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="w-20">
                                <x-label class="mb-1 text-xs" value="Qty" />
                                <x-input type="number" :name="`parts[${index}][quantity]`" x-model="part.qty" min="1" required class="py-2.5" />
                            </div>
                            <div class="flex-1">
                                <x-label class="mb-1 text-xs" value="Unit Price" />
                                <x-input type="number" :name="`parts[${index}][unit_price]`" x-model="part.price" min="0" required class="py-2.5" />
                            </div>
                            <button type="button" @click="removePart(index)" class="px-2 py-3 text-red-500 hover:text-red-700 transition">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </template>
                </div>

                @error('parts')
                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>


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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('jobForm', (carsData, servicePresets, partsReference, preselectedCarId) => ({
                customerId: '{{ old('customer_id', $preselectedCustomerId) }}',
                carId: '{{ old('car_id', $preselectedCarId) }}',
                availableCars: [],
                services: [],
                parts: [],
                carsData,
                servicePresets,
                partsReference,

                init() {
                    if (this.customerId) {
                        this.updateCars();
                        if (preselectedCarId) {
                            this.carId = preselectedCarId;
                        } else if (this.availableCars.length === 1) {
                            this.carId = this.availableCars[0].id;
                        }
                    }
                },

                updateCars() {
                    this.availableCars = this.customerId && this.carsData[this.customerId] 
                        ? this.carsData[this.customerId] 
                        : [];
                    // Reset carId if the selected car is no longer available
                    if (!this.availableCars.find(c => c.id == this.carId)) {
                        this.carId = '';
                    }
                },

                addService() {
                    this.services.push({ id: Date.now(), preset_id: '', desc: '', cost: 0 });
                },
                removeService(index) {
                    this.services.splice(index, 1);
                },
                updateService(index) {
                    const preset = this.servicePresets[this.services[index].preset_id];
                    if (preset) this.services[index].cost = preset.default_labor_cost;
                },

                addPart() {
                    this.parts.push({ id: Date.now(), ref_id: '', qty: 1, price: 0 });
                },
                removePart(index) {
                    this.parts.splice(index, 1);
                },
                updatePart(index) {
                    const ref = this.partsReference[this.parts[index].ref_id];
                    if (ref) this.parts[index].price = ref.default_price;
                }
            }));
        });
    </script>
@endsection
