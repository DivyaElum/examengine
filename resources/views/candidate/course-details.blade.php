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
						<h3>Prerequisites Listing</h3>
						<hr />
						<div class="row">
							@php 
							foreach($arrPrerequisites as $row) { @endphp
							<div class="col-md-4 col-sm-6 col-xs-6 col-12">
								<div class="thumbImg">
									<img src="images/dashboard/thumb-img.jpg" alt="" class="img-responsive">
								</div>
								<div class="thumbCont">
									<div class="title">
										{{$row->title }}
										<?php 
										if($row->video_file_original_name != '') {?>
											<span>Video Name : {{$row->video_file_original_name }}</span>
										<?php }elseif($row->video_url != ''){ ?>
											<span>Video Name : {{$row->video_file_original_name }}</span>
											<span>Video URL : {{$row->video_url }}</span>
										<?php }else{ ?>
											<span>Video Name : {{$row->video_file_original_name }}</span>
											<span>Youtube Video URL : {{$row->youtube_url }}</span>
										<?php } ?>

										<i class="fa fa-check-square completed" aria-hidden="true"></i>
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