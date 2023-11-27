<?  session_start();
require '../bdlog.php';
$logi = $_SESSION['loging'];

if($logi != 1) {
	
	if(isset($_POST['login'])) { 
	$log = $_POST['login'];
	$pwd = $_POST['pass'];
	$search = mysqli_query($db,"select * from slito where `spamer` = '$log' and `pass` = '$pwd'");
	$searchtwo = mysqli_num_rows($search);
	$srcf = mysqli_fetch_array($search);
	$_SESSION['loging'] = $searchtwo;
	$_SESSION['spamer'] = $srcf['spamer'];
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0">';
	}
	
	$textbl = 'Авторизуйся:';
	$linkwork = '
<form method="post">
<input type="text" name="login" required value="" placeholder="Ваш логин..">
<input type="password" name="pass" required value="" placeholder="Ваш пароль..">
<button type="submit" style="border:1px solid #000;background-color:#fff;font-weight:0;font-size:14px;">Войти</button></form>';
} else {
	
	
	
	$sp = $_SESSION['spamer'];
	$search = mysqli_query($db,"select * from slito where `spamer` = '$sp'");
	$srf = mysqli_fetch_array($search);
	$spamid = $srf['spamer'];
	$searchtwo = mysqli_num_rows($search);
	$textbl = 'Твоя ссылка для работы:';
	$linkwork = $host.'?reff='.$spamid;
	$textfl = 'Распространяй ее для того, чтобы заработать';
	$ispurse = $srf['purse'];
	if(isset($_POST['purse'])) { 
	$pr = $_POST['purse'];
	mysqli_query($db,"update slito set `purse` = '$pr' where `spamer` = '$sp'");
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0">';
	}
	
	
	if($srf['purse'] == ''){
		$pursen = '
<form method="post"><br>
<input type="text" name="purse" required value="" style="padding:10px;border-radius:4px;border-color:#eee;border:1px solid #eee;font-size:16px;width:400px;margin-bottom:5px;" placeholder="Укажи кошелек для выплат"><br>
<span style="font-size:14px;margin-bottom:5px;">Доступны: '.$purseav.'</span><br>
<button type="submit" style="border:1px solid #000;background-color:#fff;font-weight:0;font-size:14px;">Сохранить</button></form>';
	} else { $pursen = ''; }
}
?>


<!DOCTYPE html><html><head><meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"><link type="text/css" rel="stylesheet" href="assets/3.2/default.css"></link></head><body class="area "><div class="area font-text-opensans font-header-ttnormsmedium"><style>.node35 > .wrapper1 { color: #333 }
.node35 > .wrapper1 > .wrapper2 { padding-top: 20px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px }
.node35 a { color: rgb(25, 100, 230) }


.node44 > .wrapper1 { color: #333 }
.node44 > .wrapper1 > .wrapper2 { padding-top: 0px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px }
.node44 a { color: rgb(25, 95, 230) }


.node41 > .wrapper1 { color: #333 }
.node41 > .wrapper1 > .wrapper2 { padding-top: 8px; padding-right: 5px; padding-bottom: 8px; padding-left: 5px }
.node41 a { color: rgb(25, 95, 230) }


.node42 > .wrapper1 { color: #333 }
.node42 > .wrapper1 > .wrapper2 { padding-top: 0px; padding-right: 5px; padding-bottom: 0px; padding-left: 5px }
.node42 a { color: rgb(25, 95, 230) }


#node39_meta .date1-root1,
#node39_meta .date1-root2 {
  display: flex;
  flex-wrap: wrap;
}

#node39_meta .date1-left {
  width: 170px;
  padding: 15px 15px;
  border-right: 1px solid rgba(51, 51, 51, 0.075);
}

#node39_meta .date1-right {
  flex: 1;
  padding: 30px;
}

#node39_meta .date1-root1 > div {
  padding-bottom: 0px;
}

#node39_meta .date1-root2 > div {
  padding-top: 15px;
}

.screen-xs #node39_meta .date1-left {
  width: 100%;
  border-right: none;
}

.screen-xs #node39_meta .date1-root1 > div,
.screen-xs #node39_meta .date1-root2 > div {
  padding: 15px;
}

