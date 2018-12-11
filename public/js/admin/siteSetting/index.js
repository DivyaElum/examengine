$(document).ready(function() 
{
    var adminPath = $('meta[name="admin-path"]').attr('content');
    var targetURL = adminPath+'/site-setting/getSettings'; 

    $('#questionsListingTable').DataTable( 
    {
        responsive: 'true',
        serverSide: 'true',
        processing: 'true',
        ajax: targetURL,
        columns: [
            { "data": "id",         "ordereble": "true"},
            { "data": "title",      "ordereble": "true"},
            { "data": "value",      "ordereble": "true"},
            { "data": "created_at", "ordereble": "true"},
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
    });
});