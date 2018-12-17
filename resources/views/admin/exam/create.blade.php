@extends('admin.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datepicker/bootstrap-datetimepicker.css') }}">
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
				                  	<label for="">Title <span style="color: red">*</span></label>
					                  	<input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" maxlength="100">
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Question Category <span style="color: red">*</span></label><br>
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

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Questions <span style="color: red">*</span></label><br>
					                  	<select name="exam_questions[]"  multiple="multiple" id="exam_questions" class="form-control">
					                  	</select>
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Duration (Hrs) <span style="color: red">*</span></label>
					                  	<input type="text" maxlength="2" name="duration" id="duration" class="form-control" placeholder="Enter duration (Hrs)" >
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Total Number Of Questions <span style="color: red">*</span></label>
				                  	<input type="text" maxlength="3" name="total_question" id="total_question" class="form-control" placeholder="50" maxlength="6">
				                </div>
	              			</div>


              				<div class="exam_days_wrapper">

		              			<div class="exam_days_div">
			              			<div class="col-md-9">
						                <div class="form-group">
						                  	<label for="">Exam Days <span style="color: red">*</span></label><br>
							                  	<select name="exam_days[0][day]" class="form-control exam_days">
							                  		@if(!empty($weekdays))
							                  			@foreach($weekdays as $key => $day)
							                  				<option value="{{ strtolower($day) }}">{{ $day }}</option>
							                  			@endforeach
							                  		@endif
							                  	</select>
						                  	</select>
						                </div>
			              			</div>
			              			<div class="col-md-2">
						                <div class="form-group">
						                  	<label for="">Start Time <span style="color: red">*</span></label><br>
						                  	<div class="row">
						                  		<div class="col-md-9">
						                  			<div class='input-group datetimepicker' >
									                    <input type='text' name="exam_days[0][start_time][]" class="form-control start_time" />
									                    <span class="input-group-addon" >
									                        <span class="glyphicon glyphicon-time"></span>
									                    </span>
									                </div>
						                  		</div>
						                  		<div class="col-md-2">
													<a class="btn btn-info add_new_slot" onclick="return addNewSlot(this)"><i class="fa fa-plus"></i></a>
						                  		</div>
						                  	</div>
						                </div>
			              			</div>
			              			<div class="col-md-1">
			              			</div>
		              			</div>

	              				<div class="col-md-12">
									<a class="btn btn-info add_new_day" onclick="return addNewDay(this)" style="float: right;">Add more exam days</a>
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
	
	<script>
		var daysOptions = '';
		@if(!empty($weekdays))
  			@foreach($weekdays as $key => $day)
  				var value = "{{ strtolower($day) }}";
  				var title = "{{ $day }}";
  				daysOptions = daysOptions + '<option value="'+value+'">'+title+'</option>';
  			@endforeach
  		@endif	    
	</script>

	<script type="text/javascript" src="{{ asset('plugins/datepicker/moment.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datepicker/bootstrap-datetimepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/multiselect/bootstrap-multiselect.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/exam/create&edit.js') }}"></script>
@stop