<?php

error_reporting(0);

if (isset($_POST["amount"]) && $_POST["amount"] !== null) {
    $amount = $_POST["amount"];
    $item = $_POST["item"];
    $checkbox = $_POST["checkbox"];

    if ($checkbox == "checked") {
        $type = "refund";
    } else {
        $type = "common";
    }

    $filename = "payments/" . substr(md5(rand(1000000, 9999999)), 4, 12);
    $content = [
        "amount" => $amount,
        "item" => $item,
        "type" => $type
    ];

    $content = json_encode($content);

    $file = fopen($filename, "w");
    fwrite($file, $content);
    fclose($file);

    $response = [
        "status" => "success",
        "url" => urlencode("https://" . $_SERVER["HTTP_HOST"] . "/merchant/?id=" . explode("/", $filename)[1])
    ];

    echo json_encode($response);
    exit;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=cyrillic">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/common.css">
        <link rel="shortcut icon" type="image/png" href="img/fav-icon.png">

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/common.js"></script>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <title>Генератор ссылок</title>
    </head>

    <body>
        <div class="block-info">
            <h3 class="heading-info">
                Генератор ссылок
            </h3>

            <p class="description-info">
                Сгенерируйте платежную ссылку с помощью этой формы.
            </p>
        </div>

        <div class="divider" style="margin-bottom: 25px;"></div>

        <div class="block-form">
            <form class="form-payment" action="payment.php" method="post">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                                <label for="input-month">Сумма платежа</label>
                                <input type="text" class="form-control" id="input-amount" data-type="number" placeholder="1000 ₽" maxlength="8">
                        </div>
                    </div>

                    <div class="col-xs-8">
                        <div class="form-group">
                            <label for="input-month">Описание платежа</label>
                                <input type="text" class="form-control" id="input-item" placeholder="Оплата заказа №123456">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-weight: 500;">
                              <input type="checkbox" class="input-checkbox"> Возврат платежа
                        </label>
                </div>
            </form>

            <div class="block-form-info" style="text-align: left;">
                <h4 class="heading-total">Ссылка для оплаты: <b></b></h4>
                <p class="heading-secure label-url" style="margin-top: 10px; user-select: auto;">
                    ссылка не сгенерирована
                </p>
            </div>
        </div>

        <div class="divider"></div>

        <div class="block-footer">
            <div class="row">
                <div class="col-xs-12">
                    <a class="button-generate">
                        Сгенерировать
                    </a>
                </div>
            </div>
        </div>
    </body>

    <script type="text/javascript">
        var checkbox;

        $(".input-checkbox").click(function() {
                if ($(this).is(":checked")) {
                        checkbox = "checked";
                } else {
                    checkbox = null;
                }
        });

        $(".button-generate").click(function() {
            var amount = $("#input-amount");
            var item = $("#input-item");

            if (amount.val().length < 3) {
                amount.addClass("input-error");

                setTimeout(function() {
                    amount.removeClass("input-error");
                }, 2500);

                return false;
            }

            $.post("generator.php", { "item": item.val(), "amount": amount.val(), "checkbox": checkbox })
            .done(function(response) {
                response = JSON.parse(response);

                if (response["status"] == "success") {
                    $(".label-url").text(decodeURIComponent(response["url"]));
                }
            });
        });
    </script>
</html>
