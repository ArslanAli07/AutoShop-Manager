<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Job;
use App\Models\JobService;
use App\Models\JobPart;
use App\Models\ServicePreset;
use App\Models\PartReference;
use App\Http\Requests\StoreIntakeRequest;
use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntakeController extends Controller
{
    /**
     * Render the quick intake form.
     */
    public function create()
    {
        $servicePresets = ServicePreset::orderBy('category')->orderBy('name')->get();
        $partReferences = PartReference::orderBy('name')->get();

        return view('intake_create', compact('servicePresets', 'partReferences'));
    }



    /**
     * Validate and create Customer + Car + Job in a single transaction.
     */
    public function store(StoreIntakeRequest $request)
    {
        $validated = $request->validated();

        try {
            $job = DB::transaction(function () use ($validated) {
                $customer = Customer::create([
                    'name' => trim($validated['customer_name']),
                    'phone' => trim($validated['customer_phone']),
                    'address' => isset($validated['customer_address']) ? trim($validated['customer_address']) : null,
                ]);

                $car = Car::create([
                    'customer_id' => $customer->id,
                    'plate_number' => strtoupper(trim($validated['plate_number'])),
                    'make' => trim($validated['make']),
                    'model' => trim($validated['model']),
                    'year' => $validated['year'] ?? null,
                ]);

                $job = Job::create([
                    'job_number' => app(JobService::class)->generateJobNumber(),
                    'customer_id' => $customer->id,
                    'car_id' => $car->id,
                    'date_in' => now()->toDateString(),
                    'mileage_in' => isset($validated['mileage_in']) ? (int) $validated['mileage_in'] : null,
                    'notes' => $validated['notes'] ?? null,
                    'status' => 'received',
                    'payment_status' => 'unpaid',
                    'amount_paid' => 0,
                ]);
                
                if (!empty($validated['services'])) {
                    foreach ($validated['services'] as $serviceData) {
                        JobService::create([
                            'job_id' => $job->id,
                            'service_preset_id' => $serviceData['service_preset_id'] ?? null,
                            'description' => $serviceData['description'] ?? null,
                            'labor_cost' => $serviceData['labor_cost'],
                        ]);
                    }
                }

                if (!empty($validated['parts'])) {
                    foreach ($validated['parts'] as $partData) {
                        JobPart::create([
                            'job_id' => $job->id,
                            'parts_reference_id' => $partData['parts_reference_id'] ?? null,
                            'part_name' => $partData['part_name'] ?? null,
                            'quantity' => $partData['quantity'],
                            'unit_price' => $partData['unit_price'],
                        ]);
                    }
                }
                
                return $job;
            });

            return redirect()->route('jobs.show', $job->id)
                ->with('success', "Job card {$job->job_number} created via Quick Intake!");
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Quick Intake failed. Please try again.');
        }
    }
}
