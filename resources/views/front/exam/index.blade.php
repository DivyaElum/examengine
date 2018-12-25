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
              content: '<b>Inicio</b>:'+event.start+"<b>Fin</b>:"+event.end,
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
			dayClick: function(date, jsEvent, view, resourceObj) {

			    alert('Date: ' + date.format());
			    alert('Resource ID: ' + resourceObj.id);

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
		            	
		                var events = [];
		                $.map( doc, function( r ) {
		                	console.log(r);
		                        events.push({
		                            title: r.title,
		                            start: r.start,
		                            end: r.end
		                        });
		                    });
		                callback(events);
		            }
		        });
		    }
		});
		
	});

</script>
{!! $calendar->script() !!}
@stop