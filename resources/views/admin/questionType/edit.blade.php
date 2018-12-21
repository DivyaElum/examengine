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
	        {{ $moduleAction }}
	      </h1>
	      <ol class="breadcrumb">
	        <li class=""><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
	        <li class="active">{{ $moduleAction }}</li>
	      </ol>
	    </section>
	    
	    <section class="content">

	      	<div class="box">

	        	<div class="box-header with-border">
		          	<h3 class="box-title"></h3>
		          	<div class="box-tools pull-right">
		            	<a title="Back" href="{{ route($modulePath.'.index') }}" class="btn btn-social btn-linkedin" ><i class="fa fa-arrow-left"></i>{{'Back'}}</a>
		          	</div>
	        	</div>

        	 	<form onsubmit="return saveFormData(this)" action="{{route($modulePath.'.update',[base64_encode(base64_encode($object->id))])}}" >
        	 		<input name="_method" type="hidden" value="PUT">
	              	<div class="box-body">
	              		<div class="row">

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Question Type Title<span style="color: red">*</span></label>
				                  	<input type="text" name="title" value="{{ $object->title }}" maxlength="100" class="form-control" placeholder="Enter Question Type Title">
				                  	<span class="help-block err_title" ></span>
				                </div>
	              			</div>	

							<div class="col-md-12">
				                  	<label for="">Option Types <span style="color: red">*</span></label>
				                <div class="form-group">
				                  	<label class="radio-inline">
								      <input type="radio" @if($object->option == 'radio') checked  @endif name="option" id="radio" value="radio" >Radio Box 
								    </label>
								    <label class="radio-inline">
								      <input type="radio" @if($object->option == 'checkbox') checked  @endif name="option" id="checkbox" value="checkbox" >Check Box
								    </label>
				                </div>
	              			</div>	


							<div class="col-md-12">
				                  	<label for="">Status <span style="color: red">*</span></label>
				                <div class="form-group">
				                  	<label class="radio-inline">
								      <input type="radio" name="status" @if($object->status == 1) checked @endif value="1">Active
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="status" @if($object->status == 0) checked @endif value="0">Inactive
								    </label>
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