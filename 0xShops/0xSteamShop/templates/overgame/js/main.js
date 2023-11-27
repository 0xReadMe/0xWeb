jQuery.fn.exists = function(){ return this.length > 0; }
function sleep(millis) {
    var t = (new Date()).getTime();
    var i = 0;
    while (((new Date()).getTime() - t) < millis) {
        i++;
    }
}

function responses(id_goods,page){
	$.get("/engine/ajax/resp_block.php?id_goods=" + id_goods + "&page=" + page, function(result){
		if (result.length>10){
			$(".digiseller-reviews_content").html(result);}
	});
}

function list_view(){
	$('#catalog-list>div').addClass('catalog-list').removeClass('net-list');
	$(".jspPane dd").attr("onclick","alert(1)");
}
function item_view(){
	$('#catalog-list>div').addClass('net-list').removeClass('catalog-list');
	//$(".net-list .item-link").append($(".net-list .item-main"));
	
}

function filter(){
	//if(tags) location.href = "/tags/"+tags;
	$("#dle-content").remove();
	$("#main-catalog").prepend('<div style="width:100%;height:100%" class="lds-ripple"><div></div><div></div></div>');
	
	setTimeout(function(){
		var tags = $("#select-select-markSelect .jspPane .selected").text();
		var publisher = $("#publisher .jspPane .selected").text();
		var fromDateR = $("#select-select-fromDateSelect .jspPane .selected").text();
		var toDateR = $("#select-select-toDateSelect .jspPane .selected").text();
		var sort_type = $("select[name=sort]").val(); 
		if(tags == "Поиск по метке") tags = "";
		var active = Array();
		var i = 0;
		$('ul[data-filter="activation"] li').each(function(index, element) {
			if($(this).hasClass("checked")){
				active[i] = $(this).find("input").attr("data-data");
				++i;
			}
		});
		var type = Array();
		i = 0;
		$('ul[data-filter="categories"] li').each(function(index, element) {
			if($(this).hasClass("checked")){
				type[i] = $(this).find("input").attr("data-data");
				++i;
			}
		});
		var avail = Array();
		i = 0;
		$('ul[data-filter="avail"] li').each(function(index, element) {
			if($(this).hasClass("checked")){
				avail[i] = $(this).find("input").attr("data-data");
				++i;
			}
		});
		var genres = Array();
		i = 0;
		$('ul[data-filter="genres"] li').each(function(index, element) {
			if($(this).hasClass("checked")){
				genres[i] = $(this).find("input").attr("data-data");
				++i;
			}
		});
		var players = Array();
		i = 0;
		$('ul[data-filter="players"] li').each(function(index, element) {
			if($(this).hasClass("checked")){
				players[i] = $(this).find("input").attr("data-data");
				++i;
			}
		});
		var characteristics = Array();
		i = 0;
		$('ul[data-filter="characteristics"] li').each(function(index, element) {
			if($(this).hasClass("checked")){
				characteristics[i] = $(this).find("input").attr("data-data");
				++i;
			}
		});
		var language = Array();
		i = 0;
		$('ul[data-filter="language"] li').each(function(index, element) {
			if($(this).hasClass("checked")){
				language[i] = $(this).find("input").attr("data-data");
				++i;
			}
		});
		var platforms = Array();
		i = 0;
		$('ul[data-filter="platforms"] li').each(function(index, element) {
			if($(this).hasClass("checked")){
				platforms[i] = $(this).find("input").attr("data-data");
				++i;
			}
		});
		var pricemin,pricemax;
		if($("#price-range-min-price").exists()){
			pricemin = $("#price-range-min-price").val();
		}else{
			pricemin = false;
		}
		if($("#price-range-max-price").exists()){
			pricemax = $("#price-range-max-price").val();
		}else{
			pricemax = false;
		}
		var filter = {
			pricemin: pricemin,
			pricemax: pricemax,
			tags: tags,
			active: active,
			type:type,
			avail:avail,
			genres:genres,
			players:players,
			characteristics:characteristics,
			language:language,
			platforms:platforms,
			publisher:publisher,
			fromDateR:fromDateR,
			toDateR:toDateR,
			sort_type:sort_type
		};
		console.log(filter);
		
		$.ajax({
		  type: "POST",
		  url: "/engine/ajax/some.php",
		  data: "filter="+JSON.stringify(filter)+"&location=Boston",
		  success: function(msg){
			console.log(msg);
			$("#main-catalog").html(msg);
			$(document).scrollTop(60);
			var now = 0;
			var CountInt2 = setInterval(function(){
				if($("#catalog-list .item").exists()){
					$("#catalog-list .item").each(function(index, element) {
						count_g = ++index;
					});
					if(now != count_g){ 
						++now;
					}else{
						clearInterval(CountInt2);
					}
					$(".list-find-counter>.counter").text(now)
				}else{
					clearInterval(CountInt2);
				}
			},10);
		  }
		});
	},300);
	
}
$(document).ready(function() {
	setTimeout(function(){
		$(".selectList dd").bind("click",function(){
			//$("input[name^=story]").val($(this).text());
			filter($(this).text());
			});
	},500);
	
var CountInt = setInterval(function(){
	now = parseInt($(".list-find-counter>.counter").text());
	if($("#catalog-list .item").exists()){
		$("#catalog-list .item").each(function(index, element) {
			count_g = ++index;
		});
		if(now != count_g){ 
			++now;
		}else{
			clearInterval(CountInt);
			
		}
		$(".list-find-counter>.counter").text(now)
	}else{
		
		$("#main-catalog").prepend('<div style="width:100%;height:100%" class="lds-ripple"><div></div><div></div></div>');
		$.ajax({
		  type: "POST",
		  url: "/engine/ajax/some.php",
		  data: "name=John&location=Boston",
		  success: function(msg){
			 // console.log(msg);
			$("#main-catalog").html(msg);
			var CountInt2 = setInterval(function(){
				if($("#catalog-list .item").exists()){
					$("#catalog-list .item").each(function(index, element) {
						count_g = ++index;
					});
					if(now != count_g){ 
						++now;
					}else{
						clearInterval(CountInt2);
					}
					$(".list-find-counter>.counter").text(now)
				}
		  	},10);
		  }
		});
		clearInterval(CountInt);	
	}
			
		
},10);

var limit = 11;


$(".catalog-tab-content.active .prev-arrow").addClass("slick-disabled");
$(".catalog-tab-content.active .next-arrow").addClass("slick-disabled");
$(".catalog-tab-content.active .slick-track>.item").each(function(index, element) {
    if(index < limit){
		$(this).show();
	}else{
		$(this).hide();
	}
	if(index === limit){
		$(".catalog-tab-content.active .next-arrow").removeClass("slick-disabled");
	}
});

$(".content.left .prev-arrow").bind("click",function(){
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,first_index = 0, itter = limit;
		$(this).closest(".catalog-tab-content").find(".catalog-list .item").each(function(index, element) {
			if($(element).hasClass("show") && itter){
				if(!first_index){first_index = index;}
				$(element).removeClass("show").fadeOut("fast");
			}
			max_index = index;
		});
		for(i=1;i<=limit;++i){
			$(".catalog-tab-content.active .catalog-list .item").eq(first_index-i).fadeIn("fast").addClass("show");
		}
		if(first_index-limit === 0){
			$(".catalog-tab-content.active .prev-arrow").addClass("slick-disabled");
			$(".catalog-tab-content.active .next-arrow").removeClass("slick-disabled");
		}else{
			$(".catalog-tab-content.active .next-arrow").removeClass("slick-disabled");
		}
	}
});
$(".content.left .next-arrow").bind("click",function(){
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,last_index = 0, itter = limit;
		$(this).closest(".catalog-tab-content").find(".catalog-list .item").each(function(index, element) {
			if($(element).css("display") === "block" && itter){
				$(element).removeClass("show").fadeOut("fast");
				setTimeout(function(){
					$(element).closest(".catalog-tab-content").find(".catalog-list .item").eq(index+limit).addClass("show");	
				},150);	
				last_index = index+limit;
				--itter;
			}
			max_index = index;
		});
		if(last_index >= max_index){
			$(".catalog-tab-content.active .next-arrow").addClass("slick-disabled");
			$(".catalog-tab-content.active .prev-arrow").removeClass("slick-disabled");
		}
		if(limit <= last_index){
			$(".catalog-tab-content.active .prev-arrow").removeClass("slick-disabled");
		}else{
			$(".catalog-tab-content.active .prev-arrow").addClass("slick-disabled");
		}
	}
});


