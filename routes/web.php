<?php

use App\Http\Controllers\BudgetController;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/dashboard', function () {
////    $user = User::query()->with('budget')->find(1);
////    dd($user->budget->first()->name);
////    return view('dashboard', ['user' => $user]);
//
//});
Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
