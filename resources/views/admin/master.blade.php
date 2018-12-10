<!DOCTYPE html>
<html>
<head>
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

	@yield('styles')
</head>
<body class="hold-transition skin-blue sidebar-mini" >
	<div class="wrapper">

  		@section('header')
  			@include('admin.partials._header')
  		@show

  		@section('sidebar')
  			@include('admin.partials._sidebar')
		@show

		@yield('content')
  		
  		@section('footer')
  			@include('admin.partials._footer')
  		@show
	
	</div>

	<script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
	<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
	@yield('scripts')
</body>
</html>