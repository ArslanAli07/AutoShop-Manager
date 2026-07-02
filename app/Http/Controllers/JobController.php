<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Customer;
use App\Models\Car;
use App\Models\ServicePreset;
use App\Models\PartReference;
use App\Models\JobService;
use App\Models\JobPart;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Services\JobService;
use Illuminate\Http\Request;

class JobController extends Controller
{


    /**
     * Display a listing of jobs with search and filters.
     */
    public function index(Request $request)
    {
        $query = Job::with('customer', 'car');

        // Search by customer name, phone, or car plate
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })
                    ->orWhereHas('car', function ($subQ) use ($search) {
                        $subQ->where('plate_number', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date_in', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date_in', '<=', $request->input('date_to'));
        }

        // Sorting
        $sortField = $request->input('sort', 'date_in');
        $sortDirection = $request->input('direction', 'desc');
        
        $allowedSorts = ['job_number', 'date_in', 'status', 'payment_status'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest('date_in');
        }

        $jobs = $query->paginate(20)->withQueryString();

        return view('jobs.index', compact('jobs', 'sortField', 'sortDirection'));
    }

    /**
     * Show the form for creating a new job.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $servicePresets = ServicePreset::orderBy('category')->orderBy('name')->get();
        $partReferences = PartReference::orderBy('name')->get();

        return view('jobs.create', compact('customers', 'servicePresets', 'partReferences'));
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(StoreJobRequest $request)
    {
        $validated = $request->validated();

        $job = Job::create([
            'job_number' => app(JobService::class)->generateJobNumber(),
            'customer_id' => $validated['customer_id'],
            'car_id' => $validated['car_id'],
            'date_in' => $validated['date_in'],
            'mileage_in' => $validated['mileage_in'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'received',
            'payment_status' => 'unpaid',
            'amount_paid' => 0,
        ]);

        // Add services
        if ($request->has('services')) {
            foreach ($request->input('services') as $service) {
                if (isset($service['labor_cost']) && $service['labor_cost'] > 0) {
                    JobService::create([
                        'job_id' => $job->id,
                        'service_preset_id' => $service['service_preset_id'] ?? null,
                        'description' => $service['description'] ?? null,
                        'labor_cost' => $service['labor_cost'],
                    ]);
                }
            }
        }

        // Add parts
        if ($request->has('parts')) {
            foreach ($request->input('parts') as $part) {
                if (isset($part['quantity']) && $part['quantity'] > 0 && isset($part['unit_price']) && $part['unit_price'] > 0) {
                    JobPart::create([
                        'job_id' => $job->id,
                        'parts_reference_id' => $part['parts_reference_id'] ?? null,
                        'part_name' => $part['part_name'] ?? null,
                        'part_number' => $part['part_number'] ?? null,
                        'quantity' => $part['quantity'],
                        'unit_price' => $part['unit_price'],
                    ]);
                }
            }
        }

        return redirect()->route('jobs.show', $job->id)
            ->with('success', "Job card {$job->job_number} created successfully!");
    }

    /**
     * Display the specified job (detail/receipt view).
     */
    public function show(Job $job)
    {
        $job->load('customer', 'car', 'services.servicePreset', 'parts.partsReference');

        // Calculate totals
        $laborTotal = $job->services->sum('labor_cost');
        $partsTotal = $job->parts->sum(function ($part) {
            return $part->quantity * $part->unit_price;
        });
        $grandTotal = $laborTotal + $partsTotal;

        return view('jobs.show', compact('job', 'laborTotal', 'partsTotal', 'grandTotal'));
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(Job $job)
    {
        $job->load('customer', 'car', 'services', 'parts');
        $customers = Customer::orderBy('name')->get();
        $cars = Car::orderBy('plate_number')->get();
        $servicePresets = ServicePreset::orderBy('category')->orderBy('name')->get();
        $partReferences = PartReference::orderBy('name')->get();

        return view('jobs.edit', compact('job', 'customers', 'cars', 'servicePresets', 'partReferences'));
    }

    /**
     * Update the specified job in storage.
     */
    public function update(UpdateJobRequest $request, Job $job)
    {
        $validated = $request->validated();

        $job->update([
            'customer_id' => $validated['customer_id'],
            'car_id' => $validated['car_id'],
            'date_in' => $validated['date_in'],
            'date_out' => $validated['date_out'] ?? null,
            'mileage_in' => $validated['mileage_in'] ?? null,
            'mileage_out' => $validated['mileage_out'] ?? null,
            'status' => $validated['status'],
            'payment_status' => $validated['payment_status'],
            'amount_paid' => $validated['amount_paid'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Update services - delete old, create new
        $job->services()->delete();
        if ($request->has('services')) {
            foreach ($request->input('services') as $service) {
                if (isset($service['labor_cost']) && $service['labor_cost'] > 0) {
                    JobService::create([
                        'job_id' => $job->id,
                        'service_preset_id' => $service['service_preset_id'] ?? null,
                        'description' => $service['description'] ?? null,
                        'labor_cost' => $service['labor_cost'],
                    ]);
                }
            }
        }

        // Update parts - delete old, create new
        $job->parts()->delete();
        if ($request->has('parts')) {
            foreach ($request->input('parts') as $part) {
                if (isset($part['quantity']) && $part['quantity'] > 0 && isset($part['unit_price']) && $part['unit_price'] > 0) {
                    JobPart::create([
                        'job_id' => $job->id,
                        'parts_reference_id' => $part['parts_reference_id'] ?? null,
                        'part_name' => $part['part_name'] ?? null,
                        'part_number' => $part['part_number'] ?? null,
                        'quantity' => $part['quantity'],
                        'unit_price' => $part['unit_price'],
                    ]);
                }
            }
        }

        return redirect()->route('jobs.show', $job->id)
            ->with('success', "Job card {$job->job_number} updated successfully!");
    }

    /**
     * Display the print-friendly receipt view.
     */
    public function print(Job $job)
    {
        $job->load('customer', 'car', 'services.servicePreset', 'parts.partsReference');
        return view('jobs.print', compact('job'));
    }

    /**
     * Record a payment against a job.
     */
    public function recordPayment(Request $request, Job $job)
    {
        // Calculate grand total to determine remaining balance
        $job->load('services', 'parts');
        $laborTotal = $job->services->sum('labor_cost');
        $partsTotal = $job->parts->sum(fn($p) => $p->quantity * $p->unit_price);
        $grandTotal = $laborTotal + $partsTotal;
        $balance = max(0, $grandTotal - $job->amount_paid);

        $validated = $request->validate([
            'amount_paid' => ['required', 'numeric', 'min:0', 'max:' . $balance],
        ], [
            'amount_paid.max' => 'The payment amount cannot exceed the remaining balance of Rs. ' . number_format($balance),
        ]);

        $currentAmountPaid = (float) $job->amount_paid;
        $newPayment = (float) $validated['amount_paid'];
        
        $totalAmountPaid = $currentAmountPaid + $newPayment;

        if ($totalAmountPaid <= 0) {
            $paymentStatus = 'unpaid';
        } elseif ($totalAmountPaid >= $grandTotal) {
            $paymentStatus = 'paid';
        } else {
            $paymentStatus = 'partial';
        }

        $job->update([
            'amount_paid'    => $totalAmountPaid,
            'payment_status' => $paymentStatus,
        ]);

        return redirect()->route('jobs.show', $job->id)
            ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy(Job $job)
    {
        $jobNumber = $job->job_number;
        $job->services()->delete();
        $job->parts()->delete();
        $job->delete();

        return redirect()->route('jobs.index')
            ->with('success', "Job card {$jobNumber} deleted successfully!");
    }

    /**
     * Quick status update.
     */
    public function updateStatus(Request $request, Job $job)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:received,in_progress,ready,delivered,cancelled',
        ]);

        $job->update(['status' => $validated['status']]);

        return back()->with('success', "Job card {$job->job_number} status updated to " . ucfirst(str_replace('_', ' ', $validated['status'])) . " successfully!");
    }
}
