<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Cost;
use App\Models\ReducedCost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ReducedCostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Budget $budget): View
    {
        $costs_ids = Cost::query()
            ->where('budget_id', $budget->id)
            ->get('id');
        $costs_ids = array_column($costs_ids->toArray(), 'id');

        $records = ReducedCost::query()
            ->whereIn('cost_id', $costs_ids)
            ->with(['cost'])
            ->orderBy('id', 'desc')
            ->get();

        return view('reduced_costs.index', [
            'records' => $records,
            'budget' => $budget,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Cost $cost): View
    {
        return view('reduced_costs.create', [
            'cost' => $cost,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Cost $cost): RedirectResponse
    {
        $attributes = request()->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $attributes['amount'] *= 100;

        $attributes['cost_id'] = $cost->id;

        $total_amount = ReducedCost::query()
            ->where('cost_id', $cost->id)
            ->sum('amount');

        if ($attributes['amount'] > $cost->amount - $total_amount) throw ValidationException::withMessages(
            ['amount' => 'Amount may not exceed remaining amount of € ' . number_format(($cost->amount - $total_amount) / 100,2)
        ]);

        ReducedCost::create($attributes);
        return redirect()->route('budgets.show', $cost->budget);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReducedCost $reduced_cost)
    {
        dd('dodododod');
    }
}
