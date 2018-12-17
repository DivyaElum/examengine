$('#btn_submit').click(function(){
		$("form[name='frmResetPassword']").validate({
			onkeyup: false,			
			//validation rules
			rules:{
				password			:{required:true},
				confirm_password	:{required:true,equalTo : "#password"}
			},
			// validation messages
			messages:{
				password			: { required:"Please enter password"},
				confirm_password	: { required:"Please enter confirm password"}
			},
			//submit handler
		   submitHandler: function(form){
		   	var formData = new FormData(form);
			   $.ajax({
					type: "POST", 
					dataType: "JSON",
					url: "/resetpassword",
					data: formData,
					processData: false,
	  				contentType: false,
					success: function(data) {
						$('.error').removeClass('has-error');
					   	$('.error').find('.help-block').html('');
						if(data.status == 'success')
						{
							form.reset();
							$('.successMsgAlrt').show();
			    			$('.successMessage').html(data.msg);
				    		// setTimeout(function ()
				    		// {
				    		// 	window.location.href = data.url;
				    		// }, 10000)
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
});