var adminPath = $('meta[name="admin-path"]').attr('content');

function saveMember(element)
{
	$(element).closest('.box').LoadingOverlay("show", {
	    image       : "",
	    background  : "rgba(165, 190, 100, 0.4)",
	    fontawesome : "fa fa-cog fa-spin"
	});

	var $this = $(element);            		
	var formData = new FormData($this[0]);	
	var action = $this.attr('action');

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
    			toastr.success(data.msg);
	    		setTimeout(function ()
	    		{
	    			window.location.href = data.url;
	    		}, 2000)
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
	  		
	  		toastr.clear()
  		 	if( data.status === 422 ) 
  		 	{
	  			var errorBag = $.parseJSON(data.responseText);
		  		if (errorBag) 
		    	{
		    		var x = 0;
			    	$.each(errorBag.errors, function(row, fields)
			    	{
			    		if (x == 0) 
			    		{
			    			toastr.error(fields);
			    		}

			    		x++;
		      		});
		    	}
		    }
		    else
		    {
	  			toastr.error('Something went wrong on server, Please try again later.');
		    	
		    }
	  	}
	});

	return false
}
