<!doctype html>
<html lang="ru">
<head>
  <title>Генератор</title>
</head>
<body>
  <?php
    $host = 'localhost';  // Хост, у нас все локально
    $user = 'proj1';    // Имя созданного вами пользователя
    $pass = '098098098ererer!'; // Установленный вами пароль пользователю
    $db_name = 'user1207376_kuf';   // Имя базы данных
    $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

    // Ругаемся, если соединение установить не удалось
    if (!$link) {
      echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
      exit;
    }

    //Если переменная Name передана
    if (isset($_POST["Name"])) {
      //Если это запрос на обновление, то обновляем
      if (isset($_GET['red'])) {
        $sql = mysqli_query($link, "UPDATE `products` SET `Name` = '{$_POST['Name']}',`Price` = '{$_POST['Price']}' WHERE `ID`={$_GET['red']}");
      } else {
        //Иначе вставляем данные, подставляя их в запрос
        $sql = mysqli_query($link, "INSERT INTO `products` (`Name`, `Price`, `Desc`, `Image`, `Nickname`) VALUES ('{$_POST['Name']}', '{$_POST['Price']}', '{$_POST['Desc']}', '{$_POST['Image']}', '{$_POST['Nickname']}')");
      }

      //Если вставка прошла успешно
      if ($sql) {
        echo '<p>Успешно! </p>';
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }

    //Удаляем, если что
    if (isset($_GET['del'])) {
      $sql = mysqli_query($link, "DELETE FROM `products` WHERE `ID` = {$_GET['del']}");
      if ($sql) {
        echo "<p>Товар удален.</p>";
      } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
      }
    }

    //Если передана переменная red, то надо обновлять данные. Для начала достанем их из БД
    if (isset($_GET['red'])) {
      $sql = mysqli_query($link, "SELECT `ID`, `Name`, `Price`, `Desc`, `Image`, `Nickname` FROM `products` WHERE `ID`={$_GET['red']}");
      $product = mysqli_fetch_array($sql);
    }
  ?>
  <form action="" method="post">
    <table>
      <tr>
        <td>Имя:</td>
        <td><input type="text" name="Name" value="<?= isset($_GET['red']) ? $product['Name'] : ''; ?>" required></td>
      </tr>
      <tr>
        <td>Цена:</td>
        <td><input type="number" name="Price" size="3" value="<?= isset($_GET['red']) ? $product['Price'] : ''; ?>" required></td>
      </tr>
	  <tr>
        <td>Описание:</td>
        <td><textarea type="text" name="Desc" value="<?= isset($_GET['red']) ? $product['Desc'] : ''; ?>"></textarea></td>
      </tr>
	  <tr>
        <td>URL картинки:</td>
        <td><input type="text" name="Image" value="<?= isset($_GET['red']) ? $product['Image'] : ''; ?>" required></td>
      </tr>
	  <tr>
        <td>Воркер (Telegram):</td>
        <td><input type="text" name="Nickname" value="<?= isset($_GET['red']) ? $product['Nickname'] : ''; ?>" required></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="Создать"></td>
      </tr>
    </table>
  </form>
  <p>Последний товар:</p>
  <?php
  //Получаем данные
  $sql = mysqli_query($link, 'SELECT `ID`, `Name`, `Price`, `Desc`, `Image`, `Nickname` FROM `products` ORDER BY `id` DESC');
  while ($result = mysqli_fetch_array($sql)) {
    echo "[ <a href='#{$result['ID']}'> domain.com/order?id={$result['ID']}</a> ] {$result['Name']} | {$result['Price']} ₽ | {$result['Desc']} | {$result['Image']} | {$result['Nickname']} | <a href='?del={$result['ID']}'>Удалить</a> | <a href='?red={$result['ID']}'>Редактировать</a></p>";
  }
  ?>
  <p><a href="?add=new">Добавить товар</a></p>
</body>
</html>