$(".catalog-tab-list > li").bind("click", function(){
	var max_index = 0;
	$(".catalog-tab-content").removeClass("active");
	$(".catalog-tab-list > li").removeClass("active");
	$(this).addClass("active");
	var id = $(this).find("span").attr("id");
	id = id.split("-");
	id = id[0];
	$("#"+id).addClass("active");
	$("#"+id).find(".item").each(function(index, element) {
		if(index < limit){
			$(this).fadeIn("fast").addClass("show");
		}else{
			$(this).removeClass("show").hide();
		}
		max_index = index;
    });
	if(limit > max_index){
		$(".catalog-tab-content.active .prev-arrow").addClass("slick-disabled");
		$(".catalog-tab-content.active .next-arrow").addClass("slick-disabled");
	}else{
		$(".catalog-tab-content.active .prev-arrow").addClass("slick-disabled");
		$(".catalog-tab-content.active .next-arrow").removeClass("slick-disabled");
	}
	
});



var limit2 = 9;


$(".top-sale .prev-arrow").addClass("slick-disabled");
$(".top-sale .next-arrow").addClass("slick-disabled");
$(".top-sale .top-sale-list>.item").each(function(index, element) {
    if(index < limit2){
		$(this).show();
	}else{
		$(this).hide();
	}
	if(index === limit2){
		$(".top-sale .next-arrow").removeClass("slick-disabled");
	}
});



