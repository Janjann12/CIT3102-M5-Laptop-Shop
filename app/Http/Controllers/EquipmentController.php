<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::query();

        $allowedFilters = ['category', 'quantity'];

        foreach ($allowedFilters as $field) {
            if ($request->has($field)) {
                $query->where($field, $request->input($field));
            }
        }

        return response()->json($query->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $equipment = Equipment::create($validated);

        return response()->json($equipment, 201);
    }

    public function show(Equipment $equipment)
    {
        return response()->json($equipment, 200);
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $equipment->update($validated);

        return response()->json($equipment, 200);
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return response()->noContent();
    }
}
