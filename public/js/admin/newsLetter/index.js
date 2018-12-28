$(document).ready(function() 
{
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/news-letter/getNewsLetter'; 


    $('#listingTable').DataTable( 
    {
        
        responsive: 'true',
        serverSide: 'true',
        processing: 'true',
        ajax: targetURL,
        columns: [
            { "data": "id",         "ordereble": "true"},
            { "data": "email_id",   "ordereble": "true"},
            { "data": "status",     "ordereble": "true"}
        ],
        columnDefs: [
            { "width": "20%", "targets": 0 }
        ],
        aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0, 2 ] }],
        lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
        aaSorting: [[0, 'DESC']],
        language: {
          processing: "Loading ..."
        }
    });
});

function rwChanceStatus(element)
{
    var $Module     = '/news-letter';
    var $adminPath  = $('meta[name="admin-path"]').attr('content');

    var $this   = $(element);
    var id      = $this.attr('data-rwid');
    var status  = $this.attr('data-rwst');
     
    var $Action     = '/changeStatus';
    var $URL        = $adminPath+$Module+$Action; 

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