$(document).ready(function() 
{
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/repository/getRepositoryQuestions'; 

    $('#questionsListingTable').DataTable( 
    {
        responsive: 'true',
        serverSide: 'true',
        processing: 'true',
        ajax: targetURL,
        
        columns: [
            { "data": "id",             "ordereble": "true"},
            { "data": "question_text",  "ordereble": "true"},
            { "data": "question_type",  "ordereble": "true"},
            { "data": "right_marks",    "ordereble": "true"},
            { "data": "created_at",     "ordereble": "true"},
            { "data": "actions"}
        ],

        dom: 'Blfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ],
        lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
        aaSorting: [[0, 'DESC']]
    } );
});

function deleteQuestionFromRepository(element)
{
    var $this = $(element);
    var id = $this.attr('data-qsnid');
    
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/repository/'+id; 


    if (id != '') 
    {
        swal({
          title: "Are you sure !!",
          text: "You want to delete ?",
          type: "warning",
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Delete",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true
        }, 
        function () 
        {
            $.ajax({
                type:'DELETE',
                url:targetURL,
                dataType:'json',
                success: function(data)
                {
                    setTimeout(function () 
                    {
                        if (data.status == 'success') 
                        {
                            $('#questionsListingTable').DataTable().ajax.reload();
                            swal("Success", data.msg,'success');
                        }
                        else
                        {
                            swal("Error",data.msg,'error');
                        }
                    }, 1000);
                }
            })
        });
    }
}