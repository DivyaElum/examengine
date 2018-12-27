<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-path" content="{{ url('/') }}">
        <title>{{ $exam->title }}</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <style type="text/css">
        
            .question_buttons{
                height: 50px;
                background: #ccc;
                margin: 4px -11px;
                padding: 15px 10px 10px 10px;
                position: relative;
                cursor: pointer;
            }

            .question_buttons h4{
                position: absolute;
                left: 5%;
                top: 60%;
                color: #0095d9;
                font-size: 16px;
                font-weight: bold;
            }

            .activate{
                background-color: #0095d9;
            }

            .activate h4{
                color: #fff;
            }

            .question {
                height: 615px;
                background:  black;
                margin: -14px 0;
            }

            .question h3{
                padding: 10px;
                color: #fff;
            }

            #my-carousel {
                border: 1px solid #ccc;
                height: 620px;
            }

            .option_buttons_div {
                border-left: 1px solid #ccc;
                height: 620px;
            }

            .timer { 

                padding: 10px;
                border-bottom: 1px solid #ccc;
            }
        </style>
    </head>
    <body>
        <div class="container" id="startExam">
            <div class="content">
                <div class="title">
                    <a href="javascript:void(0)" onclick="return startTimer(this)"  data-hours="{{ $exam->duration }}" >Click to start test</a>
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

                        <div class="col-sm-9">
                            <div class="carousel-inner" role="listbox">

                                @if(!empty($exam_questions) && sizeof($exam_questions) > 0)
                                @foreach($exam_questions as $key => $question)

                                    <?php 
                                        $active = $key == 0 ? 'active' : ''; 
                                        $srno = $key+1;
                                    ?>

                                    <div class="item question {{ $active }}">
                                        <h3>
                                            <div class="row ">

                                                <div class="col-sm-12 quesiton_title_div" style="height: 150px; margin-top: 100px ">
                                                    <label>Q.{{ $srno }}) {{ ucfirst($question->repository->question_text) }}</label>
                                                </div>

                                                <div class="col-sm-12 answers_div" style="height: 150px">
                                                    <div class="row">
                                                        
                                                        <div class="col-sm-12">
                                                            <label>Answer</label>
                                                            <hr>
                                                        </div>

                                                        <!-- options for radio buttons -->
                                                        @if($question->repository->option_type == 'radio')
                                                            
                                                            @if($question->repository->option1 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="radio_box_wrapper">
                                                                        <input type="radio" name="correct[radio][{{$question->id}}]" id="option1_{{ $srno }}" value="{{ $question->repository->option1 }}"> 
                                                                        <label for="option1_{{ $srno }}" > {{$question->repository->option1}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option2 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="radio_box_wrapper">
                                                                        <input type="radio" name="correct[radio][{{$question->id}}]" id="option2_{{ $srno }}" value="{{ $question->repository->option2 }}"> 
                                                                        <label for="option2_{{ $srno }}" > {{$question->repository->option2}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option3 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="radio_box_wrapper">
                                                                        <input type="radio" name="correct[radio][{{$question->id}}]" id="option3_{{ $srno }}" value="{{ $question->repository->option3 }}"> 
                                                                        <label for="option3_{{ $srno }}" > {{$question->repository->option3}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option4 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="radio_box_wrapper">
                                                                        <input type="radio" name="correct[radio][{{$question->id}}]" id="option4_{{ $srno }}" value="{{ $question->repository->option4 }}"> 
                                                                        <label for="option4_{{ $srno }}" > {{$question->repository->option4}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option5 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="radio_box_wrapper">
                                                                        <input type="radio" name="correct[radio][{{$question->id}}]" id="option5_{{ $srno }}" value="{{ $question->repository->option5 }}"> 
                                                                        <label for="option5_{{ $srno }}" > {{$question->repository->option5}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option6 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="radio_box_wrapper">
                                                                        <input type="radio" name="correct[radio][{{$question->id}}]" id="option6_{{ $srno }}" value="{{ $question->repository->option6 }}"> 
                                                                        <label for="option6_{{ $srno }}" > {{$question->repository->option6}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if($question->repository->option7 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="radio_box_wrapper">
                                                                        <input type="radio" name="correct[radio][{{$question->id}}]" id="option7_{{ $srno }}" value="{{ $question->repository->option7 }}"> 
                                                                        <label for="option7_{{ $srno }}" > {{$question->repository->option7}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option8 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="radio_box_wrapper">
                                                                        <input type="radio" name="correct[radio][{{$question->id}}]" id="option8_{{ $srno }}" value="{{ $question->repository->option8 }}"> 
                                                                        <label for="option8_{{ $srno }}" > {{$question->repository->option8}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 
                                                        @endif 
                                                        <!-- options for checkbox buttons -->
                                                        @if($question->repository->option_type == 'checkbox')
                                                            
                                                            @if($question->repository->option1 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="radio_box_wrapper">
                                                                        <input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option1_{{ $srno }}" value="{{ $question->repository->option1 }}"> 
                                                                        <label for="option1_{{ $srno }}"> {{$question->repository->option1}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option2 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="checkbox_box_wrapper">
                                                                        <input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option2_{{ $srno }}" value="{{ $question->repository->option2 }}"> 
                                                                        <label for="option2_{{ $srno }}"> {{$question->repository->option2}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option3 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="checkbox_box_wrapper">
                                                                        <input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option3_{{ $srno }}" value="{{ $question->repository->option3 }}"> 
                                                                        <label for="option3_{{ $srno }}"> {{$question->repository->option3}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option4 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="checkbox_box_wrapper">
                                                                        <input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option4_{{ $srno }}" value="{{ $question->repository->option4 }}"> 
                                                                        <label for="option4_{{ $srno }}" > {{$question->repository->option4}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option5 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="checkbox_box_wrapper">
                                                                        <input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option5_{{ $srno }}" value="{{ $question->repository->option5 }}"> 
                                                                        <label for="option5_{{ $srno }}"> {{$question->repository->option5}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option6 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="checkbox_box_wrapper">
                                                                        <input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option6_{{ $srno }}" value="{{ $question->repository->option6 }}"> 
                                                                        <label for="option6_{{ $srno }}" > {{$question->repository->option6}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if($question->repository->option7 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="checkbox_box_wrapper">
                                                                        <input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option7_{{ $srno }}" value="{{ $question->repository->option7 }}"> 
                                                                        <label for="option7_{{ $srno }}"> {{$question->repository->option7}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 

                                                            @if($question->repository->option8 != NULL)
                                                                <div class="col-sm-6">
                                                                    <div class="checkbox_box_wrapper">
                                                                        <input type="checkbox" name="correct[checkbox][{{$question->id}}][]" id="option8_{{ $srno }}" value="{{ $question->repository->option8 }}"> 
                                                                        <label for="option8_{{ $srno }}"> {{$question->repository->option8}} </label>
                                                                    </div>
                                                                </div>
                                                            @endif 
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="col-sm-12 status_buttons" style="margin-top: 100px">
                                                    <div class="buttons" style="float: right;">
                                                        
                                                        @if($srno > 1)
                                                            <a href="javascript:void(0)" class="btn btn-info" onclick="return goPrevious(this)" data-qn="{{$srno}}">Prev Question</a>
                                                        @endif

                                                        @if($srno < count($exam_questions))
                                                            <a href="javascript:void(0)" class="btn btn-info" onclick="return goNext(this)" data-qn="{{$srno}}">Next Question</a>
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="col-sm-12 submit_button" style="margin-top: 5px">
                                                    <div class="button" style="float: right;">
                                                        <button class="btn btn-success" >Submit Exam</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </h3>
                                    </div>
                                
                                @endforeach    
                                @endif  

                            </div>
                        </div>

                        <div class="col-sm-3 option_buttons_div" >
                            <div class="row timer">
                                <label>Duration : </label>
                                <span id="demo"></span>
                            </div>
                            <div class="row">
                                @if(!empty($exam_questions) && sizeof($exam_questions) > 0)
                                    @foreach($exam_questions as $key => $question)

                                        <?php 
                                            $buttonActive = $key == 0 ? 'activate' : ''; 
                                            $buttonSrno = $key+1;
                                        ?>

                                        <div class="col-xs-3">
                                            <div class="question_buttons srno_{{$buttonSrno}} {{ $buttonActive }}" data-target="#my-carousel" data-slide-to="{{ $key }}">
                                                {{ $key+1 }}
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
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            window.addEventListener('load', function(e)
            {
                // document.addEventListener('keydown', event => event.preventDefault());
                // document.addEventListener('contextmenu', event => event.preventDefault());

                // Set the date we're counting down to
               Date.prototype.addHours = function(h) 
               {    
                   this.setTime(this.getTime() + (h*60*60*1000)); 
                   return this;   
                }
            })

            function startTimer(element)
            {
                // adding status to start timer
                var course_id   = $('input[name="course_id"]').val();
                var user_id     = $('input[name="user_id"]').val();
                var exam_id     = $('input[name="exam_id"]').val();

                var formData = new FormData();
                formData.append('course_id',course_id)
                formData.append('user_id',course_id)
                formData.append('exam_id',course_id)

                var action = "{{ url('/exam/updateExamResultStatus') }}"

                $dbdata = [];
                $.ajax(
                {
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: action,
                    data: formData,
                    global: false,
                    async: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data)
                    {
                        $dbdata = data;
                    }
                });

                if (!$.isEmptyObject($dbdata)) 
                {
                    if ($dbdata.status == 'error') 
                    {
                        alert('Server failure, Please try again later.');
                        return false;
                    }

                    $('#examForm').append('<input type="hidden" name="result_id" value="'+$dbdata.result+'">');
                }
                else
                {
                    alert('Server failure, Please try again later.');
                    return false;
                }

                var hours = $(element).attr('data-hours');

                document.getElementById('startExam').style.display = 'none';
                document.getElementById('exam').style.display = 'block';

                var countDownDate = new Date().addHours(hours)

                // Update the count down every 1 second
                var x = setInterval(function() 
                {

                    // Get todays date and time
                    var now = new Date().getTime();
                    
                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;
                    
                    // Time calculations for days, hours, minutes and seconds
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    // Output the result in an element with id="demo"

                    console.log(hours);
                    console.log(minutes);
                    console.log(seconds);

                    document.getElementById("demo").innerHTML = hours + " hours : " + minutes + " min : " + seconds + ' sec';
                    
                    // If the count down is over, write some text 
                    if (distance < 0) 
                    {
                        clearInterval(x);
                        document.getElementById("demo").innerHTML = "00 Hours : 00 min : 00 sec";
                        document.getElementById('startExam2').innerHTML = 'Completed Please wait for you result';
                    }
                }, 1000);
            }

            function goPrevious(element)
            {
                var examSrno = parseInt($(element).attr('data-qn')) - 1;
                $('.srno_'+examSrno).trigger('click');
            }

            function goNext(element)
            {
                var examSrno = parseInt($(element).attr('data-qn')) + 1;
                $('.srno_'+examSrno).trigger('click');
            }

            $(document).ready(function()
            {
                $('#my-carousel').carousel();

                $('#my-carousel .question_buttons').click(function(e)
                {
                    $('.question_buttons').removeClass('activate');
                    $(this).addClass('activate');
                });
            })
        </script>
    </body>
</html>