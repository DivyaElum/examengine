<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<title>@yield('title') | {{ config('app.name') }}</title>
<!-- <title>MSC | Managed Services Council</title> -->

<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
<!-- Bootstrap core CSS -->
<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- Bootstrap core CSS -->
<link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
<!-- Style CSS -->
<link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css">
@yield('styles')
<style type="text/css">
.login-banner h1 {font-size: 50px !important;}
</style>
</head>
<body class="drawer drawer--right drawer--navbarTopGutter">
<div class="first-header">
  <div class="top-bar">
    <div class="container">
      <div class="top-left">
        <ul>
          <li><i class="fa fa-phone" aria-hidden="true"></i>Customer Services: <a href="tel:18006729205" data-title="18006729205"><span>1-800-672-9205</span></a></li>
          <li><i class="fa fa-envelope" aria-hidden="true"></i>Email: <a href="mailto:info@msc.com"><span>info@msc.com</span></a></li>
        </ul>
      </div>
      <div class="top-right">
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="nav-container">
  <div class="container"> <a href="index.php" class="navbar-brand"><img src="images/msc-logo.png" alt="logo" /></a>
    <ul class="navigation">
      <li class="active"> <a href="/sign-up">Home</a> </li>
      <!-- <li> <a href="#">Certifications</a> </li> -->
      <li> <a href="/certification-list">Certifications listing</a> </li>
      <li> <a href="#">Membership</a> </li>
    <div class="show-mobile">
      <li> <a href="#">About Us</a> </li>
      <li> <a href="#">faq</a> </li>
      <li> <a href="#">Contact Us</a> </li>
    </div>
      <li class="become-a-canditate-btn"> <a href="{{ route('sign-up.index') }}?type=candidate">Become A Candidate</a> </li>
      <li class="become-a-service-provider-btn"> <a href="{{ route('sign-up.index') }}?type=customer">Become A Service Provider</a> </li>
    </ul>
    <div class="toggle-menu"> <span></span> </div>
  </div>
  </div>
</div>
<!--/  Header End  -->  

<div class="login-banner">
  <div class="container">
    <h1>
      @yield('page_title')
    </h1>
  </div>  
</div>
<!--/ login banner end  --->
