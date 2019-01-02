<!DOCTYPE html>
<html lang="en">
<head>
  <title>Exam Result</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
      table.examResultTable tr.tableMainHeading td {
      color: #fff;
      background: #014694;
      font-weight: 700;
      font-size: 24px;
    }
    table.examResultTable th, table.examResultTable td{
      padding: 15px !important;     
    }
    table.examResultTable th.tableSubheading {
      background: #004d9f12;
      font-size: 17px;
      font-weight: 500;
    }
    .tableFooter{
      background: #ECECEC;
      text-align: right;
    }
  </style>
</head>
<body>

<div class="container">
  <center>
    <h2>Exam Result</h2>
    <br>
    <table class="table table-bordered examResultTable">
      <tbody>
      <tr class="tableMainHeading">
        <th>Categories</th>
        <th>Total Questions</th>
        <th>Total Attempted</th>
        <th>Total Right</th>
        <th>Total Wrong</th>
      </tr>
      
      @if(!empty($resultBag['categories'] && sizeof($resultBag['categories']) > 0))
        @foreach($resultBag['categories'] as $categoryKey => $category)
          <tr>
            <th class="tableSubheading" >{{ $category['category_name'] }}</th>
            <td>{{ $category['total_questions'] }}</td>
            <td>{{ $category['total_attempted'] }}</td>
            <td>{{ $category['total_right'] }}</td>
            <td>{{ $category['total_wrong'] }}</td>
          </tr>
        @endforeach

      @endif

      <tr >
        <td colspan="3" ></td>
        <th class="tableSubheading" >Percentage</th>
        <td>{{ $resultBag['percentage'] }}%</td>
      </tr>
      
      </tbody>
    </table>
  </center>
</div>

</body>
</html>