<?php
include_once 'inc/config.php';
$id = $_GET['id'];
	$sql_select = "SELECT * FROM ".$prefix."_games WHERE id='".mysql_real_escape_string($id)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$ida = $row['id'];
	$user_id = $row['user_id'];
	$cel = $row['cel'];
	$suma = $row['suma'];
	$chislo = $row['chislo'];
	$hash = $row['hash'];
	$salt12 = $row['salt1'];
	$salt22 = $row['salt2'];
	$win_summa = $row['win_summa'];
	$slat = $row['saltall'];

	$rand = $row['saltall'];
	$rande = preg_replace("/[^0-9]/", '', $rand);
	$rand = str_replace("$rande", "|{$rande}|", $rand);
$number = explode( '|', $rand )[1];
$salt1 = explode( '|', $rand )[0];
$namsalt1 = $salt1."|".$number."|";
$salt2 = str_replace($namsalt1, '', $rand);
}
if($ida == null)
{
		header('location: /');
}
?>
    <!--скрипт от Sarry13 (https://vk.com/xyecoc_syka)-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		<html lang="ru" data-textdirection="ltr" class="loaded"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="referrer" content="no-referrer">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>MN-CASH - ИГРА №<?php echo $ida; ?></title>
	  <meta name="description" content="Что такое MASHKIN - надежный сайт для какой-то хуйни.">
    <meta name="author" content="<?php echo $domain_site ?>">
    <link rel="stylesheet" type="text/css" href="/../files/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/../files/style.min.css">
    <link rel="stylesheet" type="text/css" href="/../files/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/../files/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="/../files/app.min.css">
    <link rel="stylesheet" type="text/css" href="/../files/colors.min.css">

    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/../files/style.css">
		<link rel="icon" href="/../files/<?php echo $favicon?>" type="image/x-icon">
		<link rel="shortcut icon" href="/../files/<?php echo $favicon?>" type="image/x-icon">
    <!-- END Custom CSS-->
  </head>
  <body style="background-image: url(./../img/<?php echo $bgc_site ?>);" class="horizontal-layout horizontal-menu 2-columns menu-expanded ">
        <div id="before-load">
  <!-- Иконка Font Awesome -->

    <div class="app-content container center-layout">
      <div class="content-wrapper">

        <div class="content-body"><!--native-font-stack -->





<section id="description-list-alignment">

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="row">
    <!-- Description lists horizontal -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><b>ИГРА</b><small class="text-muted " style='font-size:90%'> #<?php echo $ida; ?></small></h4>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                    <div class="card-text">

                        <dl class="row">
						<div class="table-responsive" >
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Цель</th>
                                <th>Выпало</th>
                                <th>Сумма</th>
                                <th>Выигрыш</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-weight:600"><?php echo $cel; ?></td>
                                <td style="font-weight:600"><?php echo $chislo; ?></td>
                                <td style="font-weight:600"><?php echo $suma; ?> <?php echo $walletsite; ?></td>
                                <td style="font-weight:600"><?php echo $win_summa; ?> <?php echo $walletsite; ?></td>
                            </tr>
						<center><div><p style="color:#4BB543;font-size:22px;font-weight:700"><i class="fa fa-check"></i> ВСЕ ДАННЫЕ СОВПАДАЮТ! ИГРА СЫГРАНА ЧЕСТНО!</p></div><center><i></i>
                        </tbody>
                    </table>
                </div>
						 <a href="/" style="margin-top:10px;color:#fff;background: red!important; border: 0px solid;" class="btn btn-block">Вернуться</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Description lists horizontal-->
</div>
</section>
        </div>
      </div>
    </div>

<script src="/../files/jquery-latest.min.js"></script>
<script src="/../files/redactor.min.js"></script>
<script src="/../files/clipboard.min.js" type="text/javascript"></script>
<script src="/../files/script.min.js" type="text/javascript"></script>

<span id="sbmarwusasv5"></span></body></html>
