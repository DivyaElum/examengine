<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Admin Login</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="admin-path" content="{{ url('/admin') }}">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>@yield('title') | {{ config('app.name') }}</title>

<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>

<link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/bootstrap-social/bootstrap-social.css')}}">
<link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
<link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
<link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<style type="text/css">
.redText,.error{color: red;}
.frame {position: relative;border: 3px solid #a6f;-webkit-transition: border-color 300ms ease;transition: border-color 300ms ease;}
.form-content {padding: 20px 20px 30px 20px;}
.loginbtn{background: #a6f;font-weight: 700;}
#btnSubmit:hover {background-color: green;border-color: green;}
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-box-body">
  <div class="">
    <div class="form-content">
   	@if (session('errorMsg'))
	 <div class="alert alert-danger">
			 {{ session('errorMsg') }}
	 </div>
   	@endif
  	<div class="login-logo">
    	<p><b>Forgot Password</b></p>
  	</div>
	   @if (session('login_error'))
		 <div class="alert alert-danger">
				 {{ session('login_error') }}
		 </div>
	   @endif
	  	<form onsubmit="return forgotpass(this)" action="{{asset('admin/forgot')}}" method="post">
	  		@csrf
	      <div class="form-group has-feedback">
	        <input type="Email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Enter a email Id">
	        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	        <span class="help-block errortxtEmail"></span>
	      </div>
	      <div class="row">
	        <div class="col-xs-4">
	          <button type="submit" class="btn btn-primary btn-block btn-flat ">Send</button>
	          <a href="/admin/login" class="btn btn-danger btn-block btn-flat ">Back</a>
	        </div>
	      </div>
	    </form>
    </div>
    </div>
  </div>
</div>
	<script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
	<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/checkLogin/adminCheck.js') }}"></script>
</body>
</html>
