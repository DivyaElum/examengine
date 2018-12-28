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
        aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0, 2 ] }],
        lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
        aaSorting: [[0, 'DESC']],
        language: {
          processing: "Loading ..."
        }
    });
});