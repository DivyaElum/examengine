@extends('master')

@section('title')
	{{ $moduleAction }}
@stop


@section('styles')
<link href="{{ asset('/css/dashboard_style.css') }}" rel="stylesheet" type="text/css">
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
				<div class="col-md-3 mobile_db_drawer">
					<div class="mobile_db_drawer_btn">
						<i class="fa fa-arrow-right" aria-hidden="true"></i>
					</div>
					<div class="db_sidebar">
						<div class="dashboardTitle">Dashboard view</div>
						<div class="dashboardUser_bx">
							<div class="userName">{{$arrUserData->information->first_name}}  {{$arrUserData->information->last_name}}</div>
							<div class="userId">User id : #211090</div>
						</div>
						<div class="dbMenus">
							<ul>
								<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> View Profile</a></li>
								<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Account</a></li>
								<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Video Courses</a></li>
								<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> PDF files</a></li>
								<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Settings</a></li>
								<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Payment</a></li>
							</ul>				
						</div>
					</div>
				</div>

				<div class="col-md-9 col-sm-12 col-xs-12">
					<div class="dashbaord_content">
						<h3>Course Listing</h3>
						<hr />
						<div class="row">
							@php 
							foreach($arrUsersCourse as $row) { @endphp
								<div class="col-md-4 col-sm-6">
									<div class="card">
										@php 
	              							if(file_exists(storage_path('app/public/course/featuredImageThumbnails/'.$row->featured_image_thumbnail)) && !empty($row->featured_image_thumbnail))
	              							{
	              								$featured = url('/storage/course/featuredImageThumbnails/'.$row->featured_image_thumbnail);
	              								$show = 1;
	              							}
	              							else
	              							{
	              								$featured = url('/storage/prerequisite/no-image.png');

	              							}
	              						@endphp 
	              						
										<div class="title" style="background-image: url({{ $featured }})">
											<div class="titleWrap">
												<h3><a href="{{url('course-details/'.base64_encode(base64_encode($row->id)))}}" target="_blank">{{ $row->title}}</a></h3>
											</div>
										</div>
									</div>
								</div>
							@php 
								}
							@endphp
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
<link href="{{ asset('/js/owl.js') }}" rel="stylesheet" type="text/css">
@stop