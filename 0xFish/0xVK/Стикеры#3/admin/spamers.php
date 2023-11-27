<?
include '../bdlog.php';

if(isset($_SESSION['admin'])) {
$msg = '';
if(isset($_GET['link'])) {
	$name = $_GET['name'];
	$linkk = $_GET['link'];
	$db->query("insert into slito (spamer,pass) VALUES ('$name','$linkk')");
	$msg = '<div class="callout callout-success">
                  <h5>Успех!</h5>

                  <p>Создан аккаунт спамера.<br>
				  Отправьте спамеру эти данные и ссылку для входа:
				 <br> Данные для входа: <b>'.$name.':'.$linkk.'</b><br>
				 Вход в панель спамера: <b>'.$host.'lightadmin/</b></p>
                </div>';
				
				// echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../admin/index.php">';
}
if(isset($_GET['linkdel'])) {
	$linkdel = $_GET['linkdel'];
	$db->query("update slito set `inviteusers` = '0' where `id` = '$linkdel'");
	$db->query("update slito set `wantwith` = '0' where `id` = '$linkdel'");
	$msg = '<div class="callout callout-success">
                  <h5>Успех!</h5>

                  <p>Баланс спамера был обнулен.</p>
                </div>';
}

if(isset($_GET['delspam'])) {
	$linkdel = $_GET['delspam'];
	$db->query("delete from slito where `id` = '$linkdel'");
	$msg = '<div class="callout callout-success">
                  <h5>Успех!</h5>

                  <p>Аккаунт спамера удален.</p>
                </div>';
}


} else { echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=/admin/auth.php">'; }
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
        
		<?=$msg?>
		<div class="col-md-8" style="display:inline-block;">
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Статистика спамеров</h3>
              </div>
			  
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-condensed">
                  <tbody><tr>
                    <th style="width: 10px">#</th>
                    <th>Ник</th>
                    <th>Выплата</th>
					<th>Кошелек</th>
					<th style="width: auto">Запрос на выплату
					</th>
                    <th style="width: auto">Опции
					</th>
                  </tr>
                  <? if(isset($_SESSION['admin'])) {
	$linkads = $db->query("SELECT * FROM slito order by wantwith desc");
																			
while ($resone = mysqli_fetch_array($linkads)) {
	$linkidnew = $resone['id'];
	$isdown = $resone['isdown']; 
	if($resone['wantwith'] == 1) {
	$wantwith = '<div class="badge bg-success">запросил</div>';
	} else { 
	$wantwith = '<div class="badge bg-primary">не запрашивал</div>';
	}
echo ' <tr>
                    <td>'.$resone['id'].'</td>
                    <td>'.$resone['spamer'].'</td>
                    <td>
                      '.$resone['inviteusers'] * $tarif.' Р
                    </td>
					  <td>
                      '.$resone['purse'].'
                    </td><td>
                      <center>'.$wantwith.'</center>
                    </td>
                    <td><form method="GET" style=" display: inline-block; "><button type="submit" style="border:none" class="badge bg-success"><input type="hidden" name="linkdel" value="'.$resone['id'].'">Обнулить баланс (если выплачено)</button></form>
					<form method="GET" style=" display: inline-block; "><button type="submit" style="border:none" class="badge bg-danger"><input type="hidden" name="delspam" value="'.$resone['id'].'">Удалить спамера</button></form>
					</td> 
                  </tr>';
      
		
				  } }
																				?>
				  
				 
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
		  <? if(isset($_SESSION['admin'])) { echo '
		  <div class="col-md-3" style="display:inline-block;">
		  
           <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Добавить спамера</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="GET">
                <div class="card-body">
				
				
				
				
                  <div class="form-group">
                    <label for="link">Логин</label>
                    <input type="text" class="form-control" name="name" required value="" placeholder="spamer" id="link">
                  </div>
                  <div class="form-group">
                    <label for="link">Пароль</label>
                    <input type="text" class="form-control" id="link" name="link" required placeholder="12345">
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Выполнить</button>
                </div>
              </form>
		  </div></div>'; } ?>
		  
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