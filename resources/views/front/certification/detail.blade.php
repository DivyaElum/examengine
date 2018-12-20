@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop


@section('styles')
	<link href="{{ asset('/css/certification_list_style.css') }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@stop

@section('page_title')
	{{ $page_title }}
@stop

@section('content')
<div class="bodyContent clearfix">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="CertificationCoverImage"></div>
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="certification_detail_container">
							<span class="icon"></span>
							<h2 class="title">
								{{ $arrCerficationDetils->title }}
							</h2>
							<div class="row">
								<div class="col-md-8">
									<h2>Description</h2>
									<p>{{ $arrCerficationDetils->description}}</p>
								</div>
								<div class="col-md-4">
									<div class="sidebar">
										<div class="certificatePreview">
											<img src="{{ asset('images/certification_detail/certificate.jpeg') }}" class="img-responsive" alt="">
											<span class="preivew_btn" data-toggle="modal" data-target="#myModal"><i class="fa fa-search" aria-hidden="true"></i></span>
											<div class="previewtitle">Preview This Certificate</div>
										</div>
										<div class="courseBuyDetails">
											<h4>Learn More <span>with a premium membership</span></h4>
											<p>Sign up for a Premium Membership to learn courses for Internet-free viewing.</p>
											<h2 class="price"><span>${{ $arrCerficationDetils->discount}}</span> ${{ $arrCerficationDetils->amount}}</h2>
											<div class="timeLeft">
												<i class="fa fa-history" aria-hidden="true"></i>
												52 minutes 
												<span>left at this price!</span>
											</div>
											<br>
											@if(!auth()->check())
												<a href="{{ url('/signup') }}" class="large-btn">Buy Now</a>
											@else
											<form action="{{ route('purchase') }}" onsubmit="return makePayment(this)">
												<input type="hidden" name="pud" value="{{ base64_encode(base64_encode(1)) }}">
												<input type="hidden" name="pcd" value="{{ base64_encode(base64_encode($arrCerficationDetils->id)) }}">
												<button type="submit" class="large-btn">Buy Now</button>
											</form>
											@endif
											<a href="/certification" class="link clearfix">Back to Courses</a>
										</div>										
									</div>
								</div>							
							</div>	
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <img src="{{ asset('images/certification_detail/certificate.jpeg') }}" class="img-responsive certificate_img_lg" alt="">
      </div>
    </div>
  </div>
</div>
@stop
@section('scripts')
	<script type="text/javascript" src="{{ asset('plugins/lodingoverlay/loadingoverlay.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/multiselect/bootstrap-multiselect.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.options.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/front/certification/details.js') }}"></script>
@stop