<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Agent;
use App\Models\Setting;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use App\Models\CryptoAccount;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $settings = Setting::where('id', '1')->first();
        $request = request();

        // Base validation rules
        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'currency' => ['required', 'string', 'max:10'],
            'accounttype' => ['required', 'string', 'max:50'],
            'pin' => ['required', 'string', 'min:4', 'max:4', 'regex:/[0-9]{4}/'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ];

        // Add captcha validation if enabled
        if ($settings->captcha == "true") {
            $validationRules['g-recaptcha-response'] = 'required|captcha';
        }

        Validator::make($input, $validationRules)->validate();

        // Handle referral
        if (session('ref_by')) {
            $ref_by = session('ref_by');
            $referrer = User::where('username', $ref_by)->first();
            $ref_by_id = $referrer->id ?? null;
        } else {
            if (!empty($input['ref_by'])) {
                $sponsor = User::where('username', $input['ref_by'])->first();
                $ref_by_id = $sponsor->id ?? null;
            } else {
                $ref_by_id = null;
            }
        }

        // Create user
        $user = User::create([
            'name' => $input['name'],
            'lastname' => $input['lastname'],
            'middlename' => $input['middlename'] ?? null,
            'email' => $input['email'],
            'phone' => $input['phone'],
            'username' => $input['username'],
            'country' => $input['country'],
            'currency' => $input['currency'],
            'accounttype' => $input['accounttype'],
            'pin' => $input['pin'],
            'ref_by' => $ref_by_id,
            'status' => 'active',
            'usernumber' => $this->RandomStringGenerator(11),
            'code1' => $this->RandomStringGenerator(7),
            'code2' => $this->RandomStringGenerator(7),
            'code3' => $this->RandomStringGenerator(7),
            'password' => Hash::make($input['password']),
        ]);


        // Clear referral session
        $request->session()->forget('ref_by');

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeEmail($user));

        return $user;
    }

    /**
     * Generate a random numeric string
     *
     * @param int $n
     * @return string
     */
    function RandomStringGenerator($n)
    {
        $generated_string = "";
        $domain = "12345678900123456789023456789034567890456789056789067890890";
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string = $generated_string . $domain[$index];
        }
        return $generated_string;
    }
}
