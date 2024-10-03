<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create(): View
    {
        return View('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($attributes)) {
            throw validationException::withMessages([
                'email' => __('Login details incorrect'),
            ]);
        }

        $request->session()->regenerate();
        return redirect()->route('budgets.index');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
