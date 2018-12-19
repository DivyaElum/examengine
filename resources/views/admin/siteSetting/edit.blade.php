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
		            	<a title="Back to Repository" href="{{ route($modulePath.'.index') }}" class="btn btn-social btn-linkedin" ><i class="fa fa-arrow-left"></i>{{'Back'}}</a>
		          	</div>
	        	</div>

        	 	<form onsubmit="return saveSiteSetting(this)" action="{{route($modulePath.'.update', [ base64_encode(base64_encode($object->id)) ])}}"  method="post">
        	 		<input name="_method" type="hidden" value="PUT">
	              	<div class="box-body">
	              		<div class="row">
	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="site_title">Site Title  <span style="color: red">*</span></label>
				                  	<input type="text" name="site_title" id="site_title" class="form-control" value="{{$object->site_title}}" >
				                  	<span class="help-block err_txtTitle"></span>
				                </div>
				                <div class="form-group">
				                  	<label for="Address">Address <span style="color: red">*</span></label>
				                  	<input type="text" name="address" id="address" class="form-control"  value="{{$object->site_title}}" >
				                  	<span class="help-block err_txtValue"></span>
				                </div>
				                <div class="form-group">
				                  	<label for="Address">Contact Number <span style="color: red">*</span></label>
				                  	<input type="text" name="contact_no" id="contact_no" class="form-control"  value="{{$object->contact_no}}" >
				                  	<span class="help-block err_txtValue"></span>
				                </div>
				                <div class="form-group">
				                  	<label for="email_id">Email Id <span style="color: red">*</span></label>
				                  	<input type="email" name="email_id" id="email_id" class="form-control"  value="{{$object->email_id}}" >
				                  	<span class="help-block err_txtValue"></span>
				                </div>
				                <div class="form-group">
				                  	<label for="meta_keywords">Meta Keywords</label>
				                  	<input type="text" name="meta_keywords" id="meta_keywords" class="form-control"  value="{{$object->meta_keywords}}" >
				                  	<span class="help-block err_txtValue"></span>
				                </div>
				                <div class="form-group">
				                  	<label for="meta_desc">Meta Descriptions </label>
				                  	<textarea name="meta_desc" id="meta_desc" class="form-control">{{$object->meta_desc}}</textarea>
				                  	<span class="help-block err_txtValue"></span>
				                </div>
				                <div class="form-group">
				                  	<label for="status">Status </label>&nbsp;&nbsp;
				                  	<label class="radio-inline">
								      <input type="radio" name="status" <?php if($object->status == '1'){ echo 'checked';} ?>  value="1">Active
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="status" value="0" <?php if($object->status == '0'){ echo 'checked';} ?>  >Inactive
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
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/admin/siteSetting/addEditSiteSetting.js') }}"></script>
@stop