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
						<h3>Certificates</h3>
						<hr />
						<div class="row">
							@if (!empty($object) && sizeof($object) > 0)
								@foreach($object as $row)
									<div class="col-md-4">
										<div class="sidebar" onclick="return generatePreview(this)" data-rd="{{ base64_encode(base64_encode($row->id)) }}">
											<div class="certificatePreview">
												<img src="images/certification_detail/certificate.jpeg" class="img-responsive" alt="">
												<span class="preivew_btn"><i class="fa fa-search" aria-hidden="true"></i></span>
												<div class="previewtitle">{{ ucfirst($row->course->title) }}</div>
											</div>							
										</div>
									</div>
								@endforeach
							@else
								<h4 class="text-center">No Certificate Available</h4>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog" role="document">
	   	 	<div class="modal-content">
	      		<div class="modal-body" id="modalBody">
	      		</div>
	    	</div>
	  	</div>
	</div>
	
@stop

@section('scripts')
	<script src='{{ asset('/js/front/certification/generate.js') }}'></script>
@stop