$(".top-sale .prev-arrow").bind("click",function(){
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,first_index = 0, itter = limit2;
		$(this).closest(".top-sale").find(".top-sale-list .item").each(function(index, element) {
			if($(element).hasClass("show") && itter){
				if(!first_index){first_index = index;}
				$(element).removeClass("show").fadeOut("fast");
			}
			max_index = index;
		});
		for(i=1;i<=limit2;++i){
			$(".top-sale .top-sale-list .item").eq(first_index-i).fadeIn("fast").addClass("show");
		}
		if(first_index-limit2 === 0){
			$(".top-sale .prev-arrow").addClass("slick-disabled");
			$(".top-sale .next-arrow").removeClass("slick-disabled");
		}else{
			$(".top-sale .next-arrow").removeClass("slick-disabled");
		}
	}
});
$(".top-sale .next-arrow").bind("click",function(){
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,last_index = 0, itter = limit2;
		$(this).closest(".top-sale").find(".top-sale-list .item").each(function(index, element) {
			if($(element).css("display") === "block" && itter){
				$(element).removeClass("show").fadeOut("fast");
				setTimeout(function(){
					$(element).closest(".top-sale").find(".top-sale-list .item").eq(index+limit2).fadeIn("slow").addClass("show");	
				},100);				
				last_index = index+limit2;
				--itter;
			}
			max_index = index;
		});
		if(last_index >= max_index){
			$(".top-sale .next-arrow").addClass("slick-disabled");
			$(".top-sale .prev-arrow").removeClass("slick-disabled");
		}
		if(limit <= last_index){
			$(".top-sale .prev-arrow").removeClass("slick-disabled");
		}else{
			$(".top-sale .prev-arrow").addClass("slick-disabled");
		}
	}
});






var limit3 = 6;


$(".reviews .prev-arrow").addClass("slick-disabled");
$(".reviews .next-arrow").addClass("slick-disabled");
$(".reviews .review-list>.item").each(function(index, element) {
    if(index < limit3){
		$(this).show();
	}else{
		$(this).hide();
	}
	if(index === limit3){
		$(".reviews .next-arrow").removeClass("slick-disabled");
	}
});



$(".reviews .prev-arrow").bind("click",function(){
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,first_index = 0, itter = limit3;
		$(this).closest(".reviews").find(".review-list .item").each(function(index, element) {
			if($(element).hasClass("show") && itter){
				if(!first_index){first_index = index;}
				$(element).removeClass("show").fadeOut("fast");
			}
			max_index = index;
		});
		for(i=1;i<=limit3;++i){
			$(".reviews .review-list .item").eq(first_index-i).fadeIn("fast").addClass("show");
		}
		if(first_index-limit3 === 0){
			$(".reviews .prev-arrow").addClass("slick-disabled");
			$(".reviews .next-arrow").removeClass("slick-disabled");
		}else{
			$(".reviews .next-arrow").removeClass("slick-disabled");
		}
	}
});
$(".reviews .next-arrow").bind("click",function(){
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,last_index = 0, itter = limit3;
		$(this).closest(".reviews").find(".review-list .item").each(function(index, element) {
			if($(element).css("display") === "block" && itter){
				$(element).removeClass("show").fadeOut("fast");
				setTimeout(function(){
					$(element).closest(".reviews").find(".review-list .item").eq(index+limit3).fadeIn("slow").addClass("show");	
				},100);				
				last_index = index+limit3;
				--itter;
			}
			max_index = index;
		});
		if(last_index >= max_index){
			$(".reviews .next-arrow").addClass("slick-disabled");
			$(".reviews .prev-arrow").removeClass("slick-disabled");
		}
		if(limit <= last_index){
			$(".reviews .prev-arrow").removeClass("slick-disabled");
		}else{
			$(".reviews .prev-arrow").addClass("slick-disabled");
		}
	}
});




