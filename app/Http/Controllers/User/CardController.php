<?php

namespace App\Http\Controllers\User;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Models\CardDeliveryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cards = Card::where('user_id', $user->id)->get();
        $deliveryRequests = CardDeliveryRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.card', compact('cards', 'deliveryRequests', 'user'));
    }

    public function create()
    {
        return view('card.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:mastercard,visa',
        ]);

        $user = Auth::user();

        // Check if user already has a card of this type
        $existingCard = Card::where('user_id', $user->id)
            ->where('type', $request->type)
            ->first();

        if ($existingCard) {
            return redirect()->route('card')->with('error', 'You already have a ' . $request->type . ' card.');
        }

        // Generate card details
        $cardNumber = $this->generateCardNumber($request->type);
        $cvv = rand(100, 999);
        $expiryDate = now()->addYears(3)->format('m/y');

        Card::create([
            'user_id' => $user->id,
            'card_number' => $cardNumber,
            'cvv' => $cvv,
            'expiry_date' => $expiryDate,
            'card_holder_name' => $user->first_name . ' ' . $user->last_name,
            'type' => $request->type,
            'status' => 'active'
        ]);

        return redirect()->route('card')->with('success', 'Card created successfully.');
    }

    private function generateCardNumber($type)
    {
        // Generate valid card numbers based on type
        $prefix = $type === 'visa' ? '4' : '5';

        // Generate 15 random digits (16 total with prefix)
        $number = $prefix;
        for ($i = 0; $i < 15; $i++) {
            $number .= rand(0, 9);
        }

        // Validate uniqueness
        if (Card::where('card_number', $number)->exists()) {
            return $this->generateCardNumber($type);
        }

        return $number;
    }

    public function toggleStatus(Card $card)
    {
        if ($card->user_id !== Auth::id()) {
            abort(403);
        }

        $card->status = $card->status === 'active' ? 'inactive' : 'active';
        $card->save();

        return redirect()->route('card')->with('success', 'Card status updated successfully.');
    }

    public function destroy(Card $card)
    {
        if ($card->user_id !== Auth::id()) {
            abort(403);
        }

        $card->delete();

        return redirect()->route('card')->with('success', 'Card deleted successfully.');
    }

    public function requestDelivery(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'nearest_airport' => 'required|string|max:255', // ✅ Added validation
        ]);

        CardDeliveryRequest::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'nearest_airport' => $request->nearest_airport, // ✅ Save to DB
        ]);

        return redirect()->route('card')->with('success', 'Delivery request submitted successfully.');
    }
}
