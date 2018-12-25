var $Path = $('meta[name="admin-path"]').attr('content');
var $Module = '/course';

$(document).ready(function()
{
	$('#discount').mask('9999999');
	$('#amount').mask('9999999');

	$('#prerequisites').multiselect({ enableFiltering: true, buttonWidth: '100%' });
})

function calculateAmount(element)
{
	$this = $(element);
	$('.err_calculated_amount').html('');
	$('.err_amount').html('');

	var amount = $('#amount').val();
	var discount = $('#discount').val();
	var discount_by = $('#discount_by').val();

	var totalAmount = 0;

	// amount validation 

	if (amount == '' || isNaN(amount) ) 
	{
		$('.err_amount').html('Please enter valid amount.');
		$('#calculated_amount').val('');
		return false;
	}

	totalAmount = amount;

	if(discount != '' && !isNaN(discount))
	{
		discount_by = discount_by.toLowerCase();

		switch(discount_by)
		{
			case 'flat':
				totalAmount = amount-discount;
				console.log(totalAmount);
			break;

			case '%':
				discounte_amount = (amount*discount)/100; 
				totalAmount = amount-discounte_amount;
			break;
		} 
	}

	if (totalAmount > 0 && !isNaN(totalAmount)) 
	{	
		$('#calculated_amount').val(totalAmount);
	}
	else if(totalAmount != '' || totalAmount == 0) 
	{
		$('.err_calculated_amount').html('Invalid calculated amount.');
		$('#calculated_amount').val(totalAmount);
	}
}

// priview image
function readURL(input) 
{
    $('.err_featured_image').html('');

	var value = (input.value).toLowerCase();

	var allowedExtensions = /(\.jpeg|\.jpg|\.png|\.gif)$/i;
  	if(!allowedExtensions.exec(value))
  	{
	    $('.err_featured_image').html('Image format not supported, Image format should be in png, jpg or gif.')
	    $("#featured_image").val('');
	    $('#delete_button').hide();
	    return false;
  	}

  	if (input.files && input.files[0]) 
  	{
    	var reader = new FileReader();
    	reader.onload = function(e) 
    	{
      		$('#preview').attr('src', e.target.result);
      		 $('#delete_button').show();
    	}
    	
    	reader.readAsDataURL(input.files[0]);
  	}
}

function deletePreviewImage(element)
{
	$('#preview').attr('src', defaultImaage);
	$("#featured_image").val('');
	$('#delete_button').hide();
	$('#old_image').val('');
}

// save form data
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
