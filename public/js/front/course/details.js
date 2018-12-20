var $Path = $('meta[name="base-path"]').attr('content');

function  startExam(element)
{
	var token = $(element).attr('data-token');

	if (token != '') 
	{
		// varify token  and check this exam available for today or not.
		// var formData = new FormData;
		// formData.append('token', token);

		var action = $Path+'/course/'+token+'/varify';

		$.ajax(
		{
		  	type: 'GET',
		  	url: action,
		  	data:formData,
		  	processData: false,
		  	contentType: false,
		  	success: function(data)
		  	{		
		  		console.log(data);
		  	},
		  	error: function (data)
		  	{
		  	}
		});
	}
}