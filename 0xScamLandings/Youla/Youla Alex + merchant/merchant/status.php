<?php
$set = array(
  'http' => array(
    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    'method'  => 'POST',
    'content' => http_build_query(array(
        'MD' => $_POST['MD'],
        'PaRes' => $_POST['PaRes']
        )),
  ),
);
$result = file_get_contents('https://securepay.tcsbank.ru/rest/Submit3DSAuthorization', false, stream_context_create($set));
preg_match('/\/tele2\/(.*)\?\w*.\w*.\w*.([0-9]*)/m', $result, $matches, PREG_OFFSET_CAPTURE, 0);
if($matches[1][0] == 'success'){
	header("Location: success.php");
}else{
	header("Location: error.php");
}
