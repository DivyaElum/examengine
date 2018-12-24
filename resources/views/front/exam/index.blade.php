@extends('front.master')

@section('title')
	{{ $moduleAction }}
@stop


@section('styles')
<link href="{{ asset('/css/availability-calendar.css') }}" rel="stylesheet" type="text/css">

@stop
@section('page_title')
	{{ $page_title }}
@stop
@section('content')

<div class="bodyContent dashboard clearfix">
	<div class="dashboardWraper">
		<div class="container"  style="margin:10% auto;">
			<div class="row">
				<div class="col-md-9 col-sm-12 col-xs-12">
					<a href="{{ url('/exam/book') }}" class="btn btn-primary">Book Exam</a>
					<div class="dashbaord_content">
						<div class="row">
							<div class="jquery-script-ads">
								</div>
								<div class="jquery-script-clear"></div>
								</div>
								</div>
								<div class="container">
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
<script type="text/javascript" src="{{ asset('/js/availability-calendar.js') }}"></script>
<script>
var unavailableDates = [
	{start: '2018-12-20', end: '2018-12-31'}
];

$('#calendar').availabilityCalendar(unavailableDates);
</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
@stop