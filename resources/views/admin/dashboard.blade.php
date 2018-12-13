
@extends('admin.master')

@section('title')
   {{ $moduleAction }}
@stop

@section('styles')

@stop

@section('content')
   <div class="content-wrapper">
   <section class="content-header">
      <h1>
         {{ $moduleTitle }}
      </h1>

      <ol class="breadcrumb">
         <li class=""><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
         <li class="active">{{ $moduleAction }}</li>
      </ol>
   </section>
   
   <section class="content">
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Title</h3>
            <div class="box-tools pull-right">
               <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
               title="Collapse">
               <i class="fa fa-minus"></i></button>
               <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
               <i class="fa fa-times"></i></button>
            </div>
         </div>
         <div class="box-body">
            Start creating your amazing application!
         </div>
         <!-- /.box-body -->
         <div class="box-footer">
            Footer
         </div>
         <!-- /.box-footer-->
      </div>
      <!-- /.box -->
   </section>
   </div>
@stop

@section('scripts')

@stop