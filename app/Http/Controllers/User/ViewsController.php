<?php

namespace App\Http\Controllers\User;

use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Support\Facades\Auth;

class ViewsController extends Controller
{
    public function dashboard(Request $request)
    {

        $user = Auth::user();
        $settings = Setting::first();
        $transactions = Deposit::get();
        // $transactions = Deposit::where('user_id', $user->id)
        //     ->orderBy('created_at', 'desc')
        //     ->take(5)
        //     ->get();

        return view('user.dashboard', [
            'user' => $user,
            'settings' => $settings,
            'transactions' => $transactions
        ]);
    }
}
