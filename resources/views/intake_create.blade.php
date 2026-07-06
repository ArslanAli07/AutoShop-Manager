@extends('layouts.app')

@section('title', 'Quick Intake | AutoShop Manager')
@section('meta_description', 'Quickly onboard a walk-in customer, vehicle, and create a job card in seconds.')
@section('page_title', 'Quick Intake')

@section('content')
    <div class="max-w-4xl mx-auto pb-10" x-data="intakeForm(@js($servicePresets->keyBy('id')), @js($partReferences->keyBy('id')))">
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
            <section class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6"
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
            <section class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6"
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
            <section class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6"
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
            <section class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6"
                aria-label="Services details">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-[var(--app-text)]">Services / Labor</h2>
                    <button type="button" @click="addService()" class="text-sm font-semibold text-[var(--app-accent)] hover:underline">
                        + Add Service
                    </button>
                </div>

                <div class="space-y-4 mt-5">
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
                                <x-input x-bind:name="`services[${index}][description]`" x-model="service.desc" placeholder="Notes..." class="py-2.5" />
                            </div>
                            <div class="w-32">
                                <x-label class="mb-1 text-xs" value="Labor Cost" />
                                <x-input type="number" x-bind:name="`services[${index}][labor_cost]`" x-model="service.cost" required class="py-2.5" />
                            </div>
                            <button type="button" @click="removeService(index)" class="px-2 py-3 text-red-500 hover:text-red-700 transition">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </template>
                </div>

                @error('services')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </section>

            {{-- Parts --}}
            <section class="rounded-3xl border border-[var(--app-border)] bg-[var(--app-surface)] p-6"
                aria-label="Parts details">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-display text-lg font-semibold text-[var(--app-text)]">Parts</h3>
                        <p class="text-xs text-[var(--app-muted)] mt-1">Components used</p>
                    </div>
                    <button type="button" @click="addPart()" class="text-sm font-semibold text-[var(--app-accent)] hover:underline">
                        + Add Part
                    </button>
                </div>

                <div class="space-y-4 mt-5">
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
                                <x-input type="number" x-bind:name="`parts[${index}][quantity]`" x-model="part.qty" min="1" required class="py-2.5" />
                            </div>
                            <div class="flex-1">
                                <x-label class="mb-1 text-xs" value="Unit Price" />
                                <x-input type="number" x-bind:name="`parts[${index}][unit_price]`" x-model="part.price" min="0" required class="py-2.5" />
                            </div>
                            <button type="button" @click="removePart(index)" class="px-2 py-3 text-red-500 hover:text-red-700 transition">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </template>
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
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('intakeForm', (servicePresets, partsReference) => ({
                services: [],
                parts: [],
                servicePresets,
                partsReference,

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
