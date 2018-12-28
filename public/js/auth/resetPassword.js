$('#btn_submit').click(function(){
		$("form[name='frmResetPassword']").validate({
			onkeyup: false,			
			//validation rules
			rules:{
				password			:{
										required:true,
										minlength: 8,
                    					maxlength: 20,
									 },
				confirm_password	:{required:true,
									  	equalTo : "#password",
									  	minlength: 8,
                     				  	maxlength: 20
									  }
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
				    		setTimeout(function ()
				    		{
				    			window.location.href = data.url;
				    		}, 2000)
						} 
						else
						{
							$('.errorMsgAlrt').show();
			    			$('.dangerMessage').html('Something went wrong, Please try again later.');
						}						
					},
					error: function (data)
				  	{
				    	$('.errorMsgAlrt').show();
		    			$('.dangerMessage').html('Something went wrong, Please try again later.');
				  	}
				});
			}
		});
});