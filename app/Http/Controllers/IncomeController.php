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
    public function create(Budget $budget): View
    {
        return view('incomes.create', [
           'budget' => $budget,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Budget $budget): RedirectResponse
    {
        $attributes = $request->validate([
            'name' => 'required|max:100',
           'amount' => 'required|numeric|min:0',
        ]);

        $attributes['amount'] *= 100;
        $attributes['budget_id'] = $budget->id;
        Income::create($attributes);

        return redirect()->route('incomes.index', $budget);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income): RedirectResponse
    {

        switch($request->form_type) {
            case 'update_amount':
                $attributes = $request->validate([
                    'amount' => 'required|numeric|min:0',
                ]);

                $attributes['amount'] *= 100;
                break;

            case 'update_is_received':
                $request->is_received ? $attributes['is_received'] = true : $attributes['is_received'] = false;
                break;
        }

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
