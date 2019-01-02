@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/tomorrow.min.css">
	<style type="text/css">
		.titleWrap h3 a {color: #fff;text-decoration: none;}
	</style>
@stop

@section('page_title')
	{{ $page_title }}
@stop

@section('content')
	<div class="bodyContent dashboard clearfix">
	<div class="dashboardWraper">
		<div class="container">
			<div class="row">
				@include('front.partials._sidebar')
				<div class="col-md-9 col-sm-12 col-xs-12">
					<div class="dashbaord_content">
						<h3>Prerequisites Listing</h3>
						<hr />
						<div class="row">
							
							@if($bookingStatus == 'new' || $bookingStatus == 'rescheduled' )
								<a href="{{ url('/exam/exam-book/'.base64_encode(base64_encode($arrCourse->id))) }}" class="btn btn-primary">Book Exam</a>
							@endif
							
							@if($bookingStatus == 'pending' )
								<span><a onclick="return startExam(this)" data-token="{{$arrCourse->id}}" class="btn btn-info">Take Exam</a></span>
							@endif

							@if(!empty($arrPrerequisites) && sizeof($arrPrerequisites) > 0)
								@php 
								foreach($arrPrerequisites as $row) 
								{ 
									@endphp
									<div class="col-md-6 col-sm-6 col-xs-6 col-12">
									<div class="thumbImg">
										<img src="images/dashboard/thumb-img.jpg" alt="" class="img-responsive">
									</div>
									<div class="thumbCont">
										<div class="title">
											<p><b>Title </b>: {{$row->title }}</p>
											
											<?php 
											if($row->video_file_original_name != '') 
											{
												?>
												<video width="320" height="240" controls>
												  	<source src="{{ url('storage/'.$row->video_file) }}" type="video/{{ $row->video_file_mime }}">
													Your browser does not support the video tag.
												</video>
													<p><b>Video Name </b>: <a href="{{$row->video_file_original_name }}" target="_blank"> {{$row->video_file_original_name }}</a></p>
												<?php 
											}
											elseif($row->video_url != '')
											{ 
												?>
												<p><b>Video Name </b>: {{$row->video_file_original_name }}</p>
												<p><b>Video URL </b>:<a href="{{$row->video_url }}" target="_blank"> {{$row->video_url }}</a></p>
												<?php 
											}
											else
											{ 
												?>
												<p><b>Video Name </b>: {{$row->video_file_original_name }}</p>
												<p><b>Youtube Video URL </b>: <a href="{{$row->youtube_url }}" target="_blank"> {{$row->youtube_url }}</a></p>
												
												<script type="text/javascript">
													var youtubeUrl 		= "{{ $row->youtube_url }}";
													var user_id 		= "{{ base64_encode(base64_encode(auth()->user()->id)) }}";
													var course_id 		= "{{ base64_encode(base64_encode($arrCourse->id)) }}";
													var prerequisite_id = "{{ base64_encode($enc_prerequisites) }}";

												</script>
												<script type="text/javascript" src="{{ asset('js/front/course/video.js') }}"></script>
												<script type="text/javascript" src="{{ asset('js/front/course/savePreStatus.js') }}"></script>
												<?php 
											}
											?>
										</div>
									</div>
									</div>
									@php 
								}
								@endphp
								<div id="video-placeholder"></div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
@stop

@section('scripts')
	<script src='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js'></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
	<script src="https://www.youtube.com/iframe_api"></script>
	<script type="text/javascript" src="{{ asset('/js/front/course/details.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/front/course/video.js') }}"></script>
@stop