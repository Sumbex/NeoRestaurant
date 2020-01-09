<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        return User::login($request);
    }

    public function Logout()
    {
        return User::logout();
    }
}
