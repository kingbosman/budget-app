<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SplitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [SessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])
    ->middleware('guest');
Route::delete('/logout', [SessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register')
    ->middleware('guest');
Route::post('/register', [RegisteredUserController::class, 'store']);

//Logged in routes
Route::middleware(['auth'])->group(function () {

    // show budgets
    Route::get('/budgets', [BudgetController::class, 'index'])
        ->name('budgets.index');


    //create budgets
    Route::get('/budgets/create', [BudgetController::class, 'create'])
        ->name('budgets.create');
    Route::get('/budgets/{budget}', [BudgetController::class, 'show'])
        ->name('budgets.show')
        ->can('show', 'budget');
    Route::post('/budgets/create', [BudgetController::class, 'store']);

    //edit budget
    Route::get('budgets/{budget}/edit', [BudgetController::class, 'edit'])
        ->name('budgets.edit')
        ->can('update', 'budget');
    Route::patch('budgets/{budget}/edit', [BudgetController::class, 'update'])
        ->name('budgets.update')
        ->can('update', 'budget');
    Route::delete('budgets/{budget}/edit', [BudgetController::class, 'destroy'])
        ->name('budgets.delete')
        ->can('update', 'budget');

    // Record
    Route::get('/costs/{budget}/new', [CostController::class, 'create'])
        ->name('costs.create')
        ->can('update', 'budget');
    Route::post('/costs/{budget}/new', [CostController::class, 'store'])
        ->name('costs.store')
        ->can('update', 'budget');
    Route::patch('/costs/{cost}', [CostController::class, 'update'])
        ->name('costs.update')
        ->can('update', 'cost');
    Route::delete('/costs/{cost}', [CostController::class, 'destroy'])
        ->name('costs.destroy')
        ->can('destroy', 'cost');

    // Income
    Route::get('/income/{budget}', [IncomeController::class, 'index'])
        ->name('incomes.index')
        ->can('show', 'budget');
    Route::get('/income/{budget}/new', [IncomeController::class, 'create'])
        ->name('incomes.create')
        ->can('update', 'budget');
    Route::post('/income/{budget}/new', [IncomeController::class, 'store'])
        ->name('incomes.store')
        ->can('update', 'budget');


    Route::patch('/income/{income}', [IncomeController::class, 'update'])
        ->name('incomes.update')
        ->can('update', 'income');

    Route::delete('/income/{income}', [IncomeController::class, 'destroy'])
        ->name('incomes.destroy')
        ->can('destroy', 'income');

    Route::get('/split/{budget}', [SplitController::class, 'index'])
        ->name('splits.index')
        ->can('update', 'budget');
    Route::post('/split/{budget}', [SplitController::class, 'store'])
        ->name('splits.store')
        ->can('update', 'budget');

    Route::delete('split/{split}', [SplitController::class, 'destroy'])
        ->name('splits.destroy')
        ->can('update', 'split');

});

