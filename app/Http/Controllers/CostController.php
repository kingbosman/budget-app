<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCostRequest;
use App\Http\Requests\UpdateCostRequest;
use App\Models\Budget;
use App\Models\Cost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CostController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Budget $budget): View
    {
        return view('costs.create', ['budget' => $budget]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Budget $budget): RedirectResponse
    {
        $attributes = request()->validate([
            'description' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'category' => ['string', 'nullable'],
        ]);

        $attributes['amount'] = intval($request->amount * 100);
        $attributes['category'] = strtolower($attributes['category']);
        $attributes['budget_id'] = $budget->id;

        Cost::create($attributes);

        return redirect()->route('budgets.show', ['budget' => $budget]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cost $cost): RedirectResponse
    {
        switch ($request->form_type) {
            case 'update_amount':
                $attributes = $request->validate([
                    'amount' => ['numeric', 'required', 'min:0'],
                ]);

                $attributes['amount'] *= 100;

                break;
            case 'update_category':
                $attributes = $request->validate([
                    'category' => ['max:50'],
                ]);
                $attributes['category'] = strtolower($attributes['category']);
                break;
            case 'update_paid':
                $attributes['paid'] = ($request->paid) ? 1 : 0;
                break;
        }

        $cost->update($attributes);

        return redirect()->route('budgets.show', $cost->budget)->with('status', 'Record for ' . $cost->description . ' updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cost $cost): RedirectResponse
    {
        $budget = $cost->budget;
        $description = $cost->description;
        $cost->delete();
        return redirect()->route('budgets.show', $budget)->with('status', 'Record ' . $description . ' deleted');
    }
}
