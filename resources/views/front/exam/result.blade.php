<!DOCTYPE html>
<html>
<head>
	<title>Exam Result</title>
</head>
<body>
	<center>	
		<h3>Exam Result</h3>
		@if(!empty($resultBag) && sizeof($resultBag) > 0)
			@foreach($resultBag as $key => $result)
				<label> <?php echo ucfirst(str_replace('_', ' ', $key))  ?> :   </label> {{ $result }} <br>
			@endforeach
		@endif
	</center>
</body>
</html>