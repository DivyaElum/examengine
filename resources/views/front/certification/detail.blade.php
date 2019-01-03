@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop


@section('styles')
<style type="text/css">
	.error_voucher_code.error {color: red;}
</style>
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
											<p>Sign up for a Premium Membership to learn courses for Internet-free viewing.</p>
											<h2 class="price">
												<span>${{ $arrCerficationDetils->discount}}</span> 
												
												@if($intDisAmount)
													$<?php echo number_format($intDisAmount,2); ?>
												@else
													${{ $arrCerficationDetils->calculated_amount}}
												@endif
											</h2>
											<br>
											@if(!auth()->check())
												<a href="{{ url('/signup') }}" class="large-btn">Buy Now</a>
											@else
											<p><a href="javascript:void(0)" data-toggle="modal" data-target="#myVoucherModal">Apply Voucher</a></p>
											<form action="{{ route('purchase') }}" onsubmit="return makePayment(this)">
												<input type="hidden" name="pud" value="{{ base64_encode(base64_encode(auth()->user()->id)) }}">
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
          		<input type="hidden" name="courses_id" value="{{$arrCerficationDetils->id}}">
          		@if(auth()->check())
          			<input type="hidden" name="user_id" value="{{ base64_encode(base64_encode(auth()->user()->id)) }}">
          		@endif
          		<input type="hidden" name="course_price" value="{{$arrCerficationDetils->calculated_amount}}">
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
	<script type="text/javascript" src="{{ asset('js/front/voucher/applyVoucher.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/front/certification/details.js') }}"></script>
@stop