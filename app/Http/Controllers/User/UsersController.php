<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function verifyemail()
    {
        return view('auth.verify-email', [
            'title' => 'Verify Your email address',
        ]);
    }
}
