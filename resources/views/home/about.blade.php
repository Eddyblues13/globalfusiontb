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
  <h2>About Us</h2>
  <ul class="breadcrumb-menu list-style">
  <li><a href="/">Home </a></li>
  <li>About Us</li>
  </ul>
  </div>
  </div>
  </div>
  
  
  <div class="partner-wrap ptb-100">
  <div class="container">
  <div class="row">
  <div class="col-xl-10 offset-xl-1 col-lg-10 offset-lg-1">
  <div class="section-title text-center mb-40">
  <h2>Used By 100K+ Businesses Of All Shapes &amp; Sizes</h2>
  </div>
  </div>
  </div>
  <div class="partner-slider owl-carousel">
  <div class="partner-item">
  <img src="temp/custom/assets/img/partner/partner-1.png" alt="Image">
  </div>
  <div class="partner-item">
  <img src="temp/custom/assets/img/partner/partner-2.png" alt="Image">
  </div>
  <div class="partner-item">
  <img src="temp/custom/assets/img/partner/partner-3.png" alt="Image">
  </div>
  <div class="partner-item">
  <img src="temp/custom/assets/img/partner/partner-4.png" alt="Image">
  </div>
  <div class="partner-item">
  <img src="temp/custom/assets/img/partner/partner-5.png" alt="Image">
  </div>
  <div class="partner-item">
  <img src="temp/custom/assets/img/partner/partner-6.png" alt="Image">
  </div>
  <div class="partner-item">
  <img src="temp/custom/assets/img/partner/partner-7.png" alt="Image">
  </div>
  </div>
  </div>
  </div>
  
  
  <section class="about-wrap style1 pb-100">
  <div class="container">
  <div class="row gx-5 align-items-center">
  <div class="col-lg-6">
  <div class="row">
  <div class="col-6 about-img-wrap">
  <img src="temp/custom/assets/img/about/about-shape-4.png" alt="Image" class="about-shape-one bounce">
  <div class="about-img">
  <img src="temp/custom/assets/img/about/about-img-1.jpg" alt="Image">
  </div>
  <div class="about-img">
  <img src="temp/custom/assets/img/about/about-img-2.jpg" alt="Image">
  </div>
  </div>
  <div class="col-6 about-img-wrap lgm-70">
  <img src="temp/custom/assets/img/shape-1.png" alt="Image" class="about-shape-two moveHorizontal">
  <div class="about-img">
  <img src="temp/custom/assets/img/about/about-img-3.jpg" alt="Image">
  </div>
  <div class="about-img">
  <img src="temp/custom/assets/img/about/about-img-4.jpg" alt="Image">
  </div>
  </div>
  </div>
  </div>
  <div class="col-lg-6">
  <div class="about-content">
  <div class="content-title style1">
  <span>ABOUT US</span>
  <h2>Digital Banking was revolutionized by us.</h2>
  <p>We've developed to become one of the most well-known digital banking companies, dedicated to reinventing, simplifying, and humanizing the banking experience.</p>
  </div>
  <div class="feature-item-wrap">
  <div class="feature-item">
  <div class="feature-icon">
  <i class="flaticon-clicking"></i>
  </div>
  <div class="feature-text">
  <h3>Powerful Mobile &amp; Online App</h3>
  <p>Our mobile app service is quick and easy to use, and you can get it from your app store.</p>
   </div>
  </div>
  <div class="feature-item">
  <div class="feature-icon">
  <i class="flaticon-alarm"></i>
  </div>
  <div class="feature-text">
  <h3>Brings More Transperency &amp; Speed</h3>
  <p>Our digital banking services are transparent and quick, and we're building a reliable network.</p>
  </div>
  </div>
  <div class="feature-item">
  <div class="feature-icon">
  <i class="flaticon-setting"></i>
  </div>
  <div class="feature-text">
  <h3>Special For Multiple User Capabilities</h3>
  <p>The ability of a computer or operating system to create independent working environments for several users is referred to as multiuser.</p>
  </div>
  </div>
  </div>
  <a href="register" class="btn style1">START WITH US<i class="ri-arrow-right-s-line"></i></a>
  </div>
  </div>
  </div>
  </div>
  </section>
  
  
  <div class="feature-wrap style1 pt-100 pb-75 bg-whisper">
  <div class="container">
  <div class="row">
  <div class="col-xl-6 offset-xl-3 col-lg-10 offset-lg-1">
  <div class="section-title style1 text-center mb-40">
  <span>MOST POPULAR CURRENCY TOOLS</span>
  <h2>Set Up &amp; Exchange Money From Your Cards In A Minute</h2>
  </div>
  </div>
  </div>
  <div class="row justify-content-center">
  <div class=" col-xxl-3 col-xl-4 col-lg-6 col-md-6">
  <div class="feature-card style1">
  <div class="feature-icon">
  <i class="flaticon-hand"></i>
  </div>
  <h3><a href="login">Money Transfer</a></h3>
  <p>With our digital platform, you may send money to relatives and friends all around the world.</p>
  <a href="login" class="link style1">Send Money <i class="ri-arrow-right-s-line"></i></a>
  </div>
  </div>
  <div class=" col-xxl-3 col-xl-4 col-lg-6 col-md-6">
  <div class="feature-card style1">
  <div class="feature-icon">
  <i class="flaticon-pie-chart"></i>
  </div>
  <h3><a href="chart">Curreny Charts</a></h3>
  <p>You can always watch the market's movement and make trading decisions with our currency charts.</p>
  <a href="login" class="link style1">View Charts<i class="ri-arrow-right-s-line"></i></a>
  </div>
   </div>
  <div class=" col-xxl-3 col-xl-4 col-lg-6 col-md-6">
  <div class="feature-card style1">
  <div class="feature-icon">
  <i class="flaticon-notification"></i>
  </div>
  <h3><a href="alerts">Rate Alerts</a></h3>
  <p>To enable our clients to convert, we at Stana Group provide the finest currency rates in the market.</p>
  <a href="register" class="link style1">Create Alerts<i class="ri-arrow-right-s-line"></i></a>
  </div>
  </div>
  <div class=" col-xxl-3 col-xl-4 col-lg-6 col-md-6">
  <div class="feature-card style1">
  <div class="feature-icon">
  <i class="flaticon-user-3"></i>
  </div>
  <h3><a href="register">Create Account</a></h3>
  <p>Create a free digital bank account with us today to send money around the world.</p>
  <a href="register" class="link style1">Get Started <i class="ri-arrow-right-s-line"></i></a>
  </div>
  </div>
  </div>
  </div>
  </div>
  
  
  
  <section class="wh-wrap style3 ptb-100">
  <div class="container">
  <div class="row gx-5 align-items-center">
  <div class="col-lg-6 order-lg-1 order-md-2 order-2">
  <div class="wh-content">
  <div class="content-title style1">
  <span>WHY CHOOSE US</span>
  <h2>We are innovative and digital</h2>
  <p>New Capital Ltd transformed the credit card business using data and technology more than ten years ago. We are now one of the largest digital banking providers, dedicated to innovating, simplifying, and humanizing banking.</p>
  </div>
  <div class="feature-item-wrap">
  <div class="feature-item">
  <div class="feature-icon">
  <i class="flaticon-tick"></i>
  </div>
  <div class="feature-text">
  <h3>Historical Currency Rates</h3>
  <p></p>
  </div>
  </div>
  <div class="feature-item">
  <div class="feature-icon">
  <i class="flaticon-tick"></i>
  </div>
  <div class="feature-text">
  <h3>Travel Expense Calculator</h3>
  <p></p>
  </div>
  </div>
  <div class="feature-item">
   <div class="feature-icon">
  <i class="flaticon-tick"></i>
  </div>
  <div class="feature-text">
  <h3>Currency Email Updates</h3>
  <p></p>
  </div>
  </div>
  </div>
  </div>
  </div>
  <div class="col-lg-6 order-lg-2 order-md-1 order-1">
  <div class="wh-img-wrap">
  <img src="temp/custom/assets/img/shape-6.png" alt="Image" class="wh-shape-one animationFramesTwo">
  <img src="temp/custom/assets/img/why-choose-us/wh-img-7.jpg" alt="Image">
  </div>
  </div>
  </div>
  </div>
  </section>
  
  
  <div class="counter-wrap style1 pb-75">
  <div class="container">
  <div class="row">
  <div class="col-xl-6 offset-xl-3 col-lg-10 offset-lg-2">
  <div class="section-title style1 text-center mb-40">
  <span>SOME FUN FACTS</span>
  <h2>We Always Try To Understand Customer's Expectation</h2>
  </div>
  </div>
  </div>
  <div class="counter-card-wrap">
  <div class="counter-card">
  <div class="counter-text">
  <h2 class="counter-num">
  <span class="odometer" data-count="2"></span>
  <span class="target">M+</span>
  </h2>
  <p>Downloaded</p>
  </div>
  </div>
  <div class="counter-card">
  <div class="counter-text">
  <h2 class="counter-num">
  <span class="odometer" data-count="18"></span>
  <span class="target">K+</span>
  </h2>
  <p>Feedback</p>
  </div>
  </div>
  <div class="counter-card">
  <div class="counter-text">
  <h2 class="counter-num">
  <span class="odometer" data-count="13"></span>
  <span class="target">K+</span>
  </h2>
  <p>Workers</p>
  </div>
  </div>
  <div class="counter-card">
  <div class="counter-text">
  <h2 class="counter-num">
  <span class="odometer" data-count="18"></span>
  <span class="target">+</span>
  </h2>
  <p>Years Of Ecperience</p>
  </div>
  </div>
  <div class="counter-card">
  <div class="counter-text">
  <h2 class="counter-num">
  <span class="odometer" data-count="5"></span>
  <span class="target">K+</span>
  </h2>
  <p>Contributors</p>
  </div>
  </div>
  </div>
  </div>
  </div>
  
  
  
  <div class="feature-wrap style1 ptb-100 bg-whisper">
  <div class="container">
  <div class="row">
  <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
  <div class="section-title style1 text-center mb-40">
  <span>YOUR BENIFITS</span>
  <h2>Your one-stop digital banking platform</h2>
  </div>
  </div>
  </div>
  <div class="feature-slider-one owl-carousel">
  <div class="feature-card style6">
  <div class="feature-icon">
  <i class="flaticon-planet-earth"></i>
  </div>
  <div class="feature-info">
  <h3><a href="#">Global Coverage</a></h3>
  <p></p>
  </div>
  </div>
  <div class="feature-card style6">
  <div class="feature-icon">
  <i class="flaticon-money-bag-1"></i>
  </div>
  <div class="feature-info">
  <h3><a href="#">Easy Transfer Method</a></h3>
  <p></p>
  </div>
  </div>
  <div class="feature-card style6">
  <div class="feature-icon">
  <i class="flaticon-notification"></i>
  </div>
  <div class="feature-info">
  <h3><a href="#">Global 24/7 Support</a></h3>
  <p></p>
  </div>
  </div>
  <div class="feature-card style6">
  <div class="feature-icon">
  <i class="flaticon-money-1"></i>
  </div>
  <div class="feature-info">
  <h3><a href="#">Lowest Fee</a></h3>
  <p></p>
  </div>
  </div>
  <div class="feature-card style6">
  <div class="feature-icon">
  <i class="flaticon-automation"></i>
  </div>
  <div class="feature-info">
  <h3><a href="#">Instant Processing</a></h3>
  <p></p>
  </div>
  </div>
  <div class="feature-card style6">
  <div class="feature-icon">
  <i class="flaticon-shield"></i>
  </div>
  <div class="feature-info">
  <h3><a href="#">Bank Lavel Security</a></h3>
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