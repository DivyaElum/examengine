$(document).ready(function()
{	
	$('input[name="right_marks"]').mask('99');
	

	var multiple_choice = $('.multiple_choice').find('.options').length;
	if (multiple_choice == 8) 
	{
		$('.add_new_choice').hide();
	}	


	var multiple_response = $('.multiple_response').find('.options').length;
	if (multiple_response == 8) 
	{
		$('.add_new_response').hide();
	}	

})

var adminPath = $('meta[name="admin-path"]').attr('content');

// common
function saveQuestion(element)
{
	$(element).closest('.box').LoadingOverlay("show", {
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

function getStructure(element)
{
	var $this = $(element);
	var type = $this.val();

	targetPath = adminPath+'/question/getHtmlStructure/'+type;

	$.get(targetPath, function(data)
	{
		if (data != 'Not Found') 
		{
			$('.html_data').html(data);
			$('input[name="right_marks"]').mask('99');
		}
		else
		{
			notfoundhtml = `
				<div class="col-md-12">
            		${ data }
					</div>
			`;
			$('.html_data').html(`<span style='text-align:center'>${ notfoundhtml }</span>`);
		}
	
	}, 'json');  


}

function getIndexByCount(index)
{
	var reponseData = {};
	reponseData.radioValue = '';
	reponseData.radioName = '';

	var targetPath = adminPath+'/question/getOptionsAnswer/'+index;

	$.ajax({
        'async': false,
        'type': "GET",
        'global': false,
        'dataType': 'json',
        'url': targetPath,
        'success': function (data) 
        {
        	if (data.status == 'success') 
        	{
        		reponseData.radioValue = data.value;
				reponseData.radioName = data.name;
        	}
        }
    });

	return reponseData;
}

// Multiple choice options

function AddMultipleChoiceOption(element)
{
	var $this = $(element);

	var total = ($('.multiple_choice').find('.options').length + 1);
	
	if (total == 8) 
	{
		$this.hide();
	}	            

	$indexData = getIndexByCount(total);

	var name  = $indexData.radioName;
	var value = $indexData.radioValue;
	var title = value.toUpperCase();

	var htmldata =`
		<div class="options">
			<div class="col-md-11">
              	<div class="input-group">
                    <span class="input-group-addon">
                    	<label>${ title }</label><br>
                      <input type="radio" name="correct" value="${ value }">
                    </span>
                	<textarea type="text" class="form-control" name="${ name }"></textarea>
      			</div><br>
  			</div>
			<div class="col-md-1">
				<i class="fa fa-trash" onclick="return removeMultipleChoiceOption(this)"></i>
			</div>
		</div>`;


	$(htmldata).insertAfter($('.multiple_choice').find('.options').last());

	return false;
}

function removeMultipleChoiceOption(element)
{
	$this = $(element);
	$this.closest('.options').remove();
	$('.multiple_choice').find(".add_new_choice").show();
	refreshMultipleChoiceOption();          			
}

function refreshMultipleChoiceOption()
{
	$('.multiple_choice').find('.options').each(function(index, html)
	{
		var total = (index+1);

		$indexData = getIndexByCount(total);
		var name  = $indexData.radioName;
		var value = $indexData.radioValue;
		var title = value.toUpperCase();

		$(html).find("label").text(title);
		$(html).find("input[name='correct']").val(value);
		$(html).find("textarea").attr('name', name);
	})
}

// Multiple response

function AddMultipleResponseOption(element)
{
	var $this = $(element);

	var total = ($('.multiple_response').find('.options').length + 1);
	
	if (total == 8) 
	{
		$this.hide();
	}	            

	$indexData = getIndexByCount(total);

	var name  = $indexData.radioName;
	var value = $indexData.radioValue;
	var title = value.toUpperCase();

	var htmldata =`
		<div class="options">
			<div class="col-md-11">
              	<div class="input-group">
                    <span class="input-group-addon">
                    	<label>${ title }</label><br>
                      <input type="checkbox" name="correct[]" value="${ value }">
                    </span>
                	<textarea type="text" class="form-control" name="${ name }"></textarea>
      			</div><br>
  			</div>
			<div class="col-md-1">
				<i class="fa fa-trash" onclick="return removeMultipleResponseOption(this)"></i>
			</div>
		</div>`;


	$(htmldata).insertAfter($('.multiple_response').find('.options').last());

	return false;
}

function removeMultipleResponseOption(element)
{
	$this = $(element);
	$this.closest('.options').remove();
	$('.multiple_response').find(".add_new_response").show();
	refreshMultipleResponseOption();         
}

function refreshMultipleResponseOption()
{
	$('.multiple_response').find('.options').each(function(index, html)
	{
		var total = (index+1);

		$indexData = getIndexByCount(total);
		var name  = $indexData.radioName;
		var value = $indexData.radioValue;
		var title = value.toUpperCase();

		$(html).find("label").text(title);
		$(html).find("input[name='correct']").val(value);
		$(html).find("textarea").attr('name', name);
	})
}
