<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [SessionController::class, 'create'])
    ->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::delete('/logout', [SessionController::class, 'destroy'])
    ->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

//Logged in routes
Route::middleware(['auth'])->group(function () {
    Route::get('/budgets', [BudgetController::class, 'index'])
        ->name('budgets.index');

    Route::get('/budgets/create', [BudgetController::class, 'create'])
        ->name('budgets.create');
    Route::post('/budgets/create', [BudgetController::class, 'store']);

    Route::get('/budgets/{budget}', [BudgetController::class, 'show'])
        ->name('budgets.show')
        ->can('show', 'budget');

    Route::patch('/costs/{cost}', [CostController::class, 'update'])
        ->name('costs.update')
        ->can('update', 'cost');

    Route::delete('/costs/{cost}', [CostController::class, 'destroy'])
        ->name('costs.destroy')
        ->can('destroy', 'cost');

    Route::get('/costs/{budget}/new', [CostController::class, 'create'])
        ->name('costs.create')
        ->can('update', 'budget');

    Route::post('/costs/{budget}/new', [CostController::class, 'store'])
        ->name('costs.store')
        ->can('update', 'budget');

});

