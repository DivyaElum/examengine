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

        	 	<form onsubmit="return saveFormData(this)" action="{{route($modulePath.'.update',[base64_encode(base64_encode($object->id))])}}" enctype="multipart/form-data" >
        	 		<input name="_method" type="hidden" value="PUT">
	              	<div class="box-body">
	              		<div class="row">

	              			<div class="col-md-12">
				        		<p class="alert" style="background-color: #d9edf7 !important">
				        			<b>NOTE : </b> <br>
				    				<b>Exam fee calculated as : </b><br>
				    				1. If there is a commercial percentage then <b>Fee = ((Exam Fee*Discount)/100). </b><br>	
				    				2. If there is a commercial flat then <b>Fee = Commercial Flat Rate. </b>
				    				<br>
				    				<b>Featured Image : </b><br>
				    				1. Only png, gif, jpeg image formats are allowed.
				    			</p>
				            </div>

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Title <span style="color: red">*</span></label>
					                  	<input type="text" name="title" value="{{ $object->title }}" id="title" class="form-control" placeholder="Enter Title" maxlength="100">
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12">
				                <div class="form-group">
				                  	<label for="">Description <span style="color: red">*</span></label>
				                  	<textarea  name="description" id="description" class="form-control" placeholder="Enter Description" >{{ $object->description }}</textarea>
				                </div>
				            </div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Question Categories <span style="color: red">*</span></label><br>
				                  	<select name="category[]" multiple="multiple" id="category" class="form-control" data >
				                  		@if(!empty($categories))
				                  			@foreach($categories as $key => $category)
				                  				@if(!empty($category->questions) && sizeof($category->questions)>0)
					                  				<option value="{{ $category->id }}" @if(in_array($category->id, $object_quesitons_categories)) selected  @endif >{{ $category->category_name }}</option>
				                  				@endif
				                  			@endforeach
				                  		@endif
				                  	</select>
			                  		@php 
		                  				$questionsAdded = !empty($all_categories_questions) ? count($all_categories_questions) : 0; 
			                  		@endphp
				                </div>
	              			</div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Compulsory Questions </label><br>
				                  	<select name="exam_questions[]"  multiple="multiple" id="exam_questions" class="form-control">
				                  		@if(!empty($all_categories_questions))
				                  			@foreach($all_categories_questions as $key => $categories_question)
				                  				<option value="{{ $categories_question->id }}" @if(in_array($categories_question->id, $object_quesitons)) selected  @endif >{{ $categories_question->question_text }}</option>
				                  			@endforeach
				                  		@endif
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12">
			            		<p class="alert" style="background-color: #dff0d8 !important">
			            			@php 
		                  				$questionsAdded = !empty($all_categories_questions) ? count($all_categories_questions) : 0; 
			                  		@endphp
		            				<label>Total Question Available : &nbsp; </label><span id="questionsCount"> {{ $questionsAdded }}</span>
		            			</p>
				            </div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Duration (HH.MM) <span style="color: red">*</span></label>
					                  	<input type="text" maxlength="2" value="{{ $object->duration }}"  oninput="return checkTimeSlots()" name="duration" id="duration" class="form-control" placeholder="Duration (HH.MM)" >
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-6">
				                <div class="form-group">
				                  	<label for="">Total Number Of Questions <span style="color: red">*</span></label>
				                  	<input type="text" maxlength="3" value="{{ $object->total_question }}" name="total_question" id="total_question" class="form-control" placeholder="50" maxlength="6">
				                </div>
	              			</div>

	              			<div class="col-md-4">
				                <div class="form-group">
				                  	<label for="">Exam Fee<span style="color: red">*</span></label>
				                  	<input type="text" value="{{ $object->amount }}" oninput="return calculateAmount(this)" placeholder="Exam Fee" name="amount" id="amount" class="form-control">
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
				                  	<input type="text" value="0" value="{{ $object->discount }}"  oninput="return calculateAmount(this)" placeholder="Exam Discount" name="discount" id="discount" class="form-control">
				                	<span class="err_discount " style="color: red"></span>
				                </div>
	              			</div>	

	              			<div class="col-md-2">
				                <div class="form-group">
				                  	<label for="">Discount By</label>
				                  	<select name="discount_by" onchange="return calculateAmount(this)" id="discount_by" class="form-control">
				                  		<option value="Flat" @if($object->discount_by == 'Flat') selected @endif >Flat</option>
				                  		<option value="%" @if($object->discount_by == '%') selected @endif>%</option>
				                  	</select>
				                  	{{-- <span class="err_calculated_amount " style="color: red"></span> --}}
				                </div>
	              			</div>

	              			<div class="col-md-2">
				                <div class="form-group">
				                  	<label for="">Calculated Exam Fee<span style="color: red">*</span></label>
				                  	<input type="text" readonly value="{{ $object->calculated_amount }}" placeholder="Calculated Exam Fee" name="calculated_amount" id="calculated_amount" class="form-control">
				                	<span class="err_calculated_amount " style="color: red"></span>
				                </div>
	              			</div> 

	              			<div class="clear"></div>
              				<div class="col-md-12">
	              				<div class="exam_days_wrapper clearfix">
	              					@if(!empty($slots)) 
										@foreach($slots as $slot_key => $slot)
											<div class="exam_days_div clearfix">
						              			{{-- <div class="col-md-12">
									                <div class="form-group">
									                  	<label for="">Exam Days <span style="color: red">*</span></label><br>
									                  	<div class="row">
									                  		<div class="col-md-11">
											                  	<select name="exam_days[{{ $slot_key }}][day]" class="form-control exam_days">
											                  		@if(!empty($weekdays))
											                  			@foreach($weekdays as $key => $day)
											                  				<option value="{{ strtolower($day) }}" @if(strtolower($day) == $slot['day']) selected @endif >{{ $day }}</option>
											                  			@endforeach
											                  		@endif
											                  	</select>
									                  		</div>
									                  		<div class="col-md-1">
									                  			@if($slot_key == 0)
																 	<a class="btn btn-info add_new_day" title="Add new exam day" onclick="return addNewDay(this)"><i class="fa fa-plus"></i></a>
									                  			@else
																	<a class="btn btn-danger remove_day" title="Remove exam day" onclick="return removeDay(this)"><i class="fa fa-trash"></i></a>
									                  			@endif
									                  		</div>
									                  	</div>
									                </div>
						              			</div> --}}

						              			<div class="input-daterange">
							              			<div class="col-md-6 form-group">
							              				<label for="">Start Date <span style="color: red">*</span></label>
							                  			<input type="text" name="start_date" value="<?php echo Date('m/d/Y', strtotime($object->start_date) ); ?>" readonly style="background-color: white" id="start_date" class="form-control start_date"  placeholder="Start Date">
							                  		</div>
							                  		<div class="col-md-6 form-group">
							              				<label for="">End Date <span style="color: red">*</span></label>
							                  			<input type="text" name="end_date" value="<?php echo Date('m/d/Y', strtotime($object->end_date) ); ?>" readonly style="background-color: white" id="end_date" class="form-control end_date" placeholder="End Date">
							                  		</div>
				              					</div>

						              			@if(!empty($slot['time']))
					              					@foreach($slot['time'] as $time_key => $time)
					              						<div class="time_wrapper">
									              			<div class="col-md-4 start_time_wrapper">
								                  				<label for="">Start Time <span style="color: red">*</span></label><br>
									                  			<div class='input-group form-group datetimepicker' >
												                    <input type='text' placeholder="Start Time" onblur="return getEndTime(this)" value="{{ $time->start_time }}" name="exam_days[{{ $slot_key }}][start_time][]" class="form-control start_time" />
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
														                    <input type='text' placeholder="End Time" readonly name="exam_days[{{ $slot_key }}][end_time][]" value="{{ $time->end_time }}" class="form-control end_time" />
														                    <span class="input-group-addon" >
														                        <span class="glyphicon glyphicon-time"></span>
														                    </span>
														                </div>
												                	</div>
									              					<div class="col-md-3">
									              						@if($time_key == 0)
																			<a class="btn btn-info add_new_slot" title="Add new time slot" onclick="return addNewSlot(this)"><i class="fa fa-plus"></i></a>
									              						@else
																			<a class="btn btn-danger remove_new_slot" title="Remove time slot" onclick="return removeNewSlot(this)"><i class="fa fa-trash"></i></a>
									              						@endif
									              					</div>
									              				</div>
									              			</div>
							              				</div>
						              				@endforeach
						              			@else
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
						              			@endif
				              				</div>
										@endforeach
									@else
			              				<div class="exam_days_div clearfix">
				              			<div class="col-md-12">
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
				              			</div>
				              			<div class="time_wrapper">
					              			<div class="col-md-4 start_time_wrapper">
				                  				<label for="">Start Time <span style="color: red">*</span></label><br>
					                  			<div class='input-group form-group datetimepicker' >
								                    <input type='text' onblur="return getEndTime(this)" name="exam_days[0][start_time][]" class="form-control start_time" />
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
										                    <input type='text' readonly name="exam_days[0][end_time][]" class="form-control end_time" />
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
			              			@endif
	              				</div>
              				</div>

              				<div class="col-md-12">
	              				<div class="row">
	              					<div class="col-md-2">
	              						@php 
	              							if(file_exists(storage_path('app/public/exam/featuredImageThumbnails/'.$object->featured_image_thumbnail)) && !empty($object->featured_image_thumbnail))
	              							{
	              								$featured = url('/storage/exam/featuredImageThumbnails/'.$object->featured_image_thumbnail);
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

  		var defaultImaage = "{{ url('/images/no-image.png') }}";    
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