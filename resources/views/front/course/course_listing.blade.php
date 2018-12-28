@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop


@section('styles')
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
						<h3>Course Listing</h3>
						<hr />
						<div class="row">
							@if (count($arrUsersCourse) >= 1)
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
												<h3><a href="{{url('/course/details/'.base64_encode(base64_encode($row->id)))}}" target="_blank">{{ $row->title}}</a></h3>
											</div>
										</div>
									</div>
								</div>
							@php 
								}
							@endphp
							@else
								<h4 class="text-center">No course available</h4>
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
<link href="{{ asset('/js/owl.js') }}" rel="stylesheet" type="text/css">
@stop