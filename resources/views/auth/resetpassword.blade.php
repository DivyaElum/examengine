@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
<style type="text/css">
.error, .help-block {color: red !important;font-weight: 500;}
.errorMsgAlrt , .successMsgAlrt , .successLoginMsgAlrt , .errorLoginMsgAlrt{display: none;}
.login-page-form {width: 100%;height: auto;display: flex;flex-wrap: wrap;background-image: linear-gradient(90deg,#f1f1f1 100%,#fefeff 50%) !important;}
</style>
@stop

@section('content')
@php 
$remember_token = \Request::segment(2);
@endphp
<div class="login-banner">
    <div class="container">
      <h1>
        Reset Password
      </h1>
    </div>  
  </div>
<div class="login-page-form">
	<div class="container">
		<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
			<div class="left-form-box">
				<h2>Forgot Password</h2>
				<div class="alert alert-success alert-dismissible successMsgAlrt">
				    <strong><span class="successMessage"></span></strong>
				  </div>
				  <div class="alert alert-danger alert-dismissible errorLoginMsgAlrt">
				    <strong><span class="dangerLoginMessage"></span></strong>
				  </div>
				  <form class="form-horizontal" name="frmResetPassword" method="post">
				  	@csrf
				  	<input type="hidden" class="form-control" id="urltoken" placeholder="Email Address" name="urltoken"  value="{{$remember_token}}" />
					<div class="form-group error">
					  <div class="col-sm-12">
						<input type="email" class="form-control" id="email" placeholder="Email Address" name="email"  value="{{$arrUserData->email}}" readonly="" />
					  </div>
					</div>
					<div class="form-group error">
					  <div class="col-sm-12">
						<input type="Password" class="form-control" id="password" placeholder="Password" name="password"  value="" />
					  </div>
					</div>
					<div class="form-group error">
					  <div class="col-sm-12">
						<input type="Password" class="form-control" id="confirm_password" placeholder="confirm password" name="confirm_password"  value="" />
					  </div>
					</div>
					<div class="form-group">        
					  <div class="col-sm-12">
						<button type="submit" class="btn btn-default blue-button" id="btn_submit">Submit</button>
					  </div>
					</div>
				  </form>
			</div>
		</div>
	</div>
</div>
@stop
@section('scripts')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script type="text/javascript" src="{{ asset('js/auth/resetPassword.js') }}"></script>
@stop