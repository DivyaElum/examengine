@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop

@section('styles')
	<style type="text/css">
		.titleWrap h3 a {color: #fff;text-decoration: none;}

		#graph{
		  border-radius: 5px 5px 0 0;
		  padding-top: 50px;
		  margin: 25px auto 0;
		  height: 100%;
		  background-color: #fff;
		  svg{width: 100% !important;}
		  .slice{stroke: white; stroke-width: 5px;}
		  .slice:hover{opacity: .5;}
		  .labels text{background-color: #333; width: 200px;}
		}

		#adjust{
		  outline: transparent;
		  padding: 25px 0;
		  background-color: #eee;
		  text-align: center;
		  line-height: 50px;
		  button{padding: 10px 20px; text-transform: uppercase; letter-spacing: 5px; color: #fff; background: #333;   border: none; border-radius: 5px; font: 10px "avenir"; cursor: pointer;}
		  button:focus{outline:none;}
		  button:hover{ background: #222;}
		  box-shadow: 0px 4px 6px #000;
		  input{font-size: 18px; padding: 10px; width: 50px; text-align: center; color: #30AD63;}
		}
		svg{
		    width: 100%;
		    height: 100%;
		}
		path.slice{
		    stroke-width:5px;
		}

		polyline{
		    stroke: #333;
		    stroke-width: 1px;
		    fill: none;
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
									<h4>Exam Statistics All</h4>
									<hr>
								</div>

								<div class="col-md-12" >
									<h4>Exam Statistics Category Wise</h4>
									<hr>

									<div class="form-group">
										<label for="">Select Exam</label>
										<select onchange="return bbuildCourseWiseCharts(this)" name="exam" class="form-control" id="exam">
											@if(!empty($exams) && sizeof($exams) > 0 )
												<option value="" selected disabled >Please select</option>
												@foreach($exams as $examKey => $exam)
													<option value="{{ base64_encode(base64_encode($exam->course_id)) }}">{{ ucfirst($exam->course->title) }}</option>
												@endforeach
											@endif
										</select>

										<div id="adjust">
										    Duration  <input type="textbox" id="duration"  value="500"> in milliseconds
										    <br>
									    	<button class="randomize">New Data</button> 
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
@stop

@section('scripts')
	<script src="https://d3js.org/d3.v3.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/front/dashboard/dashboard.js') }}"></script>
@stop