<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BillPaymentController extends Controller
{
    /**
     * Display the bill payment page
     */
    public function index()
    {
        $user = Auth::user();


        return view('user.pay', compact('user'));
    }

    /**
     * Process bill payment request
     */
    public function process(Request $request, $type)
    {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'account_number' => 'required|string',
        ]);

        // Here you would typically:
        // 1. Validate user has sufficient balance
        // 2. Create transaction record
        // 3. Integrate with payment gateway
        // 4. Send notification

        return response()->json([
            'success' => true,
            'message' => "Your {$type} payment request has been received. You will receive instructions shortly.",
            'transaction_id' => uniqid('BILL_')
        ]);
    }
}
