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
  <center><h2>Exam Result</h2></center>
  <br>
  <table class="table table-bordered examResultTable">
    <tbody>
    <tr class="tableMainHeading">
    <td>Features</td>
    <td>Result</td>
    </tr>
      @if(!empty($resultBag) && sizeof($resultBag) > 0)
        @foreach($resultBag as $key => $result)          
          <tr>            
            <th class="tableSubheading"> <?php echo ucfirst(str_replace('_', ' ', $key))  ?> : </th> 
            <td>{{ $result }}</td>
          </tr>
          @endif
        @endforeach
      @endif
      
    <tr class="tableFooter">
    <td colspan="2">
      <button class="btn btn-success" ><i class="fa fa-print" aria-hidden="true"></i> Print</button>
      <button class="btn btn-success" ><i class="fa fa-times-circle" aria-hidden="true"></i> close</button>
    </td>
    </tr>
      
    </tbody>
  </table>
  <hr>

  @if(!empty($resultBag['categories'] && sizeof($resultBag['categories']) > 0))
   <table class="table">
    <thead>
      <center><h3>Category Wise Result</h3></center>
    </thead>
      @if(!empty($resultBag) && sizeof($resultBag) > 0)
        @foreach($resultBag as $key => $result)
          @if( $key == 'categories')
            @foreach($result as $categoryKey => $category)
              <tbody>
                @foreach($category as $key => $value)
                  @if($key != 'category_id')
                  <tr>
                    <th> <?php echo ucfirst(str_replace('_', ' ', $key))  ?> : </th> <td>{{ $value }}</td>
                  </tr>
                  @endif
                @endforeach
              </tbody>
            @endforeach
          @endif 
        @endforeach
      @endif
    </tbody>
  </table>
  @endif
</div>

</body>
</html>
