@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop


@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

@stop
@section('page_title')
	{{ $page_title }}
@stop
@section('content')

<!-- @include('front.partials._sidebar') -->
<div class="bodyContent dashboard clearfix">
	<div class="dashboardWraper">
		<div class="container"  style="margin:10% auto;">
			<div class="container">
			    <div class="row">
			        <div class="col-md-8 col-md-offset-2">
			            <div class="panel panel-default">
			                <div class="panel-body">
			                    <!-- {!! $calendar->calendar() !!} -->
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
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary"><a id="eventUrl" target="_blank">Event Page</a></button>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<script type="">
	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		

		var calendar = $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			selectable: true,
			selectHelper: true,
        eventRender: function(event, element){
          element.popover({
              animation:true,
              delay: 300,
              trigger: 'hover'
          });

        },
		select: function(start, end, allDay) {
			var title = prompt('Event Title:');
			if (title) {
				calendar.fullCalendar('renderEvent',
					{
						title: title,
						start: start,
						end: end,
						allDay: allDay
					},
					true // make the event "stick"
				);
			}
			calendar.fullCalendar('unselect');
		},
		eventRender: function (event, element) {
	        element.click(function() {
				 $.ajax({
		            url: '/exam/getExampSlot/',
		            type: 'POST',
		            dataType: 'json',
		            data: {
	                	id: event.id,
	            	},
		        });
	            
	        });
	    },
		editable: true,
		events: function(start, end, timezone, callback) {
	        $.ajax({
	            url: '/exam/loadEvent/',
	            type: 'POST',
	            dataType: 'json',
	            data: {
	                start: start.format(),
	                end: end.format()
	            },
	            success: function(doc) {
	            	console.log(doc);
	                var events = [];
	                $.map( doc, function( r ) {
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

</script>

@stop