<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Cost;
use App\Models\Income;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
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
           'name' => ['required','min:3', 'max:100'],
        ]);

        //set creator of the budget as admin
        $attributes['admin_user_id'] = Auth::id();

        $budget = Budget::create($attributes);
        $budget->users()->attach(Auth::id());

        return redirect()->route('budgets.show', ['budget' => $budget]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget): View
    {
        // get all costs
        $costs = Cost::query()
            ->with(['reducedCosts'])
            ->where('budget_id', $budget->id)
            ->orderBy('category')
            ->get();

        // get reserved income
        $reserved = Income::query()
            ->where('budget_id', $budget->id)
            ->where('is_received', 1)
            ->sum('amount');

        $unpaid= 0;
        foreach ($costs as $cost) {
            if (!$cost->paid) $unpaid += $cost->amount;
        }


        return View('budgets.show', [
            'budget' => $budget,
            'costs' => $costs,
            'reserved' => $reserved / 100,
            'unpaid' => $unpaid / 100,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget): View
    {
        return View('budgets.edit', [
            'budget' => $budget,
            'is_admin' => Auth::id() === $budget->admin_user_id,
        ]);
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
    public function destroy(Budget $budget): RedirectResponse
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('status', 'Budget ' . $budget->name . ' successfully deleted!');
    }

    public function storeShare(Budget $budget, Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'email' => ['required','email','exists:users,email'],
        ]);

        $userId = User::where('email', $attributes['email'])->first('id')->id;
        if($budget->users->find($userId)) throw ValidationException::withMessages(['email' => 'Already shared']);
        $budget->users()->attach($userId);

        return redirect()->back();

    }

    public function destroyShare(Budget $budget, Request $request): RedirectResponse
    {
        $userId = $request->user_id;
        if($userId == Auth::id()) throw ValidationException::withMessages(['user_id' => 'You cannot delete yourself']);
        $budget->users()->detach($userId);
        return redirect()->back();
    }
}
