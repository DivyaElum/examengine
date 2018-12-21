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

	              			<div class="col-md-12">
	              				<label>Video Type <span style="color: red">*</span></label>
				                <div class="form-group">
								    <label class="radio-inline">
								      <input type="radio" onclick="setVideoType(true)" name="type" checked value="file">Video File
								    </label>
								    <label class="radio-inline">
								      <input type="radio" onclick="setVideoType(true)" name="type" value="pdf">Pdf File
								    </label>
								    <label class="radio-inline">
								      <input type="radio" onclick="setVideoType(true)" name="type" value="url">Video URL
								    </label>
								    <label class="radio-inline">
								      <input type="radio" onclick="setVideoType(true)" name="type" value="youtube">Youtube URL
								    </label>
				                </div>
	              			</div>	

	              			<div class="col-md-12 options file" style="display: none;">
				                <div class="form-group">
				                  	<label for="">Video File</label>
					                  	<input type="file"  name="video_file" accept=".mpg,.mpeg,.avi,.wmv,.mov,.rm,.ram,.swf,.flv,.ogg,.webm,.mp4" id="video_file" class="form-control option_input" >
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12 options pdf" style="display: none;">
				                <div class="form-group">
				                  	<label for="">Pdf File</label>
					                  	<input type="file"  name="pdf_file" accept=".pdf" id="pdf_file" class="form-control option_input" >
				                  	</select>
				                </div>
	              			</div>

	              			<div class="col-md-12 options url" style="display: none;">
				                <div class="form-group">
				                  	<label for="">Video URL</label>
					                  	<input type="text" name="video_url" id="video_url" class="form-control option_input" placeholder="Enter Video URL" >
				                  	</select>
				                </div>
	              			</div>	

	              			<div class="col-md-12 options youtube" style="display: none;" >
				                <div class="form-group">
				                  	<label for="">Youtube URL</label>
					                  	<input type="text" name="youtube_url" id="youtube_url" class="form-control option_input" placeholder="Enter Youtube URL">
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
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/prerequisite/create&edit.js') }}"></script>
@stop