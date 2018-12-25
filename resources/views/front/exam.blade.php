<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <script type="text/javascript">
            
            window.addEventListener('load', function(e)
            {
                document.addEventListener('keydown', event => event.preventDefault());
                document.addEventListener('contextmenu', event => event.preventDefault());

                Date.prototype.addMinuts= function(m)
                {
                    this.setMinutes(this.getMinutes()+m);
                    return this;
                }
            })

            function startTimer()
            {
                document.getElementById('startExam').style.display = 'none';
                document.getElementById('startExam2').style.display = 'block';

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
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            a {
                text-decoration: none
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <center><h1 id="demo"> 20 min : 00 sec</h1></center>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    <a href="javascript:void(0)" onclick="startTimer()" id="startExam">Click to start test</a>
                    <a href="javascript:void(0)" id="startExam2" style="display: none">Exam started please wait ...</a>
                </div>
            </div>
        </div>
    </body>
</html>