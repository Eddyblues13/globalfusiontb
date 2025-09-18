{{-- blade-formatter-disable --}}
@component('mail::message')
# Hello {{$foramin  ? 'Admin' : $user->name}}
@if ($foramin)
 This is to inform you of a successfull Deposit of {{config('currencies.' . $user->currency, '$') .$deposit->amount}} from {{$user->name}}. {{ $deposit->status == "Processed" ? '' : ' Please login to process it.' }}
@else
@if ($deposit->status == 'Processed')
This is to inform you that your deposit of {{config('currencies.' . $user->currency, '$').$deposit->amount}} have been received and confirmed. Your account balance have been credited with the specified amount.
@else
<p>Your Crypto Asset Deposit has been recorded successfully and currently undergoing confirmation. You will receive an automatic notification once your transaction was confirmed on the blockchain Network. This usually take upto 15 minutes.
  </p>
                        
<p>Amount: {{config('currencies.' . $user->currency, '$').$deposit->amount}}</p> 
                         
                          
<p>Deposited on: {{ \Carbon\Carbon::parse($deposit->created_at)->toDayDateTimeString() }}</p>                        
                         
                         
@endif
@endif
Thanks,
{{ config('app.name') }}
@endcomponent
{{-- blade-formatter-disable --}}
