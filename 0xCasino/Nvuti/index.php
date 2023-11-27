<?php
include_once "inc/config.php";
include_once "inc/main.php";
$sql_select111 = "SELECT MAX(id) FROM demo_games";
$result111 = mysql_query($sql_select111);
$row = mysql_fetch_array($result111);
$games = $row['MAX(id)'];
if($prava == 0)
{
if($offsite == 1){
include('offsite.php');
}
}
?>
    <!DOCTYPE html>
<!--скрипт от Sarry13 (https://vk.com/xyecoc_syka)-->
    <html lang="ru" >
    <head>
		<meta name="description" content="Что такое Mashkin-Nvuti? - Сервис мгновенных игр с выбором шанса выигрыша!">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
	      <meta name="referrer" content="no-referrer">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="author" content="https://mn-cash.ml">
			<meta name="keywords" content="mn-cash, mn cash, nvuti промокоды, нвути аналог, мн-кэш, мн кэш, mashkin-nvuti, машкин-нвути, numrate, nvuti, нвути, svuti, rvuti, быстрые игры, мгновенные игры, промокоды nvuti, фарм баланса, проверка тактик, лучшие тактики, стратегия игры, проверка сайта, нвути тактика, numrate вывод, тактика для nvuti, раздача промокодов, розыгрыш промокодов, nvuti похожие сайты, тактики ютуберов">
        <link rel="stylesheet" type="text/css" href="/../files/css.css" >
		<link rel="stylesheet" type="text/css" href="/../files/style.css">
		<link rel="stylesheet" type="text/css" href="/../files/mobile.css"/>
        <link rel="stylesheet" type="text/css" href="/../files/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/../files/style.minn.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="icon" href="/../files/<?php echo $favicon?>" type="image/x-icon">
    		<link rel="shortcut icon" href="/../files/<?php echo $favicon?>" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="/../files/bootstrap-extended.min.css">
        <link rel="stylesheet" type="text/css" href="/../files/app.min.css">
        <link rel="stylesheet" type="text/css" href="/../files/colors.min.css">
        <link rel="stylesheet" type="text/css" href="/../files/horizontal-menu.min.css">    
	</head>
<?php
if($_GET['code'])
{
$token = json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id='.$ID.'&display=page&redirect_uri='.$URL.'&client_secret='.$SECRET.'&code='.mysql_real_escape_string($_GET['code']).'&v=5.74'), true);
$data = json_decode(file_get_contents('https://api.vk.com/method/users.get?user_id='.$token['user_id'].'&v=5.74&access_token='.$token['access_token'].'&fields=first_name,last_name'), true);
$data = $data['response']['0'];
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$code = mysql_real_escape_string($_GET['code']);
echo "<script>var code = '$code';var first = '$first_name';var last = '$last_name';</script>";

if(!$_COOKIE['sid'])
{
  echo <<<HTML
  <script>
  setTimeout(function(){
    $.ajax({
        type: 'POST',
        url: 'inc/engine.php',
        data: {
          type: 'vkauth',
          code: code,
          fname: first,
          lname: last
        },
        success: function(data) {
          var obj = jQuery.parseJSON(data);
          if (obj.success == 'success') {
            Cookies.set('sid', obj.sid, { expires: 365,path: '/',secure:true });
            Cookies.set('uid', obj.uid, { expires: 365,path: '/',secure:true });
            Cookies.set('login', obj.login, { expires: 365,path: '/',secure:true });
            window.location.href = '';
          }
        }
    });
  },500);
  </script>
HTML;
}
else
{
  echo <<<HTML
  <script>
    setTimeout(function(){
      $.ajax({
          type: 'POST',
          url: 'inc/engine.php',
          data: {
            type: 'vkconnect',
            code: code,
            fname: first,
            lname: last,
            sid: Cookies.get('sid')
          },
          success: function(data) {
            var obj = jQuery.parseJSON(data);
            if (obj.success == 'success') {
              $('#vk_success').show();
              $('#vk_success').html(obj.error);
              setTimeout(function(){
                $('#vk_success').hide();
              },7000);
              $('#vkupd').html('<a style="color:#3B5998" onclick="vkunconnect()" class="btn btn-social mb-1 mr-1 btn-outline-facebook"><span class="fa fa-vk"></span> <span class="px-1">Отвязать ВК</span></a>');
            }else{
              $('#vk_error').html(obj.error);
              $('#vk_error').show();
              setTimeout(function(){
                $('#vk_error').hide();
              },7000);
            }
          }
      });
    },500);
  </script>
HTML;
}
}
?>
<script>
function menuOpen(){
	if($('.menu-all-mobile').position().left=="-245"){
		$('.menu-all-mobile').offset({left:0});
	} else {
		$('.menu-all-mobile').offset({left:-245});
	}
}
function mobileClick(what, count){
	for(var i = 1; i <= count; i++){
		$('#menu_mob' + i).css('background-color', 'white');
		$('#menu_mob' + i).css('font-weight', 'normal');
	}
}
mobileClick('1', '0');
</script>
<script>
            
window.onload = function () 
{
    
    
    setTimeout(function () {

  $('#before-load').find('i').fadeOut().end().delay(400).fadeOut('slow');
        }, 700);
  
}
</script>
        <div id="before-load">
  <!-- Иконка Font Awesome -->
  <i><svg width="200px"  height="200px"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-eclipse" style="background: none;"><path ng-attr-d="{{config.pathCmd}}" ng-attr-fill="{{config.color}}" stroke="none" d="M25 50A25 25 0 0 0 75 50A25 27 0 0 1 25 50" fill="#cd2325" transform="rotate(29.97 50 51)"><animateTransform attributeName="transform" type="rotate" calcMode="linear" values="0 50 51;360 50 51" keyTimes="0;1" dur="1.6s" begin="0s" repeatCount="indefinite"></animateTransform></path></svg></i>
</div>
        <style>
        #before-load {
  position: fixed; /*фиксированное положение блока*/
  left: 0; /*положение элемента слева*/
  top: 0; /*положение элемента сверху*/
  right: 0; /*положение элемента справа*/
  bottom: 0; /*положение элемента снизу*/
  background: #000; /*цвет заднего фона блока*/
  z-index: 9999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999; /*располагаем его над всеми элементами на странице*/
}
#before-load i {
    width: 600px;
    font-size: 70px; /*размер иконки*/
  position: absolute; /*положение абсолютное, позиционируется относительно его ближайшего предка*/
  left: 50%; /*слева 50% от ширины родительского блока*/
  top: 50%; /*сверху 50% от высоты родительского блока*/
  margin: -35px 0 0 -35px; /*смещение иконки, чтобы она располагалась по центру*/
     margin-left: -70px;
     margin-top: -70px;
}
        </style> <body class="horizontal-layout horizontal-menu 2-columns menu-expanded" style=" background-size: 1810px 1810px;background-image: url(img/<?php echo $bgc_site ?>);">
	<nav style="background: #FFFFFF; border-radius: 0px;" class="mobile_nav menu" data-nav="brand-center">
		<div class="menu-mobile" id="menu-open" onclick="menuOpen();"></div>
		<div class="mobile-logo"></div>
	</nav>
		<div class="menu-all-mobile">
		
				<div class="menu-one-mobile" id="menu_mob1" onclick="$('.dsec').hide(); $('#lastBets').show(); $(document.body).removeClass('menu-open'); menuOpen(); mobileClick('1', '5');">
					<span style="font-weight: inherit;">  Главная</span>
				</div>
				<div class="menu-one-mobile" id="menu_mob2" onclick="$('.dsec').hide(); $('#realGame').show(); $(document.body).removeClass('menu-open'); menuOpen(); mobileClick('2', '5');">
					<span style="font-weight: inherit;">  Честная игра</span>
				</div>
				<div class="menu-one-mobile" id="menu_mob3" onclick="$('.dsec').hide(); $('#rules').show(); $(document.body).removeClass('menu-open'); menuOpen(); mobileClick('3', '5');">
					<span style="font-weight: inherit;">  Задаваемые вопросы</span>
				</div>
                <div class="menu-one-mobile" id="menu_mob4" onclick="$('.dsec').hide(); $('#comment').show(); $(document.body).removeClass('menu-open'); menuOpen(); mobileClick('4', '5');">
                        <span style="font-weight: inherit;"> Отзывы</span>
                </div>
				<div class="menu-one-mobile" id="menu_mob5" onclick="last_out();$('.dsec').hide(); $('#lastWithdraw').show(); $(document.body).removeClass('menu-open'); menuOpen(); mobileClick('5', '5');">
                        <span style="font-weight: inherit;"> Выплаты</span>
                </div>
				<div class="menu-one-mobile" id="menu_mob6" onclick="location.href = '/promo'">
                        <span style="font-weight: inherit;"> Промокоды</span>
                </div>
				<div style="margin-left:10px;float:left;">
                            <a style="margin: 0px 5px !important; margin-top: 7px !important; color:#000000" onclick="window.open(&quot;https://vk.com/nvuti_mashkina&quot;);" class="btn btn-social mb-1 mr-1 btn-outline-facebook">
                                <span class="fa fa-vk"></span>
                                <span class="px-1">ВКонтакте</span>
                            </a>
                        </div>	
				
				</div>
	
	

        <!-- ////////////////////////////////////////////////////////////////////////////-->

        <!-- Horizontal navigation-->

        <div id="sticky-wrapper" class="sticky-wrapper h66" >
            <div role="navigation" data-menu="menu-wrapper" class="menu header-navbar navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow menu-border navbar-brand-center" data-nav="brand-center">
                <!-- Horizontal menu content-->
