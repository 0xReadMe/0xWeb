////////// Responsive
// Breackpoints
let breakpoints = {
	xl : 1200,
	lg : 992,
	md : 768,
	sm : 576,
	xsm: 375
};

// Media quares
let MQ = {
	wWidth : 0,
	isXL   : false,
	isLG   : false,
	isMD   : false,
	isSM   : false,
	isXSM  : false,
	updateState: function(){
		this.wWidth = $(window).width();

		for( let key in breakpoints ){
			this['is'+ key.toUpperCase()] = this.wWidth <= breakpoints[key];
		}
	}
};

MQ.updateState();

$(window).on('resize', function () {
	MQ.updateState();
});



////////// Common functions

// Popup opener
$('.js-popup').click(function (event) {
	event.preventDefault();
	let popupID = $(this).attr('href');

	mfpPopup(popupID);
});


// Mobile menu toggle
$('.js-menu').click(function () {

	$(this).toggleClass('is-active');
	$('.menu').toggleClass('opened');
});



// E-mail Ajax Send
$('form').submit(function (e) {
	e.preventDefault();

	let form = $(this);
	let formData = {};
	formData.data = {};

	// Serialize
	form.find('input, textarea').each(function () {
		let name = $(this).attr('name');
		let title = $(this).attr('data-name');
		let value = $(this).val();

		formData.data[name] = {
			title: title,
			value: value
		};

		if (name === 'subject') {
			formData.subject = {
				value: value
			};
			delete formData.data.subject;
		}
	});

	$.ajax({
		type: 'POST',
		url: 'mail/mail.php',
		dataType: 'json',
		data: formData
	}).done(function (data) {

		if (data.status === 'success') {
			if (form.closest('.mfp-wrap').hasClass('mfp-ready')) {
				form.find('.form-result').addClass('form-result--success');
			} else {
				mfpPopup('#success');
			}

			setTimeout(function () {
				if (form.closest('.mfp-wrap').hasClass('mfp-ready')) {
					form.find('.form-result').removeClass('form-result--success');
				}
				$.magnificPopup.close();
				form.trigger('reset');
			}, 3000);

		} else {
			alert('Ajax result: ' + data.status);
		}

	});
	return false;
});



////////// Ready Functions
$(document).ready(function () {

	//

});



////////// Load functions
$(window).on('load', function () {

	// 

});



/////////// mfp popup - https://dimsemenov.com/plugins/magnific-popup/
let mfpPopup = function (popupID, source) {
	$.magnificPopup.open({
		items: {
			src: popupID
		}, 
		type: 'inline',
		fixedContentPos: false,
		fixedBgPos: true,
		overflowY: 'auto',
		closeBtnInside: true,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		closeMarkup: '<button type="button" class="mfp-close">&times;</button>',
		mainClass: 'mfp-fade-zoom',
		// callbacks: {
		// 	open: function() {
		// 		$('.source').val(source);
		// 	}
		// }
	});
};

// $(document).ready(function() {
// 	$(".sample__img").fancybox();
// });

	$(document).ready(function(){
		$("#menu").on("click","a", function (event) {
			event.preventDefault();
			var id  = $(this).attr('href'),
			top = $(id).offset().top;
		$('body,html').animate({scrollTop: (top - 100)}, 1500);
	 });

	 $("#menu1").on("click","a", function (event) {
		event.preventDefault();
		var id  = $(this).attr('href'),
		top = $(id).offset().top;
	$('body,html').animate({scrollTop: (top - 100)}, 1500);
 });
 $("#menu2").on("click","a", function (event) {
	event.preventDefault();
	var id  = $(this).attr('href'),
	top = $(id).offset().top;
$('body,html').animate({scrollTop: (top - 100)}, 1500);
});
});

	$('.testimonials__slider').slick({
		nextArrow: '<button type="button" class="slick-btn slick-next"></button>',
		prevArrow: '<button type="button" class="slick-btn slick-prev"></button>',
		infinite: false,
		dots: true,
		speed: 300,
		slidesToShow: 1,
		variableWidth: true,

		responsive: [
			{
				breakpoint: 768,
				settings: {
					dots: false,
					slidesToShow: 1,
					variableWidth: false
				}
			}
		]


	});
	// $('.testimonials__slider').slick({
	// 	dots: true,
	// 	// centerMode: true,
  	// 	infinite: false,
  	// 	speed: 300,
  	// 	slidesToShow: 1,
	// 	slidesToScroll: 1,
	// 	nextArrow: '<button type="button" class="slick-btn slick-next"></button>',
    // 	prevArrow: '<button type="button" class="slick-btn slick-prev"></button>',
		

	$( ".gam" ).click(function() {
		$( ".nav" ).addClass("open");
	  });
	  
	  $( ".nav__closed" ).click(function() {
		$( ".nav" ).removeClass("open");
	  });

	// Phone input mask
$('input[type="tel"]').inputmask({
	mask: '+7 (999) 999-99-99',
	showMaskOnHover: false
});
