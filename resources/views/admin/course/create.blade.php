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
		            	<a title="Back" href="{{ route($modulePath.'.index') }}" class="btn btn-social btn-linkedin" ><i class="fa fa-arrow-left"></i>{{'Back'}}</a>
		          	</div>
	        	</div>

        	 	<form onsubmit="return saveFormData(this)" action="{{route($modulePath.'.store')}}" >
	              	<div class="box-body">
	              		<div class="row">

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Title <span style="color: red">*</span></label>
					                  	<input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" maxlength="200">
				                  	</select>
				                </div>
				            </div>

			                <div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Prerequisites</label>
				                  		<select name="prerequisites[]" id="prerequisites" class="form-control">
				                  			@if(!empty($prerequisites) && sizeof($prerequisites) > 0)
				                  				@foreach($prerequisites as $pkey => $prerequisite)
				                  					<option value="{{$prerequisite->id}}">{{ ucfirst($prerequisite->title) }}</option>
				                  				@endforeach
				                  			@endif
				                  		</select>
				                  	</select>
				                </div>
	              			</div>	 

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Exams</label>
					                  	<select name="exams[]" id="exams" class="form-control">
				                  			@if(!empty($exams) && sizeof($exams) > 0)
				                  				@foreach($exams as $pkey => $exam)
				                  					<option value="{{$exam->id}}">{{ ucfirst($exam->title) }}</option>
				                  				@endforeach
				                  			@endif
				                  		</select>
				                  	</select>
				                </div>
	              			</div>	

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Course Fee <span style="color: red">*</span></label>
				                  	<input type="text" placeholder="Course Fee" name="amount" id="amount" class="form-control">
				                </div>
	              			</div>	

	              			<div class="col-md-3">
				                <div class="form-group">
				                  	<label for="">Discount</label>
				                  	<input type="text" placeholder="Course Discount" name="amount" id="amount" class="form-control">
				                </div>
	              			</div>	

	              			<div class="col-md-1">
				                <div class="form-group">
				                  	<label for="">Discount By</label>
				                  	<select name="discount_by" id="discount_by" class="form-control">
				                  		<option value="Fee">Fee</option>
				                  		<option value="%">%</option>
				                  	</select>
				                </div>
	              			</div>	

	              			<div class="col-md-2">
				                <div class="form-group">
				                  	<label for="">Calculated Course Fee <span style="color: red">*</span></label>
				                  	<input type="text" readonly placeholder="Calculated Course Fee" name="calculated_amount" id="calculated_amount" class="form-control">
				                </div>
	              			</div>

	              			<div class="col-md-6">
	              				<img id="preview" src="{{ url('/storage/prerequisite/no-image.png')  }}" alt="Featured Image" style="width: 200px;height: 200px;" />
				                <div class="form-group">
				                  	<label for="">Featured Image </label>
				                  	<input type="file" name="featured_image" id="featured_image" onchange="readURL(this)" class="form-control">
				                </div>
	              			</div>

	              			<div class="col-md-12">
				                  	<label for="">Status <span style="color: red">*</span></label>
				                <div class="form-group">
				                  	<label class="radio-inline">
								      <input type="radio" name="status" checked value="1">Active
								    </label>
								    <label class="radio-inline">
								      <input type="radio" name="status" value="0">Inactive
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
	<script type="text/javascript">
		function readURL(input) 
		{
		  if (input.files && input.files[0]) {
		    var reader = new FileReader();

		    reader.onload = function(e) {
		      $('#preview').attr('src', e.target.result);
		    }

		    reader.readAsDataURL(input.files[0]);
		  }
		}
	</script>
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/course/create&edit.js') }}"></script>
@stop