<?php

echo $panel;
?>
				</div>
        </div>

        <div class="app-content container center-layout mt-2">
            <div class="content-wrapper">
                <div class="content-body">
<?php
echo $go;
?>															
													
                                                        <div class="row dsec" id="lastBets" style="display:block">
                                        <div class="col-xs-12">
                                            <div class="card">
                                                <div  class="card-header"   style="border-radius: 4px!important;-webkit-user-select: none;-moz-user-select: none;">
                                                   <h4 class="card-title" style=""><b>ПОСЛЕДНИЕ ИГРЫ</b></h4>	<div  style="margin-top: -13px;margin-left: 170px;display: inline-block;position: absolute;" class="circle-online" ></div> <span data-toggle="tooltip" data-placement="top" id="oe" style="margin-top: -20px;margin-left: 184px;display: inline-block;position: absolute;"><?php echo $online; ?></span>
													   <h4 class="card-title" style="margin-top:5px"><b>ИГР СЫГРАНО:</b></h4><div  style="background:linear-gradient(to right, #d5002d,#d5002d);margin-top: -12.5px;margin-left: 135px;display: inline-block;position: absolute;" class="circle-online" ></div> <span data-toggle="tooltip" data-placement="top"  id="oe" style="margin-top: -19px;margin-left: 148px;display: inline-block;position: absolute;"><?php echo $games; ?></span>
															<h4 class="card-title" style="margin-top:5px"><b>СЕССИЯ #<?php echo rand(1, 9999); ?></b></h4>
													<div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a data-action="collapse"><i class="fa fa-minus"></i></a></li>
                                                        </ul>
                                                    </div>

                                                </div>
												
                                                <div class="card-body collapse in" style="padding-bottom:2px;-webkit-user-select: none;-moz-user-select: none;" >

                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>

                                                                <tr style="cursor:default!important" class="polew">
                                                                    <th style="text-align: center;width:6%" >Игрок</th>
                                                                    <th style="text-align: center;width:20%">Число</th>
                                                                    <th style="text-align: center;width:20%">Цель</th>
                                                                    <th style="text-align: center;width:20%">Сумма</th>
                                                                    <th style="text-align: center;width:20%">Шанс</th>
                                                                    <th style="text-align: center;width:20%">Выигрыш</th>
                                                                </tr>
                                                            </thead>
                                                                                        <tbody id="response"> </tbody>
											
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <section id="realGame" class="card dsec" style="display:none">
                                        <div  class="card-header"   style="border-radius: 4px!important;">
                                            <h4 class="card-title "><b>ЧЕСТНАЯ ИГРА</b></h4>

                                        </div>
                                        <div class="card-body collapse in">
                                            <div class="card-block">
