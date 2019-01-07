@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	<style type="text/css">
		.titleWrap h3 a {color: #fff;text-decoration: none;}
		.container{ text-align: center; }

		/* Button styles: */
		i.fb,       span.fb{         color: #3b5998; }
		i.tw,       span.tw{     	color: #00aced; }
		i.google,   span.google{ 	color: #dd4b39; }
		i.linkin,   span.linkin{ 	color: #007bb6; }
		i.pinterest,span.pinterest{ color: #cb2027; }

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
	      			<embed src="" type="application/pdf" width="100%" height="520px" />
		      		<div class="btn-group">
				        <button class="btn btn-default disabled">Share:</button>
				        <a class="btn btn-default" target="_blank" title="On Facebook" href="#"><i class="fa fa-facebook fa-lg fb"></i></a>
			            <a class="btn btn-default" target="_blank" title="On Twitter" href="#"><i class="fa fa-twitter fa-lg tw"></i></a>
		                <a class="btn btn-default" target="_blank" title="On Google Plus" href="#"><i class="fa fa-google-plus fa-lg google"></i></a>
				    </div>
	      		</div>
	    	</div>
	  	</div>
	</div>
	
@stop

@section('scripts')
	<script src='{{ asset('/js/front/certification/generate.js') }}'></script>
@stop