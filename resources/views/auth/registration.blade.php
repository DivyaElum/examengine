@extends('master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
<style type="text/css">
.error, .help-block {
	color: red !important;
	font-weight: 500;
}
.errorMsgAlrt , .successMsgAlrt , .successLoginMsgAlrt , .errorLoginMsgAlrt{display: none;}
.radio-inline {
	color: #000;
}
</style>
@stop

@section('content')
@php 
$strUser = app('request')->input('type');
@endphp
<div class="login-page-form">
	<div class="container">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="left-form-box">
				<h2>Log In</h2>
				<div class="alert alert-success alert-dismissible successLoginMsgAlrt">
				    <strong><span class="successLoginMessage"></span></strong>
				  </div>
				  <div class="alert alert-danger alert-dismissible errorLoginMsgAlrt">
				    <strong><span class="dangerLoginMessage"></span></strong>
				  </div>
				  <form class="form-horizontal" onsubmit="return checkLogin(this)" action="{{ route($modulePath.'.index') }}" method="post">
					<div class="form-group error">
					  <div class="col-sm-12">
						<input type="email" class="form-control" id="email" placeholder="Email Address" name="email">
						<span class="errors_email help-block"></span>
					  </div>
					</div>
					<div class="form-group error">
					  <div class="col-sm-12">          
						<input type="password" class="form-control" id="password" placeholder="Password" name="password">
						<span class="errors_password help-block"></span>
					  </div>
					</div>
					<div class="form-group">        
					  <div class="col-sm-12">
						<div class="checkbox">
						  <label><input type="checkbox" name="remember"> Remember me</label>
						<a href="#" class="forgot-password">Forget Password?</a>
						</div>
					  </div>
					</div>
					<div class="form-group">        
					  <div class="col-sm-12">
						<button type="submit" class="btn btn-default blue-button">log In</button>
					  </div>
					</div>
				  </form>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="right-form-box">
				<h2>Registration</h2>
				  <div class="alert alert-success alert-dismissible successMsgAlrt">
				    <strong><span class="successMessage"></span></strong>
				  </div>
				  <div class="alert alert-danger alert-dismissible errorMsgAlrt">
				    <strong><span class="dangerMessage"></span></strong>
				  </div>
				  <form class="form-horizontal" name="frmRegister" id="frmRegister" action="{{ route($modulePath.'.index') }}"  method="post" enctype="multipart/form-data">
				  	<div class="form-group error col-md-8">
				  		<label class="radio-inline">
					      	<input type="radio" name="user_role" id="canditate" value="candidate" <?php if($strUser == 'candidate'){echo 'checked';}else{ echo 'checked';} ?> /> Canditate
					    </label>
					    <label class="radio-inline">
					      <input type="radio" name="user_role" id="customer" value="customer" <?php if($strUser == 'customer'){echo 'checked';} ?> />Service provider
					    </label>
				  	</div>

					@if($strUser == 'customer')
					<div class="organisationFiledDiv">
					<div class="form-group error">
					  <div class="col-sm-12">          
						<input type="text" class="form-control" name="organisation_name" id="organisation_name" placeholder="Organisation Name">
						<span class="error_organisation_name help-block"></span>
					  </div>
					</div>
					<div class="form-group error">
					  <div class="col-sm-12">          
						<input type="file" class="form-control" name="organisation_image" id="organisation_image">
						<span class="error_organisation_image help-block"></span>
					  </div>
					</div>
					</div>
					@endif
					<div class="form-group error">
					  <div class="col-sm-12">
						<input class="form-control" placeholder="First Name" name="first_name" id="first_name">
						<span class="error_first_name help-block"></span>
					  </div>
					</div>
					<div class="form-group error">
					  <div class="col-sm-12">          
						<input class="form-control" id="last_name" name="last_name" placeholder="Last Name">
						<span class="error_last_name help-block"></span>
					  </div>
					</div>
					<div class="form-group error">
					  <div class="col-sm-12">
						<input type="email" class="form-control" id="email" placeholder="Email Address" name="email">
						<span class="error_email help-block"></span>
					  </div>
					</div>
					<div class="form-group error">
					  <div class="col-sm-12">          
						<input type="password" class="form-control" id="password" placeholder="Password" name="password">
						<span class="error_password help-block"></span>
					  </div>
					</div>
					<div class="form-group error">
					  <div class="col-sm-12">          
						<input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
						<span class="error_confirm_password help-block"></span>
					  </div>
					</div>
					<div class="form-group error">
					  <div class="col-sm-12">          
						<input type="text" class="form-control" name="telephone_no" id="telephone_no" placeholder="Telephone Number">
						<span class="error_telephone_no help-block"></span>
					  </div>
					</div>
					<div class="form-group">        
					  <div class="col-sm-12">
						<button type="submit" class="btn btn-default green-button" id="btn_register">Register</button>
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
<script type="text/javascript" src="{{ asset('js/auth/registration/addEditMember.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/auth/login/adminCheck.js') }}"></script>
@stop