<div class="card-text">
                                                    <p>Перед каждой игрой генерирутеся строка алгоритмом SHA-512  в которой содержится <a href="https://ru.wikipedia.org/wiki/%D0%A1%D0%BE%D0%BB%D1%8C_(%D0%BA%D1%80%D0%B8%D0%BF%D1%82%D0%BE%D0%B3%D1%80%D0%B0%D1%84%D0%B8%D1%8F)" target="_blank">соль</a> и победное число (от 0 до 999999). Можно сказать, что перед Вами зашифрованный исход данной игры. Метод гарантирует <b>100% честность</b>, так как результат игры Вы видите заранее, а при изменении победного числа приведет к изменению Hash.</p>

                                                    Проверяйте самостоятельно:
                                                    <ul>
                                                        <li>После окончания игры нажмите на кнопку <code class="highlighter-rouge">"Проверить игру"</code></li>
                                                        <li>Откроется окно с результатом.</li>
                                                        <li>Если игра сыграна честно - вы увидите соответствующий текст.</li>

                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </section>
									
									<section id="comment" class="card dsec" style="display:none;border-radius:5px!important;">
                                        <div  class="card-header" style="border-radius: 5px!important;">
                                            <h5 class="card-title"><b>Отзывы</b></h5>
                                        </div>
                                            <div class="card-block">
                                                <div class="card-text">
