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
		.prerequisite_div { border: 1px solid #ccc; padding: 15px 0; background: #f3f3f3; margin: 15px 0;}

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
		            				<br><b> Video/PDF upload : </b><br>
		            				1. Max video file size limit 2 MB	<br>
		            				2. Max pdf file size limit 2 MB	
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

	              			@if(!empty($object->prerequisites) && sizeof($object->prerequisites) > 0)
              					<div class="clear"></div>
      							<div class="col-md-12">
              						<div class="prerequisite_wrapper clearfix">
              							@foreach($object->prerequisites as $key => $row )

		              						<div class="prerequisite_div clearfix">
						              			
              									<input type="hidden" name="prerequisite[{{ $key }}][pd]" value="{{ base64_encode(base64_encode($row->id)) }}">

						              			<div class="col-md-12">
									                <div class="form-group">
									                  	<label for="">Display name <span style="color: red">*</span></label>
									                  	<div class="row">
									                  		<div class="col-md-11">
										                  		<input type="text" name="prerequisite[{{ $key }}][title]" value="{{ $row->title }}" class="form-control title" placeholder="Enter display name" maxlength="200">
									                  		</div>
									                  		<div class="col-md-1">
									                  			@if($key > 0)
									                  				<a class="btn btn-danger remove_new_slot" title="Remove time slot" onclick="return removePrerequisite(this)"><i class="fa fa-trash"></i></a>
									                  			@endif
									                  		</div>
									                  	</div>
									                </div>
						              			</div>	

						              			<div class="col-md-11">
						              				<label>Type <span style="color: red">*</span></label>
									                <div class="form-group">
													    <label class="radio-inline">
													      <input type="radio" onclick="setVideoType(this)" @if(!empty($row->video_file)) checked  @endif name="prerequisite[{{ $key }}][type]" class="radiobutton" checked value="file">Video File
													    </label>
													    <label class="radio-inline">
													      <input type="radio" onclick="setVideoType(this)" @if(!empty($row->pdf_file)) checked  @endif name="prerequisite[{{ $key }}][type]" class="radiobutton" value="pdf">Pdf File
													    </label>
													    <label class="radio-inline">
													      <input type="radio" onclick="setVideoType(this)" @if(!empty($row->video_url)) checked  @endif name="prerequisite[{{ $key }}][type]" class="radiobutton" value="url">Video URL
													    </label>
													    <label class="radio-inline">
													      <input type="radio" onclick="setVideoType(this)" @if(!empty($row->youtube_url)) checked  @endif name="prerequisite[{{ $key }}][type]" class="radiobutton" value="youtube">Youtube URL
													    </label>
													    <label class="radio-inline">
													      <input type="radio" onclick="setVideoType(this)" @if(!empty($row->other)) checked  @endif name="prerequisite[{{ $key }}][type]" class="radiobutton" value="other">Other
													    </label>
									                </div>
						              			</div>	

						              			<div class="col-md-11 options file" @if(empty($row->video_file)) style="display: none;"  @endif >
									                <div class="form-group">
									                  	<label for="">Video File</label>
									                  	<input type="file"  name="prerequisite[{{ $key }}][video_file]" accept=".mpg,.mpeg,.avi,.wmv,.mov,.rm,.ram,.swf,.flv,.ogg,.webm,.mp4"  class="video_file form-control option_input" ><br>
									                	<div @if(empty($row->video_file)) style="display: none;" @endif >
									                		<label for="">Old Video File</label>
									                		<input type="text"  name="prerequisite[{{ $key }}][old_video_file]" value="{{ $row->video_file_original_name }}" class="form-control" readonly >
									                	</div>
									                </div>
						              			</div>

						              			<div class="col-md-11 options pdf" @if(empty($row->pdf_file)) style="display: none;"  @endif >
									                <div class="form-group">
									                  	<label for="">Pdf File</label>
									                  	<input type="file"  name="prerequisite[{{ $key }}][pdf_file]" accept=".pdf" class="pdf_file form-control option_input" ><br>
									                	<div @if(empty($row->pdf_file)) style="display: none;"  @endif>
									                		<label for="">Old Pdf File</label>
									                		<input type="text"  name="prerequisite[{{ $key }}][old_pdf_file]" value="{{ $row->pdf_file_original_name }}" class="form-control" readonly>
									                	</div>
									                </div>
						              			</div>

						              			<div class="col-md-11 options url" @if(empty($row->video_url)) style="display: none;"  @endif >
									                <div class="form-group">
									                  	<label for="">Video URL</label>
									                  	<input type="text" name="prerequisite[{{ $key }}][video_url]" value="{{ $row->video_url }}" class="video_url form-control option_input" placeholder="Enter Video URL" >
									                </div>
						              			</div>	
			              			
						              			<div class="col-md-11 options youtube" @if(empty($row->youtube_url)) style="display: none;"  @endif >
									                <div class="form-group">
									                  	<label for="">Youtube URL</label>
									                  	<input type="text" name="prerequisite[{{ $key }}][youtube_url]" value="{{ $row->youtube_url }}" class="youtube_url form-control option_input" placeholder="Enter Youtube URL">
									                </div>
						              			</div>	

						              			<div class="col-md-11 options other" @if(empty($row->other)) style="display: none;"  @endif >
									                <div class="form-group">
									                  	<label for="">Other</label>
									                  	<textarea type="text" name="prerequisite[{{ $key }}][other]" class="other_input form-control option_input" placeholder="Enter Description">{{ $row->other }}</textarea>
									                </div>
						              			</div>	
      										</div>
										@endforeach
          							</div>
      							</div>
								<div class="col-md-12">
	  								<div class="form-group">
      									<a style="float: right;margin-bottom: 20px" class="btn btn-info add_new_prerequisite" title="Add new" onclick="return addNewPrerequisite()"><i class="fa fa-plus"></i> &nbsp;Add More</a>
	  								</div>
  								</div>
	              			@else
	              				<div class="clear"></div>
              					<div class="col-md-12">
	              					<div class="prerequisite_wrapper clearfix">
			              			<div class="prerequisite_div clearfix">
				              			<div class="col-md-12">
							                <div class="form-group">
							                  	<label for="">Display name <span style="color: red">*</span></label>
							                  	<div class="row">
							                  		<div class="col-md-11">
								                  		<input type="text" name="prerequisite[0][title]" class="form-control title" placeholder="Enter display name" maxlength="200">
							                  		</div>
							                  		<div class="col-md-1">
							                  		</div>
							                  	</div>
							                </div>
				              			</div>	

				              			<div class="col-md-11">
				              				<label>Type <span style="color: red">*</span></label>
							                <div class="form-group">
											    <label class="radio-inline">
											      <input type="radio" onclick="setVideoType(this)" name="prerequisite[0][type]" class="radiobutton" checked value="file">Video File
											    </label>
											    <label class="radio-inline">
											      <input type="radio" onclick="setVideoType(this)" name="prerequisite[0][type]" class="radiobutton" value="pdf">Pdf File
											    </label>
											    <label class="radio-inline">
											      <input type="radio" onclick="setVideoType(this)" name="prerequisite[0][type]" class="radiobutton" value="url">Video URL
											    </label>
											    <label class="radio-inline">
											      <input type="radio" onclick="setVideoType(this)" name="prerequisite[0][type]" class="radiobutton" value="youtube">Youtube URL
											    </label>
											    <label class="radio-inline">
											      <input type="radio" onclick="setVideoType(this)" name="prerequisite[0][type]" class="radiobutton" value="other">Other
											    </label>
							                </div>
				              			</div>	

				              			<div class="col-md-11 options file">
							                <div class="form-group">
							                  	<label for="">Video File</label>
							                  	<input type="file"  name="prerequisite[0][video_file]" accept=".mpg,.mpeg,.avi,.wmv,.mov,.rm,.ram,.swf,.flv,.ogg,.webm,.mp4"  class="video_file form-control option_input" >
							                </div>
				              			</div>

				              			<div class="col-md-11 options pdf" style="display: none;">
							                <div class="form-group">
							                  	<label for="">Pdf File</label>
							                  	<input type="file"  name="prerequisite[0][pdf_file]" accept=".pdf" class="pdf_file form-control option_input" >
							                </div>
				              			</div>

				              			<div class="col-md-11 options url" style="display: none;">
							                <div class="form-group">
							                  	<label for="">Video URL</label>
							                  	<input type="text" name="prerequisite[0][video_url]" class="video_url form-control option_input" placeholder="Enter Video URL" >
							                </div>
				              			</div>	
				              			
				              			<div class="col-md-11 options youtube" style="display: none;" >
							                <div class="form-group">
							                  	<label for="">Youtube URL</label>
							                  	<input type="text" name="prerequisite[0][youtube_url]" class="youtube_url form-control option_input" placeholder="Enter Youtube URL">
							                </div>
				              			</div>	

				              			<div class="col-md-11 options other" style="display: none;" >
							                <div class="form-group">
							                  	<label for="">Other</label>
							                  	<textarea type="text" name="prerequisite[0][other]" class="other_input form-control option_input" placeholder="Enter Description"></textarea>
							                </div>
				              			</div>	
		              				</div>
	              					</div>
	              				</div>
      							<div class="col-md-12">
      							<div class="form-group">
      								<a style="float: right;margin-bottom: 20px" class="btn btn-info add_new_prerequisite" title="Add new" onclick="return addNewPrerequisite()"><i class="fa fa-plus"></i> &nbsp;Add More</a>
      							</div>
      							</div>
      						@endif

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