@php
    if ($settings->redirect_url != null or !empty($settings->redirect_url)) {
        header("Location: $settings->redirect_url", true, 301);
        exit();
    }
@endphp
@extends('layouts.base')




@section('content')
   
    


<div class="content-wrapper">

<div class="breadcrumb-wrap bg-f br-1" style="margin-top:-140px;">
<div class="container">
<div class="breadcrumb-title">
<br><br>
<h2>Terms Of Data</h2>
<ul class="breadcrumb-menu list-style">
<li><a href="/">Home </a></li>
<li>Terms Of Data</li>
</ul>
</div>
</div>
</div>


<div class="feature-wrap style1 pt-100 pb-75">
<div class="container">
<div class="row">
<div class="col-xl-6 offset-xl-3 col-lg-10 offset-lg-1">
<div class="section-title style1 text-center mb-40">
<span style="text-transform: uppercase;">{{$settings->site_name}} Policy</span>
<h4>Learn more about how {{$settings->site_name}} protects and uses your personal information.</h4>
</div>
</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="single-terms">
			<h3>Our Terms Of Data</h3>
			<p>We are {{$settings->site_name}} Private Bank, the data controller. You can 
contact our Data Protection Officer (DPO) at Salisbury Road, South West 
London, Hounslow, TW4 if you have any questions.</p>

<p>
    This is our Privacy Statement which explains how we obtain, use and keep 
your personal data safe in relation to the {{$settings->site_name}} website 
(gateleyprivate.com).
</p>
<p>
    Your personal data is data which by itself or with other data available 
to us can be used to identify you.
</p>
<p>
    We're committed to keeping your personal information safe in accordance 
with applicable data protection laws.
</p>
<p>
   The types of personal data we collect and use 
</p>
<p>
    The types of personal data we capture and use will depend on what you 
are doing on the website. We’ll use your personal data for some or all 
of the reasons set out in this Privacy Statement. If you become a 
customer we’ll also use it to manage the account, policy or service 
you’ve applied for and we’ll provide you with a separate data protection 
statement specifically in relation to that as part of the application 
process. Some of the information relevant to that is included in this 
Privacy Statement for consistency. Examples of the personal data we use 
in relation to our websites may include:
</p>
<p>
    Full name and personal details including contact information (e.g. home 
address and address history, email address, home and mobile telephone 
numbers);
Date of birth and/or age (e.g. to make sure that you are eligible to 
apply for a product or service);
</p>
<p>
    Financial details (e.g. salary and details of other income, and details 
of accounts held with other providers if you apply for a product or 
service with us);
Records of products and services you’ve obtained or applied for, how you 
use them and the relevant technology used to access or manage them (e.g. 
mobile phone location data, IP address, MAC address);
</p>
<p>
    Biometric data (e.g. fingerprints and voice recordings for Touch ID and 
voice recognition);
Information from credit reference or fraud prevention agencies, 
electoral roll, court records of debt judgement and bankruptcies and 
other publicly available sources as well as information on any financial 
associates you may have if you apply for a product or service with us;
</p>
<p>
    Family, lifestyle or social circumstances if relevant to the product or 
service you apply for (e.g. the number of dependants you have);
</p>
<p>
    Education and employment details/employment status for credit and fraud 
prevention purposes if you apply for a product or service with us; and
Personal data about other named individuals as required. Where you 
provide the personal data of others you must have their authority to 
provide their personal data to us and share this Privacy Statement and 
any related data protection statement with them beforehand together with 
details of what you’ve agreed on their behalf.
</p>
		
			</div>
		</div>
	</div>
</div>

<hr>

<div class="row justify-content-center">
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="feature-card style3">
<div class="feature-title">
<span>
<i class="ri-apple-fill"></i>
</span>
<h3><a href="send-money">Apple ios</a></h3>
</div>
<p></p>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="feature-card style3">
<div class="feature-title">
<span>
<i class="ri-android-fill"></i>
</span>
<h3><a href="chart">Google Android</a></h3>
</div>
<p></p>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="feature-card style3">
<div class="feature-title">
<span>
<i class="ri-github-line"></i>
</span>
<h3><a href="alerts">Alexa</a></h3>
</div>
<p></p>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="feature-card style3">
<div class="feature-title">
<span>
<i class="ri-slack-line"></i>
</span>
<h3><a href="register">Slack</a></h3>
</div>
<p></p>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="feature-card style3">
<div class="feature-title">
<span>
<i class="ri-google-fill"></i>
</span>
<h3><a href="register">Google Assistant</a></h3>
</div>
<p></p>
</div>
</div>
<div class="col-xl-4 col-lg-6 col-md-6">
<div class="feature-card style3">
<div class="feature-title">
<span>
<i class="ri-facebook-fill"></i>
</span>
<h3><a href="register">Facebook</a></h3>
</div>
<p></p>
</div>
</div>
 </div>
</div>
</div>


<section class="app-wrap style1 ptb-100 bg-whisper">
<div class="container">
<div class="row gx-5 align-items-center">
<div class="col-lg-6">
<div class="app-img-wrap">
<img src="temp/custom/assets/img/shape-4.png" alt="Image" class="app-shape-one bounce">
<img src="temp/custom/assets/img/app-screen.png" alt="Image">
</div>
</div>
<div class="col-lg-6">
<div class="app-content">
<div class="content-title style1">
<span>OUR APP</span>
<h2>Let's Answer Some Of Your Questions Or Download Our App</h2>
<p>Our digital banking platform is up to date and completely trustworthy.
You can use your mobile to perform transactions, loan requests, and credit card transactions.</p>
</div>
<h5>Over 9.2 million Downloads Worldwide</h5>
<div class="app-btn-wrap">
<a href="apps">
<img src="temp/custom/assets/img/about/play-store.png" alt="Image">
</a><a href="app">
<img src="temp/custom/assets/img/about/app-store.png" alt="Image">
</a>
</div>
</div>
</div>
</div>
</div>
</section>

</div>


@endsection
