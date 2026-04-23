<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Force la redirection après connexion
    protected function redirectTo()
    {
        return '/home';
    }

    // Alternative : rediriger manuellement
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('home');
    }
}
