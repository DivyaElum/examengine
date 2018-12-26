
var $Path = $('meta[name="admin-path"]').attr('content');
var $Module = '/exam';

$(document).ready(function() 
{
    var $Action = '/getRecords'; 
    var $URL    = $Path+$Module+$Action; 

    $('#listingTable').DataTable( 
    {
        responsive: 'true',
        serverSide: 'true',
        processing: 'true',
        ajax: $URL,
        columns: [
            { "data": "id",             "ordereble": "true"},
            { "data": "title",          "ordereble": "true"},
            { "data": "duration",       "ordereble": "true"},
            { "data": "total_question", "ordereble": "true"},
            { "data": "created_at",     "ordereble": "true"},
            { "data": "status",         "ordereble": "true"},
            { "data": "actions"}
        ],
        aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0, 6 ] }],
        lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
        aaSorting: [[0, 'DESC']],
        language: {
          processing: "Loading ..."
        }
    } );
});

function rwDelete(element)
{
    var $this = $(element);
    var id = $this.attr('data-rwid');

    var $Action = '/'+id; 
    var $URL    = $Path+$Module+$Action; 

    if (id != '') 
    {
        swal({
          title: "Are you sure !!",
          text: "You want to delete ?",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Delete",
          confirmButtonClass: "btn-danger",
          closeOnConfirm: false,
          showLoaderOnConfirm: true
        }, 
        function () 
        {
            $.ajax({
                type:'DELETE',
                url:$URL,
                dataType:'json',
                success: function(data)
                {
                    setTimeout(function () 
                    {
                        if (data.status == 'success') 
                        {
                            $('#listingTable').DataTable().ajax.reload();
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

function rwChanceStatus(element)
{
    var $this   = $(element);
    var id      = $this.attr('data-rwid');
    var status  = $this.attr('data-rwst');
     
    var $Action     = '/changeStatus';
    var $URL        = $Path+$Module+$Action; 

    if (id != '') 
    {
        swal({
          title: "Are you sure !!",
          text: "You want to change status ?",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Change",
          confirmButtonClass: "btn-warning",
          closeOnConfirm: false,
          showLoaderOnConfirm: true
        }, 
        function () 
        {
            $.ajax({
                type:'POST',
                data:{'id':id,'status':status},
                url:$URL,
                dataType:'json',
                success: function(data)
                {
                    setTimeout(function () 
                    {
                        if (data.status == 'success') 
                        {
                            $('#listingTable').DataTable().ajax.reload();
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