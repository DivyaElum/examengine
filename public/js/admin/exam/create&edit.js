
var $Path = $('meta[name="admin-path"]').attr('content');
var $Module = '/exam';

// initialize timepicker
$(function () {
    $('.datetimepicker').datetimepicker({
        format: 'HH:mm'
    });
});

$(document).ready(function()
{
	$('#title').focus();
	$('#duration').mask('99.99');
	$('#total_question').mask('999');
	$('#discount').mask('9999999');
	$('#amount').mask('9999999');

	$('#category').multiselect(
	{ 	
		enableFiltering: true, 
	 	buttonWidth: '100%',
	 	nonSelectedText: 'Select Categories',
	 	onChange: function(option, checked, select) 
	 	{
       		setDynamicQuesions();
    	}
	});

	$('#exam_questions').multiselect(
	{ 
		enableFiltering: true, 
		buttonWidth: '100%', 
		nonSelectedText: 'Select Questions' 
	});
	
	$('.input-daterange').datepicker({ startDate:new Date() });	
})

// submit form
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

//  add category wise questions 
function setDynamicQuesions()
{
	var categories = $('#category').val();
	if (categories != '') 
	{
		var formData = new FormData();
		formData.append('categories', categories);

		$Action = '/getDynamicQuesions';
		$URL = $Path+$Module+$Action;

		$.ajax(
		{
		  	type: 'POST',
		  	url: $URL,
		  	data: formData,
		  	processData: false,
		  	contentType: false,
		  	success: function(data)
		  	{
		  		var previousId = [];
				$('#exam_questions option:selected').each(function (key, option)
				{
					var option_id = $(option).val();
					if (previousId.indexOf(option_id) == '-1') 
					{
						previousId.push(parseInt(option_id));
					}
				});
	  			
	  			$('#exam_questions').empty();

	  			var questionCount = 0;
		  		if (data.questions != '') 
		  		{
		  			$.each(data.questions, function (index, question)
		  			{
  						if (previousId.indexOf(question.id) != '-1') 
  						{
  							$('#exam_questions')
				         	.append($("<option></option>")
	                    	.attr("value",question.id)
	                    	.attr("selected", "selected")
		                    .text(question.question_text)); 
  						}
  						else
  						{
  							$('#exam_questions')
				         	.append($("<option></option>")
	                    	.attr("value",question.id)
		                    .text(question.question_text)); 
  						}

		                $('#exam_questions').multiselect('rebuild');
		  			})

		  			questionCount = data.questions.length;
		  		}
		  		else
		  		{
		  			questionCount = data.questions.length;
		  		}

		  		$('#questionsCount').html(questionCount);
		  	},
		  	error: function (data)
		  	{

		  	}
		});
	}
	else
	{
		$('#exam_questions').empty();
		$('#exam_questions').multiselect('rebuild');
	}
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

// function addNewDay(element)
// {
// 	var $this = $(element);

// 	var index = $('.exam_days_div').length;
// 	if (index == 3) 
// 	{
// 		return false
// 	}

// 	var htmldata =`
// 			<div class="exam_days_div clearfix">
//       			<div class="col-md-12">
// 	                <div class="form-group">
// 	                  	<label for="">Exam Days <span style="color: red">*</span></label><br>
// 	                  	<div class="row">
// 	                  		<div class="col-md-11">
// 			                  	<select name="exam_days[${index}][day]" class="form-control exam_days">
// 			                  		${daysOptions}
// 			                  	</select>
// 	                  		</div>
// 	                  		<div class="col-md-1">
// 								<a class="btn btn-danger remove_day" title="Remove exam day" onclick="return removeDay(this)"><i class="fa fa-trash"></i></a>
// 	                  		</div>
// 	                  	</div>
// 	                </div>
//       			</div>
//       			<div class="time_wrapper">
//           			<div class="col-md-4 start_time_wrapper">
//           				<label for="">Start Time <span style="color: red">*</span></label><br>
//               			<div class='input-group form-group datetimepicker' >
// 		                    <input type='text' placeholder="Start Time" onblur="return getEndTime(this)" name="exam_days[${index}][start_time][]" class="form-control start_time" />
// 		                    <span class="input-group-addon" >
// 		                        <span class="glyphicon glyphicon-time"></span>
// 		                    </span>
// 		                </div>
//           			</div>
//           			<div class="col-md-5 end_time_wrapper">
//           				<label for="">End Time <span style="color: red">*</span></label><br>
//           				<div class="row">
//           					<div class="col-md-9">
//               					<div class='input-group form-group' >
// 				                    <input type='text' placeholder="End Time" readonly name="exam_days[${index}][end_time][]" class="form-control end_time" />
// 				                    <span class="input-group-addon" >
// 				                        <span class="glyphicon glyphicon-time"></span>
// 				                    </span>
// 				                </div>
// 		                	</div>
//           					<div class="col-md-3">
// 								<a class="btn btn-info add_new_slot" title="Add new time slot" onclick="return addNewSlot(this)"><i class="fa fa-plus"></i></a>
//           					</div>
//           				</div>
//           			</div>
//       			</div>
//   			</div>`;


// 	$(htmldata).insertAfter($('.exam_days_wrapper').find('.exam_days_div').last());
// 	$('.datetimepicker').datetimepicker({
//         format: 'HH:mm'
//     });

// 	return false;
// }

// function removeDay(element)
// {
// 	var $this = $(element);
// 	$this.closest('.exam_days_div').remove();
// 	$('.add_new_day').show();

// 	$('.exam_days_div').each(function(index, html)
// 	{		
// 		// changing exam days name
// 		var exam_days = $(html).find('.exam_days').attr('name');		
// 		var temp_name = exam_days.split('][');
// 		var new_name  = 'exam_days['+index+']['+temp_name[1];
// 		$(html).find('.exam_days').attr('name', new_name);

// 		// changing start time name
// 		var start_time = $(html).find('.start_time').attr('name');		
// 		var temp_name2 = start_time.split('][');
// 		var new_name2  = 'exam_days['+index+']['+temp_name2[1]+'][]';
// 		$(html).find('.start_time').attr('name', new_name2);

// 		// changing end time name
// 		var start_time = $(html).find('.end_time').attr('name');		
// 		var temp_name2 = start_time.split('][');
// 		var new_name2  = 'exam_days['+index+']['+temp_name2[1]+'][]';
// 		$(html).find('.end_time').attr('name', new_name2);
// 	})
// }

// calculate end time
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

// calculate exam
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