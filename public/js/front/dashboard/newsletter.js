var strPath = $('meta[name="base-path"]').attr('content');

$('.successMsgAlrt').hide();
$('.errorMsgAlrt').hide();
function saveNewsletter(element)
{	
	var $this = $(element);            		
	var formData = new FormData($this[0]);	
	var action = strPath+'/newsletter';

	$.ajax(
	{
	  	type: 'POST',
	  	url: action,
	  	data: formData,
	  	processData: false,
	  	contentType: false,
	  	success: function(data)
	  	{
	    	if (data.status == 'success') 
	    	{
	    		$('.errorMsgAlrt').hide();
	    		$('.dangerMessage').html('');

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
	    		$('.dangerMessage').html(data.msg);
	    		$('#submit_button').show();
	    	}
	  	},
	  	error: function (data)
	  	{
	  		$('.errorMsgAlrt').show();
	    	$('.dangerMessage').html('Something went wrong on server, Please try again later.');
	  	}
	});

	return false
}
