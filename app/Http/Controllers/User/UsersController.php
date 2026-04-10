<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Settings;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\NewNotification;
use Illuminate\Support\Facades\Mail;
use Session;

class UsersController extends Controller
{

  public function verifyemail()
  {
    return view('auth.verify-email', [
      'title' => 'Verify Your email address',
    ]);
  }

  public function verifyEmailCode(Request $request)
  {
    $request->validate([
      'digit1' => ['required', 'string', 'size:1'],
      'digit2' => ['required', 'string', 'size:1'],
      'digit3' => ['required', 'string', 'size:1'],
      'digit4' => ['required', 'string', 'size:1'],
    ]);

    $code = $request->digit1 . $request->digit2 . $request->digit3 . $request->digit4;
    $user = $request->user();

    if (!$user->email_verification_code) {
      return back()->withErrors(['verification_code' => 'No verification code found. Please request a new one.']);
    }

    if (now()->greaterThan($user->email_verification_code_expires_at)) {
      return back()->withErrors(['verification_code' => 'Verification code has expired. Please request a new one.']);
    }

    if (!hash_equals($user->email_verification_code, $code)) {
      return back()->withErrors(['verification_code' => 'Invalid verification code. Please try again.']);
    }

    $user->email_verified_at = now();
    $user->email_verification_code = null;
    $user->email_verification_code_expires_at = null;
    $user->save();

    return redirect()->route('dashboard')->with('success', 'Email verified successfully!');
  }

  public function addusername(Request $request)
  {
    Validator::make($request, [
      'username' => ['required', 'unique:users,username'],
    ])->validate();

    User::where('id', Auth::user()->id)->update([
      'username' => $request['username'],
    ]);
    return redirect()->route('dashboard');
  }

  //send contact message to admin email
  public function sendcontact(Request $request)
  {

    $settings = Settings::where('id', '1')->first();

    $message = "$request->message";
    $subject = "Inquiry from $request->name with email $request->email";


    Mail::to($settings->contact_email)->send(new NewNotification($message, $subject, 'Admin'));

    return redirect()->back()
      ->with('success', ' Your message was sent successfully!');
  }


  //Get downlines level
  public function getdownlines($array, $parent = 0, $level = 0)
  {
    $referedMembers = '';
    foreach ($array as $entry) {
      if ($entry->ref_by == $parent) {

        if ($level == 0) {
          $levelQuote = "Direct referral";
        } else {
          $levelQuote = "Indirect referral level $level";
        }

        $referedMembers .= "
                  <tr>
                  <td> $entry->name $entry->l_name </td> 
                  <td> $levelQuote </td>" .
          '<td>' . $this->getUserParent($entry->id) . '</td>' .
          '<td>' . $this->getUserStatus($entry->id) . '</td>
                  <td>' . $this->getUserRegDate($entry->id) . '</td>
                  </tr>';

        $referedMembers .= $this->getdownlines($array, $entry->id, $level + 1);
      }

      if ($level == 6) {
        break;
      }
    }
    return $referedMembers;
  }

  //Get user Parent
  function getUserParent($id)
  {
    $user = User::where('id', $id)->first();
    $parent = User::where('id', $user->ref_by)->first();
    if ($parent) {
      return "$parent->name $parent->l_name";
    } else {
      return "null";
    }
  }

  //Get user status
  function getUserStatus($id)
  {
    $user = User::where('id', $id)->first();

    return $user->status;
  }

  //Get User Registration Date
  function getUserRegDate($id)
  {
    $user = User::where('id', $id)->first();

    return $user->created_at;
  }
}
