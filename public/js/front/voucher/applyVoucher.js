var adminPath = $('meta[name="admin-path"]').attr('content');

$('.loadingImg').hide();
function applyVoucher(element)
{
	var $this 	 = $(element);            		
	var formData = new FormData($this[0]);	
	var action 	 = $this.attr('action');
	$('#btnApply').hide();
	$('.loadingImg').show();
	$.ajax(
	{
	  	type 	: 'POST',
	  	url		: action,
	  	data    : formData,
	  	processData: false,
	  	contentType: false,
	  	success: function(data)
	  	{
	    	if (data.status == 'success') 
	    	{
	    		$('.loadingImg').hide();
	    		$('#btnApply').show();
	    		$('.error_voucher_code').hide();
	    		$this[0].reset();
    			alert(data.msg);
	    		setTimeout(function()
    			{
    				window.location.href = data.url;

    			}, 2000);
	    	}
	    	else
	    	{
	    		$('.loadingImg').hide();
	    		$('#btnApply').show();
	    		$('.error_voucher_code').html(data.msg);
	    	}
	  	}
	});

	return false
}