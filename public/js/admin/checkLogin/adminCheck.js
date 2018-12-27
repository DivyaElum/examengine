var adminPath = $('meta[name="admin-path"]').attr('content');

function checkLogin(element)
{
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
	  		toastr.clear()
	    	if (data.status == 'success') 
	    	{
	    		$this[0].reset();
    			//toastr.success(data.msg);	
	    		$('#submit_button').show();
	    		setTimeout(function ()
	    		{
	    			window.location.href = data.url;
	    		}, 1000)
    			
	    	}
	    	else
	    	{
	    		$('#submit_button').show();
	    		toastr.error(data.msg);
	    	}

	    	$(element).closest('.box').LoadingOverlay("hide");
	  	},
	  	error: function (data)
	  	{
	  		$(element).closest('.box').LoadingOverlay("hide");
	    	$('#submit_button').show();
    		
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
		    
    	// 	$('.errortxtEmail').html('');
    	// 	$('.errortxtEmail').closest('.form-group').removeClass('has-error');
    	// 	$('.errortxtPassword').html('');
    	// 	$('.errortxtPassword').closest('.form-group').removeClass('has-error');
	    	
	    	
	    // 	if(typeof(data.responseJSON.errors.txtEmail) !== undefined)
	    // 	{
    	// 		$('.errortxtEmail').closest('.form-group').addClass('has-error');
	    // 		$('.errortxtEmail').html(data.responseJSON.errors.txtEmail);
	    // 	}
	    // 	if(typeof(data.responseJSON.errors.txtPassword) !== undefined)
	    // 	{
    	// 		$('.errortxtPassword').closest('.form-group').addClass('has-error');
	    // 		$('.errortxtPassword').html(data.responseJSON.errors.txtPassword);
	    // 	}
	  		// toastr.error('Login unsuccessful');
	  	}
	});

	return false
}

function forgotpass(element)
{
	var $this = $(element);            		
	var formData = new FormData($this[0]);	
	var action = $this.attr('action');
	$('#submit_button').hide();
	
	$.ajax({
	  	type: 'POST',
	  	url: action,
	  	data: formData,
	  	processData: false,
	  	contentType: false,
	  	success: function(data)
	  	{
	  		$('.errortxtEmail').html('');
    		$('.errortxtEmail').closest('.form-group').removeClass('has-error');
    		$('.errortxtPassword').html('');
    		$('.errortxtPassword').closest('.form-group').removeClass('has-error');

	    	if (data.status == 'success') 
	    	{
	    		$this[0].reset();
    			toastr.success(data.msg);	
	    		$('#submit_button').show();
	    		setTimeout(function ()
	    		{
	    			window.location.href = data.url;
	    		}, 1000)
	    	}
	    	else
	    	{
	    		$('#submit_button').show();
	    		toastr.error(data.msg);
	    	}
	  	},
	  	error: function (data)
	  	{
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

function resetpassword(element)
{
	var $this = $(element);            		
	var formData = new FormData($this[0]);	
	var action = $this.attr('action');
	$('#submit_button').hide();
	$urltoken = (window.location.href).split('/').reverse()[0];
	formData.append('urltoken',$urltoken);
	$.ajax({
	  	type: 'POST',
	  	url: action,
	  	data: formData,
	  	processData: false,
	  	contentType: false,
	  	success: function(data)
	  	{
	  		// $('.errorComPassword').html('');
    	// 	$('.errorComPassword').closest('.form-group').removeClass('has-error');
    	// 	$('.errorNewPassword').html('');
    	// 	$('.errorNewPassword').closest('.form-group').removeClass('has-error');

	    	if (data.status == 'success') 
	    	{
	    		$this[0].reset();
    			toastr.success(data.msg);	
	    		$('#submit_button').show();
    			setTimeout(function ()
	    		{
	    			$('#submit_button').show();
	    			window.location.href = data.url;

	    		}, 2000)
	    	}
	    	else
	    	{
	    		$('#submit_button').show();
	    		toastr.error(data.msg);
	    	}
	  	},
	  	error: function (data)
	  	{
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
    		// $('.errortxtEmail').html('');
    		// $('.errortxtEmail').closest('.form-group').removeClass('has-error');
    		
	    	// if(typeof(data.responseJSON.errors.txtNewPassword) !== undefined)
	    	// {
    		// 	$('.errorNewPassword').closest('.form-group').addClass('has-error');
	    	// 	$('.errorNewPassword').html(data.responseJSON.errors.txtNewPassword);
	    	// }
	    	// if(typeof(data.responseJSON.errors.txtComPassword) !== undefined)
	    	// {
    		// 	$('.errorComPassword').closest('.form-group').addClass('has-error');
	    	// 	$('.errorComPassword').html(data.responseJSON.errors.txtComPassword);
	    	// }
	  	}
	});
	return false
}