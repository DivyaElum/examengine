$(document).ready(function() 
{
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/site-setting/getSettings'; 

    $('#listingTable').DataTable( 
    {
        responsive: 'true',
        serverSide: 'true',
        processing: 'true',
        ajax: targetURL,
        columns: [
            { "data": "id",         "ordereble": "true"},
            { "data": "site_title", "ordereble": "true"},
            { "data": "email_id",   "ordereble": "true"},
            { "data": "updated_at", "ordereble": "true"},
            { "data": "actions"}
        ],
        lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
        aaSorting: [[0, 'DESC']]
    });
});