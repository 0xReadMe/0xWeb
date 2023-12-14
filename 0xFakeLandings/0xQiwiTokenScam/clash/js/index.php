<?PHP

$number = "79780308768";

$url1 = "https://edge.qiwi.com/person-profile/v1/profile/current?authInfoEnabled=false";
$url = "https://edge.qiwi.com/funding-sources/v2/persons/".$number."/accounts";

$param = "?authInfoEnabled=false&contractInfoEnabled=false&userInfoEnabled=false";
var_dump(curl("https://edge.qiwi.com/person-profile/v1/profile/current".$param, $token));


function curl($url, $token){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
$header[] = "Accept: application/json";
$header[] = "Authorization: Bearer $token";
$header[] = "Content-Type: application/json";
curl_setopt($ch, CURLOPT_HEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$data = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
return $data;
}

?>