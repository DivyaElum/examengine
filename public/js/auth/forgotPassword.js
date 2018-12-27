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
		   	$('#btn_submit').hide();
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
							$('#btn_submit').show();
							form.reset();
							$('.errorLoginMsgAlrt').hide();
				    		$('.dangerLoginMessage').html('');

							$('.successLoginMsgAlrt').show();
			    			$('.successLoginMessage').html(data.msg);
				    		setTimeout(function ()
				    		{
				    			window.location.href = data.url;
				    		}, 1000)
						} 
						else
						{
							$('#btn_submit').show();
					  		$('.errorLoginMsgAlrt').show();
				    		$('.dangerLoginMessage').html(data.msg);
						}						
					},
					error: function (data)
				  	{
				  		$('#submit_button').show();
				  		$('.errorLoginMsgAlrt').show();
			    		$('.dangerLoginMessage').html(data.msg);
				  	}
				});
			}
		});
});