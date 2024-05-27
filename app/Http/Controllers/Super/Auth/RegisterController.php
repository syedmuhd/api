<?php

namespace App\Http\Controllers\Super\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Register admin
 * Only Super can execute this
 */

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        /**
         * Super is allowed
         */
        abort_if(!$request->user()->is_super, Response::HTTP_BAD_REQUEST, 'Operation is not permitted');

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        return $validated;
    }
}
