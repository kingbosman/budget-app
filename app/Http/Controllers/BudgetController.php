<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Cost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $budgets = Budget::query()
            ->with('users')
            ->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return View('budgets.index', ['budgets' => $budgets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return View('budgets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
           'name' => ['required','min:3'],
        ]);

        $budget = Budget::create($attributes);
        $budget->users()->attach(Auth::id());

        return redirect()->route('budgets.show', ['budget' => $budget]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget): View
    {
        $costs = Cost::query()
            ->where('budget_id', $budget->id)
            ->orderBy('category', 'desc')
            ->get();

        return View('budgets.show', [
            'budget' => $budget,
            'costs' => $costs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget): View
    {
        return View('budgets.edit', ['budget' => $budget]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget): RedirectResponse
    {
        $attributes = $request->validate([
           'name' => ['required','min:3'],
        ]);

        $budget->update($attributes);
        return redirect()->route('budgets.show', ['budget' => $budget]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('status', 'Budget ' . $budget->name . ' successfully deleted!');
    }
}
