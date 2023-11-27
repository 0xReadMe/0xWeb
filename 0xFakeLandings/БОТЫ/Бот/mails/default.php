<?
// Настройка подключения бд
$db = mysqli_connect('localhost','USERNAME','PASSWORD','DATABASE');
$bot_api_key  = ''; // токен бота который отправляет письма

// Настройки писем gmail

$bb_gmail_login = 'example@gmail.com'; // логин от аккаунта gmail BOXBERRY
$bb_gmail_password = 'example'; // пароль от аккаунта gmail BOXBERRY
$cdek_gmail_login = 'example@gmail.com'; // логин от аккаунта gmail CDEK
$cdek_gmail_password = 'example'; // логин от аккаунта gmail CDEK
$avito_gmail_login = 'example@gmail.com'; // логин от аккаунта gmail AVITO
$avito_gmail_password = 'example'; // логин от аккаунта gmail AVITO
$youla_gmail_login = 'example@gmail.com'; // логин от аккаунта gmail YOULA
$youla_gmail_password = 'example'; // логин от аккаунта gmail YOULA
//
$accept_pay_link = 'paylink.ru'; // допустимый домен оплаты в указанном формате
// bots replies
$r_start = '`Добро пожаловать`';
$r_start2 = '`Пришли мне адрес, куда будем отправлять письмо, например:
vanya.ivanov@mail.ru`';
$r_t_name = '`Пришли мне название товара, например:
Смартфон IPhone 6S Space Grey`';
$r_t_punkt = '`Пришли мне адрес отделения, например:
ул. Микояна, 3`';
$r_t_address = '`Пришли мне адрес получателя, например:
ул. Пушкина, д. 51/2`';
$r_t_fio = '`Пришли мне имя получателя, например:
Виктория`';
$r_t_paylink = '`Пришли мне ссылку на оплату заказа, например:
https://'.$accept_pay_link.'/?order=102838190&amount=1500`';
$stop_time = 0;

include('vendor/autoload.php');
$telegram = new Telegram($bot_api_key);


require_once "gmclass.php";
 $stop_time = time() + $stop_time * 60;

 function sendGmail($html,$address) {
	 global $mailSMTP, $gmail_name, $gmail_login;


if($result === true)
{
    return 1;
}
else
{
    echo "Ошибка отправки: " . $result;
}
 }
