@extends('front.master')

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
				@include('front.partials._sidebar')
				<div class="col-md-9 col-sm-12 col-xs-12">
					<div class="dashbaord_content">
						<h2>Welcome <span class="userText">{{$arrUserData->information->first_name}}  {{$arrUserData->information->last_name}}</span></h2>
						<hr />
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