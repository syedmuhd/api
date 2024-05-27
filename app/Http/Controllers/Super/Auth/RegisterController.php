<?php

namespace App\Http\Controllers\Super\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|email'
        ]);

        return "validated";
    }
}
