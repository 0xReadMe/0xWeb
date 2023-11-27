<?
include '../bdlog.php';

$msg = '';
if(!isset($_SESSION['admin'])) {
if(isset($_POST['pass'])) {
	$linkk = $_POST['pass'];
	$checkpass = mysqli_fetch_array($db->query("SELECT acceskey FROM settings order by id desc limit 1"));
	$ps = $checkpass['acceskey'];
	if($linkk == $ps) {
	$msg = '<div class="callout callout-success">
                  <h5>Успех!</h5>
                </div>';
				$_SESSION['admin'] = 'ok';
				echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=index.php">';
	} else {
		$msg = '<div class="callout callout-danger">
                  <h5>Ошибка!</h5>

                  <p>Данные введены неверно.</p>
                </div>';
	}
} } else {
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=index.php">';
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lockscreen</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <b>Вход</b>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">ADMIN</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="../admin/dist/img/user1-128x128.jpg" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" method="POST">
      <div class="input-group">
        <input type="password" name="pass" class="form-control" placeholder="password">

        <div class="input-group-append">
          <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <?=$msg?>
  <div class="help-block text-center">
    Введите ключ доступа
  </div>
  
  
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
