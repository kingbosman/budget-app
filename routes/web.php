<?php

use App\Http\Controllers\BudgetController;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
