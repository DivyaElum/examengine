@extends('admin.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datepicker/bootstrap-datepicker.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datepicker/bootstrap-datetimepicker.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/multiselect/bootstrap-multiselect.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css') }}">
	<style>
		.clear{clear: both;}
		.exam_days_div { border: 1px solid #ccc; padding: 15px 0; background: #f3f3f3; margin: 15px 0;}
		.input-daterange input 
		{
		    text-align: left !important; 
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

        	 	<form onsubmit="return saveFormData(this)" action="{{route($modulePath.'.update', [ base64_encode(base64_encode($object->id)) ])}}" >
        	 		<input name="_method" type="hidden" value="PUT">

	              	<div class="box-body">
	              		<div class="row">

	              			<div class="col-md-12">
			            		<p class="alert" style="background-color: #d9edf7 !important">
		            				<b>NOTE : </b><br>
		            				<b>Course fee calculated as : </b><br>
		            				1. If there is a commercial percentage then <b>Fee = ((Course Fee*Discount)/100). </b><br>	
		            				2. If there is a commercial flat then <b>Fee = Commercial Flat Rate. </b>
		            				<br><b> Featured Image : </b><br>
		            				1. Only png, gif, jpeg image formats are allowed.
		            			</p>
				            </div>

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Title <span style="color: red">*</span></label>
					                  	<input type="text" value="{{ $object->title }}" name="title" id="title" class="form-control" placeholder="Enter Title" maxlength="200">
				                  	</select>
				                </div>
				            </div>
				            <div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Description <span style="color: red">*</span></label>
					                  	<textarea  name="description" id="description" class="form-control" placeholder="Enter Description" >{{ $object->description }}</textarea>
				                  	</select>
				                </div>
				            </div>

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Exams</label>
					                  	<select name="exam" id="exam" class="form-control">
					                  		<option value="">Please Select Exam</option>
				                  			@if(!empty($exams) && sizeof($exams) > 0)
				                  				@foreach($exams as $pkey => $exam)
				                  					<option value="{{$exam->id}}" @if($object->exam_id == $exam->id ) selected @endif >{{ ucfirst($exam->title) }}</option>
				                  				@endforeach
				                  			@endif
				                  		</select>
				                  	</select>
				                </div>
	              			</div>	

	              			<div class="col-md-4">
				                <div class="form-group">
				                  	<label for="">Course Fee<span style="color: red">*</span></label>
				                  	<input type="text" oninput="return calculateAmount(this)" value="{{ $object->amount }}" placeholder="Course Fee" name="amount" id="amount" class="form-control">
				                	<span class="err_amount" style="color: red"></span>
				                </div>
	              			</div>

	              			<div class="col-md-2">
				                <div class="form-group">
				                  	<label for="">Currency</label>
				                  	<select name="currency" id="currency" class="form-control">
				                  		<option value="USD" @if($object->currency == 'USD') selected @endif >USD</option>
				                  		<option value="AED" @if($object->currency == 'AED') selected @endif >Dirham</option>
				                  	</select>
				                </div>
	              			</div>		

	              			<div class="col-md-2">
				                <div class="form-group">
				                  	<label for="">Discount</label>
				                  	<input type="text"  oninput="return calculateAmount(this)" value="<?php echo $object->discount ?? 0 ?>" placeholder="Course Discount" name="discount" id="discount" class="form-control">
				                	<span class="err_discount " style="color: red"></span>
				                </div>
	              			</div>	

	              			<div class="col-md-2">
				                <div class="form-group">
				                  	<label for="">Discount By</label>
				                  	<select name="discount_by" onchange="return calculateAmount(this)" id="discount_by" class="form-control">
				                  		<option value="Flat" @if($object->discount_by == 'Flat') selected @endif >Flat</option>
				                  		<option value="%" @if($object->discount_by == '%') selected @endif >%</option>
				                  	</select>
				                	{{-- <span class="err_calculated_amount " style="color: red"></span> --}}
				                </div>
	              			</div>

	              			<div class="col-md-2">
				                <div class="form-group">
				                  	<label for="">Calculated Course Fee <span style="color: red">*</span></label>
				                  	<input type="text" readonly placeholder="Calculated Course Fee" value="{{ $object->calculated_amount }}" name="calculated_amount" id="calculated_amount" class="form-control">
				                	<span class="err_calculated_amount" style="color: red"></span>
				                </div>
	              			</div>

	              			<div class="input-daterange">
		              			<div class="col-md-6 form-group">
		              				<label for="">Start Date <span style="color: red">*</span></label>
		                  			<input type="text" name="start_date" value="{{ $object->start_date }}" readonly style="background-color: white" id="start_date" class="form-control start_date"  placeholder="Start Date">
		                  		</div>
		                  		<div class="col-md-6 form-group">
		              				<label for="">End Date <span style="color: red">*</span></label>
		                  			<input type="text" value="{{ $object->end_date }}" name="end_date" readonly style="background-color: white" id="end_date" class="form-control end_date" placeholder="End Date">
		                  		</div>       				
              				</div>

	              			<div class="col-md-12">
	              				<div class="row">
	              					<div class="col-md-2">
	              						@php 
	              							if(file_exists(storage_path('app/public/course/featuredImageThumbnails/'.$object->featured_image_thumbnail)) && !empty($object->featured_image_thumbnail))
	              							{
	              								$featured = url('/storage/course/featuredImageThumbnails/'.$object->featured_image_thumbnail);
	              								$show = 1;
	              							}
	              							else
	              							{
	              								$featured = url('/images/no-image.png');

	              							}
	              						@endphp 
	              						<img id="preview" class="image-responsive"  src="{{ $featured }}" alt="Featured Image" width="100%" height="125px" />
	              						<input type="hidden" name="old_image" value="{{ $object->featured_image_thumbnail }}" id="old_image">
	              					</div>
	              				</div>

	              				<div class="row" id="delete_button" @if(empty($show))style="display: none"@endif>
				                	<div class="col-md-2" > 
				                		<a  href="javascript:void(0)" onclick="deletePreviewImage(this)" class="btn btn-danger form-control" >Delete</a>
				                	</div>
	              				</div>

				                <div class="row">
					                <div class="form-group col-md-6">
					                  	<label for="">Featured Image </label>
					                  	<input type="file" name="featured_image" accept="image/x-png,image/gif,image/jpeg" id="featured_image" onchange="readURL(this)" class="form-control">
					                	<span class="err_featured_image" style="color: red"></span>
				                	</div>
				                </div>
	              			</div>

	              			<!-- <div class="col-md-12">
				                  	<label for="">Status <span style="color: red">*</span></label>
				                <div class="form-group">
				                  	<label class="radio-inline">
								      <input type="radio" name="status" @if($object->status == 1) checked @endif value="1">Active
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="status" @if($object->status == 0) checked @endif value="0">Inactive
								    </label>
				                </div>
	              			</div>	 -->

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
	<script type="text/javascript">
		var defaultImaage = "{{ url('/images/no-image.png') }}";
	</script>
	<script type="text/javascript" src="{{ asset('plugins/datepicker/moment.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datepicker/bootstrap-datepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datepicker/bootstrap-datetimepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/multiselect/bootstrap-multiselect.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/input-mask/mask.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/course/create&edit.js') }}"></script>
@stop