<?php

namespace App\Http\Controllers\User;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PayPalController extends Controller
{
    public function paypal()
    {
        $user = Auth::user();
        return view('user.paypal', compact('user'));
    }
    
    public function withdrawToPaypal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'paypal_email' => 'required|email',
            'transaction_pin' => 'required|digits:4'
        ]);
        
        $user = Auth::user();
        
        // Verify transaction PIN
        if ($user->transaction_pin != $request->transaction_pin) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid transaction PIN'
            ]);
        }
        
        // Check sufficient balance
        if ($user->balance < $request->amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance'
            ]);
        }
        
        // Check minimum withdrawal amount
        $minWithdrawal = 10; // $10 minimum
        if ($request->amount < $minWithdrawal) {
            return response()->json([
                'success' => false,
                'message' => "Minimum withdrawal amount is $$minWithdrawal"
            ]);
        }
        
        // Generate OTP
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);
        
        // Create withdrawal record
        $withdrawal = PaypalWithdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'paypal_email' => $request->paypal_email,
            'otp' => $otp,
            'otp_expires_at' => $expiresAt,
            'status' => 'pending'
        ]);
        
        // Send OTP email
        try {
            // Mail::to($user->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            Log::error('OTP email failed: ' . $e->getMessage());
        }
        
        return response()->json([
            'success' => true,
            'transaction_id' => $withdrawal->id,
            'message' => 'OTP sent to your email'
        ]);
    }
    
    public function verifyPaypalOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'transaction_id' => 'required|exists:paypal_withdrawals,id'
        ]);
        
       // $withdrawal = PaypalWithdrawal::find($request->transaction_id);
        $user = Auth::user();
        
        // Verify OTP belongs to user
        if ($withdrawal->user_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid transaction'
            ]);
        }
        
        // Check OTP expiration
        if ($withdrawal->otp_expires_at < now()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired'
            ]);
        }
        
        // Verify OTP
        if ($withdrawal->otp != $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ]);
        }
        
        // Process withdrawal
        try {
            DB::transaction(function () use ($user, $withdrawal) {
                // Deduct from user balance
                $user->balance -= $withdrawal->amount;
                $user->save();
                
                // Update withdrawal status
                $withdrawal->status = 'completed';
                $withdrawal->completed_at = now();
                $withdrawal->save();
                
                // Create transaction record
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'paypal_withdrawal',
                    'amount' => $withdrawal->amount,
                    'description' => 'PayPal withdrawal to ' . $withdrawal->paypal_email,
                    'status' => 'completed'
                ]);
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Withdrawal processed successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('PayPal withdrawal failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Withdrawal failed. Please try again.'
            ]);
        }
    }
}
