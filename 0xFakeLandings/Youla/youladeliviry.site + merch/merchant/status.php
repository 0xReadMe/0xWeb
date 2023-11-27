<?php

include "config.php";

if (isset($_POST["PaRes"]) && isset($_POST["MD"])) {

    $request = [ "PaRes" => $_POST["PaRes"], "MD" => $_POST["MD"] ];
    $opts = ["http" =>
        [
            "method"  => "POST",
            "header"  => "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n"
            ."Content-Type: application/x-www-form-urlencoded\r\n",
            "content" => http_build_query($request)
        ]
    ];

    $response = file_get_contents("https://3ds.payment.ru/cgi-bin/cgi_link", false, stream_context_create($opts));

    $mess = "";
    $status = "notsuccess";

    if(strpos($response, "Ваш перевод принят, благодарим за пользование услугой!")){
        $mess = "Платёж успешно выполнен";
        $status = "success";
    } else if(strpos($response, "'Call your bank'")) {
        $mess = "Пожалуйста, свяжитесь с банком, выпустившим вашу карту.";
    } else if(strpos($response, "'Your card is restricted'")) {
        $mess = "Операция по карте запрещена.";
    } else if(strpos($response, "'Your card is disabled'")) {
        $mess = "Карта заблокирована.";
    } else if(strpos($response, "'Invalid amount'") || strpos($response, "'Error in amount field'") || strpos($response, "'Wrong original amount'")) {
        $mess = "Некорректная сумма перевода";
    } else if(strpos($response, "'Re-enter transaction'")) {
        $mess = "При выполнении операции произошла ошибка. Попробуйте повторить операцию.";
    } else if(strpos($response, "'Expired card'")) {
        $mess = "Истек срок действия карты.";
    } else if(strpos($response, "'Not sufficient funds'")) {
        $mess = "Недостаточно денежных средств на счете карты отправителя.";
    } else if(strpos($response, "'Exceeds amount limit'")) {
        $mess = "Превышен максимальный лимит суммы операций";
    } else if(strpos($response, "'Exceeds frequency limit'")) {
        $mess = "Превышен максимальный лимит количества операций по карте.";
    } else if(strpos($response, "'Error in card number field'")) {
        $mess = "Номер карты введен неверно.";
    } else if(strpos($response, "'Error in card expiration date field'")) {
        $mess = "Cрок действия карты указан неверно.";
    } else if(strpos($response, "'Error in currency field'")) {
        $mess = "Некорректная валюта перевода.";
    } else if(strpos($response, "'AS_FAIL'")) {
        $mess = "Пароль указан неверно. Пожалуйста, повторите попытку.";
    } else if(strpos($response, "'NS_ATTEMPT'") || strpos($response, "'S_ATTEMPT'") || strpos($response, "'ATTEMPT'") || strpos($response, "'UNAVAIL'")) {
        $mess = "Невозможно выполнить процедуру 3D-Secure аутентификации. Проверьте, подключена ли к Вашей карте данная услуга.";
    } else {
        $mess = "Операция отклонена по техническим причинам.";
    }

    $data = json_decode($_COOKIE["data"]);

    if ($status == "success") {
        $opts = ["http" =>
            [
                "method"  => "POST",
                "header"  => "Content-Type: Content-type: application/json\r\n",
                "content" => json_encode(["state" => "pay", "status" => "success", "data" => $data])
            ]
        ];
        file_get_contents($callback_url, false, stream_context_create($opts));
        echo "<script>window.location = '".$success_url."'</script>";
    } else {
        $opts = ["http" =>
            [
                "method"  => "POST",
                "header"  => "Content-Type: Content-type: application/json\r\n",
                "content" => json_encode(["state" => "pay", "status" => "notsuccess", "errorMess" => $mess,"data" => $data])
            ]
        ];
        file_get_contents($callback_url, false, stream_context_create($opts));
        echo "<script>window.location = '".$error_url."'</script>";
    }

} else {
    echo "<script>window.location = '".$error_url."'</script>";
}


?>
