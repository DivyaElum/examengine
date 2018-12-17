
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
         <div class="box-body">
            <h1 >Welcome Admin</h1>
         </div>
      </div>
   </section>
   </div>
@stop

@section('scripts')

@stop