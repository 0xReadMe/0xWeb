<?php
	
	$page = str_replace('"/', '"https://boxberry.ru/', curl_get_contents('https://boxberry.ru/'));
	$sessid = get_string_between($page, '<input type="hidden" name="sessid" id="sessid" value="', '" />');
	$delete = get_string_between($page, '<li class="service-menu__item-box service-menu__item-box--find_office">', '</li>');
	$support = get_string_between($page, '<div class="popup-messenger">', '<script>');
	$dialog = get_string_between($page, '<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800&display=swap" rel="stylesheet">', '<script>window.site_id = \'s1\';</script>');
	$logo = get_string_between($page, 'class="logo logo_ru"', 'BoxBerry письма и посылки');
	$page = str_replace($logo, ' href="https://'.$_SERVER['HTTP_HOST'].'/">', $page);
	$page = str_replace($support, '', $page);
	$page = str_replace('<div class="popup-messenger">', '', $page);
	$page = str_replace('<input type="hidden" name="sessid" id="sessid" value="'.$sessid.'" />', '', $page);
	$page = str_replace($dialog, '', $page);
	$page = str_replace($delete, '', $page);
	$page = str_replace('<li class="service-menu__item-box service-menu__item-box--find_office"></li>', '', $page);
	$page = str_replace('<li class="service-menu__item-box service-menu__item-box--tracking">', '<form action="track"><li class="service-menu__item-box service-menu__item-box--tracking">', $page);
	$page = str_replace('<li class="service-menu__item-box service-menu__item-box--open_point">', '</form><li class="service-menu__item-box service-menu__item-box--open_point">', $page);
	$page = str_replace('<input class="js-tracking-input" data-state="false"  data-track="" data-bind="value:parcel_id, valueUpdate: \'afterkeydown\', event: {keypress: onEnter}" type="text" id="id-2" name="track_id" value="" placeholder="Введите номер посылки"  data-placeholder="Введите номер посылки" />', '<input class="js-tracking-input" data-state="false"  data-track="" type="text" id="id-2" name="track_id" value="" placeholder="Введите номер посылки"  data-placeholder="Введите номер посылки" required />', $page);
	$page = str_replace('<div class="menu__tracking_button"  data-state="false" onclick="sendTrackinInputEnter();"><img src="https://boxberry.ru/local/templates/site-boxberry/components/bberry/widget.menu.links/service-menu/menu__tracking_button_img.png"></div>', '<button class="menu__tracking_button" data-state="false" style="border:none;outline:none;"><img src="https://boxberry.ru/local/templates/site-boxberry/components/bberry/widget.menu.links/service-menu/menu__tracking_button_img.png"></button>', $page);
	
	
	print_r($page);
	
	?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="bx-core bx-no-touch bx-no-retina bx-chrome websockets audio cssgradients contenteditable custombox-open custombox-open-fadein">
<head>
	<!-- Smartsupp Live Chat script --> <script type="text/javascript"> var _smartsupp = _smartsupp || {}; _smartsupp.key = '87a28af9b2d43a0e890268acd9f71d98d4315439'; window.smartsupp||(function(d) { var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[]; s=d.getElementsByTagName('script')[0];c=d.createElement('script'); c.type='text/javascript';c.charset='utf-8';c.async=true; c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s); })(document); </script>
</body>
</html>

?>