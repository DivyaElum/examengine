@extends('admin.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/multiselect/bootstrap-multiselect.css') }}">
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

        	 	<form onsubmit="return saveFormData(this)" action="{{route($modulePath.'.update', [ base64_encode(base64_encode($object->id)) ])}}" >
        	 		<input name="_method" type="hidden" value="PUT">

	              	<div class="box-body">
	              		<div class="row">

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
				            	<p style="font-weight:normal;padding:5px;background-color: #dff0d8;border-color: #d6e9c6;">
				            		<b>Note : </b> Please select either both prerequisites and exam or at least one of them.
				            	</p>	
				            </div>

			                <div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Prerequisites</label>
				                  		@php
				                  			$arr_prerequisites = json_decode($object->prerequisite_id);
				                  		@endphp
				                  		<select name="prerequisites[]" multiple id="prerequisites" class="form-control">
				                  			@if(!empty($prerequisites) && sizeof($prerequisites) > 0)
				                  				@foreach($prerequisites as $pkey => $prerequisite)
				                  					<option value="{{$prerequisite->id}}" @if(in_array($prerequisite->id, $arr_prerequisites)) selected @endif >{{ ucfirst($prerequisite->title) }}</option>
				                  				@endforeach
				                  			@endif
				                  		</select>
				                  	</select>
				                </div>
	              			</div>	 

	              			<div class="col-md-6">
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

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Course Fee (AED)<span style="color: red">*</span></label>
				                  	<input type="text" oninput="return calculateAmount(this)" value="{{ $object->amount }}" placeholder="Course Fee (AED)" name="amount" id="amount" class="form-control">
				                	<span class="err_amount" style="color: red"></span>
				                </div>
	              			</div>	

	              			<div class="col-md-2">
				                <div class="form-group">
				                  	<label for="">Discount</label>
				                  	<input type="text"  oninput="return calculateAmount(this)" value="{{ $object->discount }}" placeholder="Course Discount" name="discount" id="discount" class="form-control">
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
				                  	<input type="number" readonly placeholder="Calculated Course Fee (AED)" value="{{ $object->calculated_amount }}" name="calculated_amount" id="calculated_amount" class="form-control">
				                	<span class="err_calculated_amount" style="color: red"></span>
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
	              						<img id="preview"  src="{{ $featured }}" alt="Featured Image" width="125px" height="125px" />
	              						<input type="hidden" name="old_image" value="{{ $object->featured_image_thumbnail }}" id="old_image">
	              					</div>
	              				</div>

	              				<div class="row" id="delete_button" @if(empty($show))style="display: none"@endif>
				                	<div class="col-md-2" > 
				                		<a  href="javascript:void(0)" onclick="deletePreviewImage(this)" class="btn btn-danger form-control" style="margin-left: 5px">Delete</a>
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
		var defaultImaage = "{{ url('/storage/prerequisite/no-image.png') }}";
	</script>
	<script type="text/javascript" src="{{ asset('plugins/multiselect/bootstrap-multiselect.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/input-mask/mask.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/course/create&edit.js') }}"></script>
@stop