var limit4 = 8;


$(".action  .prev-arrow").addClass("slick-disabled");
$(".action  .next-arrow").addClass("slick-disabled");
$(".action  .action-list>.item").each(function(index, element) {
    if(index < limit4){
		$(this).show();
	}else{
		$(this).hide();
	}
	if(index === limit4){
		$(".action  .next-arrow").removeClass("slick-disabled");
	}
});



$(".action  .prev-arrow").bind("click",function(){
	console.log(1);
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,first_index = 0, itter = limit4;
		$(this).closest(".action ").find(".action-list .item").each(function(index, element) {
			if($(element).hasClass("show") && itter){
				if(!first_index){first_index = index;}
				$(element).removeClass("show").fadeOut("fast");
			}
			max_index = index;
		});
		for(i=1;i<=limit4;++i){
			$(".action  .action-list .item").eq(first_index-i).fadeIn("fast").addClass("show");
		}
		console.log(first_index);
		if(first_index-limit4 === 0){
			$(".action  .prev-arrow").addClass("slick-disabled");
			$(".action  .next-arrow").removeClass("slick-disabled");
		}else{
			$(".action  .next-arrow").removeClass("slick-disabled");
		}
	}
});
$(".action  .next-arrow").bind("click",function(){
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,last_index = 0, itter = limit4;
		$(this).closest(".action ").find(".action-list .item").each(function(index, element) {
			if($(element).css("display") === "block" && itter){
				$(element).removeClass("show").fadeOut("fast");
				setTimeout(function(){
					$(element).closest(".action ").find(".action-list .item").eq(index+limit4).fadeIn("slow").addClass("show");	
				},100);				
				last_index = index+limit4;
				--itter;
			}
			max_index = index;
		});
		if(limit <= last_index){
			$(".action  .prev-arrow").removeClass("slick-disabled");
		}else{
			$(".action  .prev-arrow").addClass("slick-disabled");
		}
		if(last_index >= max_index){
			$(".action .next-arrow").addClass("slick-disabled");
			$(".action .prev-arrow").removeClass("slick-disabled");
		}
	}
});



$(".price-change  .prev-arrow").addClass("slick-disabled");
$(".price-change  .next-arrow").addClass("slick-disabled");
$(".price-change  .price-change-list>.item").each(function(index, element) {
    if(index < limit4){
		$(this).show();
	}else{
		$(this).hide();
	}
	if(index === limit4){
		$(".price-change  .next-arrow").removeClass("slick-disabled");
	}
});



$(".price-change  .prev-arrow").bind("click",function(){
	console.log(1);
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,first_index = 0, itter = limit4;
		$(this).closest(".price-change ").find(".price-change-list .item").each(function(index, element) {
			if($(element).hasClass("show") && itter){
				if(!first_index){first_index = index;}
				$(element).removeClass("show").fadeOut("fast");
			}
			max_index = index;
		});
		for(i=1;i<=limit4;++i){
			$(".price-change  .price-change-list .item").eq(first_index-i).fadeIn("fast").addClass("show");
		}
		console.log(first_index);
		if(first_index-limit4 === 0){
			$(".price-change  .prev-arrow").addClass("slick-disabled");
			$(".price-change  .next-arrow").removeClass("slick-disabled");
		}else{
			$(".price-change  .next-arrow").removeClass("slick-disabled");
		}
	}
});
$(".price-change  .next-arrow").bind("click",function(){
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,last_index = 0, itter = limit4;
		$(this).closest(".price-change ").find(".price-change-list .item").each(function(index, element) {
			if($(element).css("display") === "block" && itter){
				$(element).removeClass("show").fadeOut("fast");
				setTimeout(function(){
					$(element).closest(".price-change ").find(".price-change-list .item").eq(index+limit4).fadeIn("slow").addClass("show");	
				},100);				
				last_index = index+limit4;
				--itter;
			}
			max_index = index;
		});
		if(last_index >= max_index){
			$(".price-change  .next-arrow").addClass("slick-disabled");
			$(".price-change  .prev-arrow").removeClass("slick-disabled");
		}
		if(limit <= last_index){
			$(".price-change  .prev-arrow").removeClass("slick-disabled");
		}else{
			$(".price-change  .prev-arrow").addClass("slick-disabled");
		}
	}
});


