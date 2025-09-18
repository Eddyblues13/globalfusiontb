
<!DOCTYPE html>
<html lang="zxx">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="index,follow">
  <meta name="robots" content="noindex,follow">
  <meta name="robots" content="index,nofollow">
  <meta name="robots" content="noindex,nofollow">
  <meta name="googlebot" content="noindex,nofollow,noarchive,nosnippet,noodp"/>
  <meta name="robots" content="noindex,nofollow,noarchive,nosnippet,noodp"/>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="{{$settings->site_name}} was launched to make online banking easy and fast.">
  <meta name="keywords" content="Bank,{{$settings->site_name}} , Internet Banking"/>
  <meta property="og:description" content="{{$settings->site_name}} was launched to make online banking easy and fast.">
  <link rel="canonical" href="/">
  <meta property="og:url" content="">
  <meta property="og:site_name" content="{{$settings->site_name}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap%404.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js%401.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap%404.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<link rel="stylesheet" href="temp/custom/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="temp/custom/assets/css/flaticon.css">
<link rel="stylesheet" href="temp/custom/assets/css/remixicon.css">
<link rel="stylesheet" href="temp/custom/assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="temp/custom/assets/css/odometer.min.css">
<link rel="stylesheet" href="temp/custom/assets/css/fancybox.css">
<link rel="stylesheet" href="temp/custom/assets/css/aos.css">
<link rel="stylesheet" href="temp/custom/assets/css/style.css">
<link rel="stylesheet" href="temp/custom/assets/css/responsive.css">
<link rel="stylesheet" href="temp/custom/assets/css/dark-theme.css">
<title>{{$settings->site_name}} - Dedicated to innovating, simplifying, and humanizing digital banking.</title>
<link rel="icon" type="image/png" href="{{ asset('storage/app/public/'.$settings->favicon)}}">
</head>
<body>

<div class="preloader js-preloader">
<div class="loader loader-inner-1">
<div class="loader loader-inner-2">
<div class="loader loader-inner-3">
</div>
</div>
</div>
</div>


{{-- <div class="switch-theme-mode">
<label id="switch" class="switch">
<input type="checkbox" onchange="toggleTheme()" id="slider">
<span class="slider round"></span>
</label>
</div> --}}


<div class="page-wrapper">

<header class="header-wrap style2">
<div class="header-bottom">
<div class="container">
    
<nav class="navbar navbar-expand-md navbar-light" style="">
<a class="navbar-brand" href="/">
<img class="logo-light" src="{{ asset('storage/app/public/'.$settings->logo)}}" alt="{{ $settings->site_name }}  " width="200" height="260">
<img class="logo-dark" src="{{ asset('storage/app/public/'.$settings->logo)}}" alt="{{ $settings->site_name }}" width="200" height="260">
</a>


<div id="google_translate_element"></div>
<div class="collapse navbar-collapse main-menu-wrap" id="navbarSupportedContent">
<div class="menu-close d-lg-none">
<a href="javascript:void(0)"> <i class="ri-close-line"></i></a>
</div>
<ul class="navbar-nav ms-auto">
<li class="nav-item">
<a href="/" class="nav-link active">
Home
<!--<i class="ri-arrow-down-s-line"></i>-->
</a>

</li>


<li class="nav-item">
<a href="business" class="nav-link">
 Business
<!--<i class="ri-arrow-down-s-line"></i>-->
</a>
</li>


<li class="nav-item">
<a href="personal" class="nav-link">
Personal
<!--<i class="ri-arrow-down-s-line"></i>-->
</a>
</li>


<li class="nav-item">
<a href="cards" class="nav-link">
Credit Cards
<!--<i class="ri-arrow-down-s-line"></i>-->
</a>
</li>


<li class="nav-item">
<a href="loans" class="nav-link">
Loans
<!--<i class="ri-arrow-down-s-line"></i>-->
</a>
</li>


<li class="nav-item">
<a href="contact" class="nav-link">Support</a>
</li>


<li class="nav-item d-lg-none">
<a href="login" class="nav-link btn style1">ONLINE BANKING<i class="ri-arrow-right-s-line"></i></a>
</li>

</ul>



<div class="other-options md-none">
<div class="option-item">
<div class="user-login">
<span><i class="ri-user-add-line"></i></span>
<ul class="list-style">
<li><a href="login">Sign In</a></li>
<li><a href="register">Sign Up</a></li>
</ul>
</div>
</div>
<div class="option-item">
<a href="login" class="btn style1">ONLINE BANKING<i class="ri-arrow-right-s-line"></i></a>
</div>
</div>
</div>
</nav>
<div class="mobile-bar-wrap">
<div class="user-login d-lg-none">
<span><i class="ri-user-add-line"></i></span>
<ul class="list-style">
<li><a href="login">Sign In</a></li>
<li><a href="register">Sign Up</a></li>
</ul>
</div>
<div class="mobile-menu d-lg-none">
<a href="javascript:void(0)"><i class="ri-menu-line"></i></a>
</div>
</div></div>
</div>
</header>


@yield('content')




