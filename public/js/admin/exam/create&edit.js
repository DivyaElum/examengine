
var $Path = $('meta[name="admin-path"]').attr('content');
var $Module = '/exam';

$(function () {
    $('.datetimepicker').datetimepicker({
        format: 'HH:mm'
    });
});

$(document).ready(function()
{	
	var count = $('.exam_days_div').length;
	if (count >= 3) 
	{
		$('.add_new_day').hide();
	}

	$('#category').multiselect(
	{ 	
		enableFiltering: true, 
	 	buttonWidth: '100%',
	 	onChange: function(option, checked, select) 
	 	{
       		setDynamicQuesions();
    	}
	});

	$('#exam_questions').multiselect({ enableFiltering: true, buttonWidth: '100%' });
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
		  		if (data.questions != '') 
		  		{
	  				$('#exam_questions').empty();
		  			$.each(data.questions, function (index, question)
		  			{
		  				$('#exam_questions')
				         	.append($("<option></option>")
	                    	.attr("value",question.id)
		                    .text(question.question_text)); 

		                $('#exam_questions').multiselect('rebuild');
		  			})
		  		}
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

function addNewSlot(element)
{
	var $this = $(element);
	
	var total_time_count = ($this.closest('.exam_days_div').find('.start_time_div').length + 1);
	var week_days_index = $this.closest('.exam_days_div').index();

	if (total_time_count == 3) 
	{
		return false;
	}

	var startTimeHtml = `<div class="start_time_div">
							<div class="col-md-9">
				            <div class="form-group">
				            </div>
							</div>
							<div class="col-md-2">
				            <div class="form-group">
				              	<label for="">Start Time <span style="color: red">*</span></label><br>
				              	<div class="row">
				              		<div class="col-md-9">
				              			<div class='input-group datetimepicker' >
						                    <input type='text' name="exam_days[${week_days_index}][start_time][]" class="form-control start_time" />
						                    <span class="input-group-addon" >
						                        <span class="glyphicon glyphicon-time"></span>
						                    </span>
						                </div>
				              		</div>
				              		<div class="col-md-2">
										<a class="btn btn-danger remove_new_slot" onclick="return removeNewSlot(this)"><i class="fa fa-trash"></i></a>
				              		</div>
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
	$this.closest('.start_time_div').remove();
}

function addNewDay(element)
{
	var $this = $(element);

	var index = $('.exam_days_div').length;
	var count = ($('.exam_days_div').length + 1);
	if (count == 3) 
	{
		$this.hide();
	}
	
	var htmldata =`
			<div class="exam_days_div">
      			<div class="col-md-9">
	                <div class="form-group">
	                  	<label for="">Exam Days <span style="color: red">*</span></label><br>
		                  	<select name="exam_days[${index}][day]" class="form-control exam_days">
		                  	${daysOptions}
		                  	</select>
	                  	</select>
	                </div>
      			</div>
      			<div class="col-md-2">
	                <div class="form-group">
	                  	<label for="">Start Time <span style="color: red">*</span></label><br>
	                  	<div class="row">
	                  		<div class="col-md-9">
	                  			<div class='input-group datetimepicker' >
				                    <input type='text' name="exam_days[${index}][start_time][]" class="form-control start_time" />
				                    <span class="input-group-addon" >
				                        <span class="glyphicon glyphicon-time"></span>
				                    </span>
				                </div>
	                  		</div>
	                  		<div class="col-md-3" style="white-space:nowrap;">
								<a class="btn btn-info add_new_slot" onclick="return addNewSlot(this)"><i class="fa fa-plus"></i></a>
	                  			&nbsp;&nbsp;&nbsp;
      							<a href="javascript:void(0)" class="remove_day" onclick="return removeDay(this)" ><i class="fa fa-trash" style="color: red;font-size: 20px;" title="Delete"></i></a>
	                  		</div>
	                  	</div>
	                </div>
      			</div>
  			</div>`;


	$(htmldata).insertAfter($('.exam_days_wrapper').find('.exam_days_div').last());
	$('.datetimepicker').datetimepicker({
        format: 'HH:mm'
    });

	return false;
}

function removeDay(element)
{
	var $this = $(element);
	$this.closest('.exam_days_div').remove();
	$('.add_new_day').show();

	$('.exam_days_div').each(function(index, html)
	{		
		// changing exam days name
		var exam_days = $(html).find('.exam_days').attr('name');		
		var temp_name = exam_days.split('][');
		var new_name  = 'exam_days['+index+']['+temp_name[1];
		$(html).find('.exam_days').attr('name', new_name);

		// changing start time name
		var start_time = $(html).find('.start_time').attr('name');		
		var temp_name2 = start_time.split('][');
		var new_name2  = 'exam_days['+index+']['+temp_name2[1]+'][]';
		$(html).find('.start_time').attr('name', new_name2);
	})
}