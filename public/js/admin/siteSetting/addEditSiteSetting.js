var adminPath = $('meta[name="admin-path"]').attr('content');

function saveSiteSetting(element)
{
	$(element).closest('.box').LoadingOverlay("show", {
	    image       : "",
	    background  : "rgba(165, 190, 100, 0.4)",
	    fontawesome : "fa fa-cog fa-spin"
	});

	var $this = $(element);            		
	var formData = new FormData($this[0]);	
	var action = $this.attr('action');
	$('#submit_button').hide();

	$.ajax(
	{
	  	type: 'POST',
	  	url: action,
	  	data: formData,
	  	processData: false,
	  	contentType: false,
	  	success: function(data)
	  	{
	    	if (data.status == 'success') 
	    	{
	    		$this[0].reset();
    			toastr.success(data.msg);
	    		$('#submit_button').show();
	    		setTimeout(function()
    			{
    				window.location.href = data.url;

    			}, 3000);
	    	}
	    	else
	    	{
	    		console.log(data);
	    		$('#submit_button').show();
	    		toastr.error(data.msg);
	    	}

	    	$(element).closest('.box').LoadingOverlay("hide");
	  	},
	  	error: function (data)
	  	{
	  		$(element).closest('.box').LoadingOverlay("hide");
	    	$('#submit_button').show();

  		 	if( data.status === 422 ) 
  		 	{
	  			var errorBag = $.parseJSON(data.responseText);
		  		if (errorBag) 
		    	{
			    	$.each(errorBag.errors, function(row, fields)
			    	{
			    		toastr.error(fields);
		      		});
		    	}
		    }
		    else
		    {
	  			toastr.error('Something went wrong, Please try again later.');
		    	
		    }
	  	}
	});

	return false
}