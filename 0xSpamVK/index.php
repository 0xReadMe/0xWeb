<?php

	
const ACCESS_TOKEN = '!!'; // https://vk.cc/5Kl8L9 
const RUCAPTCHA_KEY = '!!'; //ключ рукапчи

$attachments = null;

$message = '> принимаю βςεχ β ∂ρყзья.❮ ☘ ❯' . PHP_EOL;
$message .= '> λαйκน взаимно.❮ 🍃 ❯' . PHP_EOL;
$message .= '> комменты взаимно :(❮ 🍒 ❯' . PHP_EOL;
$message .= '> χσчყ 1Θ.ΘΘΘ ∂ρყзεй.❮ 🍒 ❯';

$group_ids = [39130136, 10190856, 56558556];
foreach ($group_ids as $group_id) {
	$captcha_sid = null;
	$captcha_key = null;

	while (true) {
		$response = callApi('wall.post', [
			'v' => 5.8,
			'message' => $message,
			'owner_id' => -$group_id,
			'attachments' => $attachments,
			'captcha_sid' => $captcha_sid,
			'captcha_key' => $captcha_key,
		]);

		if (!isset($response['error'])) {
			break;
		}

		if ($response['error']['error_code'] !== 14) {
			throw new LogicException($response['error']['error_msg']);
		}

		if (!copy($response['error']['captcha_img'], 'captcha.jpg')) {
			throw new LogicException('Cant copy captcha image');
		}

		$captcha_sid = $response['error']['captcha_sid'];
		$captcha_key = getCaptchaText('captcha.jpg');
	}
}

function getCaptchaText($filename) {
    if (!file_exists($filename)) {
        throw new LogicException('File does not exists');
    }

    $source = file_get_contents($filename);
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query([
                'key' => RUCAPTCHA_KEY,
                'body' => 'data:image/' . $extension . ';base64,' . base64_encode($source),
                'method' => 'base64',
            ]),
        ],
    ]);

    $response = file_get_contents('http://rucaptcha.com/in.php', false, $context);
    $arr = explode('|', $response);
    if ($arr[0] !== 'OK') {
        throw new LogicException($arr[0]);
    }

    $data = http_build_query([
        'id' => $arr[1],
        'key' => RUCAPTCHA_KEY,
        'action' => 'get',
    ]);

    while(true) {
        sleep(5);

        $response = file_get_contents('http://rucaptcha.com/res.php?' . $data);
        $arr = explode('|', $response);
        if ($arr[0] === 'OK') {
            return $arr[1];
        }

        if ($arr[0] === 'CAPCHA_NOT_READY') {
            continue;
        }

        throw new LogicException($arr[0]);
    }

    return null;
}

function callApi($method, array $params = []) {
    if (!isset($params['v'])) {
        $params['v'] = 5.0;
    }

    if (!isset($params['access_token'])) {
        $params['access_token'] = ACCESS_TOKEN;
    }

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'content' => http_build_query($params),
        ],
    ]);

    $json = @file_get_contents('https://api.vk.com/method/' . $method, false, $context);
    if (empty($json)) {
        throw new LogicException('Something went wrong');
    }

    return json_decode($json, true);
}
?>