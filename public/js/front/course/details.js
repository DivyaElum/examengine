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
		  	// data:formData,
		  	processData: false,
		  	contentType: false,
		  	dataType:'json',
		  	success: function(data)
		  	{		
		  		if (data.status == 'success') 
		  		{
		  			var Params = ', directories=no';
			    	  	Params += ', channelmode=no';
			          	Params += ', fullscreen=yes';
			          	Params += ', location=no';
			          	Params += ', menubar=no';
			          	Params += ', resizable=yes';
			          	Params += ', scrollbars=no';
			          	Params += ', status=no';
			          	Params += ', titlebar=no';
			          	Params += ', toolbar=no';

	          		var ExamWindow = window.open(data.url,'_blank' , Params);
		  		}
		  		else
		  		{
		  			console.log('Something went wrong, Please try again later.');
		  		}
		  	},
		  	error: function (data)
		  	{
		  		console.log('Something went wrong, Please try again later.');
		  	}
		});
	}
}