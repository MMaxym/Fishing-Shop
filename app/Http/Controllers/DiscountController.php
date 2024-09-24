<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::all();
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|string',
        ]);

        Discount::create($validated);

        return redirect()->route('admin.discounts.index')->with('success', 'Знижка створена успішно !!!');
    }

    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|string',
        ]);

        $discount->update($validated);

        return redirect()->route('admin.discounts.index')->with('success', 'Знижка оновлена успішно !!!');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discounts.index')->with('error', 'Знижку успішно видалено !!!');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $discounts = Discount::where('name', 'LIKE', "%{$query}%")->get();

        return response()->json([
            'discounts' => $discounts
        ]);
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');
        $filterType = $request->input('filter_type');
        $filterStatus = $request->input('filter_status');

        $discounts = Discount::query();

        if ($filterType) {
            $discounts->where('type', $filterType);
        }

        if ($filterStatus === 'active') {
            $discounts->where('end_date', '>', now());
        } elseif ($filterStatus === 'expired') {
            $discounts->where('end_date', '<=', now());
        }

        if ($query) {
            $discounts->where('name', 'like', '%' . $query . '%');
        }

        return response()->json([
            'discounts' => $discounts->get()
        ]);
    }

}
