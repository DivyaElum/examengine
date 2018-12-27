<!DOCTYPE html>
<html lang="en">
<head>
  <title>Exam Result</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <center><h2>Exam Result</h2></center>
  
  <table class="table">
    <tbody>
      @if(!empty($resultBag) && sizeof($resultBag) > 0)
        @foreach($resultBag as $key => $result)
          <tr>
            <th> <?php echo ucfirst(str_replace('_', ' ', $key))  ?> : </th> <td>{{ $result }}</td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
</div>

</body>
</html>
