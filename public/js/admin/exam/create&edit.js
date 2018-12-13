
var $Path = $('meta[name="admin-path"]').attr('content');
var $Module = '/exam';

$(document).ready(function()
{
	$('#category').multiselect({ 	
									enableFiltering: true, 
								 	buttonWidth: '400px',
								 	onChange: function(option, checked, select) 
								 	{
					               		setDynamicaQuesions();
					            	}
								});

	$('#exam_days').multiselect({ enableFiltering: true, buttonWidth: '400px' });
	$('#exam_questions').multiselect({ enableFiltering: true, buttonWidth: '400px' });
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

function setDynamicaQuesions()
{	
	var categories = $('#category').val();
	
}