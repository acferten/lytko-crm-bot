<?php

namespace App\Http\Web\Controllers\Auth;

use Domain\Shared\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends Controller
{
    public function getForm(): View
    {
        return view('pages.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'credential' => ['required'],
            'password' => ['required'],
        ]);

        if (User::where('login', $request->input('credential'))->exists()) {
            $credentials = [
                'login' => $request->input('credential'),
                'password' => $request->input('password'),
            ];
        } else {
            $credentials = [
                'email' => $request->input('credential'),
                'password' => $request->input('password'),
            ];
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'password' => 'The provided credentials do not match our records.',
        ]);
    }
}
