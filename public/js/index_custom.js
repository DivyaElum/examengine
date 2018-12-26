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

/****   Datepicker  ****/
 $(function () {
   var bindDatePicker = function() {
		$(".date").datetimepicker({
        format:'YYYY-MM-DD',
			icons: {
				time: "fa fa-clock-o",
				date: "fa fa-calendar",
				up: "fa fa-arrow-up",
				down: "fa fa-arrow-down"
			}
		}).find('input:first').on("blur",function () {
			// check if the date is correct. We can accept dd-mm-yyyy and yyyy-mm-dd.
			// update the format if it's yyyy-mm-dd
			var date = parseDate($(this).val());

			if (! isValidDate(date)) {
				//create date based on momentjs (we have that)
				date = moment().format('YYYY-MM-DD');
			}

			$(this).val(date);
		});
	}
   
   var isValidDate = function(value, format) {
		format = format || false;
		// lets parse the date to the best of our knowledge
		if (format) {
			value = parseDate(value);
		}

		var timestamp = Date.parse(value);

		return isNaN(timestamp) == false;
   }
   
   var parseDate = function(value) {
		var m = value.match(/^(\d{1,2})(\/|-)?(\d{1,2})(\/|-)?(\d{4})$/);
		if (m)
			value = m[5] + '-' + ("00" + m[3]).slice(-2) + '-' + ("00" + m[1]).slice(-2);

		return value;
   }
   
   bindDatePicker();
 });
