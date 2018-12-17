@extends('admin.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/jquery.dataTables.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/dataTables.bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/fixedHeader.bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/responsive.bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/buttons.dataTables.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
@stop

@section('content')
	<div class="content-wrapper">

	    <section class="content-header">
	      <h1>
	        {{ $moduleTitle }}
	      </h1>
	      <ol class="breadcrumb">
	        <li class=""><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
	        <li class="active">{{ $moduleTitle }}</li>
	      </ol>
	    </section>
	    
	    <section class="content">
	      	<div class="box">
	        	<div class="box-header with-border">
		          	<h3 class="box-title">{{ $moduleAction }}
		          	</h3>
		          	<div class="box-tools pull-right">
		          		<a title="Add New Question" href="{{ route($modulePath.'.create') }}" class="btn btn-social btn-linkedin" ><i class="fa fa-plus"></i>{{'Add New '.$moduleTitle}}</a>
		          	</div>
	        	</div>

              	<div class="box-body">
          			<div class="dataTables_wrapper form-inline dt-bootstrap">
          				<table id="listingTable" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
          					<thead>
          						<th>Sr. No</th>
          						<th>Category</th>
          						<th>Status</th>
          						<th>Created Date</th>
          						<th>Action</th>
          					</thead>
          					<tbody>
          						
          					</tbody>
          				</table>
          			</div>
              	</div>

	      	</div>
	    </section>

	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="{{ asset('plugins/datatable/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/dataTables.bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/dataTables.fixedHeader.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/dataTables.responsive.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/responsive.bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/dataTables.buttons.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/jszip.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/pdfmake.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/vfs_fonts.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/buttons.html5.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/buttons.print.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/datatable/buttons.colVis.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugins/sweetalert/sweetalert.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/admin/questionCategory/index.js') }}"></script>
@stop