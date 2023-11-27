<?php
include('settings.php');
$url = 'https://olx.ua/'.$_SERVER['REQUEST_URI'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36"
            ]);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$curl_scraped_page = curl_exec($ch);
curl_close($ch);
$curl_scraped_page = str_replace('olx.ua', 'olxbox.info', $curl_scraped_page);
echo $curl_scraped_page;
?>