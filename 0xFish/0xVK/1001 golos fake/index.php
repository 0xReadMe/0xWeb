<?php
error_reporting(0);
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
define('DOCUMENT_ROOT', substr(__FILE__, 0, -10));
define('MSSE_INC_DIR', DOCUMENT_ROOT.'/system/include');
define('MSSE_LIB_DIR', MSSE_INC_DIR.'/lib');
require_once(DOCUMENT_ROOT.'/lib/fix.php');
$obj = new PreInstallCheckManager();
$obj->SetData('php:version', '5.6.0', '50.0.0');
try
 {
	$obj->Run();
 }
catch(EPreInstallCheckFailed $e)
 {
	die($e->GetMessage());
 }
require_once(DOCUMENT_ROOT.'/lib/archive.php');
?>