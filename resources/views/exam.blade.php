<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Exam Test</title>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            
            window.addEventListener('load', function(e)
            {
                // document.addEventListener('keydown', event => event.preventDefault());
                // document.addEventListener('contextmenu', event => event.preventDefault());

                // Set the date we're counting down to
                Date.prototype.addMinuts= function(m)
                {
                    this.setMinutes(this.getMinutes()+m);
                    return this;
                }
            })

            function startTimer()
            {

                document.getElementById('startExam').style.display = 'none';
                document.getElementById('exam').style.display = 'block';

                var countDownDate = new Date().addMinuts(20)

                // Update the count down every 1 second
                var x = setInterval(function() 
                {

                    // Get todays date and time
                    var now = new Date().getTime();
                    
                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;
                    
                    // Time calculations for days, hours, minutes and seconds
                    // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    // Output the result in an element with id="demo"
                    document.getElementById("demo").innerHTML = minutes + " min : " + seconds + ' sec';
                    
                    // If the count down is over, write some text 
                    if (distance < 0) 
                    {
                        clearInterval(x);
                        document.getElementById("demo").innerHTML = "00 min : 00 sec";
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
                    <a href="javascript:void(0)" onclick="startTimer()" >Click to start test</a>
                </div>
            </div>
        </div>
        <div class="container" id="exam" style=" display: none; padding: 10px">
            <div class="row">
                <div id="my-carousel" class="carousel" data-ride="carousel" data-interval="false">
                    
                    <div class="col-sm-9">
                        <div class="carousel-inner" role="listbox">
                            <div class="item active question">
                              <h3>1</h3>
                            </div>
                            <div class="item question">
                              <h3>2</h3>
                            </div>
                            <div class="item question">
                              <h3>3</h3>
                            </div>
                            <div class="item question">
                              <h3>4</h3>
                            </div>
                            <div class="item question">
                              <h3>5</h3>
                            </div>
                            <div class="item question">
                              <h3>6</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 option_buttons_div" >
                        <div class="row timer">
                            <label>Duration</label>
                            <span id="demo"> 20 min : 00 sec </span>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="question_buttons activate" data-target="#my-carousel" data-slide-to="0">
                                    One
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="question_buttons" data-target="#my-carousel" data-slide-to="1">
                                    Two
                                </div>
                            </div>
                        
                            <div class="col-xs-3">
                                <div class="question_buttons" data-target="#my-carousel" data-slide-to="2">
                                    Three
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="question_buttons" data-target="#my-carousel" data-slide-to="3">
                                    Four
                                </div>
                            </div>
                        
                            <div class="col-xs-3">
                                <div class="question_buttons" data-target="#my-carousel" data-slide-to="4">
                                    Five
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="question_buttons" data-target="#my-carousel" data-slide-to="5">
                                    Six
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $('#my-carousel .question_buttons').click(function(e)
            {
                $('.question_buttons').removeClass('activate');
                $(this).addClass('activate');
            });
        </script>
    </body>
</html>