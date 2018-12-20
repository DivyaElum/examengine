<div class="col-md-3 mobile_db_drawer">
	<div class="mobile_db_drawer_btn">
		<i class="fa fa-arrow-right" aria-hidden="true"></i>
	</div>
	<div class="db_sidebar">
		<div class="dashboardTitle">Dashboard view</div>
		<div class="dashboardUser_bx">
			@if(auth()->check())
			<div class="userName">{{$arrUserData->information->first_name}}  {{$arrUserData->information->last_name}}</div>
			@endif
			<div class="userId">User id : #211090</div>
		</div>
		<div class="dbMenus">
			<ul>
				<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> View Profile</a></li>
				<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Account</a></li>
				<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Video Courses</a></li>
				<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> PDF files</a></li>
				<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Settings</a></li>
				<li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Payment</a></li>
			</ul>				
		</div>
	</div>
</div>