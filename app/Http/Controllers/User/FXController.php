<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\Transaction;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FXController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $settings = Setting::first();

        // Check if FX module is enabled
        if (!$settings->modules || !in_array('fx', json_decode($settings->modules, true))) {
            abort(404, 'FX trading is not available at this time');
        }

        return view('user.cfx', [
            'user' => $user,
            'settings' => $settings
        ]);
    }

    public function trade(Request $request)
    {
        $user = Auth::user();
        $settings = Setting::first();

        // Generate a unique reference
        $ref = Str::random(10);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'asset_symbol' => 'required|string|max:20',
            'asset_name' => 'required|string|max:255',
            'asset_type' => 'required|in:stock,crypto,forex',
            'type' => 'required|in:buy,sell',
            'amount' => 'required|numeric|min:0.01|max:' . $user->balance,
            'quantity' => 'required|numeric|min:0.0001',
            'order_type' => 'required|in:market,limit,stop',
            'limit_price' => 'nullable|required_if:order_type,limit|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Check if user has sufficient balance for buy orders
        if ($validated['type'] === 'buy' && $user->balance < $validated['amount']) {
            return redirect()->back()
                ->with('error', 'Insufficient balance for this trade')
                ->withInput();
        }

        // Process the trade
        try {
            // Create trade record
            $trade = Trade::create([
                'user_id' => $user->id,
                'trade_ref' => "TRD" . $ref,
                'asset_symbol' => $validated['asset_symbol'],
                'asset_name' => $validated['asset_name'],
                'asset_type' => $validated['asset_type'],
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'quantity' => $validated['quantity'],
                'order_type' => $validated['order_type'],
                'limit_price' => $validated['limit_price'] ?? null,
                'status' => 'completed', // In a real app, this might be 'pending' initially
            ]);

            if ($validated['type'] === 'buy') {
                // Deduct amount from user balance for buy orders
                $user->balance -= $validated['amount'];
                $transactionType = 'debit';
                $description = "Buy {$validated['quantity']} {$validated['asset_symbol']}";
            } else {
                // For sell orders, we would typically add to balance
                $user->balance += $validated['amount'];
                $transactionType = 'credit';
                $description = "Sell {$validated['quantity']} {$validated['asset_symbol']}";
            }

            $user->save();

            // // Create transaction record
            // $transaction = new Transaction;
            // $transaction->user_id = $user->id;
            // $transaction->transaction_id = "TRD" . $ref;
            // $transaction->transaction_ref = "TRD" . $ref;
            // $transaction->transaction_type = $transactionType === 'debit' ? 'Debit' : 'Credit';
            // $transaction->transaction = "FX Trade";
            // $transaction->transaction_amount = $validated['amount'];
            // $transaction->wallet_type = $validated['asset_type'];
            // $transaction->wallet_address = ''; // Not applicable for FX trades
            // $transaction->transaction_description = $description;
            // $transaction->balance_after = $user->balance;
            // $transaction->transaction_status = 1; // Completed
            // $transaction->metadata = json_encode([
            //     'trade_id' => $trade->id,
            //     'asset_symbol' => $validated['asset_symbol'],
            //     'asset_name' => $validated['asset_name'],
            //     'quantity' => $validated['quantity'],
            //     'order_type' => $validated['order_type'],
            //     'limit_price' => $validated['limit_price'] ?? null,
            // ]);
            // $transaction->save();

            return redirect()->route('fx.index')
                ->with('success', 'Trade executed successfully!');
        } catch (\Exception $e) {
            return redirect()->route('fx.index')
                ->with('error', 'Trade failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function getMarketData(Request $request)
    {
        // API endpoint to get real market data
        $symbol = $request->input('symbol');
        $type = $request->input('type');

        // In a real implementation, you would fetch data from a market data API
        // This is a simplified mock data response
        $mockData = [
            'price' => rand(100, 1000) + (rand(0, 99) / 100),
            'change' => (rand(-500, 500) / 100),
            'symbol' => $symbol,
            'name' => ucfirst(strtolower($symbol)) . ' Inc.',
            'type' => $type
        ];

        return response()->json($mockData);
    }
}
