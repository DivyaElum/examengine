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
		            	<a title="Back to Repository" href="{{ route('siteSetting.index') }}" class="btn btn-social btn-linkedin" ><i class="fa fa-arrow-left"></i>{{'Back'}}</a>
		          	</div>
	        	</div>
        	 	<form onsubmit="return saveSiteSetting(this)" action="{{route('siteSetting.store')}}" >
	              	<div class="box-body">
	              		<div class="row">
	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="txtTitle">Title </label>
				                  	<input type="text" name="txtTitle" id="txtTitle" class="form-control">
				                  	<span class="help-block err_txtTitle"></span>
				                </div>
				                <div class="form-group">
				                  	<label for="txtValue">Value </label>
				                  	<input type="text" name="txtValue" id="txtValue" class="form-control">
				                  	<span class="help-block err_txtValue"></span>
				                </div>
				                <div class="form-group">
				                  	<label for="">Status </label>&nbsp;&nbsp;
				                  	<label class="radio-inline">
								      <input type="radio" name="txtStatus" checked value="1">Active
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="txtStatus" value="0">Inactive
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
	<script type="text/javascript" src="{{ asset('js/admin/repository/create_edit.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/siteSetting/addEditSiteSetting.js') }}"></script>
@stop