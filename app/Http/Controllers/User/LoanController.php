<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $settings = Setting::first();

        // Calculate eligible amount based on user's balance and activity
        $eligibleAmount = $this->calculateEligibleAmount($user);

        // Get outstanding and pending loans using Transaction model
        $outstandingLoans = Transaction::where('user_id', $user->id)
            ->where('type', Transaction::TYPE_LOAN_REQUEST)
            ->where('status', Transaction::STATUS_COMPLETED)
            ->sum('amount');

        $pendingLoans = Transaction::where('user_id', $user->id)
            ->where('type', Transaction::TYPE_LOAN_REQUEST)
            ->where('status', Transaction::STATUS_PENDING)
            ->sum('amount');

        // Get recent loan transactions
        $loans = Transaction::where('user_id', $user->id)
            ->where('type', Transaction::TYPE_LOAN_REQUEST)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.loan', compact(
            'eligibleAmount',
            'outstandingLoans',
            'pendingLoans',
            'loans',
            'settings'
        ));
    }

    public function requestLoan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100',
            'loan_type' => 'required|string|max:255',
            'repayment_period' => 'required|integer|in:30,90,180,365',
            'reason' => 'required|string|min:10|max:1000',
            'transaction_pin' => 'required|digits:4',
            'terms' => 'required|accepted'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // Verify transaction PIN

        // Verify transaction PIN
        if ($request->transaction_pin !== $user->pin) {
            return redirect()->back()
                ->with('error', 'Invalid transaction PIN')
                ->withInput();
        }
        // Check if user has pending loans
        $pendingLoan = Transaction::where('user_id', $user->id)
            ->where('type', Transaction::TYPE_LOAN_REQUEST)
            ->where('status', Transaction::STATUS_PENDING)
            ->exists();

        if ($pendingLoan) {
            return back()->with('error', 'You already have a pending loan application')->withInput();
        }

        // Check eligible amount
        $eligibleAmount = $this->calculateEligibleAmount($user);
        if ($request->amount > $eligibleAmount) {
            return back()->with('error', 'Requested amount exceeds your eligible loan limit')->withInput();
        }

        try {
            // Create loan transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'type' => Transaction::TYPE_LOAN_REQUEST,
                'amount' => $request->amount,
                'fee' => 0, // No upfront fee for loan request
                'net_amount' => $request->amount,
                'status' => Transaction::STATUS_PENDING,
                'loan_type' => $request->loan_type,
                'repayment_period' => $request->repayment_period,
                'loan_reason' => $request->reason,
                'description' => $request->loan_type . ' loan request',
                'reference_id' => Transaction::generateReferenceId(),
                'transaction_pin' => Hash::make($request->transaction_pin),
            ]);

            // Here you would typically:
            // 1. Send notification to admin for approval
            // 2. Send confirmation email to user
            // 3. Log the loan application

            return redirect()->route('loan')->with('success', 'Loan application submitted successfully and is pending approval');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to submit loan application: ' . $e->getMessage())->withInput();
        }
    }

    private function calculateEligibleAmount(User $user)
    {
        // Enhanced eligibility calculation
        $baseAmount = 5000; // Base eligible amount
        $balanceFactor = $user->account_bal * 3; // Up to 3x current balance
        $incomeFactor = 2000; // Assume monthly income factor

        // Consider user's transaction history
        $transactionCount = Transaction::where('user_id', $user->id)
            ->where('status', Transaction::STATUS_COMPLETED)
            ->count();

        $activityFactor = min($transactionCount * 100, 2000); // Reward activity

        return min($baseAmount + $activityFactor, $balanceFactor + $incomeFactor);
    }

    private function getInterestRate($period)
    {
        // Different interest rates based on repayment period
        $rates = [
            30 => 5.0,   // 5% for 1 month
            90 => 7.5,   // 7.5% for 3 months
            180 => 10.0, // 10% for 6 months
            365 => 12.5  // 12.5% for 12 months
        ];

        return $rates[$period] ?? 10.0;
    }
}
