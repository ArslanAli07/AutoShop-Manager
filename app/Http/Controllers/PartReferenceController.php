<?php

namespace App\Http\Controllers;

use App\Models\PartReference;
use Illuminate\Http\Request;

class PartReferenceController extends Controller
{
    public function index()
    {
        $parts = PartReference::orderBy('name')
            ->paginate(20);

        return view('parts.index', compact('parts'));
    }

    public function create()
    {
        return view('parts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'part_number'   => 'nullable|string|max:50',
            'default_price' => 'required|numeric|min:0',
        ]);

        // Checkboxes are NOT submitted when unchecked — read explicitly.
        $validated['needs_reorder'] = $request->boolean('needs_reorder');

        PartReference::create($validated);

        return redirect()->route('parts.index')
            ->with('success', 'Part reference created successfully.');
    }

    public function edit(PartReference $part)
    {
        return view('parts.edit', compact('part'));
    }

    public function update(Request $request, PartReference $part)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100',
            'part_number'   => 'nullable|string|max:50',
            'default_price' => 'required|numeric|min:0',
        ]);

        // Checkboxes are NOT submitted when unchecked — read explicitly so
        // unchecking "Needs Reorder" correctly saves false (in stock).
        $validated['needs_reorder'] = $request->boolean('needs_reorder');

        $part->update($validated);

        return redirect()->route('parts.index')
            ->with('success', 'Part reference updated successfully.');
    }

    public function destroy(PartReference $part)
    {
        $part->delete();

        return redirect()->route('parts.index')
            ->with('success', 'Part reference deleted successfully.');
    }
}
