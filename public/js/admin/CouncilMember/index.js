$(document).ready(function() 
{
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/concil-member/getMembers'; 

    $('#questionsListingTable').DataTable( 
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
            { "data": "status",         "ordereble": "true"},
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

function deleteMember(element)
{
    var $this = $(element);
    var id = $this.attr('data-qsnid');
    
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/concil-member/'+id; 


    if (id != '') 
    {
        swal({
          title: "Are you sure !!",
          text: "You want to delete ?",
          type: "info",
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
                            setTimeout(function ()
                            {
                                window.location.href = document.referrer;

                            }, 3000)
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
    var targetURL = adminPath+'/concil-member/changeStatus';


    if (id != '') 
    {
        swal({
          title: "Are you sure !!",
          text: "You want to chaange status ?",
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
                            setTimeout(function ()
                            {
                                window.location.href = document.referrer;

                            }, 3000)
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