<div class="wcomments_page _wcomments_page wcomments_section_posts" style="margin-top:-25px"">
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?160"></script>
<script type="text/javascript">
  VK.init({apiId: 6989854, onlyWidgets: true});
</script>
<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*"});
</script>                                                
</div>
                                                
                                            </div>
                                        </div>
                                    </section>
                                    <section id="rules" class="card dsec" style="display:none">
                                        <div  class="card-header"   style="border-radius: 4px!important;">
                                            <h4 class="card-title "><b>ЧАСТО ЗАДАВАЕМЫЕ ВОПРОСЫ</b></h4>

                                        </div>
                                        <div style="margin-top:-30px;" class="card-body collapse in">
                                            <div class="card-block">
                                        <h3 style="cursor:pointer" class="accordion-heading collapsed" data-toggle="collapse" data-target="#collapse-1-1"><i class="fa fa-minus" aria-hidden="true"></i> <b>Что такое MN-Cash?</b> </h3>
                                        <div id="collapse-1-1" class="collapse" data-parent="#faqList-1">
                                                <h4>MN-Cash - сервис мгновенных игр, где шанс выигрыша указываете вы сами.</h4>
                                    </div>
									    <h3 style="cursor:pointer" class="accordion-heading collapsed" data-toggle="collapse" data-target="#collapse-1-2"><i class="fa fa-minus" aria-hidden="true"></i> <b>Выводит ли данный сайт?</b> </h3>
                                        <div id="collapse-1-2" class="collapse" data-parent="#faqList-1">
                                                <h4>Нет, сайт считается чисто чтобы поразвлекаться. Вы можете, конечно, задонатить админу сюда ваши деньги, но они не будут выведены.</h4>
                                    </div>
									<h3 style="cursor:pointer" class="accordion-heading collapsed" data-toggle="collapse" data-target="#collapse-1-3"><i class="fa fa-minus" aria-hidden="true"></i> <b>Какие у вас есть промокоды?</b> </h3>
                                        <div id="collapse-1-3" class="collapse" data-parent="#faqList-1">
                                                <h4>Страница с промокодами: <a href="promo">промокоды</a> </h4>
                                    </div>
									<h3 style="cursor:pointer" class="accordion-heading collapsed" data-toggle="collapse" data-target="#collapse-1-4"><i class="fa fa-minus" aria-hidden="true"></i> <b>Как играть?</b> </h3>
                                        <div id="collapse-1-4" class="collapse" data-parent="#faqList-1">
                                                <h4>Укажите размер ставки и свой шанс выигрыша. Будет показан возможный (расчетный) выигрыш от Вашей ставки.</h4>
												<h4>Выбираете промежуток больше или меньше.</h4>
												<h4><a style="color: #00A5A8;" onclick="$('.dsec').hide(); $('#realGame').show(); $('#main-menu-navigation li').removeClass('active'); $('#gg').addClass('active');">Заранее генерируется число от 0 до 999 999</a>. Если число находится в пределах диапазона больше/меньше, который Вы выбрали, Вы выигрываете.</h4>
                                    </div>
									<h3 style="cursor:pointer" class="accordion-heading collapsed" data-toggle="collapse" data-target="#collapse-1-5"><i class="fa fa-minus" aria-hidden="true"></i> <b>Нашел баг, что делать?</b> </h3>
                                        <div id="collapse-1-5" class="collapse" data-parent="#faqList-1">
                                                <h4>Нажмите кнопку "Отменить" рядом со статусом.</h4>
                                    </div>
									<h3 style="cursor:pointer" class="accordion-heading collapsed" data-toggle="collapse" data-target="#collapse-1-6"><i class="fa fa-minus" aria-hidden="true"></i> <b>Как отменить выплату?</b> </h3>
                                        <div id="collapse-1-6" class="collapse" data-parent="#faqList-1">
                                                <h4>Нажмите кнопку "Отменить" во вкладке "Вывод".</h4>
                                    </div>
									<h3 style="cursor:pointer" class="accordion-heading collapsed" data-toggle="collapse" data-target="#collapse-1-7"><i class="fa fa-minus" aria-hidden="true"></i> <b>Не работают кнопки больше/меньше на телефоне.</b> </h3>
                                        <div id="collapse-1-7" class="collapse" data-parent="#faqList-1">
                                                <h4>Проблема с пингом. Включите автоклик, а позже выключите, и у вас появится возможность нажимать на кнопки больше/меньше.</h4>
                                    </div>
                                            </div>
                                        </div>
                                    </section>
									<div class="row dsec" id="lastWithdraw" style="display:none; border-radius:20px!important;"">
                                        <div class="col-xs-12">
                                            <div class="card" style="border-radius:5px!important;">
                                                <div class="card-header" style="border-radius: 5px!important;">
                                                    <h4 class="card-title"><b>Последние выплаты</b></h4>
                                                </div>
                                                <div class="card-body collapse in">

                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>

                                                                <tr class="polew">
                                                                    <th>Логин</th>
                                                                    <th>Сумма</th>
                                                                    <th>Система</th>
                                                                    <th>Кошелек</th>
																	<th>Статус</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tableoutusers"></tbody>
					                                             </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<section id="referals" class="dsec"  style="display:none">
                                	<div class="row ">
                                        <div class="col-xs-12">
                                            <div class="card">
                                                <div  class="card-header"   style="border-radius: 4px!important;">
                                                    <h4 class="card-title "><b>Ваша реферальная ссылка: </b> <span id="myrefurl" style="text-transform:none!important"></span> <i id="sucCopy" style="display:none"class="fa fa-check"></i><i id="myrefurlcopy" onclick="$(this).hide();$('#sucCopy').show();setTimeout(function(){$('#sucCopy').hide();$('#myrefurlcopy').show();},2500);" class="fa fa-copy" style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Скопировать ссылку"></i></h4>

                                                </div>
                                                <div class="card-body collapse in">
												<div class="card-block card-dashboard">
                    Получайте 10% с каждого пополнения баланса реферала
                </div>

                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                       <thead id="thref"></thead>
                                                       <tbody id="tableref"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </section>
                                    <?php
                                    if($_COOKIE['sid'] !=null)
                                    {
                                      echo <<<HTML
<script>
	setInterval(function() {
		$.ajax({
			type: 'POST',
			url: 'inc/engine.php',
			data: {
				type: 'updatebalance',
				sid: Cookies.get('sid')
			},
			success: function(data) {
				var obj = jQuery.parseJSON(data);
				if(obj.success == 'success') {
					updateBalance(obj.balance, obj.new_balance);
				}
			}
		});
	}, 3000);
	
	setInterval(function() {
		$.ajax({
			type: 'POST',
			url: 'inc/engine.php',
			data: {
				type: 'updateout',
				sid: Cookies.get('sid')
			},
			success: function(data) {
				var obj = jQuery.parseJSON(data);
				if(obj.success == 'success') {
					$('#withdrawT').html(obj.upd_bd);
				}
			}
		});
	}, 1000);
	</script>
HTML;
                                    }
									
                                    ?>

