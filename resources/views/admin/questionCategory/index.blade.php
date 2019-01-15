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
	<style type="text/css">
	.fileUpload {
	    position: relative;
	    overflow: hidden;
	    margin: 10px;
	}
	.fileUpload input.upload {
	    position: absolute;
	    top: 0;
	    right: 0;
	    margin: 0;
	    padding: 0;
	    font-size: 20px;
	    cursor: pointer;
	    opacity: 0;
	    filter: alpha(opacity=0);
	}
	</style>
@stop

@section('content')
	<div class="content-wrapper">

	    <section class="content-header">
	      <h1>
	        {{ $moduleAction }}
	      </h1>
	      <ol class="breadcrumb">
	        <li class=""><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
	        <li class="active">{{ $moduleTitle }}</li>
	      </ol>
	    </section>
	    
	    <section class="content">
	      	<div class="box">
	        	<div class="box-header with-border">
		          	<h3 class="box-title">
		          		<?php 
					    $arrResult = $html = '';
					    if(Session()->has('arrSkipCnt'))
					    {
					    	$arrSkipData = Session('arrSkipCnt');
					    	if(!empty($arrSkipData))
					    	{
						    	$html .= '<div class="alert alert-danger dangerErrText">';
						    	foreach ($arrSkipData as $value) {
						    		$html .= $value."<br />";
						    	}
						    	echo $html .= '</div>';
					    	}
				    	}
					    ?>						 
		          		@if (session('error'))
						 <div class="alert alert-danger">
							{{ session('error') }}
						 </div>
					   	@endif
		          		@if (session('error'))
						 <div class="alert alert-danger">
							{{ session('error') }}
						 </div>
					   	@endif
					   	@if (session('success') && !Session()->has('arrSkipCnt') )
						 <div class="alert alert-success">
							{{ session('success') }}
						 </div>
					   	@endif
				   		@if (session('success') && Session()->has('arrSkipCnt') )
						 	<div class="alert alert-danger">
								{{ 'Error while importing file.' }}
							</div>
					   	@endif
		          	</h3>
		          	<div class="box-tools pull-right">
			          	<div class="fileUpload btn btn-primary ">
			          		<form method="post" action="{{ url('admin/question-category/excelImport') }}" id="frmImportExcel" enctype="multipart/form-data">
			          			@csrf
			          				<span>Upload</span>
			          				<input type="file" name="import_file" accept=".xlsx, .xls, .csv" class="upload"/>
			          		</form>
		          		</div>
		          		<a href="{{ asset('demoExcelCSV/categories.csv') }}" download class="btn btn-social btn-linkedin" id=""><i class="fa fa-download"></i>Download Sample CSV</a>
		          		<a title="Add New" href="{{ route($modulePath.'.create') }}" class="btn btn-social btn-linkedin" ><i class="fa fa-plus"></i>{{'Add New'}}</a>
		          	</div>
	        	</div>

              	<div class="box-body">
          			<div class="dataTables_wrapper form-inline dt-bootstrap">
          				<table id="listingTable" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
          					<thead>
          						<th>Sr. No.</th>
          						<th>Category</th>
          						<th>Created Date</th>
          						<th>Status</th>
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