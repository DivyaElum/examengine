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
				                  	<label for="">Title</label>
					                  	<input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" maxlength="150">
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Question Category</label><br>
					                  	<select name="category[]" multiple="multiple" id="category" class="form-control">
					                  		@if(!empty($categories))
					                  			@foreach($categories as $key => $category)
					                  				<option value="{{ $category->id }}">{{ $category->category_name }}</option>
					                  			@endforeach
					                  		@endif
					                  	</select>
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Questions</label><br>
					                  	<select name="exam_questions[]" multiple="multiple" id="exam_questions" class="form-control">
					                  	</select>
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Duration (Hrs)</label>
					                  	<input type="number" name="duration" id="duration" class="form-control" placeholder="Enter duration (Hrs)" maxlength="2">
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Exam Days</label><br>
					                  	<select name="exam_days[]" multiple="multiple" id="exam_days" class="form-control">
					                  		@if(!empty($weekdays))
					                  			@foreach($weekdays as $key => $day)
					                  				<option value="{{ strtolower($day) }}">{{ $day }}</option>
					                  			@endforeach
					                  		@endif
					                  	</select>
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Time Slot</label>
					                  	<input type="number" name="time_slot" id="time_slot" class="form-control" placeholder="Time Slot" maxlength="6">
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Total Number Of Questions</label>
					                  	<input type="number" name="total_questions" id="total_questions" class="form-control" placeholder="50" maxlength="6">
				                  	</select>
				                </div>
	              			</div>

	              			
	              			<div class="col-md-12">
			                  	<label for="">Status </label>
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
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/multiselect/bootstrap-multiselect.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/exam/create&edit.js') }}"></script>
@stop