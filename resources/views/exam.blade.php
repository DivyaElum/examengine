<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-path" content="{{ url('/') }}">
        
        <title>{{ $exam->title }}</title>

       	<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
		<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
		<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
       	<link href="{{ asset('/css/take-exam.css') }}" rel="stylesheet">
    </head>
    
    <body>
        <div class="container" id="startExam">
            <div class="content">
                <div class="title">
                    <a class="start-btn" href="javascript:void(0)" onclick="return startTimer(this)"  data-hours="{{ $exam->duration }}" >Start exam</a>
                    <p class="startText">Once exam started, Please do not refresh page.</p>
                </div>
            </div>
        </div>        
        <div class="container" id="exam" style=" display: none; padding: 10px">
            <div class="row">
                <form method="POST" id="examForm" action="{{ route('exam.submit') }}">
                    @csrf

                    <div id="my-carousel" class="carousel" data-ride="carousel" data-interval="false">
                        <input type="hidden" name="user_id" value="{{ base64_encode(base64_encode(auth()->user()->id)) }}">
                        <input type="hidden" name="course_id" value="{{ base64_encode(base64_encode($course->id)) }}">
                        <input type="hidden" name="exam_id" value="{{ base64_encode(base64_encode($exam->id)) }}">
                        
                        
						<div class="col-sm-12">
							<div class="row timer">
                                <label>Duration : </label>
                                <span id="demo"></span>
                            </div>
						</div>

                        <div class="col-sm-12">
                            <div class="carousel-inner" role="listbox">

                                @if(!empty($exam_questions) && sizeof($exam_questions) > 0)
                                
                                
                                @foreach($exam_questions as $key => $question)

                                    <input type="hidden" name="question_id[]" value="{{ $question->id }}">

                                    
                                    <?php 
                                        $active = $key == 0 ? 'active' : ''; 
                                        $srno = $key+1;
                                    ?>

                                    <div class="item question {{ $active }}">
										<div class="row ">
											
											<div class="col-sm-8">

												<div class="col-sm-12 quesiton_title_div">
													<label><span class="queNumb">{{ $srno }}</span> <span class="queTxt">{{ ucfirst($question->repository->question_text) }}</span></label>
												</div>

												<div class="col-sm-12">
													<div class="answers_div">

														<!-- options for radio buttons -->
														@if($question->repository->option_type == 'radio')

															@if($question->repository->option1 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">
																		<label for="option1_{{ $srno }}">
																			{{$question->repository->option1}} 
																			<input type="radio"  name="correct[radio][{{$question->id}}]" id="option1_{{ $srno }}" value="{{ $question->repository->option1 }}"> 
																			<span class="checkmark"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option2 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">
																		<label for="option2_{{ $srno }}">
																			{{$question->repository->option2}}
																			<input type="radio" name="correct[radio][{{$question->id}}]" id="option2_{{ $srno }}" value="{{ $question->repository->option2 }}"> 
																			<span class="checkmark"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option3 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">
																		<label for="option3_{{ $srno }}">
																			{{$question->repository->option3}} 																			
																			<input type="radio" name="correct[radio][{{$question->id}}]" id="option3_{{ $srno }}" value="{{ $question->repository->option3 }}"> 
																			<span class="checkmark"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option4 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper"> 
																		<label for="option4_{{ $srno }}">
																			{{$question->repository->option4}}
																			<input type="radio" name="correct[radio][{{$question->id}}]" id="option4_{{ $srno }}" value="{{ $question->repository->option4 }}">
																			<span class="checkmark"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option5 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">                                                                        
																		<label for="option5_{{ $srno }}">
																			{{$question->repository->option5}}
																			<input type="radio" name="correct[radio][{{$question->id}}]" id="option5_{{ $srno }}" value="{{ $question->repository->option5 }}"> 
																			<span class="checkmark"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option6 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">                    
																		<label for="option6_{{ $srno }}">
																			{{$question->repository->option6}}
																			<input type="radio" name="correct[radio][{{$question->id}}]" id="option6_{{ $srno }}" value="{{ $question->repository->option6 }}"> 
																			<span class="checkmark"></span>
																		</label>
																	</div>
																</div>
															@endif

															@if($question->repository->option7 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">                                                                                          
																		<label for="option7_{{ $srno }}">
																			{{$question->repository->option7}}
																			<input type="radio" name="correct[radio][{{$question->id}}]" id="option7_{{ $srno }}" value="{{ $question->repository->option7 }}"> 
																			<span class="checkmark"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option8 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">                           
																		<label for="option8_{{ $srno }}">
																			{{$question->repository->option8}}
																			<input type="radio" name="correct[radio][{{$question->id}}]" id="option8_{{ $srno }}" value="{{ $question->repository->option8 }}"> 
																			<span class="checkmark"></span>
																		</label>
																	</div>
																</div>
															@endif 
														@endif 
														<!-- options for checkbox buttons -->
														@if($question->repository->option_type == 'checkbox')

															@if($question->repository->option1 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">                                                                                                  
																		<label for="option1_{{ $srno }}">
																			{{$question->repository->option1}}
																			<input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option1_{{ $srno }}" value="{{ $question->repository->option1 }}"> 
																			<span class="checkmark_cb"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option2 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">                                                                 
																		<label for="option2_{{ $srno }}">
																			{{$question->repository->option2}}
																			<input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option2_{{ $srno }}" value="{{ $question->repository->option2 }}"> 
																			<span class="checkmark_cb"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option3 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper"> 
																		<label for="option3_{{ $srno }}">
																			{{$question->repository->option3}}
																			<input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option3_{{ $srno }}" value="{{ $question->repository->option3 }}"> 
																			<span class="checkmark_cb"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option4 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">
																		<label for="option4_{{ $srno }}">
																			{{$question->repository->option4}}
																			<input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option4_{{ $srno }}" value="{{ $question->repository->option4 }}"> 
																			<span class="checkmark_cb"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option5 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">
																		<label for="option5_{{ $srno }}">
																			{{$question->repository->option5}}
																			<input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option5_{{ $srno }}" value="{{ $question->repository->option5 }}"> 
																			<span class="checkmark_cb"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option6 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">                                                                        
																		<label for="option6_{{ $srno }}">
																			{{$question->repository->option6}}
																			<input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option6_{{ $srno }}" value="{{ $question->repository->option6 }}">
																			<span class="checkmark_cb"></span>
																		</label>
																	</div>
																</div>
															@endif

															@if($question->repository->option7 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">
																		<label for="option7_{{ $srno }}">
																			{{$question->repository->option7}}
																			<input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option7_{{ $srno }}" value="{{ $question->repository->option7 }}">
																			<span class="checkmark_cb"></span>
																		</label>
																	</div>
																</div>
															@endif 

															@if($question->repository->option8 != NULL)
																<div class="col-sm-12">
																	<div class="radio_box_wrapper">                                                                        
																		<label for="option8_{{ $srno }}">
																			{{$question->repository->option8}}
																			<input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option8_{{ $srno }}" value="{{ $question->repository->option8 }}">
																			<span class="checkmark_cb"></span>
																		</label>
																	</div>
																</div>
															@endif 
														@endif

													</div>
												</div>

												<div class="col-sm-6">
													<div class="status_buttons">
														<div class="buttons">

															@if($srno > 1)
																<a href="javascript:void(0)" class="btn btn-info small-btn" onclick="return goPrevious(this)" data-qn="{{$srno}}">Prev Question</a>
															@endif

															@if($srno < count($exam_questions))
																<a href="javascript:void(0)" class="btn btn-info" onclick="return goNext(this)" data-qn="{{$srno}}">Next Question</a>
															@endif

														</div>
													</div>
												</div>
												<div class="col-sm-6 submit_button">
													<div class="button" style="float: right;">
														<button class="btn btn-success" >Submit Exam</button>
													</div>
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="option_buttons_div">
													 @if(!empty($exam_questions) && sizeof($exam_questions) > 0)
														@foreach($exam_questions as $key => $question)

															<?php 
																$buttonActive = $key == 0 ? 'activate' : ''; 
																$buttonSrno = $key+1;
															?>

																<div class="question_buttons srno_{{$buttonSrno}} {{ $buttonActive }}" data-target="#my-carousel" data-slide-to="{{ $key }}">
																	{{ $key+1 }}
																</div>

														@endforeach    
													@endif  
												</div>
											</div>
											
											
										</div>
                                    </div>
                                
                                @endforeach    
                                @endif  

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            window.addEventListener('load', function(e)
            {
                //document.addEventListener('keydown', event => event.preventDefault());
                //document.addEventListener('contextmenu', event => event.preventDefault());

               Date.prototype.addHours = function(h) 
               {    
                   this.setTime(this.getTime() + (h*60*60*1000)); 
                   return this;   
                }
            })
        </script>
        <script type="text/javascript" src="{{ asset('/js/front/exam/takeExam.js') }}"></script>
    </body>
</html>