
var $Path = $('meta[name="admin-path"]').attr('content');
var $Module = '/prerequisite';

$(document).ready(function ()
{
	$('#title').focus();
	
	setVideoType(false);	
	hideOldVideoFile();	
	hideOldPdfFile();	
})

function saveFormData(element)
{
	$(element).closest('.box').LoadingOverlay("show", 
	{
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
	  		toastr.clear()
	  		$(element).closest('.box').LoadingOverlay("hide");

	    	if (data.status == 'success') 
	    	{
	    		$this[0].reset();
    			toastr.success(data.msg);
	    		setTimeout(function ()
	    		{
	    			$('#submit_button').show();
	    			window.location.href = document.referrer;
	    		}, 3000)
	    	}
	    	else
	    	{
	    		$('#submit_button').show();
	    		toastr.error(data.msg);
	    	}
	
	  	},
	  	error: function (data)
	  	{
	  		$(element).closest('.box').LoadingOverlay("hide");
	    	$('#submit_button').show();

	  		// $('.form-group').removeClass('has-error');
			// $('.form-group').find('.help-block').html('');

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

function setVideoType(flag)
{
	var checkedType = $('input[name="type"]:checked').val();
	
	if(flag)
	{
		$('.options').find('.option_input').val('');
	}

	$('.options').hide();
	$('.'+checkedType).show();
}

function hideOldVideoFile()
{
	$('.old_video_file_class').hide().find('input').val('');
	$('.video_file_class').show();
}

function hideOldPdfFile()
{
	$('.old_pdf_file_class').hide().find('input').val('');
	$('.pdf_file_class').show();
}