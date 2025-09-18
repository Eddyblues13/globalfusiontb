{{-- blade-formatter-disable --}}
@component('mail::message')
# Hi {{$user->name}} {{$user->middlename}} {{$user->lastname}} , 

Thank you so much for allowing us to help you with your recent account opening.
<br>We are committed to providing our customers with the highest level of service and the most innovative banking products possible.
<br>We are very glad you chose us as your financial institution and hope you will take advantage of our wide variety of savings, investment and loan products, all designed to meet your specific needs.

<p><b style="text-center">Details of your new account are shown below;</b></p>
<b>Account name: {{$user->name}} {{$user->middlename}} {{$user->lastname}}</b><br>
<b>Account Number: {{$user->usernumber}}</b><br>
<b>Account Type: {{$user->	accounttype}}</b><br>
<b>Country: {{$user->country}}</b><br>
<b>Date : {{ \Carbon\Carbon::parse($user->created_at)->toDayDateTimeString() }}</b><br>
<hr>
<p><b style="text-center">Online banking credentials</b></p>
<b>Email: {{$user->email}}</b><br>
<b>Password: Your password</b><br>
                            
                          
                               
<p>For more detailed information about any of our products or services, please refer to our website or visit any of our convenient locations. You may contact us on email {{$settings->contact_email}}.</p> 
                          
<p> {{$settings->site_name}} is a full service, local and International financial institution. Our decisions are made right here, with the community’s members best interest in mind. We are concerned about what is best for you!</p>


Thanks, and welcome.
<br>
{{ config('app.name') }}
@endcomponent
{{-- blade-formatter-disable --}}
