<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Income;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Budget $budget): View
    {

        return view('incomes.index', [
            'budget' => $budget,
            'incomes' => Income::query()->where('budget_id', $budget->id)->get(),
        ]);
    }

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income): RedirectResponse
    {
        $attributes = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $attributes['amount'] = intval($attributes['amount'] * 100);

        $income->update($attributes);
        return redirect()->route('incomes.index', $income->budget);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income): RedirectResponse
    {
        $income->delete();
        return redirect()->route('incomes.index', $income->budget)->with('status', $income->name . ' was successfully deleted.');
    }
}
