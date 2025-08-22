<?php

namespace App\Http\Controllers\User;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CryptoController extends Controller
{
    public function crypto()
    {
        $user = Auth::user();


        return view('user.crypto', compact('user'));
    }


    public function cryptoDepositPage()
    {
        $user = Auth::user();

        // Generate a unique account number if not exists
        $accountNumber = session('crypto_account_number', $user->id . rand(1000, 9999));
        session(['crypto_account_number' => $accountNumber]);

        return view('user.crypto_deposit', [
            'accountNumber' => $accountNumber,
            'balance' => $user->balance,
            'cryptoOptions' => [
                'Bitcoin' => ['icon' => 'bi-currency-bitcoin', 'color' => 'btc-icon'],
                'Ethereum' => ['icon' => 'bi-currency-ethereum', 'color' => 'eth-icon'],
                'USDT' => ['icon' => '', 'color' => 'usdt-icon', 'text' => 'USDT']
            ]
        ]);
    }



    public function cryptoWithdrawalPage()
    {

        $user = Auth::user();

        // Generate a unique account number if not exists
        $accountNumber = session('crypto_account_number', $user->id . rand(1000, 9999));
        session(['crypto_account_number' => $accountNumber]);

        return view('user.crypto_withdrawal', [
            'accountNumber' => $accountNumber,
            'balance' => $user->balance,
            'email' => $user->email,
            'cryptoOptions' => [
                'Bitcoin' => ['icon' => 'bi-currency-bitcoin', 'color' => 'btc-icon'],
                'Ethereum' => ['icon' => 'bi-currency-ethereum', 'color' => 'eth-icon'],
                'Litecoin' => ['icon' => 'bi-currency-bitcoin', 'color' => 'ltc-icon'],
                'USDT' => ['icon' => '', 'color' => 'usdt-icon', 'text' => 'USDT']
            ]
        ]);
    }

    public function cryptoDeposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'item' => 'required|in:Bitcoin,Ethereum,USDT'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        // Calculate transaction details
        $feePercentage = 1.5; // Example fee percentage
        $amount = $request->amount;
        $fee = $amount * ($feePercentage / 100);
        $netAmount = $amount - $fee;

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => Transaction::TYPE_CRYPTO_DEPOSIT,
            'amount' => $amount,
            'fee' => $fee,
            'net_amount' => $netAmount,
            'status' => Transaction::STATUS_PENDING,
            'crypto_type' => $request->item,
            'description' => 'Crypto deposit via ' . $request->item,
            'reference_id' => Transaction::generateReferenceId(),
        ]);

        // For demo purposes, we'll just show a success message
        // In a real application, you would integrate with a crypto payment gateway here

        return redirect()->route('user.crypto.deposit')
            ->with('success', 'Deposit request received. You will receive payment instructions shortly.');
    }




    public function processCryptoWithdrawal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'wallet_type' => 'required|in:Bitcoin,Ethereum,Litecoin,USDT',
            'wallet_address' => 'required|string|min:10',
            'transaction_pin' => 'required|digits:4'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        // Check if user has sufficient balance
        if ($user->balance < $request->amount) {
            return redirect()->back()
                ->withErrors(['amount' => 'Insufficient balance for this withdrawal'])
                ->withInput();
        }

        // Verify transaction PIN (direct check)
        if ($request->transaction_pin !== $user->pin) {
            return back()
                ->withErrors(['transaction_pin' => 'Invalid transaction PIN'])
                ->withInput();
        }


        // Calculate transaction details
        $feePercentage = 1.5; // Example fee percentage
        $amount = $request->amount;
        $fee = $amount * ($feePercentage / 100);
        $netAmount = $amount - $fee;

        // Create transaction record
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => Transaction::TYPE_CRYPTO_WITHDRAWAL,
            'amount' => $amount,
            'fee' => $fee,
            'net_amount' => $netAmount,
            'status' => Transaction::STATUS_PENDING,
            'wallet_type' => $request->wallet_type,
            'wallet_address' => $request->wallet_address,
            'description' => 'Crypto withdrawal via ' . $request->wallet_type,
            'reference_id' => Transaction::generateReferenceId(),
            'transaction_pin' => $request->transaction_pin // This will be hashed by the model
        ]);

        // Deduct from user balance
        $user->balance -= $amount;
        $user->save();

        return redirect()->route('user.crypto.withdrawal.page')
            ->with('success', 'Withdrawal request received. Your transaction is being processed.');
    }
}
