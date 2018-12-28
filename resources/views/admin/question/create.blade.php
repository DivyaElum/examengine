@extends('admin.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css') }}">
	<style type="text/css">
		.alert
		{
			background-color: #00c0ef75 !important;
		}
	</style>
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

        	 	<form onsubmit="return saveQuestion(this)" action="{{route($modulePath.'.store')}}" >
	              	<div class="box-body">
	              		<div class="row">
	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Type <span style="color: red">*</span></label>
				                  	<select onchange="getStructure(this)" class="form-control" name="type" >
				                  		<option value="" >Please Select</option>
				                  		@if(!empty($types) && count($types) > 0)
				                  			@foreach($types as $key => $type)
				                  				<option value="{{ base64_encode(base64_encode($type->id)) }}">{{ $type->title }}</option>
				                  			@endforeach
				                  		@endif
				                  	</select>
				                </div>
	              			</div>	
	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Category <span style="color: red">*</span></label>
				                  	<select class="form-control" name="category" >
				                  		<option value="" >Please Select</option>
				                  		@if(!empty($types) && count($category) > 0)
				                  			@foreach($category as $key => $type)
				                  				<option value="{{ $type->id }}">{{ $type->category_name }}</option>
				                  			@endforeach
				                  		@endif
				                  	</select>
				                </div>
	              			</div>
	                  		<div class="html_data">
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
	<script type="text/javascript" src="{{ asset('plugins/input-mask/mask.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/question/create&edit.js') }}"></script>
@stop