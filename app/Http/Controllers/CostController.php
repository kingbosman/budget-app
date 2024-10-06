<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCostRequest;
use App\Http\Requests\UpdateCostRequest;
use App\Models\Cost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CostController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCostRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cost $cost): RedirectResponse
    {
        $attributes = $request->validate([
            'category' => 'max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $attributes['paid'] = ($request->paid) ? 1 : 0;
        $attributes['amount'] = intval($request->amount * 100);
        $attributes['category'] = strtolower($attributes['category']);

        $cost->update($attributes);

        return redirect()->route('budgets.show', $cost->budget)->with('status', 'Record for ' . $cost->description . ' updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cost $cost)
    {
        //
    }
}
