<?php

namespace App\Http\Controllers\User;

use Session;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Deposit;
use Twilio\Rest\Client;
use App\Models\Settings;
use App\Models\Wdmethod;
use App\Mail\DepositStatus;
use Illuminate\Http\Request;
use App\Models\ChequeDeposit;
use App\Models\Tp_Transaction;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DepositController extends Controller


{
    public function getmethod($id)
    {
        $methodname =  Wdmethod::where('id', $id)->first();
        return response()->json($methodname->name);
    }

    //Return payment page
    public function newdeposit(Request $request)
    {
        $settings = Settings::where('id', '1')->first();
        $methodname =  Wdmethod::where('name', $request->payment_method)->first();

        if ($methodname->name == "Credit Card" and $settings->credit_card_provider == "Stripe") {
            $secretkey = $settings->s_s_k;
            $zero = '00';
            $amt = $request->amount . $zero;

            \Stripe\Stripe::setApiKey($secretkey);
            $paymentIntent  = \Stripe\PaymentIntent::create([
                'amount' => $amt,
                'currency' => strtolower($settings->s_currency),
                'payment_method_types' => ['card'],
                'description' => 'Funding My Investment Account',
                'shipping' => [
                    'name' => Auth::user()->name,
                    'address' => [
                        'line1' => 'No Address',
                        'postal_code' => '000000',
                        'city' => 'No City',
                        'state' => 'CA',
                        'country' => 'US',
                    ],
                ],
                'metadata' => ['integration_check' => 'accept_a_payment'],
            ]);

            //return $client_secret;
            $client_secret = $paymentIntent->client_secret;
        }


        //store payment info in session
        $request->session()->put('amount', $request['amount']);
        $request->session()->put('payment_mode', $methodname->name);
        $request->session()->put('intent', $client_secret);

        return redirect()->route('payment');
    }

    //payment route
    public function payment(Request $request)
    {
        $methodname =  Wdmethod::firstWhere('name', $request->session()->get('payment_mode'));
        return view('user.payment')
            ->with(array(
                'amount' => $request->session()->get('amount'),
                'payment_mode' => $methodname,
                'intent' => $request->session()->get('intent'),
                'title' => 'Make Payment',
            ));
    }

    public function savestripepayment(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        //get settings 
        $settings = Settings::where('id', '=', '1')->first();
        $earnings = $settings->referral_commission * $request->amount / 100;


        //save and confirm the deposit
        $dp = new Deposit();
        $dp->amount = $request->amount;
        $dp->payment_mode = "Stripe";
        $dp->status = 'Processed';
        $dp->proof = "Credit Card";
        $dp->plan = 0;
        $dp->user = $user->id;
        $dp->save();

        if ($settings->deposit_bonus != NULL and $settings->deposit_bonus > 0) {
            $bonus = $request->amount * $settings->deposit_bonus / 100;
            //create history
            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => "Deposit Bonus for $settings->currency $request->amount deposited",
                'amount' => $bonus,
                'type' => "Bonus",
            ]);
        } else {
            $bonus = 0;
        }

        //add funds to user's account
        User::where('id', $user->id)
            ->update([
                'account_bal' => $user->account_bal + $request->amount + $bonus,
                'bonus' => $user->bonus + $bonus,
                'cstatus' => 'Customer',
            ]);

        if (!empty($user->ref_by)) {

            $agent = User::where('id', $user->ref_by)->first();
            User::where('id', $user->ref_by)
                ->update([
                    'account_bal' => $agent->account_bal + $earnings,
                    'ref_bonus' => $agent->ref_bonus + $earnings,
                ]);

            //credit commission to ancestors
            $users = User::all();
            $this->getAncestors($users, $request->amount, $user->id);

            Tp_Transaction::create([
                'user' => $user->ref_by,
                'plan' => "Credit",
                'amount' => $earnings,
                'type' => "Ref_bonus",
            ]);
        }

        //Send confirmation email to user regarding his deposit and it's successful.
        Mail::to($user->email)->send(new DepositStatus($dp, $user, 'Successful Deposit', false));

        // delete the session variables
        $request->session()->forget('payment_mode');
        $request->session()->forget('amount');
        $request->session()->forget('intent');

        return response()->json(['success' => 'Payment Completed, redirecting']);
    }

    //Save deposit requests
    public function savedeposit(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        if ($user->account_status != 'active') {
            return redirect()->back()
                ->with("message", "Sorry, your account is dormant. Contact support on $settings->contact_email for more details.");
        }

        $this->validate($request, [
            'proof' => 'image|mimes:jpg,jpeg,png|max:1000',
        ]);

        $settings = Settings::where('id', '=', '1')->first();

        if ($request->hasfile('proof')) {
            $file = $request->file('proof');
            $extension = $file->extension();
            $whitelist = array('pdf', 'doc', 'jpeg', 'jpg', 'png');

            if (in_array($extension, $whitelist)) {
                $path = $file->store('uploads', 'public');
            } else {
                return redirect()->back()
                    ->with('message', 'Unaccepted Image Uploaded');
            }
        }

        //generate Reference ID
        $subtxn = substr(strtoupper($settings->site_name), 0, 4);
        $codetxn1 = $this->RandomStringGenerator(8);
        $codetxn2 = substr(strtoupper(Carbon::now()), 0, 4);

        //Save deposit
        $dp = new Deposit();
        $dp->amount = $request['amount'];
        $dp->payment_mode = $request['paymethd_method'];
        $dp->status = 'Pending';
        $dp->proof = $path;
        $dp->txn_id = "$subtxn/$codetxn1-$codetxn2";
        $dp->user = Auth::user()->id;
        $dp->save();

        //get user


        // Create notification for deposit
        NotificationHelper::create(
            $user,
            'Your deposit of ' . $settings->currency . $request['amount'] . ' via ' . $request['paymethd_method'] . ' has been received and is pending approval.',
            'Deposit Submitted',
            'info',
            'upload',
            route('deposits')
        );

        //Send Email to admin regarding this deposit
        // Mail::to($settings->contact_email)->send(new DepositStatus($dp, $user, 'Successful Deposit', true));

        //Send confirmation email to user regarding his deposit and it's successful.to get a response back from admin
        // Mail::to($user->email)->send(new DepositStatus($dp, $user, 'Successful Deposit', false));

        //twillo sms

        $date  = Carbon::parse($dp->created_at)->toDayDateTimeString();
        if ($settings->sms == '1') {
            $receiverNumber = $user->phone;
            $message = "Your Crypto Asset Deposit has been recorded successfully and currently undergoing confirmation. You will receive an automatic notification once your transaction was confirmed on the blockchain Network. This usually take upto 15 minutes.
        \n Amount : $settings->currency$dp->amount
        \n Payment method :  $dp->payment_mode
        \n Date: $date";

            try {

                $account_sid = getenv("TWILIO_SID");
                $auth_token = getenv("TWILIO_TOKEN");
                $twilio_number = getenv("TWILIO_FROM");

                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number,
                    'body' => $message
                ]);
            } catch (Exception $e) {
            }
        }



        // Kill the session variables
        $request->session()->forget('payment_mode');
        $request->session()->forget('amount');

        return redirect()->route('deposits')
            ->with('success', 'Account Fund Sucessful! Please wait for system to validate this transaction.');
    }

    /**
     * Show the cheque deposit form
     */
    public function showChequeDeposit()
    {
        $settings = Settings::where('id', '=', '1')->first();

        return view('user.cheque-deposit', [
            'settings' => $settings,
            'title' => 'Cheque Deposit'
        ]);
    }
    public function savechequedeposit(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();

        if ($user->account_status != 'active') {
            return redirect()->back()
                ->with("message", "Sorry, your account is dormant. Contact support on $settings->contact_email for more details.");
        }

        $this->validate($request, [
            'cheque_number' => 'required|string|max:255',
            'amount' => 'required|numeric|min:' . $settings->min_cheque,
            'bank_name' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
            'front_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'back_image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $settings = Settings::where('id', '=', '1')->first();

        // Process front image
        if ($request->hasfile('front_image')) {
            $frontFile = $request->file('front_image');
            $frontExtension = $frontFile->extension();
            $whitelist = array('jpeg', 'jpg', 'png');

            if (in_array($frontExtension, $whitelist)) {
                $frontPath = $frontFile->store('cheques', 'public');
            } else {
                return redirect()->back()
                    ->with('message', 'Unaccepted Image Format for Front Image');
            }
        }

        // Process back image
        if ($request->hasfile('back_image')) {
            $backFile = $request->file('back_image');
            $backExtension = $backFile->extension();
            $whitelist = array('jpeg', 'jpg', 'png');

            if (in_array($backExtension, $whitelist)) {
                $backPath = $backFile->store('cheques', 'public');
            } else {
                return redirect()->back()
                    ->with('message', 'Unaccepted Image Format for Back Image');
            }
        }

        // Generate Reference ID
        $subtxn = substr(strtoupper($settings->site_name), 0, 4);
        $codetxn1 = $this->RandomStringGenerator(8);
        $codetxn2 = substr(strtoupper(Carbon::now()), 0, 4);

        // Save cheque deposit
        $dp = new ChequeDeposit();
        $dp->amount = $request['amount'];
        $dp->cheque_number = $request['cheque_number'];
        $dp->bank_name = $request['bank_name'];
        $dp->account_holder = $request['account_holder'];
        $dp->status = 'Pending';
        $dp->front_image = $frontPath;
        $dp->back_image = $backPath;
        $dp->txn_id = "$subtxn/CHQ-$codetxn1-$codetxn2";
        $dp->user_id = Auth::user()->id;
        $dp->save();

        // Create notification for cheque deposit
        NotificationHelper::create(
            $user,
            'Your cheque deposit of ' . $settings->currency . $request['amount'] . ' has been received and is pending processing. Cheque deposits typically take 3-5 business days to clear.',
            'Cheque Deposit Submitted',
            'info',
            'file-text',
            route('deposits')
        );

        // Send Email to admin regarding this cheque deposit
        // Mail::to($settings->contact_email)->send(new ChequeDepositNotification($dp, $user, 'New Cheque Deposit'));

        // Send confirmation email to user
        // Mail::to($user->email)->send(new ChequeDepositConfirmation($dp, $user));

        // Twilio SMS notification
        $date = Carbon::parse($dp->created_at)->toDayDateTimeString();
        if ($settings->sms == '1') {
            $receiverNumber = $user->phone;
            $message = "Your cheque deposit has been received successfully and is pending processing. Cheque deposits typically take 3-5 business days to clear.
        \n Amount : $settings->currency$dp->amount
        \n Cheque # : $dp->cheque_number
        \n Bank : $dp->bank_name
        \n Date: $date";

            try {
                $account_sid = getenv("TWILIO_SID");
                $auth_token = getenv("TWILIO_TOKEN");
                $twilio_number = getenv("TWILIO_FROM");

                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number,
                    'body' => $message
                ]);
            } catch (Exception $e) {
                // Log error but don't break the flow
                Log::error('SMS sending failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('deposits')
            ->with('success', 'Cheque deposit submitted successfully! It will be processed in 3-5 business days.');
    }

    //Get uplines
    function getAncestors($array, $deposit_amount, $parent = 0, $level = 0)
    {
        $referedMembers = '';
        $parent = User::where('id', $parent)->first();

        foreach ($array as $entry) {
            if ($entry->id == $parent->ref_by) {
                //get settings 
                $settings = Settings::where('id', '=', '1')->first();

                if ($level == 1) {
                    $earnings = $settings->referral_commission1 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 2) {
                    $earnings = $settings->referral_commission2 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 3) {
                    $earnings = $settings->referral_commission3 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 4) {
                    $earnings = $settings->referral_commission4 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 5) {
                    $earnings = $settings->referral_commission5 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                }

                if ($level == 6) {
                    break;
                }

                //$referedMembers .= '- ' . $entry->name . '- Level: '. $level. '- Commission: '.$earnings.'<br/>';
                $referedMembers .= $this->getAncestors($array, $deposit_amount, $entry->id, $level + 1);
            }
        }
        return $referedMembers;
    }
    function RandomStringGenerator($n)
    {
        $generated_string = "";
        $domain = "ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string = $generated_string . $domain[$index];
        }
        // Return the random generated string 
        return $generated_string;
    }
}
