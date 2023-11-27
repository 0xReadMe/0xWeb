$( document ).ready(function() {
  $(function() {
    $.fn.extend({
        animateCss: function (animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            $(this).addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
            });
        },
          slowHide: function (animationName) {
              var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
              $(this).addClass('animated ' + animationName).one(animationEnd, function() {
                  $(this).hide();
                  $(this).removeClass('animated ' + animationName);
              });
          },
          slowShow: function (animationName) {
              var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
              $(this).show();
              $(this).addClass('animated ' + animationName).one(animationEnd, function() {
                  $(this).removeClass('animated ' + animationName);
              });
          }
    });
  });

});

$(document).on('ready', function() {
$('.game__screens-slider').slick({
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  centerMode: true,
  variableWidth: true
});
});
$('.popup-gallery').magnificPopup({
 delegate: 'a',
 type: 'image',
 tLoading: 'Загрузка изображения #%curr%...',
 gallery: {
     enabled: true,
     navigateByImgClick: true,
     preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
 }
 });
 
 function noti(status, text) {
  $('.alert-'+status+' em').text(text);
  $('.alert-'+status).slowShow('bounceIn');
  setTimeout(function() {
      $('.alert-'+status).slowHide('bounceOut');
  }, 4000);
}
 
 $(document).ready(function(){
var inProgress = false;
var formgames = 20;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !inProgress) {
        $.ajax({
            url: '/engine/games.php',
            method: 'POST',
            data: {"formgames" : formgames},
            beforeSend: function() {
            inProgress = true;}
            }).done(function(data){
             data = jQuery.parseJSON(data);
            if (data.length > 0) {
            $.each(data, function(index, data){
            $("#games_main").append("<li class='cases__item'><a class='cases__link' href='/game?id="+ data.id + "'><span class='cases__name'>" +data.name + "</span><span class='cases__image-wrapper'><img class='cases__image' src='" + data.img + "' alt='" + data.name + "'></span><span class='cases__price-wrapper'><span class='cases__price-inner'><span class='cases__price'>" + data.cost + "<span class='cases__curr'> ₽</span></span></span></span></a></li>");
            });
            inProgress = false;
            formgames += 20;
            }});
        }
    });
});
$(document).ready(function() {
			jQuery('.faq__question').click(function(){
			$(this).parents('.faq__item').toggleClass("faq__item--active").find('.faq__answer').slideToggle();
		})
});
function promocodes() {
	 var data = $('#promocodes').serialize();
    $.post("/engine/promocodes.php", data, function(r) {
      if(r.status == 'success') {
        if(typeof(r.msg) != 'undefined') {
          noti(r.status, r.msg);
	  }}
		else if(r.status == 'error') {
        noti(r.status, r.msg);
      }
    }, "json");
    return false;
}

function show_key(keyid) {
    $.post("/engine/showkey.php", {keyid:keyid}, function(r) {
      if(r.status == 'success') {
        if(typeof(r.msg) != 'undefined') {
          noti(r.status, r.msg);
        }
         if(typeof(r.img) != 'undefined') {
            $("#prize").css("display", "block");
            $("#filter").css("display", "block");
            $("#prize-img").attr('src',r.img);
            $("#prize-product").html(r.gamekey);
			$("#game-name").html(r.name);
          }
      } else if(r.status == 'error') {
       noti(r.status, r.msg);
      }
    }, "json");
}

function buy(gameid) {
    $.post("/engine/buy.php", {gameid:gameid}, function(r) {
      if(r.status == 'success') {
        if(typeof(r.msg) != 'undefined') {
          noti(r.status, r.msg);
        }
        var balance = parseInt($("#balance").html());
        if(balance >= r.price)
          balance = balance - r.price;
        $("#balance").html(balance);
         if(typeof(r.img) != 'undefined') {
            $("#prize").css("display", "block");
            $("#filter").css("display", "block");
            $("#prize-img").attr('src',r.img);
            $("#prize-product").html(r.gamekey);
			$("#game-name").html(r.name);
          }
      } else if(r.status == 'error') {
       noti(r.status, r.msg);
      }
    }, "json");
}