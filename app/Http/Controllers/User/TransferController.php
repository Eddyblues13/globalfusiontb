<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $settings = Setting::first();

        // List of supported banks (could be moved to database)
        $banks = [
            'Bank of America',
            'Wells Fargo',
            'Chase',
            'Citibank',
            'US Bank',
            'PNC Bank',
            'TD Bank',
            'Capital One',
            'HSBC',
            'Santander'
        ];

        return view('user.transfer', [
            'user' => $user,
            'settings' => $settings,
            'banks' => $banks
        ]);
    }

    public function transfer(Request $request)
    {
        $user = Auth::user();
        $settings = Setting::first();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'routing_number' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01|max:' . $user->account_bal,
            'transaction_pin' => 'required|digits:4',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Verify transaction PIN
        // Verify transaction PIN
        if ($validated['transaction_pin'] !== $user->pin) {
            return redirect()->back()
                ->with('error', 'Invalid transaction PIN')
                ->withInput();
        }


        // Check if user has sufficient balance
        if ($user->account_bal < $validated['amount']) {
            return redirect()->back()
                ->with('error', 'Insufficient balance for this transfer')
                ->withInput();
        }

        // If OTP/2FA is enabled, show OTP modal
        if ($settings->enable_2fa && $settings->otp) {
            // Store transfer data in session for confirmation
            $request->session()->put('pending_transfer', $validated);

            return redirect()->route('bank.transfer.confirm')
                ->with('show_otp', true);
        }

        // Process the transfer immediately if no 2FA
        return $this->processTransfer($user, $validated);
    }

    public function confirmTransfer(Request $request)
    {
        // Show confirmation page with OTP if needed
        $pendingTransfer = $request->session()->get('pending_transfer');

        if (!$pendingTransfer) {
            return redirect()->route('bank.transfer')
                ->with('error', 'No pending transfer found');
        }

        $user = Auth::user();
        $settings = Setting::first();

        return view('user.transfer-confirm', [
            'user' => $user,
            'settings' => $settings,
            'transfer' => $pendingTransfer
        ]);
    }

    public function verifyTransfer(Request $request)
    {
        // Verify OTP and process transfer
        $validated = $request->validate([
            'otp' => 'required|string',
        ]);

        $pendingTransfer = $request->session()->get('pending_transfer');

        if (!$pendingTransfer) {
            return redirect()->route('bank.transfer')
                ->with('error', 'No pending transfer found');
        }

        // Here you would verify the OTP
        // For demo purposes, we'll assume OTP is correct if it's not empty
        if (empty($validated['otp'])) {
            return redirect()->back()
                ->with('error', 'Invalid OTP code')
                ->withInput();
        }

        $user = Auth::user();

        return $this->processTransfer($user, $pendingTransfer);
    }

    private function processTransfer($user, $transferData)
    {
        // Start transaction
        try {
            // Calculate fee (example: 1% fee)
            $feePercentage = 1; // Could be configured in settings
            $amountDetails = Transaction::calculateNetAmount($transferData['amount'], $feePercentage);

            // Deduct amount from user balance (including fee)
            // $user->account_bal -= $amountDetails['amount'];
            // $user->save();

            // Create transaction record using the new structure
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'type' => Transaction::TYPE_BANK_TRANSFER,
                'amount' => $amountDetails['amount'],
                'fee' => $amountDetails['fee'],
                'net_amount' => $amountDetails['net_amount'],
                'status' => Transaction::STATUS_PENDING,
                'account_name' => $transferData['account_name'],
                'account_number' => $transferData['account_number'],
                'bank_name' => $transferData['bank_name'],
                'routing_number' => $transferData['routing_number'],
                'description' => $transferData['description'] ?? 'Bank transfer to ' . $transferData['account_name'],
                'reference_id' => Transaction::generateReferenceId(),
                'transaction_pin' => Hash::make($transferData['transaction_pin']),
            ]);

            // Clear pending transfer session
            session()->forget('pending_transfer');

            // Here you would typically integrate with a payment gateway or bank API
            // For now, we'll mark it as completed immediately
            $transaction->markAsCompleted();

            return redirect()->route('bank.transfer')
                ->with('success', 'Transfer of ' . number_format($transferData['amount'], 2) . ' to ' . $transferData['account_name'] . ' was successful!');
        } catch (\Exception $e) {
            return redirect()->route('bank.transfer')
                ->with('error', 'Transfer failed: ' . $e->getMessage())
                ->withInput();
        }
    }
}
