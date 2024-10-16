<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Income;
use App\Models\Split;
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
        // Default income logic
        $incomes = Income::query()->where('budget_id', $budget->id)->get();
        $total = [
            'income' => array_sum(array_column($incomes->toArray(), 'amount')) / 100,
            'cost' => array_sum(array_column($budget->costs->toArray(), 'amount')) / 100,
        ];
        $total['remainder'] = $total['income'] - $total['cost'];
        $total['percentage'] = [
            'income' => 100,
            'cost' => ($total['income']) ? $total['cost'] / $total['income'] * 100 : 0,
            'remainder' => ($total['income']) ? $total['remainder'] / $total['income'] * 100 : 0,
        ];

        // Start split logic here
        // Calculate actual percentages for each split
        $splits = Split::query()->where('budget_id', $budget->id)->get();

        // Create empty array for named convention later
        $real_splits = [];

        // create a total for calculating the remainder will increment with each iteration
        $totals['amount']['total'] = 0;

        // set a a total remainder percentage will increment with each iteration
        $it_percentage = 0;

        // add the second iteration array, empty by default
        $newIteration = [];

        foreach ($splits as $key => $split) {
            // percentage in integer saved with 2 decimals
            $amount = ($split['percentage'] / 10000) * $total['remainder'];
            if (($split['minimal'] / 100) > $amount) $mod_amount = $split['minimal'] / 100;
            if (($split['maximum'] / 100) < $amount && $split['maximum'] > 0) $mod_amount = $split['maximum'] / 100;

            if (isset($mod_amount)) {
                $totals['amount']['total'] += $mod_amount;
                $real_splits[$split['name']]['amount'] = round($mod_amount, 2, PHP_ROUND_HALF_DOWN);
                $real_splits[$split['name']]['percentage'] = $mod_amount / $total['remainder'] * 100;
            }

            // create the new iteration for items without min/max
            if (!isset($mod_amount)) {
                $newIteration[$split['name']]['amount'] = $amount;
                $newIteration[$split['name']]['percentage'] = $split['percentage'];
                $it_percentage += $split['percentage'];
            }

            // Unset for next iteration
            unset($mod_amount);

        }

        $remainder = $total['remainder'] - $totals['amount']['total'];

        // Iterate through items without min and max and set their values for the split
        foreach ($newIteration as $key => $iteration) {
            if ($it_percentage > 0 && $remainder > 0) {
                $percentage = $iteration['percentage'] / $it_percentage;
                $amount = round($remainder * $percentage, 2, PHP_ROUND_HALF_DOWN);
                $real_splits[$key]['amount'] = $amount;
                $real_splits[$key]['percentage'] = $amount / $total['remainder'] * 100;
            }
            else {
                $real_splits[$key]['amount'] = 0;
                $real_splits[$key]['percentage'] = 0;
            }
        }

        // add percentages to show when split exceed 100%
        $income_percentages = array_sum(array_column($real_splits, 'percentage'));

        return view('incomes.index', [
            'budget' => $budget,
            'incomes' => $incomes,
            'total' => $total,
            'splits' => $real_splits,
            'income_percentages' => $income_percentages,
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
