var $Path = $('meta[name="admin-path"]').attr('content');
var $Module = '/council-member';

$(document).ready(function() 
{
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/council-member/getMembers'; 

    $('#listingTable').DataTable( 
    {
        responsive: 'true',
        serverSide: 'true',
        processing: 'true',
        ajax: targetURL,
        columns: [
            { "data": "id",             "ordereble": "true"},
            { "data": "Name",           "ordereble": "true"},
            { "data": "Email",          "ordereble": "true"},
            { "data": "Designation",    "ordereble": "true"},
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

function deleteMember(element)
{
    var $this = $(element);
    var id = $this.attr('data-qsnid');
    
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+$Module+'/'+id; 


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

function rwChanceStatus(element)
{
    var $this = $(element);
    
    var id = $this.attr('data-rwid');
    var status = $this.attr('data-rwst');
    
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/council-member/changeStatus';


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