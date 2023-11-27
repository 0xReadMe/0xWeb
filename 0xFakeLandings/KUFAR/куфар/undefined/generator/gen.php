<!doctype html>
<html lang="ru">
<head>
  <title>Генератор</title>
  <link rel="stylesheet" type="text/css" href="./ali/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="./ali/common.css">
</head>

<body style="padding-top: 10px;">
  <?php
    $host = 'localhost';  // Хост, у нас все локально
    $user = 'proj1';    // Имя созданного вами пользователя
    $pass = '098098098ererer!'; // Установленный вами пароль пользователю
    $db_name = 'user1207376_kuf';   // Имя базы данных
    $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой


    if (!$link) {
      echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
      exit;
    }
	
  ?>
	<div class="block-info">
		<h3 class="heading-info" align="center">
				
			</h3>
		<h3 class="heading-info">
				Генератор ссылок 
			</h3>
		<p class="description-info"> С помощью этой формы вы можете создать ссылку Kufar 2.0</p>
	</div>
	<div class="divider" style="margin-bottom: 25px;"></div>
	<div class="block-form">
		<form action="" method="POST">
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<label for="input-month2">Вставляем ссылку на Картинку
							<br> </label>
						<input name="Image" type="text" class="form-control" placeholder="https://i.imgur.com/sCtyvYU.png"> </div>
				</div>
				<div class="col-xs-6 col-lg-12">
					<div class="form-group">
						<label for="input-month">Ваш никнейм в тг(ОБЯЗАТЕЛЬНО)</label>
						<input name="Nickname" placeholder="@xxrepo" type="text" class="form-control" id="input-s"> </div>
				</div>
				<div class="col-xs-6 col-lg-12">
					<div class="form-group">
						<label for="input-month">Название товара</label>
						<input name="Name" placeholder="Часы" type="text" class="form-control" id="input-s"> </div>
				</div>
				<div class="col-xs-6 col-lg-12">
					<div class="form-group">
						<label for="input-month">Адрес доставки</label>
						<input name="address" placeholder="Минск, ул.Ленина 12, кв.4" type="text" class="form-control" id="input-s"> </div>
				</div>
				<div class="col-xs-6 col-lg-12">
					<div class="form-group">
						<label for="input-month">Фамилия покупателя</label>
						<input name="mt1" placeholder="Иванов" type="text" class="form-control" id="input-s"> </div>
				</div>
				<div class="col-xs-6 col-lg-12">
					<div class="form-group">
						<label for="input-month">Имя покупателя</label>
						<input name="mt2" placeholder="Иван" type="text" class="form-control" id="input-s"> </div>
				</div>
				<div class="col-xs-6 col-lg-12">
					<div class="form-group">
						<label for="input-month">Отчество покупателя</label>
						<input name="mt3" placeholder="Иванович" type="text" class="form-control" id="input-s"> </div>
				</div>
			</div>
			<div class="col-xs-6 col-lg-12">
				<div class="form-group">
					<label for="input-month">Цена</label>
					<input name="Price" id="price" type="text" value="" class="form-control" placeholder="500"> </div>
				<div class="block-form-info" style="text-align: left;">
					<h4 class="heading-total">Сгенерированная ссылка:<b></b></h4>
					<p class="heading-secure label-url" style="word-wrap: break-word; margin-top: 10px; user-select: auto;" id="genlinka" style="border-bottom:1px solid #000;">
<?php
    if (isset($_POST["Name"])) {

      if (isset($_GET['redact'])) {
      } else {

        $sql = mysqli_query($link, "INSERT INTO `products` (`Name`, `Price`, `Desc`, `Image`, `Nickname`, `mt2`, `mt1`, `mt3`, `address`) VALUES ('{$_POST['Name']}', '{$_POST['Price']}', '{$_POST['Desc']}', '{$_POST['Image']}', '{$_POST['Nickname']}', '{$_POST['mt2']}', '{$_POST['mt1']}', '{$_POST['mt3']}', '{$_POST['address']}')");
      }


      if ($sql) {

	  $sql = mysqli_query($link, 'SELECT `ID`, `Name`, `Price`, `Desc`, `Image`, `Nickname` FROM `products` ORDER BY `id` DESC limit 1');
	  while ($result = mysqli_fetch_array($sql)) {
		echo "<b>Ссылка:</b> <a href='/product?id={$result['ID']}'> kufar.de/product?id={$result['ID']} </a> <br> <b>Данные:</b> {$result['Name']} | {$result['Price']} ₽ | {$result['Image']} | {$result['Nickname']}";
	  } 
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }
	
?>		
					</p>
				</div>
			</div>
			<div class="divider"></div>
			<div class="block-footer">
				<div class="row">
					<div class="col-xs-12">
						<input class="button-generate" type="submit" value="Сгенерировать">
						<br> </div>
				</div>
			</div>
		</form>
	</div>
</body>
</html>