<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Job;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $make = trim((string) $request->input('make', ''));
        $model = trim((string) $request->input('model', ''));

        $customers = Customer::query()
            ->withCount(['cars', 'jobs'])
            ->withMax('jobs', 'date_in')
            ->when($query, function ($builder) use ($query) {
                $builder->where(function ($search) use ($query) {
                    $search->where('name', 'like', "%{$query}%")
                        ->orWhere('phone', 'like', "%{$query}%");
                });
            })
            ->when($make !== '' || $model !== '', function ($builder) use ($make, $model) {
                $builder->whereHas('cars', function ($carQuery) use ($make, $model) {
                    $carQuery->when($make !== '', function ($filter) use ($make) {
                        $filter->where('make', 'like', "%{$make}%");
                    })->when($model !== '', function ($filter) use ($model) {
                        $filter->where('model', 'like', "%{$model}%");
                    });
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Customer created.');
    }

    public function show(Customer $customer)
    {
        $customer->load('cars');

        $jobs = $customer->jobs()
            ->with(['car', 'services', 'parts'])
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

        return view('customers.show', compact('customer', 'jobs', 'totalSpent'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $customer->update($data);

        return redirect()->route('customers.show', $customer)->with('success', 'Customer updated.');
    }

    public function destroy(Customer $customer)
    {
        Customer::destroy($customer->id);

        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }
}
