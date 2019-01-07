@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/tomorrow.min.css">
	<style type="text/css">
		.titleWrap h3 a {color: #fff;text-decoration: none;}
		.error_voucher_code.error {color: red;}
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
							<div class="row">
								<div class="col-xs-12">
									@if($bookingStatus == 'new')
										<a href="{{ url('/exam/book/'.base64_encode(base64_encode($arrCourse->id))) }}" class="btn btn-primary">Book Exam</a>
									@elseif($bookingStatus == 'rescheduled')
										<form action="{{ route('purchase') }}" onsubmit="return makePayment(this)">
											<input type="hidden" name="pud" value="{{ base64_encode(base64_encode(auth()->user()->id)) }}">
											<input type="hidden" name="pcd" value="{{base64_encode(base64_encode($arrCourse->id)) }}">
											<input type="hidden" name="payment_type" value="">
											<button type="submit" class="btn btn-primary">Book Exam</button>
											<a href="javascript:void(0)" data-toggle="modal" data-target="#myVoucherModal">Apply Voucher</a>
										</form>	
									@else
										@if($bookingStatus == 'hasExamAccess')
											<span><a onclick="return startExam(this)" data-token="{{$arrCourse->id}}" class="btn btn-info">Take Exam</a></span>
										@endif
									@endif
								</div>
							</div>

							@if(!empty($arrPrerequisites) && sizeof($arrPrerequisites) > 0)
							<h3>Prerequisites Listing</h3>
							<hr />
							<div class="row">
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
							</div>
							@else
								<div class="row"><br>
								<div class="col-xs-12">
						 			<p>No prerequisite content available.</p>
								</div>
							</div>
							@endif
						</div>
					</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myVoucherModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Apply Voucher</h4>
        </div>
        <div class="modal-body">
          <form method="post" name="applyVoucherFrm" id="applyVoucherFrm" method="post" action="{{ url('/certification/applyVoucher') }}" onsubmit="return applyVoucher(this)">
          	<div class="form-group">
          		<label>Voucher Code : </label>
          		<input type="text" name="voucher_code" id="voucher_code" placeholder="Enter a Voucher Code" class="form-control">
          		<span class="error_voucher_code error"></span>
          		<input type="hidden" name="courses_id" value="{{$arrCourse->id}}">
				<input type="hidden" name="user_id" value="{{ base64_encode(base64_encode(auth()->user()->id)) }}">
				<input type="hidden" name="course_price" value="{{$arrCourse->calculated_amount}}">
          	</div>
          	<button type="submit" name="btnApply" class="btn btn-primary btnApply" id="btnApply">Apply</button>
          	<img src="{{asset('images/ajax-loader.gif')}}" class="loadingImg" alt="logo" />
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

@stop

@section('scripts')
	<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js'></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script> -->
	<script src="https://www.youtube.com/iframe_api"></script>
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/front/course/details.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/front/course/video.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/front/voucher/applyVoucher.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/front/certification/details.js') }}"></script>
@stop