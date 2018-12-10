@extends('admin.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@stop

@section('content')
	
	<div class="content-wrapper">

	    <section class="content-header">
	      <h1>
	        {{ $moduleTitle }}
	      </h1>
	      <ol class="breadcrumb">
	        <li class=""><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
	        <li class="active">{{ $moduleAction }}</li>
	      </ol>
	    </section>
	    
	    <section class="content">

	      	<div class="box">

	        	<div class="box-header with-border">
		          	<h3 class="box-title">{{ $moduleAction }}</h3>
		          	<div class="box-tools pull-right">
		            	<a title="Back to Manage" href="{{ route($modulePath.'.index') }}" class="btn btn-social btn-linkedin" ><i class="fa fa-arrow-left"></i>{{'Back'}}</a>
		          	</div>
		          	
	        	</div>

        	 	<form onsubmit="return saveFormData(this)" action="{{route($modulePath.'.store')}}" >
	              	<div class="box-body">
	              		<div class="row">

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Question Type Title<span style="color: red">*</span></label>
				                  	<input type="text" name="title" maxlength="100" class="form-control" placeholder="Enter Question Type Title">
				                  	<span class="help-block err_title" ></span>
				                </div>
	              			</div>	

	              			<div class="options form-group">
								<div class="col-md-12">
									<label for="">Option Types</label>
									<div class="input-group">
										<label for="radio">
							              	<input type="radio" checked name="option" id="radio" value="radio" >
											  Radio Box 
										</label>
							      	</div>
							      	<div class="input-group">
										<label for="checkbox"> 
											<input type="radio" name="option" id="checkbox" value="checkbox" >
											 Check Box
										</label>
							      	</div>
								  	<span class="help-block err_option"></span>
							  	</div>
							</div>


	              		</div>
	              	</div>

	              	<div class="box-footer">
		                <button type="submit" id="submit_button" class="btn btn-primary">Submit</button>
            	  	</div>
	            </form>
	      </div>
	    </section>
	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/questionType/create&edit.js') }}"></script>
@stop