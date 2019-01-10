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


function setVideoType(element)
{
	$this = $(element);

	var checkedType = $this.val();
	$this.closest('.prerequisite_div').find('.options').hide();
	$this.closest('.prerequisite_div').find('.'+checkedType).show();
}

function addNewPrerequisite(element)
{
	$this = $(element);

	var $this = $(element);
	
	var index = ($('.prerequisite_wrapper').find('.prerequisite_div').length);	

	if (index > 5) 
	{
		$this.hide();
		return false;
	}


    var html = `<div class="prerequisite_div clearfix">
					<div class="col-md-12">
			            <div class="form-group">
			              	<label for="">Display name <span style="color: red">*</span></label>
			              	<div class="row">
			              		<div class="col-md-11">
			                  		<input type="text" name="prerequisite[${index}][title]" class="form-control title" placeholder="Enter Title" maxlength="100">
			              		</div>
			              		<div class="col-md-1">
			              			<a class="btn btn-danger remove_new_slot" title="Remove time slot" onclick="return removePrerequisite(this)"><i class="fa fa-trash"></i></a>
			              		</div>
			              	</div>
			            </div>
					</div>	

					<div class="col-md-11">
						<label>Type <span style="color: red">*</span></label>
			            <div class="form-group">
						    <label class="radio-inline">
						      <input type="radio" onclick="setVideoType(this)" class="radiobutton"  name="prerequisite[${index}][type]" checked value="file">Video File
						    </label>
						    <label class="radio-inline">
						      <input type="radio" onclick="setVideoType(this)" class="radiobutton" name="prerequisite[${index}][type]" value="pdf">Pdf File
						    </label>
						    <label class="radio-inline">
						      <input type="radio" onclick="setVideoType(this)" class="radiobutton" name="prerequisite[${index}][type]" value="url">Video URL
						    </label>
						    <label class="radio-inline">
						      <input type="radio" onclick="setVideoType(this)" class="radiobutton" name="prerequisite[${index}][type]" value="youtube">Youtube URL
						    </label>
						    <label class="radio-inline">
						      <input type="radio" onclick="setVideoType(this)" class="radiobutton" name="prerequisite[${index}][type]" value="other">Other
						    </label>
			            </div>
					</div>	

					<div class="col-md-11 options file">
			            <div class="form-group">
			              	<label for="">Video File</label>
			                  	<input type="file"  name="prerequisite[${index}][video_file]" accept=".mpg,.mpeg,.avi,.wmv,.mov,.rm,.ram,.swf,.flv,.ogg,.webm,.mp4"  class="video_file form-control option_input" >
			              	</select>
			            </div>
					</div>

					<div class="col-md-11 options pdf" style="display: none;">
			            <div class="form-group">
			              	<label for="">Pdf File</label>
			                  	<input type="file"  name="prerequisite[${index}][pdf_file]" accept=".pdf" class="pdf_file form-control option_input" >
			              	</select>
			            </div>
					</div>

					<div class="col-md-11 options url" style="display: none;">
			            <div class="form-group">
			              	<label for="">Video URL</label>
			                  	<input type="text" name="prerequisite[${index}][video_url]" class="video_url form-control option_input" placeholder="Enter Video URL" >
			              	</select>
			            </div>
					</div>	
					
					<div class="col-md-11 options youtube" style="display: none;" >
			            <div class="form-group">
			              	<label for="">Youtube URL</label>
			              	<input type="text" name="prerequisite[${index}][youtube_url]" class="youtube_url form-control option_input" placeholder="Enter Youtube URL">
			            </div>
					</div>	

					<div class="col-md-11 options other" style="display: none;" >
			            <div class="form-group">
			              	<label for="">Other</label>
			              	<textarea type="text" name="prerequisite[${index}][other]" class="other_input form-control option_input" placeholder="Enter Description"></textarea>
			            </div>
					</div>	
				</div>`;


	$('.prerequisite_wrapper').append(html);
}

function removePrerequisite(element)
{
	$this = $(element);
	$this.closest('.prerequisite_div').remove();

	// reorder index
	$('.prerequisite_div').each(function(index, html)
	{
		// radio buttons		
		var radiobutton = $(html).find('.radiobutton').attr('name');
		var temp_name = radiobutton.split('][');
		var new_name  = 'prerequisite['+index+']['+temp_name[1];
		$(html).find('.radiobutton').attr('name', new_name);

		// title
		var title = $(html).find('.title').attr('name');
		var temp_name1 = title.split('][');
		var new_name1  = 'prerequisite['+index+']['+temp_name1[1];
		$(html).find('.title').attr('name', new_name1);

		// video file
		var video_file = $(html).find('.video_file').attr('name');	
		var temp_name2 = video_file.split('][');
		var new_name2  = 'prerequisite['+index+']['+temp_name2[1];
		$(html).find('.video_file').attr('name', new_name2);

		// pdf file
		var pdf_file = $(html).find('.pdf_file').attr('name');		
		var temp_name3 = pdf_file.split('][');
		var new_name3  = 'prerequisite['+index+']['+temp_name3[1];
		$(html).find('.pdf_file').attr('name', new_name3);

		// video url
		var video_url = $(html).find('.video_url').attr('name');		
		var temp_name4 = video_url.split('][');
		var new_name4  = 'prerequisite['+index+']['+temp_name4[1];
		$(html).find('.video_url').attr('name', new_name4);

		// youtube url
		var youtube_url = $(html).find('.youtube_url').attr('name');		
		var temp_name5 = youtube_url.split('][');
		var new_name5  = 'prerequisite['+index+']['+temp_name5[1];
		$(html).find('.youtube_url').attr('name', new_name5);

		//  other
		var other = $(html).find('.other_input').attr('name');		
		var temp_name6 = other.split('][');
		var new_name6  = 'prerequisite['+index+']['+temp_name6[1];
		$(html).find('.other_input').attr('name', new_name6);
	})	
}

// function hideOldVideoFile()
// {
// 	$('.old_video_file_class').hide().find('input').val('');

// 	$('.video_file_class').show();
// }

// function hideOldPdfFile()
// {
// 	$('.old_pdf_file_class').hide().find('input').val('');
	
// 	$('.pdf_file_class').show();
// }