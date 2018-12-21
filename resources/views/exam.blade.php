<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Exam Test</title>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

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
        </script>

        <!-- Styles -->
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
                background:  #ccc;
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
                    <a href="javascript:void(0)" onclick="startTimer(this)"  data-hours="{{ $object->exam->duration }}" >Click to start test</a>
                </div>
            </div>
        </div>
        <div class="container" id="exam" style=" display: none; padding: 10px">
            <div class="row">
                <div id="my-carousel" class="carousel" data-ride="carousel" data-interval="false">
                    
                    <div class="col-sm-9">
                        <div class="carousel-inner" role="listbox">

                            @if(!empty($object->exam->questions) && sizeof($object->exam->questions) > 0)
                                @foreach($object->exam->questions as $key => $question)
                                    {{dump($question)}}
                                    <?php $active = $key == 0 ? 'active' : ''; ?>

                                    <div class="item question {{ $active }}">
                                        <h3>
                                            <div class="row ">

                                                <div class="col-sm-12 quesiton_title_div">
                                                    <p>{{ $key+1 }} ) {{ ucfirst($question->repository->question_text) }}</p>
                                                </div>

                                                <div class="col-sm-12 answers_div">
                                                    
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
                            @if(!empty($object->exam->questions) && sizeof($object->exam->questions) > 0)
                                @foreach($object->exam->questions as $key => $question)

                                    <?php $active = $key == 0 ? 'activate' : ''; ?>

                                    <div class="col-xs-3">
                                        <div class="question_buttons {{ $active }}" data-target="#my-carousel" data-slide-to="{{ $key }}">
                                            {{ $key+1 }}
                                        </div>
                                    </div>
                                
                                @endforeach    
                            @endif    

                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">

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