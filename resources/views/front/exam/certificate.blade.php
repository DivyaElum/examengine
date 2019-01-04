<!doctype html>
<html >
    <head>
        <title>
            Certificate
        </title>

        <style type="text/css" media="all">

            #top 
            {
                height: 100%;
            }

            #position_me 
            {
                left: 0;
            }

            .SlideBackGround
            {
                height:650px;
                width:880px;
                position:fixed;
                margin:10px 10px 10px 10px;
                background-color:white;
                background-image:url({{asset('certificate/frame.png')}});
                background-size:880px 650px;
                background-repeat:no-repeat;
                z-index: 2;
            }

            .MiddlePart
            {
                height:170px;
                width:670px;
                position:fixed;
                left:125px;
                top:80px;
                background-image:url({{asset('certificate/middle_part.png')}});
                background-size:670px 170px;
                background-repeat:no-repeat;
                z-index: 5;
            }
            
            .Seal
            {
                height:90px;
                width:90px;
                position:fixed;
                left:415px;
                top:420px;
                background-image:url({{asset('certificate/sigill.png')}});
                background-size:90px 90px;
                background-repeat:no-repeat;
                z-index: 5;
            }
            
            .Ribbon
            {
            
                width:60px;
                height:90px;
                position:fixed;
                left:435px;
                top:520px;
                background-image:url({{asset('certificate/band.png')}});
                background-size:60px 90px;
                background-repeat:no-repeat;
                z-index: 5;
            }
            
            .Signature
            {
                width:180px;
                height:90px;
                position:fixed;
                left:582px;
                top:517px;
                background-image:url({{asset('certificate/signature.png')}});
                background-size:180px 90px;
                background-repeat:no-repeat;
                z-index: 11;
            }
            
            .DateLine
            {
                width:300px;
                position:fixed;
                left:112px;
                top:570px;
                z-index:11;
            }
            
            .ExaminerLine
            {
                width:300px;
                position:fixed;
                left:500px;
                top:570px;
                z-index:11;
            }
            
            .ExaminerText
            {
                width:270px;
                position:fixed;
                left:632px;
                top:585px;
                color:#8B7B67;
                z-index:11;
            }
            
            .DateText
            {
                width:270px;
                position:fixed;
                left:232px;
                top:585px;
                z-index:11;
                color:#8B7B67;
            }
            
            .ParagraphSmall
            {
                height:200px;
                width:500px;
                position:fixed;
                left:200px;
                top:350px;
                font-size:13px;
                text-align:center;
                z-index:11;
                color:#8B7B67;
            }
            
            .ParagraphMedium
            {
                height:200px;
                width:420px;
                position:fixed;
                left:240px;
                top:260px;
                font-size:14px;
                text-align:center;
                z-index:11;
                color:#8B7B67;
            }
            
            /*.HeadingLarge
            {
                height:200px;
                width:600px;
                position:fixed;
                left:330px;
                top:130px;
                font-size:66px;
                z-index:11;
                color:#8B7B67;
            }*/

            .HeadingLarge {
                height: 200px;
                width: 600px;
                position: fixed;
                left: 170px;
                top: 132px;
                font-size: 57px;
                z-index: 11;
                color: #8B7B67;
            }
            
            .MiddleLine
            {
                width:720px;
                position:fixed;
                left:100px;
                top:330px;
                z-index:11;
                color:#8B7B67;
            }
            
            .StudentName
            {
                font-weight:bold;
                height:200px;
                width:720px;
                position:fixed;
                left:100px;
                top:310px;
                font-size:18px;
                text-align:center;
                z-index:11;
                color:#8B7B67;
            }
            
            .CompletionDate
            {
                position:fixed;
                left:225px;
                top:555px;
                z-index:11;
                color:#8B7B67;
                text-align:center;
            } 
        </style>
    </head>

    <body>

        <div class="SlideBackGround">
        </div>

        <div class="MiddlePart">
        </div>

        <div class="HeadingLarge">Managed Service Council</div>

        <div class="ParagraphMedium">
            <p>
                CERTIFICATE OF COMPLETION. AWARDED TO,
            </p>
        </div>
        
        <div class="ParagraphSmall">
            For successfully completing the on-line course
            "{{ 'course' }}"
        </div>

        <div class="Seal"></div>

        <div class="Ribbon"></div>

        <hr class="DateLine" />

        <hr class="ExaminerLine" />

        <hr class="MiddleLine" />

        <div class="DateText">Date</div>

        <div class="ExaminerText">Examiner</div>

        <div class="Signature"></div>

        <div id="CompletionDatePanel" class="CompletionDate">
        
        <span id="CompletionDateLabel">{{ date('d-m-Y') }}</span>

        </div>

        <div id="StudentNamePanel" class="StudentName">
        
        <span id="StudentNameLabel">{{'Sheshkumar Prajapati'}}</span>

        </div>
    </body>
</html>