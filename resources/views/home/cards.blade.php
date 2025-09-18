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
<h2>Credit Cards</h2>
<ul class="breadcrumb-menu list-style">
<li><a href="/">Home </a></li>
<li>Credit Cards</li>
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
<h4>We Invite You to See if You're Pre-Approved for a Credit Card from {{$settings->site_name}}</h4>
</div>
</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			    <!------------------------------------------------------>
                       <div class="row">
                         <div class="col-sm-12">
                            <div class="panel panel-default">
                             <div class="panel-body">
                               <h4 style=""><img src="temp/custom/images/3527271.png" width="25px"> &nbsp;CARD DETAILS</h4>
                               <hr>

                               <div class="row">

                                <div class="col-sm-3" align="center">
                                 <img src="temp/custom/images/349221.png" class="img-responsive" style="margin-top: 15px;" width="50">
                                  <br>
                                  <span style="font-size:14px;">VISA</span><br><br>
                                  
                                   <div class="hidden-md hidden-lg"><hr></div>
                                </div>


                                <div class="col-sm-3" align="center">
                                  <img src="temp/custom/images/147258.png" class="img-responsive" style="margin-top: 15px;" width="50">
                                  <br>
                                  
                                  <span style="font-size:14px;">MAESTRO</span><br><br>
                                   
                                   <div class="hidden-md hidden-lg"><hr></div>
                                 </div>

                                 <div class="col-sm-3" align="center">
                                   <img src="temp/custom/images/349228.png" class="img-responsive" style="margin-top: 15px;" width="50">
                                  <br>
                                 
                                  <span style="font-size:14px;">AMEX</span><br><br>
                                   
                                   <div class="hidden-md hidden-lg"><hr></div>
                                 </div>

                                 <div class="col-sm-3" align="center">
                                   <img src="temp/custom/images/349230.png" class="img-responsive" style="margin-top: 15px;" width="50">
                                  <br>
                                  <span style="font-size:14px;">DISCOVER</span><br><br>
                                   
                                   <div class="hidden-md hidden-lg"><hr></div>
                                 </div>
                                 
                               </div>

                               <br>
                               
                             </div>
                           </div>
                         </div>
                       </div>
                       
                       
                       <!------------------------------------------------------>
<br><br><br>
                       <!------------------------------------------------------>
                       <div class="row">
                         <div class="col-sm-2"></div>
                         <div class="col-sm-4">
                            <img src="temp/custom/images/1086741.png" class="img-responsive" style="margin-top: 15px;" width="150">
                         </div>
                         <div class="col-sm-4">
                         	<h3>Apply For Credit Cards</h3>
                         	<p>Welcome to {{$settings->site_name}}, Apply For Credit Cards to be delivered to your doorstep today.</p>
                         	<br>
                         	<a href="login" target="_blank" class="btn btn-primary">Apply</a>
                         </div>
                         <div class="col-sm-2"></div>
                       </div>
                       <br><br><br>
                       <!------------------------------------------------------>
		</div>
	</div>
</div>



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
<span>OUR CARDS</span>
<h2>Protect Your Card From Anywhere</h2>
<p><p>Leave your card at the restaurant or drop it at the concert? Instantly lock your card with a few taps. And if you find it, unlock it just as fast.</p></p>
</div>
<h5>Over 2 million credit card users</h5>
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
