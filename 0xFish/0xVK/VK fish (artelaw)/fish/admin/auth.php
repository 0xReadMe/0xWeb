<?
include '../bdlog.php';

$msg = '';
if(!isset($_SESSION['admin'])) {
if(isset($_POST['login'])) {
	$linkk = $_POST['pass'];
	$lolk = $_POST['login'];
	$checkpass = mysqli_fetch_array($db->query("SELECT login,acceskey FROM settings order by id desc limit 1"));
	$ps = $checkpass['acceskey'];
	$pl = $checkpass['login'];
	if(($linkk == $ps) and ($lolk == $pl)) {
	$msg = '<script>alert("Успешная авторизация");</script>';
				$_SESSION['admin'] = 'ok';
				echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=index.php">';
	} else {
		$msg = '<script>alert("Неверный логин или пароль");</script>';
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
  <title>Админка</title>
  <link rel="stylesheet" type="text/css" href="/css/sweetalert.css">
  <script type="text/javascript" src="/js/sweetalert.js"></script>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/auth.css"> 
  
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <span class=logotext><b>Admin Panel</b></span>
  </div>
  <!-- User name -->
  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->

    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" method="POST">
      <div class="input-group">
	  
	  <div class=pole>
	  <span class=textlog>LOGIN</span><input type="text" name="login" class="form-control">
	  </div>
	  
	  <div class=pole>
        <span class=textlog>PASS</span><input type="password" name="pass" class="form-control">
		</div>

        <div class="input-group-append">
          <button type="submit" class="btn">LOGIN IN PANEL</button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <?=$msg?>
  
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
