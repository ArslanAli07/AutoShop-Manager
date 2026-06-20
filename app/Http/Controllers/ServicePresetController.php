<?php

namespace App\Http\Controllers;

use App\Models\ServicePreset;
use Illuminate\Http\Request;

class ServicePresetController extends Controller
{
    public function index()
    {
        $presets = ServicePreset::orderBy('category')
            ->orderBy('name')
            ->paginate(20);

        return view('presets.index', compact('presets'));
    }

    public function create()
    {
        return view('presets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'default_labor_cost' => 'required|numeric|min:0',
        ]);

        ServicePreset::create($validated);

        return redirect()->route('presets.index')
            ->with('success', 'Service preset created successfully.');
    }

    public function edit(ServicePreset $preset)
    {
        return view('presets.edit', compact('preset'));
    }

    public function update(Request $request, ServicePreset $preset)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'default_labor_cost' => 'required|numeric|min:0',
        ]);

        $preset->update($validated);

        return redirect()->route('presets.index')
            ->with('success', 'Service preset updated successfully.');
    }

    public function destroy(ServicePreset $preset)
    {
        $preset->delete();

        return redirect()->route('presets.index')
            ->with('success', 'Service preset deleted successfully.');
    }
}