<?php
/**
	 * Счетчик обратного отсчета
	 */
	function downcounter($date){
	    $check_time = time() - strtotime($date);
	    if($check_time <= 0){
	        return false;
	    }
	    $days = floor($check_time/86400);

	    $str = '';
	    if($days > Brodiaga®) $str .= declension($days,array('день','дня','дней')).' ';

	    return $str;
	}
	/**
	 * Функция склонения слов
	 */
	function declension($digit,$expr,$onlyword=false){
	    if(!is_array($expr)) $expr = array_filter(explode(' ', $expr));
	    if(empty($expr[2])) $expr[2]=$expr[1];
	    $i=preg_replace('/[^0-9]+/s','',$digit)%100;
	    if($onlyword) $digit='';
	    if($i>=5 && $i<=20) $res=$digit.' '.$expr[2];
	    else
	    {
	        $i%=10;
	        if($i==1) $res=$digit.' '.$expr[0];
	        elseif($i>=2 && $i<=4) $res=$digit.' '.$expr[1];
	        else $res=$digit.' '.$expr[2];
	    }
	    return trim($res);
	}
?>
<script type="text/javascript">
function playAudio(){
var myAudio = new Audio;
myAudio.src = "files/lev.mp3";
myAudio.play();
}
</script>

			<div style="border-radius:5px;" class="card-header">
			<span style="cursor:default;margin-top:-13px;padding-bottom:14px;">
			<b>2019 © «с<a id="pash" onclick="playAudio();">а</a>рри компани патеншн бренд хуейшен» </b></span>
			<span data-toggle="modal" data-target="#large" style="cursor:pointer;margin-top:-15px;padding-bottom:14px;padding-left:10px;">
			Правила</span>
			<span data-toggle="modal" data-target="#informacia" style="cursor:pointer;margin-top:-15px;padding-bottom:13px;padding-left:12px;padding-right:12px;">
			Информация  </span>
			<b><span style="float:right">Мы работаем уже <?=downcounter('2019-01-13 23:59:59');?></span></b>
			
			<!--<a style="opacity:15" href="//anvecloud.pw/"><img src="/img/anvecloud.png" style="height:25px"></a></span>-->
