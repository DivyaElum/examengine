function saveMember(element)
{
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
	  		alert('Register successfully');
	  		setTimeout(function ()
	    	{
	    		window.location.href = '/register';
	    	}, 1000)
	  	},
	  	error: function (data)
	  	{
	  		console.log(data);
	  		$('.error').removeClass('has-error');
		   	$('.error').find('.help-block').html('');
			
	      	if( data.status === 422 ) 
	      	{
		      var errorBag = $.parseJSON(data.responseText);
		      if (errorBag) 
		       {
		        $.each(errorBag.errors, function(row, fields)
		        {
		        	$('.error_'+row).closest('.form-group').addClass('has-error');
		         	$('.error_'+row).html(fields);
		        });
		       }
		    }
		    else
		    {
		      alert('Something went wrong, Please try again later.');
		    }
	  	}
	});

	return false
}