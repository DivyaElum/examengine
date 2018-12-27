$(document).ready(function () {
	$('.toggle-menu').click(function () {
		$('.navigation').toggleClass('openBox');
		$(".toggle-menu").toggleClass("intro");
	});
	$('.mobile_db_drawer_btn').click(function () {
		$('.mobile_db_drawer').toggleClass('openBox');
	});	
	
	if($(window).width() >= 992){
		var newsletterForm_wrap_width = $('.container.newsletterForm_wrap').width() - 360;
		//$('.newsletterForm').attr('style', 'margin-left:' + newsletterForm_wrap_width + 'px; margin-left:' + newsletterForm_wrap_width)
		$('.newsletterForm').attr('style', 'margin-left:' + newsletterForm_wrap_width + 'px');		
	}
	
	$('#servicesCarousel').owlCarousel({
		margin:30,
		responsiveClass:true,
		dots: false,
		navText : ["Previous","Next"],
    	rewindNav : true,
		center: false,
		nav:true,
		loop:true,
		responsive:{
			0:{
				items:1
			},
			480:{
				items:1
			},
			768:{
				items:2
			},
			900:{
				items:3
			},
			1200:{
				items:4
			},
			1600:{
				items:5
			}
		}
	});
	
	$('<a href="certification_list.php" class="btn small-btn">View All</a>').appendTo('#servicesCarousel .owl-nav');
	
});

$(window).resize(function () {
	if($(window).width() >= 992){
		var newsletterForm_wrap_width = $('.container.newsletterForm_wrap').width() - 360;
		//$('.newsletterForm').attr('style', 'margin-left:' + newsletterForm_wrap_width + 'px; margin-left:' + newsletterForm_wrap_width)
		$('.newsletterForm').attr('style', 'margin-left:' + newsletterForm_wrap_width + 'px');
	}
});
$(document).ready(function(){
 $(window).resize(function(){
  var footerHeight = $('footer').outerHeight();
  var stickFooterPush = $('.push').height(footerHeight);
  $('.bodyContent').css({'marginBottom':'-' + footerHeight + 'px'});
  $('<div class="push"></div>').appendTo('.bodyContent');
 });

 $(window).resize();
});
