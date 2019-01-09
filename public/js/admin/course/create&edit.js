var $Path = $('meta[name="admin-path"]').attr('content');
var $Module = '/course';

$(document).ready(function()
{
	$('#title').focus();
	$('#duration').mask('99.99');
	$('#total_question').mask('999');
	$('#discount').mask('9999999');
	$('#amount').mask('9999999');

	$('.input-daterange').datepicker({ startDate:new Date() });	
	// $('#prerequisites').multiselect({ enableFiltering: true, buttonWidth: '100%' });
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
	  		toastr.clear()
	  		$(element).closest('.box').LoadingOverlay("hide");

	    	if (data.status == 'success') 
	    	{
	    		$this[0].reset();
    			toastr.success(data.msg);
	    		setTimeout(function ()
	    		{
	    			$('#submit_button').show();
	    			location.reload();
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


// Add and remove time slots 
function addNewSlot(element)
{
	var $this = $(element);
	
	var total_time_count = ($this.closest('.exam_days_div').find('.time_wrapper').length);
	var week_days_index = $this.closest('.exam_days_div').index();

	if (total_time_count == 3) 
	{
		return false;
	}

    var startTimeHtml = `<div class="time_wrapper">
	              			<div class="col-md-4 start_time_wrapper">
                  				<label for="">Start Time <span style="color: red">*</span></label><br>
	                  			<div class='input-group form-group datetimepicker' >
				                    <input type='text' placeholder="Start Time" onblur="return getEndTime(this)" name="exam_days[${week_days_index}][start_time][]" class="form-control start_time" />
				                    <span class="input-group-addon" >
				                        <span class="glyphicon glyphicon-time"></span>
				                    </span>
				                </div>
	              			</div>
	              			<div class="col-md-5 end_time_wrapper">
	              				<label for="">End Time <span style="color: red">*</span></label><br>
	              				<div class="row">
	              					<div class="col-md-9">
	                  					<div class='input-group form-group' >
						                    <input type='text' placeholder="End Time" readonly name="exam_days[${week_days_index}][end_time][]" class="form-control end_time" />
						                    <span class="input-group-addon" >
						                        <span class="glyphicon glyphicon-time"></span>
						                    </span>
						                </div>
				                	</div>
	              					<div class="col-md-3">
										<a class="btn btn-danger remove_new_slot" title="Remove time slot" onclick="return removeNewSlot(this)"><i class="fa fa-trash"></i></a>
				              		</div>
	              				</div>
	              			</div>
              			</div>`;


	$this.closest('.exam_days_div').append(startTimeHtml);
	$('.datetimepicker').datetimepicker({
        format: 'HH:mm'
    });
}

function removeNewSlot(element)
{
	var $this = $(element);
	$this.closest('.time_wrapper').remove();
}

function getEndTime(element)
{
	$this = $(element);	

	var duration = $('#duration').val();
	var startTime = $this.val();

	if ($.trim(duration) != '' && $.trim(startTime) != '') 
	{
		res = duration.split(".");
		durationHours = parseInt(res[0]);
		durationMin   = parseInt(res[1]);

		durationHours 	= isNaN(durationHours) ? 0 : durationHours;
		durationMin 	= isNaN(durationMin) ? 0 : durationMin;

		// get time 
		var date 		= new Date();
		var arrStartTime = startTime.split(':');
		var startTimeHour = parseInt(arrStartTime[0]);
		var startTimeMin = parseInt(arrStartTime[1]);

		// calculate Hourse
		var calculatedHour 	= date.setHours(startTimeHour + durationHours);

		// calculate minutes
		var newDate 	= new Date(calculatedHour);
		var calculatedMin 	= newDate.setMinutes(startTimeMin + durationMin);

		var final = new Date(calculatedMin);

		var endTime = final.getHours()+':'+final.getMinutes();
		$this.closest('.time_wrapper').find('.end_time').val(endTime);
	}
	else
	{
		$this.closest('.time_wrapper').find('.end_time').val('');
	}
}

// check time slot while adding duration
function checkTimeSlots()
{
	$('.start_time').each(function (index, element)
	{
		getEndTime(element);
	})
}
