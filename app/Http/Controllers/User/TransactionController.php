<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        // Fetch user transactions
        $user = Auth::user();
        return view('user.transactions', compact('user'));
    }

    // Additional methods for handling transactions can be added here
}
