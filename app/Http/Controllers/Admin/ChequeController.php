<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ChequeDeposit;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChequeStatusNotification;

class ChequeController extends Controller
{
    /**
     * Display all cheque deposits
     */
    public function chequeDeposits()
    {
        $cheques = ChequeDeposit::with('user')->latest()->paginate(10);

        return view('admin.admin-cheque-deposits', [
            'cheques' => $cheques,
            'title' => 'Cheque Deposits'
        ]);
    }

    /**
     * View a specific cheque deposit
     */
    public function viewCheque($id)
    {
        $cheque = ChequeDeposit::with('user')->findOrFail($id);

        return view('admin.admin-cheque-view', [
            'cheque' => $cheque,
            'title' => 'Cheque Details'
        ]);
    }

    /**
     * Process a cheque deposit
     */
    public function processCheque(Request $request)
    {
        $request->validate([
            'action' => 'required|in:Processed,Rejected',
            'message' => 'required|string',
            'subject' => 'required|string',
            'cheque_id' => 'required|exists:cheque_deposits,id'
        ]);

        $cheque = ChequeDeposit::with('user')->findOrFail($request->cheque_id);

        // Update cheque status - we need to add admin_notes and processed_at to fillable
        $cheque->status = $request->action;
        $cheque->save();

        // // If processed, credit user's account
        // if ($request->action == 'Processed') {
        //     $user = User::find($cheque->user_id);
        //     $user->account_bal += $cheque->amount;
        //     $user->save();

        //     // Create transaction record
        //     $transaction = new Transaction();
        //     $transaction->user_id = $user->id;
        //     $transaction->type = 'Cheque Deposit';
        //     $transaction->amount = $cheque->amount;
        //     $transaction->status = 'Processed';
        //     $transaction->sum = 'in';
        //     $transaction->txn_id = $cheque->txn_id;
        //     $transaction->save();
        // }

        // Send notification to user
        NotificationHelper::create(
            $cheque->user,
            $request->message,
            'Cheque Deposit ' . $request->action,
            $request->action == 'Processed' ? 'success' : 'danger',
            'file-text',
            route('deposits')
        );



        return redirect()->back()
            ->with('success', 'Cheque deposit has been ' . strtolower($request->action) . ' successfully.');
    }
}
