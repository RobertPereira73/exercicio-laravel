<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            return redirect('/');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login.index');
    }
}