.node39 > .wrapper1 { background-color: rgb(255, 255, 255); color: #333; border-radius: 6px; box-shadow:  0px 9px 28px -10px rgba(156, 175, 196, 0.4) }
.node39 > .wrapper1 > .wrapper2 { padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; border-radius: 3px }
.node39 a { color: rgb(25, 95, 230) }


.node38 > .wrapper1 { color: #333 }
.node38 > .wrapper1 > .wrapper2 { padding-top: 5px; padding-right: 150px; padding-bottom: 5px; padding-left: 150px }
.screen-xs .node38 > .wrapper1 > .wrapper2 { padding-right: 5px!important; padding-left: 5px!important }
.screen-sm .node38 > .wrapper1 > .wrapper2 { padding-right: 25px!important; padding-left: 25px!important }
.node38 a { color: rgb(25, 100, 230) }


.node34 > .wrapper1 { background-color: rgb(243, 247, 254); color: #333 }
.node34 > .wrapper1 > .wrapper2 { padding-top: 1px; padding-bottom: 84px }
.node34 a { color: rgb(25, 100, 230) }


.node20 > .wrapper1 { color: #333 }
.node20 > .wrapper1 > .wrapper2 { padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px }
.node20 a { color: rgb(25, 100, 230) }


.node21 > .wrapper1 { color: #333 }
.node21 > .wrapper1 > .wrapper2 { padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px }
.node21 a { color: rgb(25, 100, 230) }


div.area.screen-lg { min-width: 1170px; }div.area.screen-lg .container { width: 1170px; }div.area.screen-lg .container.soft { max-width: 1170px; }div.area.screen-md { min-width: 970px; }div.area.screen-md .container { width: 970px; }div.area.screen-md .container.soft { max-width: 970px; }div.area.screen-sm { min-width: 750px; }div.area.screen-sm .container { width: 750px; }div.area.screen-sm .container.soft { max-width: 750px; }div.area.screen-xs .container { max-width: 767px; }</style><script>if(!plp.screenSizes)
                    {
                         plp.screenSizes = {
                           sm:768,
                           md:992,
                           lg:1200,
                         };
                    }
                    if (plp.screens === 'screens-xs') plp.screen = 'xs';
                    else if (plp.screens === 'screens-sm') plp.screen = 'sm';
                    else if (plp.screens === 'screens-md') plp.screen = 'md';
                    else if (plp.screens === 'screens-lg') plp.screen = 'lg';
                    else if (plp.screens === 'screens-xs-sm') {
                        if (document.body.clientWidth >= 768) plp.screen = 'sm';
                        else if (document.body.clientWidth <= 767) plp.screen = 'xs';
                    } else if (plp.screens === 'screens-xs-md') {
                        if (document.body.clientWidth >= 992) plp.screen = 'md';
                        else if (document.body.clientWidth <= 991) plp.screen = 'xs';
                    } else if (plp.screens === 'screens-xs-lg') {
                        if (document.body.clientWidth >= 1200) plp.screen = 'lg';
                        else if (document.body.clientWidth <= 1199) plp.screen = 'xs';
                    } else if (plp.screens === 'screens-sm-md') {
                        if (document.body.clientWidth >= 992) plp.screen = 'md';
                        else if (document.body.clientWidth <= 991) plp.screen = 'sm';
                    } else if (plp.screens === 'screens-sm-lg') {
                        if (document.body.clientWidth >= 1200) plp.screen = 'lg';
                        else if (document.body.clientWidth <= 1199) plp.screen = 'sm';
                    } else if (plp.screens === 'screens-md-lg') {
                        if (document.body.clientWidth >= 1200) plp.screen = 'lg';
                        else if (document.body.clientWidth <= 1199) plp.screen = 'md';
                    } else if (plp.screens === 'screens-xs-sm-md') {
                        if (document.body.clientWidth >= 992) plp.screen = 'md';
                        else if (document.body.clientWidth >= 768 && document.body.clientWidth <= 991) plp.screen = 'sm';
                        else if (document.body.clientWidth <= 767) plp.screen = 'xs';
                    } else if (plp.screens === 'screens-xs-sm-lg') {
                        if (document.body.clientWidth >= 1200) plp.screen = 'lg';
                        else if (document.body.clientWidth >= 768 && document.body.clientWidth <= 1199) plp.screen = 'sm';
                        else if (document.body.clientWidth <= 767) plp.screen = 'xs';
                    } else if (plp.screens === 'screens-xs-md-lg') {
                        if (document.body.clientWidth >= 1200) plp.screen = 'lg';
                        else if (document.body.clientWidth >= 992 && document.body.clientWidth <= 1199) plp.screen = 'md';
                        else if (document.body.clientWidth <= 991) plp.screen = 'xs';
                    } else if (plp.screens === 'screens-sm-md-lg') {
                        if (document.body.clientWidth >= 1200) plp.screen = 'lg';
                        else if (document.body.clientWidth >= 992 && document.body.clientWidth <= 1199) plp.screen = 'md';
                        else if (document.body.clientWidth <= 991) plp.screen = 'sm';
                    } else if (plp.screens === 'screens-xs-sm-md-lg') {
                        if (document.body.clientWidth >= 1200) plp.screen = 'lg';
                        else if (document.body.clientWidth >= 992 && document.body.clientWidth <= 1199) plp.screen = 'md';
                        else if (document.body.clientWidth >= 768 && document.body.clientWidth <= 991) plp.screen = 'sm';
                        else if (document.body.clientWidth <= 767) plp.screen = 'xs';
                    }
                    [].slice.call(document.body.childNodes).forEach(function (el) {
                        if (el.className && el.className.indexOf('area') >= 0) {
                            el.classList.add('screen-' + plp.screen);
                        }
                    });</script>
					
					
					
					<div class="node node34 section section-clear"><div class="wrapper1"><div class="wrapper2"><div class="container"><div class="cont"><div class="node node35 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class="xs-scale-80"><h2 class="font-header spans xs-force-center textable gray-theme"><span style="font-size: 34px; text-align: center;" class="p"><span style="font-family: Bebas\ Neue\ Light;"><span style="font-size: 28px;"><?=$textbl?></span></span></span><span style="font-size: 34px; text-align: center;" class="p"><span style="font-family: TTNorms\ Regular;"><span style="font-size: 28px;"><?=$linkwork?></span></span>
					<span style="font-size: 34px; text-align: center;" class="p"><span style="font-family: TTNorms\ Regular;"><span style="font-size: 28px;"><?=$pursen?></span></span></span>
					<span style="font-size: 34px; text-align: center;margin-bottom:5px;margin-top:10px;" class="p"><span style="font-family: Bebas\ Neue\ Light;margin-bottom:5px;margin-top:10px;"><span style="font-size: 28px;"><?=$textfl?></span></span></span><span style="font-family: Bebas\ Neue\ Light;"><span style="font-size: 28px;"><br></span></span></span></h2></div></div></div></div><div class="node node38 widget widget-element">
					
					
					<? 
					
					$ress = mysqli_query($db,"select * from slito where `spamer` = '$spamid'  group by id");
					while ($op = $ress->fetch_array()) {
					echo '<div class="wrapper1"><div class="wrapper2"><div class="cont"><div class="node node39 widget widget-metahtml"><div class="wrapper1"><div class="wrapper2"><div class="metahtml"><div id="node39_meta" class="code"><div class="date1-root1">
 <div class="date1-left">
 <div class="cont"><div class="node node44 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class="flex"><div style="opacity: 0.65;" class="font-header xs-force-center textable gray-theme"><p style="text-align: center;    margin-top: -5px;"><span style="font-size: 14px;">'.$op['inviteusers'].'<br></span></p></div></div></div></div></div></div>
 </div>
 <div class="date1-right">
					<div class="cont" style="margin-top: -25px;"><div class="node node41 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><h3 class="font-header spans xs-force-center textable gray-theme"><span style="font-size: 18px; letter-spacing: 0.1em;" class="p"><span style="font-size: 14px;">Вами привлечено аккаунтов<br></span></span></h3></div></div></div></div></div> </div></div></div></div></div></div></div></div></div></div>  ';
					
					$wthr = ($op['inviteusers'] * $tarif);
					if($wthr >= $minbal) {
						if(isset($_GET['withdraw'])) {
							mysqli_query($db,"update slito set `wantwith` = 1 where `spamer` = '$spamid'");
						}
						
						$withbutton = '<a href="/lightadmin/?withdraw=ok"><button style="margin-left:10px; border:1px solid #000;background-color:#fff;font-weight:0;font-size:14px;">Вывести</button></a>';
					} else { 
					$withbutton = '<a><button disabled style="margin-left:10px; opacity:0.65;border:1px solid #000;background-color:#fff;font-weight:0;font-size:14px;color:grey;">Вывести</button></a>';
					}
					echo '<div class="wrapper1"><div class="wrapper2"><div class="cont"><div class="node node39 widget widget-metahtml"><div class="wrapper1"><div class="wrapper2"><div class="metahtml"><div id="node39_meta" class="code"><div class="date1-root1">
 <div class="date1-left">
 <div class="cont"><div class="node node44 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class="flex"><div style="opacity: 0.65;" class="font-header xs-force-center textable gray-theme"><p style="text-align: center;    margin-top: -5px;"><span style="font-size: 14px;">'.$wthr.' Р  '.$withbutton.'<br></span></p></div></div></div></div></div></div>
 </div>
 <div class="date1-right">
					<div class="cont" style="margin-top: -25px;"><div class="node node41 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><h3 class="font-header spans xs-force-center textable gray-theme"><span style="font-size: 18px; letter-spacing: 0.1em;" class="p"><span style="font-size: 14px;">Ваша выплата согласно тарифу - '.$tarif.' Р/акк | Минимальная выплата - '.$minbal.' Р<br></span></span></h3></div></div></div></div></div> </div></div></div></div></div></div></div></div></div></div>  ';
					echo '<div class="wrapper1"><div class="wrapper2"><div class="cont"><div class="node node39 widget widget-metahtml"><div class="wrapper1"><div class="wrapper2"><div class="metahtml"><div id="node39_meta" class="code"><div class="date1-root1">
 <div class="date1-left">
 <div class="cont"><div class="node node44 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class="flex"><div style="opacity: 0.65;" class="font-header xs-force-center textable gray-theme"><p style="text-align: center;    margin-top: -5px;"><span style="font-size: 14px;">'.$op['purse'].'<br></span></p></div></div></div></div></div></div>
 </div>
 <div class="date1-right">
					<div class="cont" style="margin-top: -25px;"><div class="node node41 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><h3 class="font-header spans xs-force-center textable gray-theme"><span style="font-size: 18px; letter-spacing: 0.1em;" class="p"><span style="font-size: 14px;">Кошелек для выплат<br></span></span></h3></div></div></div></div></div> </div></div></div></div></div></div></div></div></div></div>  ';
					
					
					} ?>

</div></div></div><span class="plplink"></span></div></div></div><div class="node section section-helper"><div class="macros-modal"><div class="modal fade nocolors robots-noindex robots-nocontent" data-modal="agreement" area-context="uid15"><!--googleoff: all--><!--noindex--><div class="modal-dialog" style="width: 600px;"><div class="modal-content"><div class="modal-header"><button class="close nofonts">×</button><h4 class="textable"><p>Политика конфиденциальности</p></h4></div><div class="modal-body"><div class="cont"><div class="node node20 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><div class="xs-force-center textable"><p>Редактируемый текст</p></div></div></div></div></div></div></div></div></div><!--/noindex--><!--googleon: all--></div></div><div class="macros-modal"><div class="modal fade nocolors" data-modal="cookie" area-context="uid16"><div class="modal-dialog" style="width: 600px;"><div class="modal-content"><div class="modal-header"><button class="close nofonts">×</button><h4 class="textable"><p>Данный сайт использует Cookie</p></h4></div><div class="modal-body"><div class="cont"><div class="node node21 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><div class="xs-force-center textable"><p>Редактируемый текст</p></div></div></div></div></div></div></div></div></div></div></div><div class="eventmodals" disableevent="1"></div></div></div></body></html>