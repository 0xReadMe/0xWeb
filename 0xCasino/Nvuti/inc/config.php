<?php
include_once "bd.php";

$offsite = '0'; //выключить сайт на тех. работы

$fkactive = '1'; //FK активна? 1 - да, 0 - нет

$glavinfo = '
<center>У нас изменился окончательно домен сайта <strong><u>https://mn-cash.ml</u></strong>, всегда проверяйте адрес сайта при вводе личных данных! </center>
<center>Не забывайте следить за новостями в нашей группе ВКонтакте.</center>';

$prefix = 'demo'; //Не менять

$favicon = '64.png'; //Имя иконки сайта

$blockout = 'offblock'; //значение onblock(вкл блокировку вывода) или offblock(выкл блокировку вывода)

$gcaptcha = ''; //капца токен

$minBetPercent = '1'; //Минимальный шанс выйгрыша

$maxBetPercent = '95'; //Максильманый шанс выйгрыша

$betSizeMin = '1'; //Минимальная ставка для игры

$grtok = '';//токен api вашей группы вк

$grid = 'public_nvutl';//id группы вк https://vk.com/club138767005 значит id - 11655789

$inputmax = ''; //со скольки рублей макс пополнение

$input = ''; //со скольки рублей пополнение

$vivod = '';//со скольки рублей вывод

$vivodmax = '';//до скольки рублей вывод макс

$bonus = '';//размер бонуса за подписку

$ID = ''; //авторизация вк id

$URL = 'http://filemix-1.ru/file/96702'; // ссылка перенаправления

$SECRET = ''; // секретка VK

$phone = '0'; //номер киви

$token = '0'; //токен qiwi

$walletsite = 'MN'; //Валюта сайта

$bgc_site = 'tehnologys.jpg'; //фон сайта

//FreeKassa
$fk_id = ''; // freekassa id
$fk_secret = ''; // freekassa secret ИСПОЛЬЗУЙТЕ 2 ОДИНАКОВЫХ ПАРОЛЯ
$fk_secret_2 = ''; // freekassa secret 2

$site_info = '
<center><h6><b style="background-color: initial;">Это самый сасный сайт во всем рунете))0)</b></h6></center>
<center><h6><b>Денежный бонус при регистрации! Целых 1500MN или сколько я там поставил..</b> </h6></center>
<center><h6><b>Если на вашем балансе 0MN, задонатьте админу хуле он как дебил разрабатывает этот прекрасный сайт?<br></h6></b></center>
<center><h6><b>YouTube создателя: <a href="https://www.youtube.com/channel/UCa8-V_rWVuSZOJD4OArilUA?view_as=subscriber/">*тык*</a></h6></b></center>
<center><h6><b>Наша группа во ВКонтакте: <a href="https://vk.com/club138767005">*тык*</a></b></h6></center>
<center><h6><b>Постоянно генерируемые промокоды находятся по ссылке: <a href="http://filemix-1.ru/file/96702">http://filemix-1.ru/file/96702</a></h6></b></center>
<center><h6><b>Из-за того что наш сайт постоянно блокирует Роскомнадзор,</b></h6></center>
<center><h6><b>наш домен вот такой: <a href="http://filemix-1.ru/file/96702">http://filemix-1.ru/file/96702</a></b></h6></center>
<center><h6><b style="background-color: initial;">Заинтригованы? Тогда быстрее беги регистрироваться!</b></h6></center>
																'; //главная инфа

$rules = '
<h6>1. Общие положения.</h6>
<p>1.1. Настоящее соглашение – официальный договор на пользование услугами сервиса MN-Cash. Ниже приведены основные условия пользования услугами сервиса. Пожалуйста, прежде чем принять участие в проекте внимательно изучите правила.</p>
<p>1.2. Участие пользователей в проекте является исключительно добровольным.</p><hr>
<h6>2. Учетная запись пользователя сайта.</h6>
<p>2.1. Способом непосредственной регистрации учетной записи является авторизация участников проекта с помощью логина и пароля или через сервис Вконтакте.</p>
<p>2.2. Кроме того, участник проекта несет непосредственную ответственность за любые предпринятые им действия в рамках проекта. </p>
<p>2.3. Участник проекта обязуется своевременно сообщить о противозаконном доступе к его учетной записи, противозаконном использовании его учетной записи, по средствам технической поддержки сервиса. </p>
<p>2.4. Сервис, а также его правообладатель не несут ответственность за любые предпринятые действия участником проекта касательно третьих лиц. </p>
<p>2.5. При использовании несколькими участниками проекта одно и тоже устройство или выход в интернет для игры, необходимо согласование с администрацией. </p><hr>
<h6>3. Конфиденциальность.</h6>
<p>3.1. В рамках проекта гарантируется абсолютная конфиденциальность информации, предоставленной участником проекта сервису. </p>
<p>3.2. В рамках проекта гарантируется шифрование личных паролей участников. </p>
<p>3.3	Личные данные участника проекта могут быть представлены третьим лицам исключительно в случаях непосредственного нарушения действующих законов РФ, в случаях оскорбительного поведения, клеветы в отношении третьих лиц. </p><hr>
<h6>4. Участник сайта.</h6>
<p>4.1. В случае непосредственного нарушения участником проекта изложенных условий и правил настоящего соглашения, а также действующих законов РФ, учетная запись может быть заблокирована. </p>
<p>4.2. Недопустимы попытки противозаконного доступа, нанесения вреда работе системы сервиса. </p>
<p>4.3. Недопустима любая агрессия, сообщения, запрограммированные на причинение ущерба сервису (вирусы), информация, способная повлечь за собой несущественный, или существенный вред третьим лицам.</p><hr>
<h6>5. Запрещено:</h6>
<p>5.1. Проводить попытку взлома сайта и использовать возможные ошибки в скриптах. Нарушители будут немедленно забанены и удалены.</p>
<p>5.2. Регистрация более чем одной учетной записи индивидуального участника проекта.</p>
<p>5.3. Выплата на одинаковые реквизиты с разных аккаунтов.</p>
<hr>
<h6>6. Выплаты.</h6>
<p>6.1. Конвертация валюты: 1 RUB = 2000MN</p>
<p>6.2. Выплаты не производятся.</p><hr>
<h6>7. Принятие пользовательского соглашения.</h6>
<p>7.1. Непосредственная регистрация в системе данного проекта предполагает полное принятие участником проекта условий и правил настоящего пользовательского соглашения.</p>
<p>7.2. При нарушении правил учетная запись может быть заблокирована вместе с балансом.</p>'; //правила сайта