<footer class="footer-wrap">
  <div class="container">
  <div class="row pt-100 pb-75">
  <div class="col-xl-3 col-lg-5 col-md-5 col-sm-6">
  <div class="footer-widget">
  <a href="/" class="footer-logo">
  <img src="{{ asset('storage/app/public/'.$settings->logo)}}" alt="Image">
  </a>
  <p class="comp-desc">
  We are now one of the largest digital banking providers, dedicated to innovating, simplifying, and humanizing banking.
  </p>
  <ul class="social-profile style1 list-style">
  <li>
  <a target="_blank" href="https://facebook.com/">
  <i class="ri-facebook-fill"></i>
  </a>
  </li>
  <li>
  <a target="_blank" href="https://twitter.com/">
  <i class="ri-twitter-fill"></i>
  </a>
  </li>
  <li>
  <a target="_blank" href="https://instagram.com/">
  <i class="ri-instagram-line"></i>
  </a>
  </li>
  <li>
  <a target="_blank" href="https://linkedin.com/">
  <i class="ri-linkedin-fill"></i>
  </a>
  </li>
  </ul>
  </div>
  </div>
  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
  <div class="footer-widget">
  <h3 class="footer-widget-title">Company</h3>
  <ul class="footer-menu list-style">
  <li>
  <a href="about" target="_blank">
  About Us
  </a>
  </li>
  <li>
  <a href="business" target="_blank">
  Business Banking
  </a>
  </li>
  <li>
  <a href="personal" target="_blank">
  Personal Banking
  </a>
  </li>
  <li>
  <a href="cards" target="_blank">
  Credit Cards
  </a>
  </li>
  <li>
  <a href="loans" target="_blank">
  Loans
  </a>
  </li>
  </ul>
  </div>
  </div>
  <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6">
  <div class="footer-widget">
  <h3 class="footer-widget-title">Resources</h3>
  <ul class="footer-menu list-style">
  <li>
  <a href="contact" target="_blank">
  Contact Us
  </a>
  </li>
  <li>
  <a href="faq" target="_blank">
  FAQ's
  </a>
  </li>
  <li>
  <a href="apps" target="_blank">
  Download App
  </a>
  </li>
  <li>
  <a href="privacy-policy" target="_blank">
  Privacy Policy
  </a>
  </li>
  <li>
  <a href="terms-of-service" target="_blank">
  Terms &amp; Conditions
  </a>
  </li>
  </ul>
  </div>
  </div>
  <div class="col-xl-2 col-lg-5 col-md-6 col-sm-6 pe-xl-4">
  <div class="footer-widget">
  <h3 class="footer-widget-title">Transfer Money</h3>
  <ul class="footer-menu list-style">
  <li>
  <a href="login" >
  Register/Login
  </a>
  </li>
  <li>
  <a href="register" >
  IBank Transfer
  </a>
  </li>
  <li>
  <a href="login" target="_blank">
  USA Money Transfer
  </a>
  </li>
  <li>
  <a href="login" target="_blank">
  UK Money Transfer
  </a>
  </li>
  <li>
  <a href="login" target="_blank">
  Euro Money Transfer
  </a>
  </li>
  </ul>
  </div>
  </div>
  <div class="col-xl-3 col-lg-7 col-md-6 col-sm-6">
  <div class="footer-widget">
  <h3 class="footer-widget-title">Contact Us</h3>
  <ul class="contact-info list-style">
  <li>
  <i class="ri-map-pin-fill"></i>
  <h6>Location</h6>
  <p>{{ $settings->address }}</p>
  </li>
  <li>
  <i class="ri-mail-open-fill"></i>
  <h6>Email</h6>
  <a href="#">{{ $settings->site_name }}</a>
  </li>
  <li>
  <i class="ri-phone-fill"></i>
  <h6>Phone</h6>
  <a href="{{ $settings->whatsapp }}">VIP ONLY</a>
  </li>
  </ul>
  </div>
  </div>
  </div>
  <div class="row">
  <div class="col-md-12">
  <p class="copyright-text"><i class="ri-copyright-line"></i> <span></span>Copyright. All Rights Reserved By <a href="login" target="_blank">{{$settings->site_name}}</a></p>
  </div>
  </div>
  </div>
  </footer>
  </div>
  @if($settings->tido)
    <script src="//code.tidio.co/{{$settings->tido}}" async></script>
    @endif
  
  <a href="javascript:void(0)" class="back-to-top bounce"><i class="ri-arrow-up-s-line"></i></a>
  
  
  <script data-cfasync="false" src="https://cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.html"></script><script src="temp/custom/assets/js/jquery.min.js"></script>
  <script src="temp/custom/assets/js/bootstrap.bundle.min.js"></script>
  <script src="temp/custom/assets/js/form-validator.min.js"></script>
  <script src="temp/custom/assets/js/contact-form-script.js"></script>
  <script src="temp/custom/assets/js/aos.js"></script>
  <script src="temp/custom/assets/js/owl.carousel.min.js"></script>
  <script src="temp/custom/assets/js/odometer.min.js"></script>
  <script src="temp/custom/assets/js/jquery.countdown.min.js"></script>
  <script src="temp/custom/assets/js/fancybox.js"></script>
  <script src="temp/custom/assets/js/jquery.appear.js"></script>
  <script src="temp/custom/assets/js/tweenmax.min.js"></script>
  <script src="temp/custom/assets/js/main.js"></script>
  <script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


  </body>
  
  </html>


