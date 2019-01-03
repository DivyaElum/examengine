@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop


@section('styles')

@stop
@section('page_title')
	{{ $page_title }}
@stop
@section('content')
<div class="login-banner">
    <div class="container">
      <h1>
        @yield('page_title')
      </h1>
    </div>  
  </div>
<div class="bodyContent clearfix">
	<div class="container">
		<div class="row">
			@if(count($arrCerficationList) > 0)
			@php
			foreach ($arrCerficationList as $key => $row) {@endphp
				<div class="col-md-4 col-sm-6">
					<div class="card">
						<div class="title" style="background-image: url(images/certification_lists/course_img1.jpg)">
							<!-- <i class="fa fa-check-circle" style="font-size:30px;color:green;position: relative;left: 160px;" title="Purchased"></i> -->
							<div class="titleWrap">
								<h3>{{ $row->title}}</h3>
								<span class="icon"></span>
							</div>
						</div>
						<div class="cardContent">
							<h2 class="price"><span>${{ $row->discount}}</span> ${{ $row->calculated_amount}}</h2>
							<p><?php echo str_limit($row->description, '100', '...'); ?></p><br />
							
							@if(in_array($row->id , $arrTransData))
								<p><i class="fa fa-cart-arrow-down" style="font-size:18px;" title="Purchased"></i><b> &nbsp;Purchased</b></p>
							@else
								<a href="{{ url('/certification/detail/'.base64_encode(base64_encode($row->id))) }}" class="btnArrow"><span></span></a>
							@endif
						</div>
					</div>
				</div>
			@php 
				}
			@endphp
			@else
				<h2 class="text-center">Course Not Available</h2>
			@endif
			<!-- <div class="loadMore_wraper text-center clearfix">
				<a href="javascriptVoid(0);" class="small_btn yellow">Load More...</a>				
			</div> -->
		</div>
	</div>
</div>
@stop
@section('scripts')

@stop