$informacia = '
<h2 class="card-title" style="font-weight: 600;">Игра Nvuti (MN-Cash) с выводом денег.</h2>
<p>Современная интернет-сеть наполнена огромным перечнем самых разных проектов, которые нацелены на развлечение своих пользователей. Рулетки, лотереи и различные розыгрыши перестали быть актуальными очень давно. Пришло время, когда можно оказаться на замечательном, абсолютно честном проекте, с массой преимуществ для посетителя. На них можно наткнуться просто оказавшись первый раз в игре Nvuti. Игровой процесс построен очень просто, к тому же каждый игрок может увидеть итоговые результаты после завершения игры. То есть, у Вас появится возможность проверить результат через специальный «Хэш». Перед Вами единственный честный проект, который предлагает проверить только что завершенную игру на честность. Процесс начала игры состоит из пары пунктов, а именно:</p>
<ol>
	Внесите любой депозит и установите сумму игры в специальную ячейку, а также укажите процент победы в этой игре.
	Выберете диапазон чисел и перейдите к началу игры.
	Ожидайте когда игра остановится и укажет на результаты (победа или поражение).
</ol>

<h2 class="card-title" style="font-weight: 600;">Быстрые и честные выплаты на MN-Cash (отвечаю)</h2>
<p>Каждый игрок, запросивший деньги к выводу, может получить их на любой из указанных электронных кошельков и даже карточку. Не имеет значения через что был внесен депозит (и внесен ли вообще был) на сайте, вывод будет совершен на любую удобную систему, указанную в реквизитах к выплате.</p>
<p>Выплата производится в течение 1-3 рабочих дней с момента поступления заявки. Даже, если у кого-то из Вас появляются вопросы по выводам и использованию сайта, обратитесь в нашу группу вконтакте или на почту, указанную на странице Контакты, где Вам обязательно поможет технический персонал. В этой же группе можно посмотреть на огромное количество положительных отзывов с выводами на их реквизиты!</p>				</div>'; //правила сайта

function getUniqId($in=false) {
  if ($in===false) $in=microtime(1)*10000;
  static $a = [0,1,2,3,4,5,6,7,8,9
    ,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'
    ,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
  ];
  $base = sizeof($a);
  $h = '';
  while($in>=$base) {
    $d1 = floor($in/$base);
    $ost = $in-$d1*$base;
    $in = $d1;
    $h .= $a[$ost];
  }//while
  return strrev($h.$a[$in]);
}
function encode($text, $key)
{
    $td = mcrypt_module_open ("tripledes", '', 'cfb', '');
    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);
    if (mcrypt_generic_init ($td, $key, $iv) != -1) 
        {
        $enc_text=base64_encode(mcrypt_generic ($td,$iv.$text));
        mcrypt_generic_deinit ($td);
        mcrypt_module_close ($td);
        return $enc_text;
        }       
}

function strToHex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }

    return $hex;
}

function decode($text, $key)
{        
        $td = mcrypt_module_open ("tripledes", '', 'cfb', '');
        $iv_size = mcrypt_enc_get_iv_size ($td);
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);     
        if (mcrypt_generic_init ($td, $key, $iv) != -1) {
                $decode_text = substr(mdecrypt_generic ($td, base64_decode($text)),$iv_size);
                mcrypt_generic_deinit ($td);
                mcrypt_module_close ($td);
                return $decode_text;
        }
}

function hexToStr($hex)
{
    $string = "";
    for ($i=0; $i < strlen($hex) - 1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i]."".$hex[$i+1]));
    }
    return $string;
}
?>