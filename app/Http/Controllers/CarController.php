<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Customer;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        $cars = Car::query()
            ->with('customer')
            ->when($query, function ($builder) use ($query) {
                $builder->where(function ($search) use ($query) {
                    $search->where('plate_number', 'like', "%{$query}%")
                        ->orWhere('make', 'like', "%{$query}%")
                        ->orWhere('model', 'like', "%{$query}%")
                        ->orWhereHas('customer', function ($customer) use ($query) {
                            $customer->where('name', 'like', "%{$query}%")
                                ->orWhere('phone', 'like', "%{$query}%");
                        });
                });
            })
            ->orderBy('plate_number')
            ->paginate(15)
            ->withQueryString();

        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        $customers = Customer::all(['id', 'name', 'phone'])->sortBy('name')->values();
        return view('cars.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plate_number' => 'required|string|max:20',
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'nullable|digits:4',
            'color' => 'nullable|string|max:30',
            'notes' => 'nullable|string',
        ]);

        $car = Car::create($data);

        return redirect()->route('cars.show', $car)->with('success', 'Car created.');
    }

    public function show(Car $car)
    {
        $car->load('customer');

        $jobs = $car->jobs()
            ->with(['services', 'parts'])
            ->withSum('services as labor_total', 'labor_cost')
            ->withSum('parts as parts_total', 'total_price')
            ->orderByDesc('date_in')
            ->get()
            ->map(function ($job) {
                $job->labor_total = (float) ($job->labor_total ?? 0);
                $job->parts_total = (float) ($job->parts_total ?? 0);
                $job->grand_total = $job->labor_total + $job->parts_total;

                return $job;
            });

        $totalSpent = $jobs->sum('grand_total');

        return view('cars.show', compact('car', 'jobs', 'totalSpent'));
    }

    public function edit(Car $car)
    {
        $customers = Customer::all(['id', 'name', 'phone'])->sortBy('name')->values();
        return view('cars.edit', compact('car', 'customers'));
    }

    public function update(Request $request, Car $car)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plate_number' => 'required|string|max:20',
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'nullable|digits:4',
            'color' => 'nullable|string|max:30',
            'notes' => 'nullable|string',
        ]);

        $car->update($data);

        return redirect()->route('cars.show', $car)->with('success', 'Car updated.');
    }

    public function destroy(Car $car)
    {
        Car::destroy($car->id);

        return redirect()->route('cars.index')->with('success', 'Car deleted.');
    }
}
