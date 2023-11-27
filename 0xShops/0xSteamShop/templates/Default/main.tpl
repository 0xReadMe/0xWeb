
<!DOCTYPE html>
<html>
<head>
{headers}
<link rel="shortcut icon" href="http://i.imgur.com/Z9ztQZR.png" type="image/x-icon">
<style>.h_slider .bx-pager{top:15%}</style>
 
<link href="{THEME}/style/st.css" rel="stylesheet" type="text/css">
<script src="{THEME}/js/jquery.js"></script>
<script type="text/javascript" src="{THEME}/js/jquery-ui.js"></script>
<script src="{THEME}/js/script_site.js"></script>
<style>.h_slider .bx-pager{top:15%}</style>
<script type="text/javascript">
/* <![CDATA[ */
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-47424123-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

(function(b){(function(a){"__CF"in b&&"DJS"in b.__CF?b.__CF.DJS.push(a):"addEventListener"in b?b.addEventListener("load",a,!1):b.attachEvent("onload",a)})(function(){"FB"in b&&"Event"in FB&&"subscribe"in FB.Event&&(FB.Event.subscribe("edge.create",function(a){_gaq.push(["_trackSocial","facebook","like",a])}),FB.Event.subscribe("edge.remove",function(a){_gaq.push(["_trackSocial","facebook","unlike",a])}),FB.Event.subscribe("message.send",function(a){_gaq.push(["_trackSocial","facebook","send",a])}));"twttr"in b&&"events"in twttr&&"bind"in twttr.events&&twttr.events.bind("tweet",function(a){if(a){var b;if(a.target&&a.target.nodeName=="IFRAME")a:{if(a=a.target.src){a=a.split("#")[0].match(/[^?=&]+=([^&]*)?/g);b=0;for(var c;c=a[b];++b)if(c.indexOf("url")===0){b=unescape(c.split("=")[1]);break a}}b=void 0}_gaq.push(["_trackSocial","twitter","tweet",b])}})})})(window);
/* ]]> */
</script>
</head>
{AJAX}
<body id="body">
<div class="wrap">
<div class="wrapper">
<header class="htop">
<div class="h_top">
<div class="logo" ><a itemprop="url" href="/"><img itemprop="logo" src="/templates/Default/images/site/logo.png" alt=" "></a></div>
<div class="hnav_w">
<nav class="hnav">
<ul>
<li><a href="/">Главная</a></li>
<li><a href="http://acc-store.su/page/rules">Правила</a></li><li><a href="http://acc-store.su/page/payments">Оплата</a></li><li><a href="http://acc-store.su/page/otzyv">Отзывы</a></li><li><a href="http://acc-store.su/page/safeguards">Гарантии</a></li><li><a href="http://acc-store.su/page/faq">F.A.Q.</a></li><li><a href="http://acc-store.su/page/about">О Магазине</a></li>
<li><a  href="https://primearea.biz/customer/" target="_blank"><span class="icon_bask"></span>МОИ ПОКУПКИ</a></li>
</ul>
</nav>
</div>
</div>
<div class="h_middle">



</form>
</form>
</div>

</header>
<div class="content_full">
<div class="side_center">
<div class="sider_center">
<div style="display:none" id="loading"><center><img src="http://i.imgur.com/QFWM5Mi.gif"><p>Загружаем контент...</p></center></div>
<div class="layer">

{content}


</div>
</div> 
<div class="sider_right">
<aside class="sblock">
<div class="sb_title"><span>РЕЙТИНГ ПРОДАЖ</span></div>
<div class="sb_cont">
<ul class="bnav bn_rat">{topnews}</ul>
</div>
</aside>
<aside class="sblock"><script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>
 
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 0, width: "280", height: "350", color1: 'FFFFFF', color2: 'd24845', color3: '4e4c4d'}, 99892724);
</script>
</aside>
<aside class="sblock">
<div class="sb_title"><span>СПОСОБЫ ОПЛАТЫ</span></div>
<div class="sb_cont">
<ul class="paymetns_list">
<li>
<div class="pict"><img src="{THEME}/images/site/webmoney.png" alt=""><span></span></div>
<p>WEBMONEY TRANSFER</p>
<p><a href="http://webmoney.ru">webmoney.ru</a></p>
</li>
<li>
<div class="pict"><img src="{THEME}/images/site/yandexmoney.png" alt=""><span></span></div>
<p>ЯНДЕКС.ДЕНЬГИ</p>
<p><a href="http://money.yandex.ru">money.yandex.ru</a></p>
</li>
<li>
<div class="pict"><img src="{THEME}/images/site/qiwi.png" alt=""><span></span></div>
<p>QIWI WALLET</p>
<p><a href="http://qiwi.ru">qiwi.ru</a></p>
</li>
<li>
<div class="pict"><img src="{THEME}/images/site/terminal.png" alt=""><span></span></div>
<p>ТЕРМИНАЛЫ ОПЛАТЫ</p>
<p><a href="#">терминалы вашего города</a></p>
</li>
</ul>
<div class="paymetns_link"><a href="/page/payments/">Все способы</a></div>
</div>
</aside>
</div> 
</div> 
<div class="side_left">
<aside class="sblock">
<div class="sb_title"><span>РАЗДЕЛЫ МАГАЗИНА</span></div>
<div class="sb_cont">
<ul class="bnav">
<ul>
<li><a href="/">Главная</a></li>

