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
$('#btn_register').click(function()
{
	var userRole = $('input[name=user_role]:checked').val();
	
	if(userRole == 'candidate')
	{
		$("form[name='frmRegister']").validate({
			onkeyup: false,			
			//validation rules
			rules:{
				organisation_name	:{required:true},
				organisation_image	:{required:true},
				first_name			:{required:true},
				last_name			:{required:true},
				email				:{required:true},
				password			:{required:true,},
				confirm_password	:{required:true},
				telephone_no		:{required:true},
			},
			// validation messages
			messages:{
				organisation_name 	: { required:"Please enter organisation name"},
				organisation_image 	: { required:"Please enter first name"},
				first_name 			: { required:"Please enter first name"},
				last_name 			: { required:"Please enter last name"},
				email 				: { required:"Please enter email Id"},
				password			: { required:"Please enter password"},
				confirm_password	: { required:"Please enter confirm password"},
				telephone_no		: { required:"Please enter telephone number"},
			},
			//submit handler
		   submitHandler: function(form){
		   	var formData = new FormData(form);
			   $.ajax({
					type: "POST", 
					dataType: "JSON",
					url: "/signup",
					data: formData,
					processData: false,
	  				contentType: false,
					success: function(data) {
						$('.error').removeClass('has-error');
					   	$('.error').find('.help-block').html('');
						if(data.status == 'success')
						{
							form.reset();
							$('.errorMsgAlrt').hide();
			    			$('.dangerMessage').html('');
			    			
							$('.successMsgAlrt').show();
			    			$('.successMessage').html(data.msg);
				    		// setTimeout(function ()
				    		// {
				    		// 	window.location.href = data.url;
				    		// }, 10000)
				    		$("html, body").animate({scrollTop : 0},700);
						} 
						else
						{
							$('.errorMsgAlrt').show();
			    			$('.dangerMessage').html('Something went wrong, Please try again later.');
						}						
					},
					error: function (data)
				  	{
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
					    	$('.errorMsgAlrt').show();
			    			$('.dangerMessage').html('Something went wrong, Please try again later.');
					    }
				  	}
				});
			}
		});
	}
	else
	{
		$("form[name='frmRegister']").validate({
			onkeyup: false,			
			//validation rules
			rules:{
				first_name			:{required:true},
				last_name			:{required:true},
				email				:{required:true},
				password			:{required:true,},
				confirm_password	:{required:true},
				telephone_no		:{required:true},
			},
			// validation messages
			messages:{
				first_name 			: { required:"Please enter first name"},
				last_name 			: { required:"Please enter last name"},
				email 				: { required:"Please enter email Id"},
				password			: { required:"Please enter password"},
				confirm_password	: { required:"Please enter confirm password"},
				telephone_no		: { required:"Please enter telephone number"},
			},
			//submit handler
		   submitHandler: function(form){
		   	var formData = new FormData(form);
			   $.ajax({
					type: "POST", 
					dataType: "JSON",
					url: "/signup",
					data: formData,
					processData: false,
	  				contentType: false,
					success: function(data) {
						$('.error').removeClass('has-error');
					   	$('.error').find('.help-block').html('');
						if(data.status == 'success')
						{
							form.reset();
							$('.errorMsgAlrt').hide();
			    			$('.dangerMessage').html('');

							$('.successMsgAlrt').show();
			    			$('.successMessage').html(data.msg);
				    		// setTimeout(function ()
				    		// {
				    		// 	window.location.href = data.url;
				    		// }, 10000)
				    		$("html, body").animate({scrollTop : 0},700);
						} 
						else
						{
							$('.errorMsgAlrt').show();
			    			$('.dangerMessage').html('Something went wrong, Please try again later.');
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
					        	$('.error_'+row).closest('.form-group').addClass('has-error');
					         	$('.error_'+row).html(fields);
					        });
					       }
					    }
					    else
					    {
					    	$('.errorMsgAlrt').show();
			    			$('.dangerMessage').html('Something went wrong, Please try again later.');
					    }
				  	}
				});
			}
		});
	}
});

$(document).ready(function() {
	if(getUserType == 'candidate'){
    	$('.organisationFiledDiv').show();
    }else{
    	$('.organisationFiledDiv').hide();
    }
	 
	$("input[name$='user_role']").click(function() {
	    var userRole = $(this).val();

	    if(userRole == 'candidate'){
	    	$('.organisationFiledDiv').show();
	    }else{
	    	$('.organisationFiledDiv').hide();
	    }
	});
});
