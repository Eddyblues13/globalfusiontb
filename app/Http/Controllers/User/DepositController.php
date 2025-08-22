<?php

namespace App\Http\Controllers\User;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DepositController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('user.deposit', [
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'front_cheque' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'transaction_pin' => 'required|digits:4'
        ]);

        $user = Auth::user();

        // Verify transaction PIN using hashed comparison
        if (!Hash::check($request->transaction_pin, $user->transaction_pin)) {
            return back()->withErrors(['transaction_pin' => 'Invalid transaction PIN'])->withInput();
        }

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('front_cheque')) {
            $imagePath = $request->file('front_cheque')->store('cheques', 'public');
        }

        // Calculate net amount (assuming 0% fee for deposits)
        $amounts = Transaction::calculateNetAmount($request->amount, 0);

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => Transaction::TYPE_CHECK_DEPOSIT,
            'amount' => $amounts['amount'],
            'fee' => $amounts['fee'],
            'net_amount' => $amounts['net_amount'],
            'status' => Transaction::STATUS_PENDING,
            'front_cheque_path' => $imagePath,
            'description' => 'Mobile check deposit',
            'reference_id' => Transaction::generateReferenceId(),
            'transaction_pin' => $user->transaction_pin, // Store hashed pin from user
        ]);

        return redirect()->route('deposit.success')->with('success', 'Your deposit is being processed and will be reviewed shortly.');
    }

    public function success()
    {
        return view('user.deposit-success');
    }
}
