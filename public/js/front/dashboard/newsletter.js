var strPath = $('meta[name="base-path"]').attr('content');

function saveNewsletter(element)
{
	var $this = $(element);            		
	var formData = new FormData($this[0]);	
	var action = strPath+'/newsletter';

	$.ajax(
	{
	  	type: 'POST',
	  	url: action,
	  	data: formData,
	  	processData: false,
	  	contentType: false,
	  	success: function(data)
	  	{
	  		toastr.clear()
	    	if (data.status == 'success') 
	    	{
	    		$this[0].reset();
    			console.log(data.msg);
	    		setTimeout(function ()
	    		{
	    			window.location.href = data.url;
	    		}, 2000)
	    	}
	    	else
	    	{
	    		console.log(data);
	    		$('#submit_button').show();
	    		console.log(data.msg);
	    	}
	  	},
	  	error: function (data)
	  	{
	  		console.log('Something went wrong on server, Please try again later.');
	  	}
	});

	return false
}
