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

        	 	<form onsubmit="return saveFormData(this)" action="{{route($modulePath.'.update',[base64_encode(base64_encode($object->id))])}}" >
        	 		<input name="_method" type="hidden" value="PUT">
	              	<div class="box-body">
	              		<div class="row">

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Title <span style="color: red">*</span></label>
					                  	<input type="text" name="title" value="{{ $object->title }}" id="title" class="form-control" placeholder="Enter Title" maxlength="100">
				                  	</select>
				                </div>
	              			</div>
	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Question Category <span style="color: red">*</span></label><br>
					                  	<select name="category[]" multiple="multiple" id="category" class="form-control" data >
					                  		@if(!empty($categories))
					                  			@foreach($categories as $key => $category)
					                  				<option value="{{ $category->id }}" @if(in_array($category->id, $object_quesitons_categories)) selected  @endif >{{ $category->category_name }}</option>
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
					                  		@if(!empty($all_categories_questions))
					                  			@foreach($all_categories_questions as $key => $categories_question)
					                  				<option value="{{ $categories_question->id }}" @if(in_array($categories_question->id, $object_quesitons)) selected  @endif >{{ $categories_question->question_text }}</option>
					                  			@endforeach
					                  		@endif
					                  	</select>
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Duration (Hrs) <span style="color: red">*</span></label>
					                  	<input type="text" maxlength="2" value="{{ $object->duration }}" name="duration" id="duration" class="form-control" placeholder="Enter duration (Hrs)" >
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Total Number Of Questions <span style="color: red">*</span></label>
				                  	<input type="text" maxlength="3" value="{{ $object->total_question }}" name="total_question" id="total_question" class="form-control" placeholder="50" maxlength="6">
				                </div>
	              			</div>

              				<div class="exam_days_wrapper">
								@if(!empty($slots)) 
									@foreach($slots as $slot_key => $slot)
										<div class="exam_days_div">
					              			<div class="col-md-9">
								                <div class="form-group">
								                  	<label for="">Exam Days <span style="color: red">*</span></label><br>
									                  	<select name="exam_days[{{ $slot_key }}][day]" class="form-control exam_days">
									                  		@if(!empty($weekdays))
									                  			@foreach($weekdays as $key => $day)
									                  				<option value="{{ strtolower($day) }}" @if(strtolower($day) == $slot['day']) selected @endif >{{ $day }}</option>
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
											                    <input type='text' name="exam_days[{{ $slot_key }}][start_time][]" value="<?php echo !empty($slot['time'][0]->start_time) ? $slot['time'][0]->start_time : '' ?>" class="form-control start_time" />
											                    <span class="input-group-addon" >
											                        <span class="glyphicon glyphicon-time"></span>
											                    </span>
											                </div>
								                  		</div>
								                  		@if($slot_key == 0)
									                  		<div class="col-md-2">
																<a class="btn btn-info add_new_slot" onclick="return addNewSlot(this)"><i class="fa fa-plus"></i></a>
									                  		</div>
								                  		@else
								                  			<div class="col-md-3" style="white-space:nowrap;">
																<a class="btn btn-info add_new_slot" onclick="return addNewSlot(this)"><i class="fa fa-plus"></i></a>
									                  			&nbsp;&nbsp;&nbsp;
								      							<a href="javascript:void(0)" class="remove_day" onclick="return removeDay(this)" ><i class="fa fa-trash" style="color: red;font-size: 20px;" title="Delete"></i></a>
									                  		</div>
								                  		@endif
								                  	</div>
								                </div>
					              			</div>
					              			<div class="col-md-1">
					              			</div>

					              			@if(!empty($slot['time']))
					              				@foreach($slot['time'] as $time_key => $time)
					              					@if($time_key >= 1)
						              					<div class="start_time_div">
															<div class="col-md-9">
												            <div class="form-group">
												            </div>
															</div>
															<div class="col-md-2">
												            <div class="form-group">
												              	<label for="">Start Time</label><br>
												              	<div class="row">
												              		<div class="col-md-9">
												              			<div class='input-group datetimepicker' >
														                    <input type='text' name="exam_days[{{ $slot_key }}][start_time][]" value="{{ $time->start_time }}" class="form-control start_time" />
														                    <span class="input-group-addon" >
														                        <span class="glyphicon glyphicon-time"></span>
														                    </span>
														                </div>
												              		</div>
												              		<div class="col-md-2">
																		<a class="btn btn-danger remove_new_slot" onclick="return removeNewSlot(this)"><i class="fa fa-trash"></i></a>
												              		</div>
												              	</div>
												            </div>
															</div>
														</div>
													@endif
												@endforeach
											@endif

			              				</div>
		              				@endforeach
								@else
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
		              			@endif

	              				<div class="col-md-12">
									<a class="btn btn-info add_new_day" onclick="return addNewDay(this)" style="float: right;">Add more exam days</a>
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
	              			</div> -->	

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
	<script type="text/javascript" src="{{ asset('plugins/input-mask/mask.js') }}"></script>
	
	<script type="text/javascript" src="{{ asset('js/admin/exam/create&edit.js') }}"></script>
@stop