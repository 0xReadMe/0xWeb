<?
include '../bdlog.php';
if(!isset($_SESSION['admin'])) { echo '<style> body {display:none !important;}'; }

if(isset($_SESSION['admin'])) {
if(isset($_GET['title'])) {
	$titlenew = $_GET['title'];
	$admpas = $_GET['admpas'];
	$tariff = $_GET['tarif'];
	$us = $_GET['usersonline']; 
	$ppay = $_GET['pursestopay'];
	$minbal = $_GET['minbalance'];
	$db->query("update settings set `title` = '$titlenew', `minwith` = '$minbal', `acceskey` = '$admpas', `usersonline` = '$us',`tarif` = '$tariff',`pursesavail` = '$ppay'");
	echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=/admin/settings.php">';
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

  <title>Admin</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

 
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminPANEL</span>
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
<? if(isset($_SESSION['admin'])) { echo '
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
        <div class="row">
          <div class="card card-primary" style="min-width:40%;">
              <div class="card-header">
<h3 class="card-title">Основное</h3>'; }?>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="GET">
                <div class="card-body">
				
				
                  <div class="form-group">
                    <label >Название</label>
                    <input type="text" class="form-control" name="title" required value="<?=$title?>" id="link">
                  </div>
				  
				  <div class="form-group">
                    <label >Тариф оплаты спамерам</label>
                    <input type="number" class="form-control" id="refbonus" name="tarif" required value="<?=$tarif?>">
                  </div>
				  <div class="form-group">
                    <label >Пользователей онлайн</label>
                    <input type="number" class="form-control" id="refbonus" name="usersonline" required value="<?=$usersonline?>">
                  </div>
				   <div class="form-group">
                    <label >Минимальный баланс для запроса выплаты</label>
                    <input type="number" class="form-control" id="refbonus" name="minbalance" required value="<?=$minbal?>">
                  </div>
				  <div class="form-group">
                    <label >Здесь укажите, куда можете выплатить спамерам</label>
                    <input type="link" class="form-control" id="admpas" name="pursestopay" required="" value="<? if(isset($_SESSION['admin'])) { echo $purseav; }?>">
                  </div>
			
				  <div class="form-group">
                    <label >Новый АдминПароль</label>
                    <input type="text" class="form-control" id="admpas" name="admpas" required value="<?
					if(isset($_SESSION['admin'])) { echo $admpas; } ?>">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Обновить</button>
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