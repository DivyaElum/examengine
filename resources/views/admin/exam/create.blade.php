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
		
		.input-daterange input {
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

        	 	<form onsubmit="return saveFormData(this)" action="{{route($modulePath.'.store')}}" enctype="multipart/form-data" >
	              	<div class="box-body">
	              		<div class="">

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Title <span style="color: red">*</span></label>
					                  	<input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" maxlength="100">
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Question Categories <span style="color: red">*</span></label><br>
				                  	<select name="category[]" multiple="multiple" id="category" class="form-control">
				                  		@if(!empty($categories))
				                  			@foreach($categories as $key => $category)
				                  				@if(!empty($category->questions) && sizeof($category->questions)>0)
				                  					<option value="{{ $category->id }}" >{{ $category->category_name }}</option>
				                  				@endif
				                  			@endforeach
				                  		@endif
				                  	</select>
              						
				                </div>
	              			</div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Compulsory Questions </label><br>
					                  	<select name="exam_questions[]"  multiple="multiple" id="exam_questions" class="form-control">
					                  	</select>
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12">
			            		<p class="alert" style="background-color: #00c0ef75 !important">
		            				<label>Questions Added : &nbsp; </label><span id="questionsCount"> 0</span>
		            			</p>
				            </div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Duration (HH.MM) <span style="color: red">*</span></label>
					                  	<input type="text" oninput="return checkTimeSlots()" maxlength="2" name="duration" id="duration" class="form-control" placeholder="Duration (HH.MM)" >
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Total Number Of Questions <span style="color: red">*</span></label>
				                  	<input type="text" maxlength="3" name="total_question" id="total_question" class="form-control" placeholder="50" maxlength="6">
				                </div>
	              			</div>

              				<div class="clear"></div>
              				<div class="col-md-12">
	              				<div class="exam_days_wrapper clearfix">
			              			<div class="exam_days_div clearfix">
				              			{{-- <div class="col-md-12">
							                <div class="form-group">
							                  	<label for="">Exam Days <span style="color: red">*</span></label><br>
							                  	<div class="row">
							                  		<div class="col-md-11">
									                  	<select name="exam_days[0][day]" class="form-control exam_days">
									                  		@if(!empty($weekdays))
									                  			@foreach($weekdays as $key => $day)
									                  				<option value="{{ strtolower($day) }}">{{ $day }}</option>
									                  			@endforeach
									                  		@endif
									                  	</select>
							                  		</div>
							                  		<div class="col-md-1">
														<a class="btn btn-info add_new_day" title="Add new exam day" onclick="return addNewDay(this)"><i class="fa fa-plus"></i></a>
							                  		</div>
							                  	</div>
							                </div>
				              			</div> --}}
				              			<div class="input-daterange">
					              			<div class="col-md-6 form-group">
					              				<label for="">Start Date <span style="color: red">*</span></label>
					                  			<input type="text" name="start_date" readonly style="background-color: white" id="start_date" class="form-control start_date"  placeholder="Start Date">
					                  		</div>
					                  		<div class="col-md-6 form-group">
					              				<label for="">End Date <span style="color: red">*</span></label>
					                  			<input type="text" name="end_date" readonly style="background-color: white" id="end_date" class="form-control end_date" placeholder="End Date">
					                  		</div>
				              			</div>
				              			<div class="time_wrapper">
					              			<div class="col-md-4 start_time_wrapper">
				                  				<label for="">Start Time <span style="color: red">*</span></label><br>
					                  			<div class='input-group form-group datetimepicker' >
								                    <input type='text' placeholder="Start Time" onblur="return getEndTime(this)" name="exam_days[0][start_time][]" class="form-control start_time" />
								                    <span class="input-group-addon" >
								                        <span class="glyphicon glyphicon-time"></span>
								                    </span>
								                </div>
					              			</div>
					              			<div class="col-md-5 end_time_wrapper">
					              				<label for="">End Time <span style="color: red">*</span></label><br>
					              				<div class="row">
					              					<div class="col-md-9">
					                  					<div class='input-group form-group' >
										                    <input type='text' placeholder="End Time" readonly name="exam_days[0][end_time][]" class="form-control end_time" />
										                    <span class="input-group-addon" >
										                        <span class="glyphicon glyphicon-time"></span>
										                    </span>
										                </div>
								                	</div>
					              					<div class="col-md-3">
														<a class="btn btn-info add_new_slot" title="Add new time slot" onclick="return addNewSlot(this)"><i class="fa fa-plus"></i></a>
					              					</div>
					              				</div>
					              			</div>
				              			</div>
			              			</div>
	              				</div>
              				</div>	

	              		</div>
	              	</div>

	              	<div class="box-footer">
              			<div class="col-md-12">
		                	<button type="submit" id="submit_button" class="btn btn-primary">Submit</button>
		            	</div>
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
	<script type="text/javascript" src="{{ asset('plugins/datepicker/bootstrap-datepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datepicker/bootstrap-datetimepicker.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/multiselect/bootstrap-multiselect.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/input-mask/mask.js') }}"></script>
	
	<script type="text/javascript" src="{{ asset('js/admin/exam/create&edit.js') }}"></script>
@stop