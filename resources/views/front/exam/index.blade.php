@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop


@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
<style type="text/css">
.fc-content {cursor: pointer;}
.fc-past {color: #b0b0b0;}
.fc-time {display: none;}
</style>
@stop
@section('page_title')
	{{ $page_title }}
@stop
@section('content')

<div class="bodyContent dashboard clearfix">
	<div class="dashboardWraper">
		<div class="container" >
			<div class="container">
			    <div class="row">
			    	@include('front.partials._sidebar')
			        <div class="col-md-8 col-md-offset-2" style="margin: 50px auto;">
			        	<h2 class="text-center">Exam Slot Calender</h2><br />
			            <div class="panel panel-default">
			                <div class="panel-body">
			                    <div id="calendar"></div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>

<div id="fullCalModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title">Exam Slots</h4>
            </div>
            <div id="modalBody" class="modal-body">
            	<span id="htmlClass"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary btnBook">Book</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>

<script type="">

	$(document).ready(function() 
	{
		var examId 	  = '{{ base64_encode(base64_encode($exam_id)) }}';
		var course_id = '{{ $course_id }}';

		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
			
		var calendar = $('#calendar').fullCalendar(
		{
			selectConstraint: {
		        start: $.fullCalendar.moment().subtract(1, 'days'),
		    },
			header: 
			{
				left	: 'prev,next today',
				center 	: 'title',
				right	: 'month,agendaWeek,agendaDay'
			},

			selectable: true,
			selectHelper: true,
	        
			eventRender: function (event, element) 
			{
				element.popover(
	          	{
	              	animation:true,
	              	delay	: 300,
	              	trigger : 'hover'
	          	});

		        element.click(function() 
		        {
		        	var selectedDate = event.start._i;

					$.ajax(
					{
			            url		: '/exam/getExampSlot/',
			            type 	: 'GET',
			            dataType: 'json',
			            data 	: {
		                	id: event.id,
		                	date:selectedDate
		            	},
		            	success: function(response) {
		            		$('#fullCalModal').modal("show");
		            		$('#htmlClass').html(response);
		            	}
			        });
		        });
		    },
			
			editable: false,
			
			events: function(start, end, timezone, callback) 
			{
		        $.ajax(
		        {
		            url		: '/exam/loadEvent/',
		            type 	: 'GET',
		            dataType: 'json',
		            data 	: {
		                start : start.format(),
		                end   : end.format(),
		                id 	  : examId
		            },
		            success: function(doc) {
		                var events = [];
		                $.map( doc, function( r ) {
		                	console.log(r);
		                	events.push({
	                            title: r.title,
	                            start: r.start,
	                            end: r.end,
	                            id: r.id,
	                        });
	                    });
		                callback(events);
		            }
		        });
		    },
		});
	});


	$(".btnBook").click(function()
	{
		var userId   = "{{ base64_encode(base64_encode($arrUserData->id)) }}";
		var examId   = '{{ base64_encode(base64_encode($exam_id)) }}';
		var courseId = '{{ $course_id }}';
		var slotTime = $('input[name=slot]:checked').val();
		var requestedDate = $('input[name="date"]').val();
		if(slotTime)
		{
			$.ajax({
			    url: '/exam/bookExamSlot/',
			    type: 'POST',
			    dataType: 'json',
			    data: {
			        exam_id   : examId,
			        user_id   : userId,
			        course_id : courseId,
			        slot_time : slotTime,
			        date : requestedDate
			    },
			    success: function(response) {
			        if (response.status == 'success') 
		    		{
		    			alert(response.msg);
		    			setTimeout(function ()
			    		{
			    			$('#submit_button').show();
			    			window.location.href = document.referrer;
			    		}, 2000)
		    		}else{
		    			alert(response.msg);
		    		}
			    }
			});
		}
		else
		{
			alert('Please select any one slot');
			return false;
		}
	});

</script>

@stop