var limit5 = 4;


$(".latest-sale  .prev-arrow").addClass("slick-disabled");
$(".latest-sale  .next-arrow").addClass("slick-disabled");
$(".latest-sale  .latest-sale-list .item").each(function(index, element) {
    if(index < limit5){
		$(this).show();
	}else{
		$(this).hide();
	}
	if(index === limit5){
		$(".latest-sale  .next-arrow").removeClass("slick-disabled");
	}
});



$(".latest-sale  .prev-arrow").bind("click",function(){
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,first_index = 0, itter = limit5;
		$(this).closest(".latest-sale").find(".latest-sale-list .item").each(function(index, element) {
			if($(element).hasClass("show") && itter){
				if(!first_index){first_index = index;}
				$(element).removeClass("show").fadeOut("fast");
			}
			max_index = index;
		});
		for(i=1;i<=limit5;++i){
			$(".latest-sale .latest-sale-list .item").eq(first_index-i).fadeIn("fast").addClass("show");
		}
		if(first_index-limit5 === 0){
			$(".latest-sale .prev-arrow").addClass("slick-disabled");
			$(".latest-sale .next-arrow").removeClass("slick-disabled");
		}else{
			$(".latest-sale .next-arrow").removeClass("slick-disabled");
		}
	}
});
$(".latest-sale  .next-arrow").bind("click",function(){
	if(!$(this).hasClass("slick-disabled")){
		var max_index = 0,last_index = 0, itter = limit5;
		$(this).closest(".latest-sale").find(".latest-sale-list .item").each(function(index, element) {
			if($(element).css("display") === "block" && itter){
				$(element).removeClass("show").fadeOut("fast");
				setTimeout(function(){
					$(element).closest(".latest-sale").find(".latest-sale-list .item").eq(index+limit5).fadeIn("slow").addClass("show");	
				},100);				
				last_index = index+limit5;
				--itter;
			}
			max_index = index;
		});
		if(limit5 <= last_index){
			$(".latest-sale  .prev-arrow").removeClass("slick-disabled");
		}else{
			$(".latest-sale  .prev-arrow").addClass("slick-disabled");
		}
		if(last_index >= max_index){
			$(".latest-sale .next-arrow").addClass("slick-disabled");
			$(".latest-sale .prev-arrow").removeClass("slick-disabled");
		}
	}
});

/*
$("#tabs").tabs({ fx: { duration: 'fast', opacity: 'toggle' } });
(function(){ var widget_id = '97152';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = ''+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();
	$( ".currency" ).click(function() {
		$(".currency_list").toggle();

	});
	$( ".s_alfabet a" ).click(function() {
		$(".alfabet_req").toggle();
		$(".s_alfabet>a").toggleClass("active");
	});	
	$( ".s_price a" ).click(function() {
		$(".price_req").toggle();
		$(".s_price>a").toggleClass("active");
	});	

		
							
								$('.tabmenu > li').click(function() {
									var menu = $('.tabmenu > li'), current = $(this), content = $('.tabs_content > li');
									menu.removeClass('current');
									current.addClass('current');
									content.removeClass('current');
									content.eq(current.index()).addClass('current');
									return false;
								});
						
	

  



  $('.slides_container').bxSlider({
    slideWidth: 259,
    minSlides: 2,
    maxSlides: 3,
    moveSlides: 1,
	slideMargin: 1
  });
  $( ".bx-prev" ).html( "<span></span>" );
  $( ".bx-next" ).html( "<span></span>" );*/

    });
	
	
