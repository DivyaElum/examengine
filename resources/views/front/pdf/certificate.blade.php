<!DOCTYPE html>
<html>
<head>
	<title>Certificate</title>
</head>
<body>

    <div style="width:650px; height:600px; padding:20px; text-align:center; border: 10px solid #787878">
        <div style="width:600px; height:550px; padding:20px; text-align:center; border: 5px solid #787878">
               <span style="font-size:50px; font-weight:bold">Certificate of Completion</span>
               <br><br>
               <span style="font-size:25px"><i>This is to certify that</i></span>
               <br><br>
               <span style="font-size:30px"><b>{{ ucfirst($userName) }}</b></span><br/><br/>
               <span style="font-size:25px"><i>has completed the course</i></span> <br/><br/>
               <span style="font-size:30px">{{ ucfirst($courseName) }}</span> <br/><br/>
               <span style="font-size:20px">with score of <b>{{ $percentage }}%</b></span> <br/><br/><br/><br/>
               <span style="font-size:25px"><i>dated</i></span><br>
              <span style="font-size:30px">{{Date("F d, Y", strtotime($updated_at)) }}</span>
        </div>
    </div>
</body>
</html>