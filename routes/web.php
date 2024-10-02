<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\SessionController;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [SessionController::class, 'create'])->name('login');

Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
