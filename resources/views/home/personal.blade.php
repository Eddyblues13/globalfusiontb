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
<h2>Personal Banking</h2>
<ul class="breadcrumb-menu list-style">
<li><a href="/">Home </a></li>
<li>Personal Banking</li>
</ul>
</div>
</div>
</div>


<div class="feature-wrap style1 pt-100 pb-75">
<div class="container">
<div class="row">
<div class="col-xl-6 offset-xl-3 col-lg-10 offset-lg-1">
<div class="section-title style1 text-center mb-40">
<span style="text-transform: uppercase;">{{$settings->site_name}}</span>
<h4>Personal Checking, Savings, Credit Cards, Loans That Works For You.</h4>
</div>
</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="single-terms">
			<h3>Our Personal Banking</h3>
			<p>We offer personal banking products that typically include savings and transaction facilities such as a bank transaction account, debit cards/EFT, an interest bearing floating account (savings account) and a fixed interest deposit account for a specific agreed period (certificates of deposit / term deposit) which can vary according to the bank.</p>
			<ul class="content-feature-list list-style">
			<li><i class="ri-checkbox-multiple-line"></i>To meet your banking needs, you'll need a combination of current and savings accounts.</li>
			<li><i class="ri-checkbox-multiple-line"></i>Complementary accounts that work together to meet the demands of each individual's cash portfolio.</li>
			<li><i class="ri-checkbox-multiple-line"></i>Instant access to cash, free day-to-day transactions, and fee-free currency conversion are just a few of the benefits – visit individual account sites for more information.</li>
			<li><i class="ri-checkbox-multiple-line"></i>Except for the Cash Hub Account, which can only have two joint account holders, other personal accounts can have up to four joint account holders.</li>
			
			</ul>
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
<h3><a href="register">Apple ios</a></h3>
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
<a href="app">
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