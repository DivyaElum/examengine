var baseUrl = $('meta[name="base-path"]').attr('content')

function generatePreview(element)
{
    $('#myModal').find('embed').attr('');
	var resultId = $(element).attr('data-rd');
	var formData = new FormData();
	formData.append('result_id', resultId);

	var action = baseUrl+'/certificate/createCertificate'

	$.ajax(
    {
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: action,
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function(data)
        {
            if (data.status == 'success') 
            {
                $('#myModal').find('embed').attr('src',data.pdf);
                $('#myModal').modal('show');
            }
        }
    });
}