<?php
session_start();

if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

$config = [
    'dbhost' => 'localhost',
    'dbname' => 'user1207376_proj1',
    'dbuser' => 'proj1',
    'dbpass' => '098098098ererer!',
    'admins' => '-808326111'
];

$connection = mysqli_connect($config['dbhost'], $config['dbuser'], $config['dbpass'], $config['dbname']) or die ('Не удалось подключиться к серверу MySQL: '.mysqli_error($connection));
mysqli_query($connection, "SET NAMES utf8");

$isbanned = $connection->query("SELECT * FROM bannedips WHERE ip = '". $_SERVER["HTTP_CF_CONNECTION_IP"] ."'");
if(mysqli_num_rows($isbanned) > 0) {
    header('Location: https://google.com');
}

if(!function_exists('curl_get_contents')) {
    function curl_get_contents($url) {
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
if(!function_exists('send')) {
    function send($method, $params = Array()) {
        return json_decode(curl_get_contents("https://api.telegram.org/bot1165440678:AAHz_lcIEN78o4mfmtb5W-MdXBiuf2PSn_w/$method?".http_build_query($params)));
    }
}