</ul>
</div>
</aside>
<script>



	  
function sortitem(searchtag){
$("#loading").show();
$("div.layer").hide();
$.ajax({
  type: 'POST',
  url: '/',
  data: "sort="+searchtag,
  success: function(data){
    $('div.layer').html(data);
	$("#loading").hide();
	$("div.layer").show();
  }
});
}


	  
function sortitemfor(sort_item){
$("#loading").show();
$("div.layer").hide();
var cat_id = $('input[name=cat_id]').val();
var sec_id = $('input[name=sec_id]').val();
var sort = $('input[name=sort]').val();
var pageitem = $('input[name=pagenum]').val();

$.ajax({
  type: 'POST',
  url: '/',
   data: {'sort_item':sort_item,'cat_id':cat_id,'sec_id':sec_id,'sort':sort,'pageitem':pageitem},
  success: function(data){
    $('div.layer').html(data);
	$("#loading").hide();
	$("div.layer").show();
  }
});
}


	 $(function(){
        $('li.clayer').click(function(){
		$("#loading").show();
		$("div.layer").hide();
                cid = $(this).data("catId")
                console.log(cid)
                $.post('/', {'sec_id': cid}, function(data){
                        $('div.layer').html(data)
                     	$("#loading").hide();
						$("div.layer").show();
                })
        })
})
	 
$(function(){
        $('li.layer').click(function(){
		$("#loading").show();
		$("div.layer").hide();
                cid = $(this).data("catId")
                console.log(cid)
                $.post('/', {'cat_id': cid}, function(data){
                        $('div.layer').html(data)
                     $("#loading").hide();
						$("div.layer").show();
                })
        })
})
	</script>
<aside class="sblock">
<div class="sb_title"><span>КАТЕГОРИИ МАГАЗИНА </span></div>
<div class="sb_cont">
<ul class="bnav" id="bnav_js">
<li><a href="#">SAMP сервер</a>
<ul>
<li><a href="http://store-samp.ru/servers/" style='padding: 8px 5px 8px 85px;'>Готовые сервера</a></li>
<li><a href="http://store-samp.ru/maps" style='padding: 8px 5px 8px 85px;'>Маппинг сервера</a></li>
<li><a href="http://store-samp.ru/filterscripts/" style='padding: 8px 5px 8px 85px;'>FilterScripts</a></li>
<li><a href="http://store-samp.ru/sites/" style='padding: 8px 5px 8px 85px;'>Готовые сайты</a></li>
<li><a href="/" style='padding: 8px 5px 8px 85px;'>Таймкарты</a></li>
</ul>
</li>
<li><a href="#">Аккаунты SAMP</a>
<ul>
<li><a href="http://store-samp.ru/accounts/samp/advancerp/" style='padding: 8px 5px 8px 85px;'>Advance RP</a></li>
<li><a href="http://store-samp.ru/accounts/samp/samprp/" style='padding: 8px 5px 8px 85px;'>Samp RP</a></li>
<li><a href="http://store-samp.ru/accounts/samp/diamondrp/" style='padding: 8px 5px 8px 85px;'>Diamond RP</a></li>
<li><a href="http://store-samp.ru/accounts/samp/other/" style='padding: 8px 5px 8px 85px;'>Аккаунты разных серверов</a></li>
</ul>
</li>
</ul>
</div>
</aside>
<aside class="sblock bg_red">
<div class="sb_title"><span>КОНТАКТНЫЕ ДАННЫЕ</span></div>
<div class="sb_cont">
<div class="sb_contacts">
<p><span class="txt_red">E-MAIL:</span> SUPPORT@Store-Samp.Ru<br/>
<p><span class="txt_red">Skype №1:</span> MineorDimon </p>
<p><span class="txt_red">Skype №2:</span> Yra19997 </p>
<p>ТЕХПОДДЕРЖКА С <span class="txt_red">8:00</span> - ДО <span class="txt_red">22:00*(мск)</span></p>
</div>
</div>
</aside>

</div> 
</div> 
<footer class="fbottom">
<div class="ins_bg">
<div class="flogo"><a href="/"><img src="/templates/Default/images/site/logo.png" alt=""></a></div>
<div class="fstat">
 <!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t20.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров за 24"+
" часа, посетителей за 24 часа и за сегодня' "+
"border='0' width='88' height='31'><\/a>")
//--></script><!--/LiveInternet-->
</div>
<div class="fstat">
	<!-- Yandex.Metrika informer --> <a href="https://metrika.yandex.ru/stat/?id=31930086&amp;from=informer" target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/31930086/3_1_FFFFFFFF_EFEFEFFF_0_pageviews" style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:31930086,lang:'ru'});return false}catch(e){}" /></a> <!-- /Yandex.Metrika informer --> <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter31930086 = new Ya.Metrika({ id:31930086, clickmap:true, trackLinks:true, accurateTrackBounce:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/31930086" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
</a>
</div>
</center>
</div>
</footer>
</div> 
</div> 
</body>
</html>