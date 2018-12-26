<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="base-path" content="{{ url('/') }}">

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<title>@yield('title') | <?php echo $siteSetting->site_title ?? config('app.name'); ?></title>
<!-- <title>MSC | Managed Services Council</title> -->

<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- Bootstrap core CSS -->
<link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
<!-- Style CSS -->
<link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('/css/dashboard_style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/css/index_style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/css/owl.css') }}" rel="stylesheet" type="text/css">
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
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
          <li><i class="fa fa-phone" aria-hidden="true"></i>Customer Services: <a href="tel:<?php echo $siteSetting->contact_no ?? ''; ?>" data-title="18006729205"><span><?php echo $siteSetting->contact_no ?? ''; ?></span></a></li>
          <li><i class="fa fa-envelope" aria-hidden="true"></i>Email: <a href="mailto:<?php echo $siteSetting->email_id ?? ''; ?>"><span><?php echo $siteSetting->email_id ?? ''; ?></span></a></li>
        </ul>
      </div>
      <div class="top-right">
        <ul>
          <li><a href="#">About Us</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Contact Us</a></li>
           @if(auth()->check())
            <li><a href="{{ url('/logout') }}">Logout</a></li>
          @endif
        </ul>
      </div>
    </div>
  </div>
  <div class="nav-container">
  <div class="container">
    @if(!auth()->check())
    <a href="{{ route('signup.index') }}" class="navbar-brand"><img src="{{asset('images/msc-logo.png')}}" alt="logo" /></a>
    @else
    <a href="{{url('/dashboard')}}" class="navbar-brand"><img src="{{asset('images/msc-logo.png')}}" alt="logo" /></a>
    @endif
    <ul class="navigation">
      <li class="active">
        @if(!auth()->check())
          <a href="{{ route('signup.index') }}">Home</a> 
        @else
          <a href="{{url('/dashboard')}}">Home</a>
        @endif
        </li>
      <li> <a href="/certification">Certifications listing</a> </li>
      <li> <a href="#">Membership</a> </li>
    <div class="show-mobile">
      <li> <a href="#">About Us</a> </li>
      <li> <a href="#">faq</a> </li>
      <li> <a href="#">Contact Us</a> </li>
    </div>
    @if(auth()->check() == '')
      <li class="become-a-canditate-btn"> <a href="{{ route('signup.index') }}?type=candidate">Become A Candidate</a> </li>
      <li class="become-a-service-provider-btn"> <a href="{{ route('signup.index') }}?type=customer">Become A Service Provider</a> </li>
    @endif
    </ul>
    <div class="toggle-menu"> <span></span> </div>
  </div>
  </div>
</div>
<!--/  Header End  -->  
@if(!auth()->check())
<!-- <div class="login-banner">
  <div class="container">
    <h1>
      @yield('page_title')
    </h1>
  </div>  
</div> -->
@endif
<!--/ login banner end  --->
