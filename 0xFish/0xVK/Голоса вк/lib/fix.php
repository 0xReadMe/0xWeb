<?php
abstract class DollyConfig
{
	final public static function Get($name)
	 {
		if(null === self::$data) self::Init();
		if(isset(self::$data[$name])) return self::$data[$name];
	 }

	final public static function Set(array $values)
	 {
		if(null === self::$data) self::Init();
		foreach($values as $name => $value)
		 {
			if(null === $value) unset(self::$data[$name]);
			else self::$data[$name] = $value;
		 }
		file_put_contents(DOCUMENT_ROOT.self::NAME, '<?php'.PHP_EOL.'return '.var_export(self::$data, true).';'.PHP_EOL.'?>', LOCK_EX);
	 }

	final private static function Init()
	 {
		$name = DOCUMENT_ROOT.self::NAME;
		if(file_exists($name)) self::$data = (require $name);
		if(!is_array(self::$data)) self::$data = array();
	 }

	private static $data = null;

	const NAME = '/config.php';
}
if(!defined('CURLPROXY_SOCKS4A')) define('CURLPROXY_SOCKS4A', 6);
if(!defined('CURLPROXY_SOCKS5_HOSTNAME')) define('CURLPROXY_SOCKS5_HOSTNAME', 7);
if(!interface_exists('JsonSerializable'))
 {
	interface JsonSerializable
	 {
		public function jsonSerialize();
	 }
 }
if(!function_exists('parse_ini_string'))
 {
	function parse_ini_string($string, $process_sections = false)
	 {
		if(!class_exists('parse_ini_filter'))
		 {
			class parse_ini_filter extends php_user_filter
			 {
				static $buf = '';
				function filter($in, $out, &$consumed, $closing)
				 {
					$bucket = stream_bucket_new(fopen('php://memory', 'wb'), self::$buf);
					stream_bucket_append($out, $bucket);
					return PSFS_PASS_ON;
				 }
			 }
			if(!stream_filter_register("parse_ini", "parse_ini_filter")) return false;
		 }
		parse_ini_filter::$buf = $string;
		return parse_ini_file("php://filter/read=parse_ini/resource=php://memory", $process_sections);
	 }
 }

require_once(MSSE_INC_DIR.'/lib/mspreinstallcheckmanager.php');

class PreInstallCheckManager extends MSPreInstallCheckManager
{
	final function __construct()
	 {
		$this->SetChecksMeta(array('php:version' => 'PHPVersionCheck', /* 'php:extensions' => 'PHPExtensionsCheck', 'apache:modules' => 'ApacheModulesCheck' */));
	 }

	protected function OnFail($id, stdClass $r)
	 {
		require_once(DOCUMENT_ROOT.'/lib/php52_l10n.php');
		switch($id)
		 {
			case 'php:version':
				if(-1 === $r->result) $r->message = php52_l10n()->php_ver_lower($r->val, $r->min);
				if(1 === $r->result) $r->message = php52_l10n()->php_ver_higher($r->val, $r->max);
				break;
			case 'php:extensions':
				$r->message = php52_l10n()->php_extensions_missing(implode(', ', $r->items));
				break;
			case 'apache:modules':
				$r->message = php52_l10n()->apache_modules_missing(implode(', ', $r->items));
				break;
			default:
		 }
	 }
}
?>