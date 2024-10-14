<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Split;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function update(Request $request, Split $split)
    {
        //
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
