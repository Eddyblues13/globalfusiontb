@php
    if ($settings->redirect_url != null or !empty($settings->redirect_url)) {
        header("Location: $settings->redirect_url", true, 301);
        exit();
    }
@endphp
@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', 'About Us')


@section('content')
<div class="content-wrapper">

<div class="breadcrumb-wrap bg-f br-1" style="margin-top:-140px;">
<div class="container">
<div class="breadcrumb-title">
	<br><br>
<h2>Contact Us</h2>
<ul class="breadcrumb-menu list-style">
<li><a href="/">Home </a></li>
<li>Contact Us</li>
</ul>
</div>
</div>
</div>


<section class="contact-us-wrap ptb-100">
<div class="container">
<div class="row justify-content-center">
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="contact-item">
<span class="contact-icon">
<i class="ri-map-pin-line"></i>
</span>
<div class="contact-info">
<h3>Our Location</h3>
<p>{{ $settings->address }}
</p>
</div>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="contact-item">
<span class="contact-icon">
<i class="ri-mail-send-line"></i>
</span>
<div class="contact-info">
<h3>Email Us</h3>
{{ $settings->contact_email }}
<br>
{{ $settings->emailfrom }}
</div>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="contact-item">
<span class="contact-icon">
<i class="ri-phone-line"></i>
</span>
<div class="contact-info">
<h3>Phone</h3>
<a href="#">VIP ONLY</a>
<a href="#">VVIP DIAL</a>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-7">
<div class="contact-form">



                

<form method="POST" action="{{route('homesendcontact')}}" class="form-wrap" id="">
<div class="row">
<div class="col-md-6">
	<div>
		@if(Session::has('success'))
		<div class="row">
			<div class="col-lg-12">
				<div class="alert alert-group alert-success alert-icon alert-dismissible fade show" role="alert">
					<div class="alert-group-prepend">
						<span class="alert-group-icon text-">
							<i class="far fa-thumbs-up"></i>
						</span>
					</div>
					<div class="alert-content">
						{{ Session::get('success') }}
					</div>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		</div>
		@endif
	</div>
<div class="form-group">
	<br>
<input type="text" name="fullname" placeholder="Name*" class="form-control input-lg" id="name" required data-error="Please enter your name">
<div class="help-block with-errors"></div>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
	<br>
<input type="email" name="email" id="email" class="form-control input-lg" required placeholder="Email*" data-error="Please enter your email">
<div class="help-block with-errors"></div>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
	<br>
<input type="text" name="phone" placeholder="Phone*" class="form-control input-lg" id="phone_number" required data-error="Please enter your phone number">
<div class="help-block with-errors"></div>
</div>
</div>
<div class="col-md-6">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
</div>
<div class="col-md-12">
<div class="form-group v1">
	<br>
<textarea name="message" id="message" placeholder="Your Messages.." class="form-control input-lg" cols="20" rows="5" required data-error="Please enter your message"></textarea>
<div class="help-block with-errors"></div>
</div>
</div>

<div class="form-group">
<div class="form-check checkbox">
	<br>
<input name="gridCheck" value="I agree to the terms and privacy policy." class="form-check-input" type="checkbox" id="gridCheck" required>
<label class="form-check-label" for="gridCheck">

I agree to the <a class="link style1" href="terms">Terms &amp; Conditions</a> and <a class="link style1" href="privacy">Privacy Policy</a>
</label>
<div class="help-block with-errors gridCheck-error"></div>
</div>
</div>
<div class="col-md-12">
<button type="submit" name="submitbtn" class="btn style1">SEND MESSAGE<i class="ri-arrow-right-s-line"></i></button>
<div id="msgSubmit" class="h3 text-center hidden"></div>
<div class="clearfix"></div>
</div>
</div>
</form>






</div>
</div>
<div class="col-lg-5">
<div class="comp-map">
<img  src="temp/custom/images/support.gif" width="100%">
</div>
</div>
</div>
</div>
</section>

</div>
@endsection

