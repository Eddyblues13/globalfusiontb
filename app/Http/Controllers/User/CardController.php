<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\CardSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\CardTransaction;
use App\Helpers\NotificationHelper;
use App\Models\CardDeliveryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CardController extends Controller
{
    /**
     * Display the virtual cards dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $cards = $user->cards()->latest()->get();

        $activeCards = $cards->where('status', 'active')->count();
        $pendingCards = $cards->where('status', 'pending')->count();
        $totalBalance = $cards->where('status', 'active')->sum('balance');

        return view('user.cards.index', [
            'title' => 'Virtual Cards',
            'cards' => $cards,
            'activeCards' => $activeCards,
            'pendingCards' => $pendingCards,
            'totalBalance' => $totalBalance,
        ]);
    }

    /**
     * Show the application form for a new card.
     *
     * @return \Illuminate\Http\Response
     */
    public function showApplicationForm()
    {
        $cardSettings = CardSettings::first();

        // If virtual cards are disabled, redirect back with message
        if (!$cardSettings->is_enabled) {
            return redirect()->route('cards')->with('message', 'Virtual cards are currently unavailable. Please try again later.')
                ->with('type', 'danger');
        }

        $issuanceFees = [
            'standard' => $cardSettings->standard_fee,
            'gold' => $cardSettings->gold_fee,
            'platinum' => $cardSettings->platinum_fee,
            'black' => $cardSettings->black_fee,
        ];

        return view('user.cards.apply', [
            'title' => 'Apply for Virtual Card',
            'issuanceFees' => $issuanceFees,
            'minLimit' => $cardSettings->min_daily_limit,
            'maxLimit' => $cardSettings->max_daily_limit,
        ]);
    }

    /**
     * Process a new card application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function applyCard(Request $request)
    {
        $cardSettings = CardSettings::first();

        // If virtual cards are disabled, redirect back with message
        if (!$cardSettings->is_enabled) {
            return redirect()->route('cards')->with('message', 'Virtual cards are currently unavailable. Please try again later.')
                ->with('type', 'danger');
        }

        $request->validate([
            'card_type' => 'required|string|in:visa,mastercard,american_express,discover',
            'card_level' => 'required|string|in:standard,gold,platinum,black',
            'daily_limit' => 'nullable|numeric|min:' . $cardSettings->min_daily_limit . '|max:' . $cardSettings->max_daily_limit,
            'currency' => 'required|string|max:10',
            'billing_address' => 'required|string|max:255',
            'terms_accepted' => 'required|accepted',
        ]);

        $user = Auth::user();

        if ($user->account_status != 'active') {
            return redirect()->back()
                ->with("message", "Sorry, your account is dormant. Contact support on $settings->contact_email for more details.");
        }

        // Get appropriate issuance fee based on card level
        $feeKey = $request->card_level . '_fee';
        $issuanceFee = $cardSettings->$feeKey;

        // Check if user has sufficient balance
        if ($user->account_bal < $issuanceFee) {
            return back()->with('message', 'Insufficient account balance to cover card issuance fee of $' . number_format($issuanceFee, 2) . '.')
                ->with('type', 'danger');
        }

        // Create the card with pending status
        $card = new Card();
        $card->user_id = $user->id;
        $card->card_holder_name = $request->input('card_holder_name', $user->name . ' ' . ($user->lastname ?? ''));
        $card->card_type = $request->card_type;
        $card->daily_limit = $request->daily_limit;
        $card->card_level = $request->card_level;
        $card->currency = $request->currency;
        $card->status = 'pending';
        $card->billing_address = $request->billing_address;
        $card->application_date = now();
        $card->reference_id = 'CARD' . strtoupper(Str::random(10));
        $card->is_virtual = true;
        $card->save();

        // Charge the issuance fee
        $user->account_bal -= $issuanceFee;
        $user->save();

        // Create fee transaction
        CardTransaction::create([
            'card_id' => $card->id,
            'user_id' => $user->id,
            'amount' => $issuanceFee,
            'currency' => $request->currency,
            'transaction_type' => 'fee',
            'transaction_reference' => 'FEE' . strtoupper(Str::random(8)),
            'merchant_name' => config('app.name'),
            'status' => 'completed',
            'description' => 'Card issuance fee for ' . ucfirst($request->card_level) . ' card',
            'transaction_date' => now(),
        ]);

        // Create notification
        NotificationHelper::create(
            $user,
            'Your card application has been submitted and is awaiting approval. You will be notified when the status changes.',
            'Card Application Submitted',
            'info',
            'credit-card',
            route('cards.view', $card->id)
        );

        return redirect()->route('cards')->with('message', 'Your virtual card application has been submitted successfully. It is now pending approval.')
            ->with('type', 'success');
    }

    /**
     * Display a specific card's details.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function viewCard(Card $card)
    {
        if (Auth::id() !== $card->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Get recent transactions for this card
        $transactions = $card->transactions()
            ->latest('transaction_date')
            ->take(10)
            ->get();

        // Get delivery requests for this card
        $deliveryRequests =  CardDeliveryRequest::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.cards.view', [
            'title'            => 'Card Details',
            'card'             => $card,
            'transactions'     => $transactions,
            'deliveryRequests' => $deliveryRequests,
        ]);
    }


    /**
     * Activate a card.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function activateCard(Card $card)
    {
        if (Auth::id() !== $card->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($card->status !== 'inactive') {
            return back()->with('message', 'This card cannot be activated.')
                ->with('type', 'danger');
        }

        $card->status = 'active';
        $card->save();

        // Create notification
        NotificationHelper::create(
            Auth::user(),
            'Your ' . ucfirst($card->card_level) . ' ' . ucfirst(str_replace('_', ' ', $card->card_type)) . ' card ending in ' . $card->last_four . ' has been activated successfully.',
            'Card Activated',
            'success',
            'check-circle',
            route('cards.view', $card->id)
        );

        return back()->with('message', 'Card has been activated successfully.')
            ->with('type', 'success');
    }

    /**
     * Deactivate a card.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function deactivateCard(Card $card)
    {
        if (Auth::id() !== $card->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($card->status !== 'active') {
            return back()->with('message', 'This card cannot be deactivated.')
                ->with('type', 'danger');
        }

        $card->status = 'inactive';
        $card->save();

        // Create notification
        NotificationHelper::create(
            Auth::user(),
            'Your ' . ucfirst($card->card_level) . ' ' . ucfirst(str_replace('_', ' ', $card->card_type)) . ' card ending in ' . $card->last_four . ' has been deactivated.',
            'Card Deactivated',
            'warning',
            'pause',
            route('cards.view', $card->id)
        );

        return back()->with('message', 'Card has been deactivated successfully.')
            ->with('type', 'success');
    }

    /**
     * Block a card.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function blockCard(Card $card)
    {
        if (Auth::id() !== $card->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($card->status, ['active', 'inactive'])) {
            return back()->with('message', 'This card cannot be blocked.')
                ->with('type', 'danger');
        }

        $card->status = 'blocked';
        $card->save();

        // Create notification
        NotificationHelper::create(
            Auth::user(),
            'Your ' . ucfirst($card->card_level) . ' ' . ucfirst(str_replace('_', ' ', $card->card_type)) . ' card ending in ' . $card->last_four . ' has been blocked for security reasons. Please contact support if you didn\'t request this action.',
            'Card Blocked',
            'danger',
            'lock',
            route('cards.view', $card->id)
        );

        return back()->with('message', 'Card has been blocked. Please contact support for assistance.')
            ->with('type', 'success');
    }

    /**
     * Display card transactions.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function cardTransactions(Card $card)
    {
        if (Auth::id() !== $card->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $transactions = $card->transactions()
            ->latest('transaction_date')
            ->paginate(15);

        return view('user.cards.transactions', [
            'title' => 'Card Transactions',
            'card' => $card,
            'transactions' => $transactions,
        ]);
    }


    public function requestDelivery(Request $request)
    {
        $request->validate([
            'card_id' => 'required|exists:cards,id',
            'full_name' => 'required|string|max:255',
            'address' => 'required|string',
            'nearest_airport' => 'nullable|string|max:500',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Check if user owns the card
        $card = Card::where('id', $request->card_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if there's already a pending request for this card
        $existingRequest = CardDeliveryRequest::where('card_id', $request->card_id)
            ->whereIn('status', ['pending', 'processing', 'shipped'])
            ->exists();

        if ($existingRequest) {
            return redirect()->back()->with('message', 'You already have a pending delivery request for this card.');
        }

        // Create delivery request
        CardDeliveryRequest::create([
            'user_id' => Auth::id(),
            'card_id' => $request->card_id,
            'full_name' => $request->full_name,
            'address' => $request->address,
            'nearest_airport' => $request->nearest_airport,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('message', 'Card delivery request submitted successfully!');
    }

    /**
     * Show delivery status
     */
    public function deliveryHistory(Card $card, Request $request)
    {
        $query = $card->deliveryRequests(); // assuming you defined relation in Card model

        // Optional filters
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->date_start) {
            $query->whereDate('created_at', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->whereDate('created_at', '<=', $request->date_end);
        }

        // Paginate results
        $requests = $query->latest()->paginate(10);

        // Counters for summary cards
        $pendingCount   = $card->deliveryRequests()->where('status', 'pending')->count();
        $deliveredCount = $card->deliveryRequests()->where('status', 'delivered')->count();

        return view('user.cards.card_delivery_requests', [
            'card'           => $card,
            'requests'       => $requests,
            'pendingCount'   => $pendingCount,
            'deliveredCount' => $deliveredCount,
        ]);
    }
}