jQuery.fn.exists=function(){return $(this).length;}
if($('#main-slider').exists()){$('#main-slider').orbit({animation:'horizontal-slide',animationSpeed:600,timer:true,advanceSpeed:5000,pauseOnHover:true,startClockOnMouseOut:true,startClockOnMouseOutAfter:0,directionalNav:true,captions:true,captionAnimation:'fade',captionAnimationSpeed:600,bullets:true,bulletThumbs:false,bulletThumbLocation:'',});}
$(document).ready(function(){if($('.header-search-form .search-input').exists()){var searchForm=$('.header-search-form');var searchInput=$('.header-search-form .search-input');searchInput.on('blur',function(e){searchForm.removeClass('focus');}).on('focus',function(e){searchForm.addClass('focus');});}
if($('.draw-summary .counter').exists()){$('.draw-summary .counter').counterUp({delay:10,time:1000});}
//if($('#game-slider01').exists()){$('#game-slider01').slick({slidesToShow:3,slidesToScroll:1,prevArrow:$('#slider01-prev-arrow'),nextArrow:$('#slider01-next-arrow'),infinite:false});}
//if($('#game-slider02').exists()){$('#game-slider02').slick({slidesToShow:5,slidesToScroll:1,prevArrow:$('#slider02-prev-arrow'),nextArrow:$('#slider02-next-arrow'),infinite:false});}
function slideAdd(thisSlider,action,cnt,a){$.get('/ajax/slick_v2.php?a='+action+'&c='+cnt+(a?'&p='+a:''),function(data){if(data.error==0){thisSlider.slick('slickAdd',data.html);return true;}},'json');return false;};if($('#tab01-slider').exists()){tab01_slider=$('#tab01-slider').slick({slidesToShow:11,slidesToScroll:11,prevArrow:$('#tab01-slider-prev-arrow'),nextArrow:$('#tab01-slider-next-arrow'),infinite:false,vertical:true,verticalSwiping:true});$(document).on('click','#tab01-slider-next-arrow',function(){var cnt=$('#tab01-slider div.item').length;if(slideAdd(tab01_slider,'popular_games_v3',cnt)){}});}
if($('#tab02-slider').exists()){tab02_slider=$('#tab02-slider').slick({slidesToShow:11,slidesToScroll:11,prevArrow:$('#tab02-slider-prev-arrow'),nextArrow:$('#tab02-slider-next-arrow'),infinite:false,vertical:true,verticalSwiping:true});$(document).on('click','#tab02-slider-next-arrow',function(){var cnt=$('#tab02-slider div.item').length;if(slideAdd(tab02_slider,'new_games_v3',cnt)){}});}
if($('#tab03-slider').exists()){tab03_slider=$('#tab03-slider').slick({slidesToShow:11,slidesToScroll:11,prevArrow:$('#tab03-slider-prev-arrow'),nextArrow:$('#tab03-slider-next-arrow'),infinite:false,vertical:true,verticalSwiping:true});$(document).on('click','#tab03-slider-next-arrow',function(){var cnt=$('#tab03-slider div.item').length;if(slideAdd(tab03_slider,'preorders_games_v3',cnt)){}});}
if($('#tab04-slider').exists()){tab04_slider=$('#tab04-slider').slick({slidesToShow:11,slidesToScroll:11,prevArrow:$('#tab04-slider-prev-arrow'),nextArrow:$('#tab04-slider-next-arrow'),infinite:false,vertical:true,verticalSwiping:true});$(document).on('click','#tab04-slider-next-arrow',function(){var cnt=$('#tab04-slider div.item').length;if(slideAdd(tab04_slider,'actions_games_v3',cnt)){}});}
if($('#ts-slider').exists()){var ts_slider=$('#ts-slider').slick({slidesToShow:1,slidesToScroll:1,prevArrow:$('#ts-prev-arrow'),nextArrow:$('#ts-next-arrow'),infinite:false,vertical:true,verticalSwiping:true});$(document).on('click','#ts-next-arrow',function(){var cnt=$('#ts-slider li.item').length,amount=$('#ts-slider').attr('data-type');if(slideAdd(ts_slider,'top_sales',cnt,amount)){}});$(document).on('click','.top-sale-filter a',function(){var amount=$(this).attr('data-amount');$.get('/ajax/slick_v2.php?a=top_sales&c=0&p='+amount,function(data){if(data.error==0){var cnt_index=$('#ts-slider div.slide').length;for(var i=0;i<cnt_index;i++){ts_slider.slick('slickRemove',0);}
$('#ts-slider').attr('data-type',amount);if(slideAdd(ts_slider,'top_sales',0,amount)){}}},'json');});}
if($('#rg-slider').exists()){rg_slider=$('#rg-slider').slick({slidesToShow:1,slidesToScroll:1,arrows:false,infinite:true,fade:true});$(document).on('click','#rg-refresh',function(){var cnt=$('#rg-slider li.item').length;slideAdd(rg_slider,'rand_games',cnt);$('#rg-slider').slick('slickNext');});}
if($('#rv-slider').exists()){var rv_slider=$('#rv-slider').slick({slidesToShow:1,slidesToScroll:1,arrows:false,infinite:true,fade:true});$(document).on('click','#rv-refresh',function(){var cnt=$('#rv-slider li.item').length;slideAdd(rv_slider,'rand_video',cnt);$('#rv-slider').slick('slickNext');});}
if($('#ls-slider').exists()){$('#ls-slider').slick({slidesToShow:3,slidesToScroll:3,prevArrow:$('#ls-prev-arrow'),nextArrow:$('#ls-next-arrow'),infinite:true,vertical:true,verticalSwiping:true,autoplay:true,autoplaySpeed:6000});}
if($('#ps-slider').exists()){var ps_slider=$('#ps-slider').slick({slidesToShow:1,slidesToScroll:1,prevArrow:$('#ps-prev-arrow'),nextArrow:$('#ps-next-arrow'),infinite:false,fade:true});$(document).on('click','#ps-next-arrow',function(){var cnt=$('#ps-slider div.item').length;if(slideAdd(ps_slider,'update_price_games',cnt)){}});}
if($('#as-slider').exists()){var as_slider=$('#as-slider').slick({slidesToShow:1,slidesToScroll:1,prevArrow:$('#as-prev-arrow'),nextArrow:$('#as-next-arrow'),infinite:false,fade:true});$(document).on('click','#as-next-arrow',function(){var cnt=$('#as-slider div.item').length;if(slideAdd(as_slider,'actions_2_games',cnt)){}});}
if($('#ns-slider').exists()){$('#ns-slider').slick({slidesToShow:3,slidesToScroll:3,prevArrow:$('#ns-prev-arrow'),nextArrow:$('#ns-next-arrow'),infinite:false});}
if($('#rs-slider').exists()){var rs_slider=$('#rs-slider').slick({slidesToShow:3,slidesToScroll:3,prevArrow:$('#rs-prev-arrow'),nextArrow:$('#rs-next-arrow'),infinite:false,vertical:true,verticalSwiping:true});$(document).on('click','#rs-next-arrow',function(){var cnt=$('#rs-slider div.item').length;slideAdd(rs_slider,'preorders_2_games',cnt);});}
if($('#ng-slider').exists()){var ng_slider=$('#ng-slider').slick({slidesToShow:6,slidesToScroll:6,prevArrow:$('#ng-prev-arrow'),nextArrow:$('#ng-next-arrow'),infinite:false});$(document).on('click','#ng-next-arrow',function(){var cnt=$('#ng-slider div.item').length;slideAdd(ng_slider,'new_2_games',cnt);});}
if($('#rw-slider').exists()){var rw_slider=$('#rw-slider').slick({slidesToShow:1,slidesToScroll:1,prevArrow:$('#rw-prev-arrow'),nextArrow:$('#rw-next-arrow'),infinite:false,fade:true});$(document).on('click','#rw-next-arrow',function(){var cnt=$('#rw-slider li.item').length;slideAdd(rw_slider,'digiseller_reviews',cnt);});}
if($('#ss-slider').exists()){var ss_slider=$('#ss-slider').slick({slidesToShow:1,slidesToScroll:1,prevArrow:$('#ss-prev-arrow'),nextArrow:$('#ss-next-arrow'),infinite:false,fade:true});$(document).on('click','#ss-next-arrow',function(){var cnt=$('#ss-slider li.item').length;slideAdd(ss_slider,'games_statistics',cnt);});}
if($('.catalog-tab-list').exists()){$('#tab01-link').click(function(e){e.preventDefault();$('.catalog-tab-list li').removeClass('active');$(this).parent().addClass('active');$('.catalog-tab-content').removeClass('active');$('#tab01').addClass('active');});$('#tab02-link').click(function(e){e.preventDefault();$('.catalog-tab-list li').removeClass('active');$(this).parent().addClass('active');$('.catalog-tab-content').removeClass('active');$('#tab02').addClass('active');});$('#tab03-link').click(function(e){e.preventDefault();$('.catalog-tab-list li').removeClass('active');$(this).parent().addClass('active');$('.catalog-tab-content').removeClass('active');$('#tab03').addClass('active');});$('#tab04-link').click(function(e){e.preventDefault();$('.catalog-tab-list li').removeClass('active');$(this).parent().addClass('active');$('.catalog-tab-content').removeClass('active');$('#tab04').addClass('active');});}
if($('.checkbox-input').exists()){$('.checkbox-input').checkbox({empty:'/templates/overgame/img/empty.png',cls:'jquery-checkbox'});}
if($('.filter-select').exists()){$('.filter-select').each(function(){if($(this).attr("id")!="toDateSelect"&&$(this).attr("id")!="fromDateSelect"&&$(this).attr("id")!="izdatelSelect"&&$(this).attr("id")!="markSelect"){var sb=new SelectBox({selectbox:$(this),height:206,scrollOptions:{verticalDragMinHeight:16,verticalDragMaxHeight:16}});}});}
if($('.filter-form').exists()){$('.filter-form .field-title > a').click(function(){$(this).parent('.field-title').parent('.filter-field').toggleClass('close');$(this).parent().next('.field-container').slideToggle(300);return false;});if($('.filter-form .show-more-link').exists()){$('.filter-field .show-more-link').click(function(){var hiddenItems=$(this).prev('.filter-checkbox-list').children('li.hidden');if(hiddenItems.is(':hidden')){hiddenItems.fadeIn(300);$(this).html('Свернуть');}else{hiddenItems.fadeOut(300);$(this).html('Показать больше');}});}
$('.filter-checkbox-list .jquery-checkbox').click(function(){$(this).parent('.item').addClass('checked');if($(this).hasClass('jquery-checkbox-checked')){$(this).parent('.item').removeClass('checked');}});$('.filter-checkbox-list .checkbox-label').click(function(){$(this).parent('.item').toggleClass('checked');});$('.filter-checkbox-list .item .checkbox-label').hover(function(){$(this).parent('.item').addClass('hover');},function(){$(this).parent('.item').removeClass('hover');});}
if($('.subscribe .popup-trigger').exists()){$('.subscribe .popup-trigger').click(function(){$('.subscribe-popup').fadeIn();});}
$(document).mouseup(function(e){var container=$(".subscribe-popup");if(!container.is(e.target)&&container.has(e.target).length===0)
{container.fadeOut();}});var isInputSupported='placeholder'in document.createElement('input');var isTextareaSupported='placeholder'in document.createElement('textarea');if(!isInputSupported||!isTextareaSupported){$('[placeholder]').focus(function(){var input=$(this);if(input.val()==input.attr('placeholder')&&input.data('placeholder')){input.val('');input.removeClass('placeholder');}}).blur(function(){var input=$(this);if(input.val()==''){input.addClass('placeholder');input.val(input.attr('placeholder'));input.data('placeholder',true);}else{input.data('placeholder',false);}}).blur().parents('form').submit(function(){$(this).find('[placeholder]').each(function(){var input=$(this);if(input.val()==input.attr('placeholder')&&input.data('placeholder')){input.val('');}})});}});$(function(){$(document).on('click','.random-video-list .item-preview',function(){var yt=$(this).attr('data-youtube');$('<div/>',{id:'opacity-bg'}).appendTo('body').css({'display':'block'});$('<div/>',{id:'pop-block'}).appendTo('body').fadeIn();$('#pop-block').html('<iframe width="640" height="400" src="//www.youtube.com/embed/'+yt+'?autoplay=0" frameborder="0" allowfullscreen></iframe>');return false;});$(document).on('click','#opacity-bg',function(){$('#opacity-bg, #pop-block').remove();return false;});$(document).on('click','.submit-btn',function(){var email=$('#subscribe-email').val();if(email.length&&$('#terms-checkbox').prop('checked')){$.post('/ajax/strr_v2.php',{a:'sub_email',email:email},function(data){if(data.error==0){$('.subscribe-popup').fadeOut();}
else{}},'json');}
return false;});});