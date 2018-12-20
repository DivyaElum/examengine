
function makePayment(element)
{
	var $this = $(element);            		
	var formData = new FormData($this[0]);	
	var action = $this.attr('action');

	$.LoadingOverlay('show');

	$.ajax(
	{
	  	type: 'POST',
	  	url: action,
	  	data: formData,
	  	processData: false,
	  	contentType: false,
	  	success: function(data)
	  	{
	  		$.LoadingOverlay("hide");

	    	if (data.status == 'success') 
	    	{
    			window.location.href = data.url;
	    	}
	    	else
	    	{
	    		toastr.error(data.msg);
	    	}
	  	},
	  	error: function (data)
	  	{
	  		toastr.error('Something went wrong, Please try again later.');
	  		$.LoadingOverlay("hide");
	  	}
	});

	return false
}