<footer>
	<div class="footer-top">
	<div class="container">
		<div class="col-md-4 col-sm-4 footer-left-box">
	    	<img src="{{asset('images/msc-logo.png')}}" width="216" height="43" alt=""/> 
			<p>Welcome to MSC <br/>MSPAlliance began in the year 2000 with the vision of becoming the unified voice for the Managed Services Industry. </p>
			<ul class="social-list">
				<li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
			</ul>
		</div>
		<div class="col-md-5 col-sm-5">
			<h2>Quick Links</h2>
			<ul class="quick-links">
				<li>
					@if(!auth()->check())
			          <a href="{{ url('/') }}">Home</a> 
			        @else
			          <a href="{{url('/dashboard')}}">Home</a>
			        @endif
				</li>
				<li><a href="#">About Us</a></li>
				<li><a href="#">Services</a></li>
				<li><a href="#">Events</a></li>
				<li><a href="#">Membership</a></li>
			</ul>
			<ul class="quick-links">
				<li><a href="/certification">Certification</a></li>
				<li><a href="#">Contact Us</a></li>
			</ul>
		</div>
		<div class="col-md-3 col-sm-3 footer-last-box">
			<h2>Contact Us</h2>
			<p>
				<?php echo $siteSetting->address ?? ''; ?><br>
				<a href="mailto:<?php echo $siteSetting->email_id ?? ''; ?>" class="footer-mail"><?php echo $siteSetting->email_id ?? ''; ?></a>

				<span class="footer-tell">tel: <a href="tel:<?php echo $siteSetting->contact_no ?? ''; ?>" data-title="<?php echo $siteSetting->contact_no ?? ''; ?>"><?php echo $siteSetting->contact_no ?? ''; ?></a></span>
			</p>
		</div>
	</div>	
		</div>
	<div class="footer-last">
		<div class="container">
			<div class="footer-last-left">
				<span>© MSC. {{date('Y')}} <?php echo $siteSetting->footer_text ?? ''; ?></span>
				<a href="#">Terms & Conditions</a>
				<a href="#">Privacy Policy</a>
			</div>
			<div class="footer-last-right">
				<a href="#0" class="cd-top back-to-top-box">Back to top</a>
			</div>
		</div>
	</div>
</footer>	
<!--/  Jquery.min  --> 
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
{{-- <script src="{{ asset('js/back-to-top.js') }}"></script>  --}}
{{-- <script src="{{asset('js/owl.js')}}"></script> --}}
<script src="{{ asset('js/custom.js') }}"></script>
@yield('scripts')
</body>
</html>