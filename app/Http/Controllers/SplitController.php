<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Split;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SplitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Budget $budget): View
    {
        return view('splits.index', [
            'budget' => $budget
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Budget $budget): RedirectResponse
    {
        Split::create([
            'name' => 'Split Name Here',
            'percentage' => 0,
            'minimal' => 0,
            'maximum' => 0,
            'budget_id' => $budget->id
        ]);

        return redirect()->route('splits.index', $budget);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Split $split): RedirectResponse
    {
        switch($request->form_type) {
            case 'update_name':
                $attributes = $request->validate([
                    'name' => 'required|string'
                ]);
                break;
            case 'update_percentage':
                $attributes = $request->validate([
                    'percentage' => 'required|numeric|min:0'
                ]);
                $attributes['percentage'] = $attributes['percentage'] * 100;
                break;
            case 'update_minimal':
                $attributes = $request->validate([
                    'minimal' => 'required|numeric|min:0'
                ]);

                if ($attributes['minimal'] > $split->maximum / 100 && $split->maximum > 0) {
                    throw validationException::withMessages([
                        'minimal' => 'Minimal can not exceed Maximum',
                    ]);
                }
                $attributes['minimal'] = $attributes['minimal'] * 100;
                break;
            case 'update_maximum':
                $attributes = $request->validate([
                    'maximum' => 'required|numeric|min:0'
                ]);
                if ($attributes['maximum'] < $split->minimal / 100 && $attributes['maximum'] > 0) {
                    throw validationException::withMessages([
                        'maximum' => 'Maximum can not be lower than Minimal',
                    ]);
                }
                $attributes['maximum'] = $attributes['maximum'] * 100;
                break;
        }

        $split->update($attributes);
        return redirect()->route('splits.index', $split->budget);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Split $split): RedirectResponse
    {
        $split->delete();
        return redirect()->route('splits.index', $split->budget)->with('status', $split->name . ' deleted successfully!');
    }
}
