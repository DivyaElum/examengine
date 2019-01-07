<div class="col-md-3 mobile_db_drawer">
	<div class="mobile_db_drawer_btn">
		<i class="fa fa-arrow-right" aria-hidden="true"></i>
	</div>
	<div class="db_sidebar">
		<div class="dashboardTitle">Dashboard view</div>
		<div class="dashboardUser_bx">
			@if(auth()->check())
			<div class="userName"><a href="/dashboard">{{ ucfirst($arrUserData->information->first_name) }} {{ucfirst($arrUserData->information->last_name)}}</a></div>
			@endif
			<!-- <div class="userId">User id : #211090</div> -->
		</div>
		<div class="dbMenus">
			<ul>
				<li class="{{ active('dashboard') }}" >
					<a href="/dashboard"><i class="fa fa-caret-right" aria-hidden="true"></i> Dashboard</a>
				</li>
				
				<li class="{{ active('course/*') }}" >
					<a href="/course/course-listing"><i class="fa fa-caret-right" aria-hidden="true"></i> My Courses</a>
				</li>

				<li class="{{ active(['certificate/*', 'certificate']) }}" >
					<a href="{{route('certificate')}}"><i class="fa fa-caret-right" aria-hidden="true"></i> My Certificates</a>
				</li>
				
				<li class="" >
					<a href="javascript:void(0)"><i class="fa fa-caret-right" aria-hidden="true"></i> View Profile</a>
				</li>

				<!-- <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Account</a></li>
				<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Video Courses</a></li>
				<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> PDF files</a></li>
				<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Settings</a></li>
				<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Payment</a></li> -->
			</ul>				
		</div>
	</div>
</div>