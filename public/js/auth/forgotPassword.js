$('#btn_submit').click(function(){
		$("form[name='frmForgotPassword']").validate({
			onkeyup: false,			
			//validation rules
			rules:{
				email	:{required:true}
			},
			// validation messages
			messages:{
				email 	: { required:"Please enter email"}
			},
			//submit handler
		   submitHandler: function(form){
		   	var formData = new FormData(form);
			   $.ajax({
					type: "POST", 
					dataType: "JSON",
					url: "/forgot",
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
					  		$('.errorLoginMsgAlrt').show();
				    		$('.dangerLoginMessage').html(data.msg);
						}						
					},
					error: function (data)
				  	{
				  		$('.errorLoginMsgAlrt').show();
			    		$('.dangerLoginMessage').html(data.msg);
				  	}
				});
			}
		});
});