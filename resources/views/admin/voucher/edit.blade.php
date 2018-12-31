@extends('admin.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css') }}">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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

        	 	<form onsubmit="return saveVoucher(this)" action="{{route($modulePath.'.update', [ base64_encode(base64_encode($objectData->id)) ])}}"  method="post" enctype="multipart/form-data">
        	 		<input name="_method" type="hidden" value="PUT">
	              	<div class="box-body">
	              		<div class="row">
	              			<div class="col-md-12">
				                <div class="form-group col-md-12">
				                  	<label for="voucher_code">Voucher Code  <span style="color: red">*</span></label>
				                  	<input type="text" placeholder="Enter Voucher code" name="voucher_code" id="voucher_code" class="form-control" value="{{$objectData->voucher_code}}" >
				                  	<span class="help-block err_site_title"></span>
				                </div>
				                <div class="form-group col-md-12">
				                  	<label for="user_count">User Count  <span style="color: red">*</span></label>
				                  	<input type="text" placeholder="Enter User Count" name="user_count" id="user_count" class="form-control" value="{{$objectData->voucher_code}}" >
				                  	<span class="help-block err_site_title"></span>
				                </div>
				                <div class="form-group col-md-12">
				                  	<label for="site_title">User Type :  <span style="color: red">*</span></label>
				                  	<select class="form-control" id="user_type" name="user_type">
				                  		<option value="">Please select user type</option>
				                  		<option value="candidate" <?php if($objectData->user_type == 'candidate'){ echo 'selected';} ?>>Candidate</option>
				                  		<option value="customer" <?php if($objectData->user_type == 'customer'){ echo 'selected';} ?>>Customer</option>
				                  	</select>
				                  	<span class="err_user_type" style="color: red"></span>
				                </div>
				                <div class="form-group">
					                <div class="col-md-6">
						                <div class="form-group">
						                  	<label for="">Discount</label>
						                  	<input type="text" value="0"  oninput="return calculateAmount(this)" placeholder="Course Discount" name="discount" id="discount" class="form-control"  value="{{$objectData->discount}}" >
						                	<span class="err_discount " style="color: red"></span>
						                </div>
		              				</div>	
			              			<div class="col-md-6">
						                <div class="form-group">
						                  	<label for="">Discount By</label>
						                  	<select name="discount_by" onchange="return calculateAmount(this)" id="discount_by" class="form-control">
						                  		<option value="Flat" <?php if($objectData->discount_by == 'Flat'){ echo 'selected';} ?>>Flat</option>
						                  		<option value="%" <?php if($objectData->discount_by == '%'){ echo 'selected';} ?>>%</option>
						                  	</select>
						                  	<span class="err_discount_by" style="color: red"></span>
						                </div>
			              			</div>
		              			</div>
		              			<div class="form-group">
			              			<div class="col-md-6">
					                  	<label for="start_date">Start Date <span style="color: red">*</span></label>
					                  	<input type="text" placeholder="Select Start Date" name="start_date" id="start_date" class="form-control datepicker"  value="{{$objectData->start_date}}">
					                  	<span class="help-block err_start_date"></span>
					                </div>

					                <div class="col-md-6">
					                  	<label for="end_date">End Date <span style="color: red">*</span></label>
					                  	<input type="text" placeholder="Select End Date" name="end_date" id="end_date" class="form-control datepicker"  value="{{$objectData->end_date}}">
					                  	<span class="help-block err_end_date"></span>
					                </div>
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
	<script type="text/javascript" src="{{ asset('plugins/input-mask/mask.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="{{ asset('js/admin/voucher/addEditVoucher.js') }}"></script>
@stop