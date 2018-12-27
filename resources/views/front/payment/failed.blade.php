@extends('front.master')

@section('title')
	{{ 'Payment failed' }}
@stop

@section('styles')
	
@stop

@section('page_title')
	{{ 'Payment failed' }}
@stop

@section('content')
<div class="bodyContent dashboard clearfix">
	<div class="dashboardWraper">
		<div class="container">
			<div class="row">
				@include('front.partials._sidebar')
				<div class="col-md-9 col-sm-12 col-xs-12">
					<div class="dashbaord_content">
						<h3>Prerequisites Listing</h3>
						<hr />
						<div class="row">
							<h1 class="text-center">payment failed</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
@stop