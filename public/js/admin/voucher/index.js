$(document).ready(function() 
{
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/voucher/getVoucher'; 

    $('#listingTable').DataTable( 
    {
        responsive: 'true',
        serverSide: 'true',
        processing: 'true',
        ajax: targetURL,
        columns: [
            { "data": "id",             "ordereble": "true"},
            { "data": "voucher_code",   "ordereble": "true"},
            { "data": "user_count",     "ordereble": "true"},
            { "data": "discount",       "ordereble": "true"},
            { "data": "discount_by",    "ordereble": "true"},
            { "data": "created_at",     "ordereble": "true"},
            { "data": "actions"}
        ],
        aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0, 4 ] }],
        lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
        aaSorting: [[0, 'DESC']],
        language: {
          processing: "Loading ..."
        }
    });
});

function rwDelete(element)
{
    var $this = $(element);
    var id = $this.attr('data-rwid');

    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/voucher/'+id; 


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
                url:targetURL,
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