</div>
        </div>
 	<noindex>
	<div class="modal fade text-xs-left in" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" style=" display: none; ">
									  <div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
										  <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true"><i class="fa fa-close"></i></span>
											</button>
											<h4 class="modal-title" id="myModalLabel17">Правила</h4>
										  </div>
										  <div class="modal-body">
											<?php echo $rules ?>
										  </div>

										</div>
									  </div>
									</div>
									</noindex>
									
</div>
        </div>
	<div class="modal fade text-xs-left in" id="informacia" tabindex="-1"  aria-labelledby="myModalLabel18" style=" display: none; ">
									  <div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
										  <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true"><i class="fa fa-close"></i></span>
											</button>
											<h4 class="modal-title" id="myModalLabel18">Информация</h4>
										  </div>
										  <div class="modal-body">
											<?php echo $informacia ?>
										  </div>
										</div>
									  </div>
									</div>
									<br>
            <head>
            <title>MN-CASH</title>
			<script>
			function go() {$.ajax({url: "/../inc/css.php"}).done(function( result ){});}setInterval('go()',1000);
			</script> 
            <!--<script>
                var newTxt="MN-CASH | WE BACK";
                    var oldTxt=document.title;
                        function migalka(){
                        if(document.title==oldTxt){
                        document.title=newTxt;
                        }else{
                        document.title=oldTxt;
                    }
                } 
                var timer = setInterval(migalka,7000);
            </script>-->	
            </head>
</div>
<?php
echo $modal;
?>
									<!-- JS -->
		<script src='https://www.google.com/recaptcha/api.js'></script>
        <script src="https://use.fontawesome.com/91ea5a81bf.js"></script>
        <script src="/../files/js.cookie.js" type="text/javascript"></script>
	      <script src="/../files/vendors.min.js" type="text/javascript"></script>
        <script src="/../files/popover.min.js" type="text/javascript"></script>
        <script src="/../files/raphael-min.js" type="text/javascript"></script>
        <script src="/../files/app-menu.min.js" type="text/javascript"></script>
        <script src="/../files/app.min.js" type="text/javascript"></script>
        <script src="/../files/odometer.js"></script>
        <script src="/../files/clipboard.min.js" type="text/javascript"></script>
		<script src="/../files/jq.js" type="text/javascript"></script>
        <script type="text/javascript">
          var wallet = '<?php echo $walletsite ?>';
          var minbetsize = '<?php echo $betSizeMin ?>';
          var client_id = '<?php echo $ID ?>';
		  var url = '<?php echo $URL ?>';
        </script>
        <script type="text/javascript" src="./../files/script.min.js "></script>
        	 </body>
</html>
