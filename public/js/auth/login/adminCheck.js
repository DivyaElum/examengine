var adminPath = $('meta[name="admin-path"]').attr('content');

function checkLogin(element)
{
	var $this = $(element);            		
	var formData = new FormData($this[0]);	
	var action = '/sign-up/login';
	//$('#submit_button').hide();
	
	$.ajax(
	{
	  	type: 'POST',
	  	url: action,
	  	data: formData,
	  	processData: false,
	  	contentType: false,
	  	success: function(data)
	  	{
	  		$('.error').removeClass('has-error');
		   	$('.error').find('.help-block').html('');
		   	
	    	if (data.status == 'success') 
	    	{
	    		$this[0].reset();
	    		$('.errorLoginMsgAlrt').hide();
			    $('.dangerLoginMessage').html('');
    			$('.successLoginMsgAlrt').show();
			    $('.successLoginMessage').html(data.msg);
	    	}
	    	else
	    	{
	    		//$('#submit_button').show();
	    		$('.errorLoginMsgAlrt').show();
			    $('.dangerLoginMessage').html(data.msg);
	    	}
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
		        	$('.errors_'+row).closest('.form-group').addClass('has-error');
		         	$('.errors_'+row).html(fields);
		        });
		       }
		    }
		    else
		    {
		  		$('.errorLoginMsgAlrt').show();
				$('.dangerLoginMessage').html('Something went wrong, Please try again later.');
		    }
	  // 		$('.errorLoginMsgAlrt').show();
			// $('.dangerLoginMessage').html('Login unsuccessful');
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
    			//window.location.href = data.url;
    			console.log(data.url);
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
    		
    		$('.errortxtEmail').html('');
    		$('.errortxtEmail').closest('.form-group').removeClass('has-error');
    		
	    	console.log(data.responseJSON);
	    	if(typeof(data.responseJSON.errors.txtEmail) !== undefined)
	    	{
    			$('.errortxtEmail').closest('.form-group').addClass('has-error');
	    		$('.errortxtEmail').html(data.responseJSON.errors.txtEmail);
	    	}
	  		toastr.error('Send Email unsuccessful');
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
	  		$('.errorComPassword').html('');
    		$('.errorComPassword').closest('.form-group').removeClass('has-error');
    		$('.errorNewPassword').html('');
    		$('.errorNewPassword').closest('.form-group').removeClass('has-error');

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
    		
    		$('.errortxtEmail').html('');
    		$('.errortxtEmail').closest('.form-group').removeClass('has-error');
    		
	    	if(typeof(data.responseJSON.errors.txtNewPassword) !== undefined)
	    	{
    			$('.errorNewPassword').closest('.form-group').addClass('has-error');
	    		$('.errorNewPassword').html(data.responseJSON.errors.txtNewPassword);
	    	}
	    	if(typeof(data.responseJSON.errors.txtComPassword) !== undefined)
	    	{
    			$('.errorComPassword').closest('.form-group').addClass('has-error');
	    		$('.errorComPassword').html(data.responseJSON.errors.txtComPassword);
	    	}
	  		toastr.error('something error');
	  	}
	});
	return false
}