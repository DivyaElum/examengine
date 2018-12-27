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
			@php 
			foreach ($arrCerficationList as $key => $row) {@endphp
				<div class="col-md-4 col-sm-6">
					<div class="card">
						<div class="title" style="background-image: url(images/certification_lists/course_img1.jpg)">
							<div class="titleWrap">
								<h3>{{ $row->title}}</h3>
								<span class="icon"></span>
							</div>
						</div>
						<div class="cardContent">
							<h2 class="price"><span>${{ $row->discount}}</span> ${{ $row->calculated_amount}}</h2>
							<p><?php echo str_limit($row->description, '100', '...'); ?></p>
							<a href="{{ url('/certification/detail/'.base64_encode(base64_encode($row->id))) }}" class="btnArrow"><span></span></a>
						</div>
					</div>
				</div>
			@php 
				}
			@endphp
			<!-- <div class="loadMore_wraper text-center clearfix">
				<a href="javascriptVoid(0);" class="small_btn yellow">Load More...</a>				
			</div> -->
		</div>
	</div>
</div>
@stop
@section('scripts')

@stop