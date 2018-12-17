<footer>
	<div class="footer-top">
	<div class="container">
		<div class="col-md-4 col-sm-4 footer-left-box">
	    	<img src="images/msc-logo.png" width="216" height="43" alt=""/> 
			<p>Generate Lorem Ipsum placeholder text for use in your graphic, print and web layouts, and discover plugins for your favorite writing, design and blogging tools.</p>
			<ul class="social-list">
				<li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
			</ul>
		</div>
		<div class="col-md-5 col-sm-5">
			<h2>Quick Links</h2>
			<ul class="quick-links">
				<li><a href="index.php">Home</a></li>
				<li><a href="about-us.php">About Us</a></li>
				<li><a href="services.php">Services</a></li>
				<li><a href="events.php">Events</a></li>
				<li><a href="membership.php">Membership</a></li>
			</ul>
			<ul class="quick-links">
				<li><a href="Certification.php">Certification</a></li>
				<li><a href="contact-us.php">Contact Us</a></li>
			</ul>
		</div>
		<div class="col-md-3 col-sm-3 footer-last-box">
			<h2>Contact Us</h2>
			<p>
				100 Europa Drive, Suite 403 Chapel Hill, NC 27517<br>
				<a href="mailto:info@msc.com" class="footer-mail">info@msc.com</a>
				<span class="footer-tell">tel: <a href="tel:18006729205" data-title="18006729205">1-800-672-9205</a></span>
			</p>
		</div>
	</div>	
		</div>
	<div class="footer-last">
		<div class="container">
			<div class="footer-last-left">
				<span>© MSC. {{date('Y')}}}</span>
				<a href="terms-and-condition.php">Terms & Conditions</a>
				<a href="privacy-policy.php">Privacy Policy</a>
			</div>
			<div class="footer-last-right">
				<a href="#0" class="cd-top back-to-top-box">Back to top</a>
			</div>
		</div>
	</div>
</footer>	
<!--/  Jquery.min  --> 
<script src="{{ asset('js/back-to-top.js') }}"></script> 
<!-- <script src="{{ asset('js/custom.js') }}"></script>  -->
@yield('scripts')
</body>
</html>