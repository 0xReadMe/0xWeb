jQuery(function($){
    
    $('.menu-mobile').on('click',function(){
    	if (!$(this).hasClass('opnd')) {
    		$(this).addClass('opnd').prev().slideDown(200);
    	}
    	else {
    		$(this).removeClass('opnd').prev().slideUp(200);
    	}
    })
    let wid = $(window).width();

    $('.menu-items ul a,.menu a').on('click',function(e){
    	e.preventDefault();
    	let block = $(this).attr('href');

    	$('body,html').animate({
    		scrollTop: $(block).offset().top
    	},600);

    	if (wid < 640) {
    		$('.menu-mobile').removeClass('opnd').prev().slideUp(200);
    	}
    })
    
});