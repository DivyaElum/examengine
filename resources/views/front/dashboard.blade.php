@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	{{-- <link href="{{ asset('/css/dashboard_style.css') }}" rel="stylesheet" type="text/css"> --}}
	<style type="text/css">
		.titleWrap h3 a {color: #fff;text-decoration: none;}

	/*
		D3 styles
	*/	
	  #CourseWiseChart {                                                          /* NEW */
        height: 360px;                                                  /* NEW */
        position: relative;                                             /* NEW */
        width: 360px;                                                   /* NEW */
      }                                                                 /* NEW */
      .tooltip {                                                        /* NEW */
        background: #eee;                                               /* NEW */
        box-shadow: 0 0 5px #999999;                                    /* NEW */
        color: #333;                                                    /* NEW */
        display: none;                                                  /* NEW */
        font-size: 12px;                                                /* NEW */
        left: 130px;                                                    /* NEW */
        padding: 10px;                                                  /* NEW */
        position: absolute;                                             /* NEW */
        text-align: center;                                             /* NEW */
        top: 95px;                                                      /* NEW */
        width: 80px;                                                    /* NEW */
        z-index: 10;                                                    /* NEW */
      }                                                                 /* NEW */
      .legend {
        font-size: 12px;
      }
      rect {
        stroke-width: 2;
      }             
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
							<h2>Welcome <span class="userText">{{ ucfirst($arrUserData->information->first_name) }} {{ucfirst($arrUserData->information->last_name)}}</span></h2>
							<hr />

							<div class="row">
								
								<div class="col-md-12" >
									<h4>Course Statistics</h4>
									<hr>
								</div>

								<div class="col-md-12">
									<center><div id="AllInOneChart"></div></center>
								</div>

								@if(!empty($exams) && sizeof($exams) > 0 )
									<div class="col-md-12" >
									<h4>Exam Statistics Course Wise</h4>
									<hr>

									<div class="form-group">
										<label for="">Select Exam</label>
										<select onchange="return buildCourseWiseCharts(this)" name="exam" class="form-control" id="exam">
											
												<option value="" selected disabled >Please select</option>
												@foreach($exams as $examKey => $exam)
													<option value="{{ base64_encode(base64_encode($exam->course_id)) }}">{{ ucfirst($exam->course->title) }}</option>
												@endforeach
										</select>
									</div>
									<div class="col-md-12">
										<center><div id="CourseWiseChart"></div></center>
									</div>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
    <script src="https://d3js.org/d3.v4.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/front/dashboard/dashboard.js') }}"></script>
@stop