<?php
use \MaxieSystems\HTTP;
require_once(MSSE_INC_DIR.'/sys_config.php');
function replaceSpecialChars($string)
{
	static $chars = array('~' => '_a_',
							'#' => '_b_',
							'%' => '_c_',
							'&' => '_d_',
							'*' => '_e_',
							'{' => '_f_',
							'}' => '_g_',
							//'\\' => '_h_',
							':' => '_j_',
							'[' => '_k_',
							']' => '_l_',
							'?' => '_m_',
							'+' => '_o_',
							'|' => '_p_',
							'"' => '_q_',
							'amp;' => '');
	return urldecode(str_replace(array_keys($chars), array_values($chars), $string));
}
if(empty($_GET['__dolly_action']))
 {
	if('POST' === $_SERVER['REQUEST_METHOD'])
	 {
		@session_start();
		require_once(DOCUMENT_ROOT.'/lib/handle_form.php');
		exit();
	 }
	elseif(false !== ($path = realpath(".$_SERVER[REQUEST_URI]")))
	 {
		if(is_dir($path))
		 {
			$path .= '/index.html';
			if(!file_exists($path)) HTTP::Status(403);
		 }
		if(is_file($path))
		 {
			HTTP::Status(200, false);
			readfile($path);
			exit();
		 }
	 }
	elseif('php' === pathinfo($_SERVER['REQUEST_URI'], PATHINFO_EXTENSION) && false !== ($path = realpath(".$_SERVER[REQUEST_URI].html")))
	 {
		HTTP::Status(200, false);
		readfile($path);
		exit();
	 }
	elseif(false !== ($path = realpath('.'.replaceSpecialChars($_SERVER['REQUEST_URI']))))
	 {
		if(is_dir($path))
		 {
			$path .= '/index.html';
			if(!file_exists($path)) HTTP::Status(403);
		 }
		if(is_file($path))
		 {
			$mime_types = array('txt' => 'text/plain',
				'htm' => 'text/html',
				'html' => 'text/html',
				'xhtml' => 'text/html',
				'php' => 'text/html',
				'css' => 'text/css',
				'less' => 'text/css',
				'js' => 'application/javascript',
				'json' => 'application/json',
				'xml' => 'application/xml',
				'xsl' => 'application/xslt+xml',
				'swf' => 'application/x-shockwave-flash',
				'flv' => 'video/x-flv',
				'png' => 'image/png',
				'jpe' => 'image/jpeg',
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpeg',
				'gif' => 'image/gif',
				'bmp' => 'image/bmp',
				'ico' => 'image/vnd.microsoft.icon',
				'tiff' => 'image/tiff',
				'tif' => 'image/tiff',
				'svg' => 'image/svg+xml',
				'svgz' => 'image/svg+xml',
				'zip' => 'application/zip',
				'tar' => 'application/x-tar',
				'rar' => 'application/x-rar-compressed',
				'exe' => 'application/x-msdownload',
				'msi' => 'application/x-msdownload',
				'cab' => 'application/vnd.ms-cab-compressed',
				'mp3' => 'audio/mpeg',
				'qt' => 'video/quicktime',
				'mov' => 'video/quicktime',
				'pdf' => 'application/pdf',
				'psd' => 'image/vnd.adobe.photoshop',
				'ai' => 'application/postscript',
				'eps' => 'application/postscript',
				'ps' => 'application/postscript',
				'doc' => 'application/msword',
				'rtf' => 'application/rtf',
				'xls' => 'application/vnd.ms-excel',
				'ppt' => 'application/vnd.ms-powerpoint',
				'odt' => 'application/vnd.oasis.opendocument.text',
				'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
				'cur' => 'text/html',
				'woff' => 'application/font-woff',
				'ttf' => 'application/font-ttf',
				'eot' => 'application/vnd.ms-fontobject',
				'otf' => 'application/font-otf',
				'torrent' => 'application/x-bittorrent',
			);
			HTTP::Status(200, false);
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			if(isset($mime_types[$ext])) header('Content-Type: '.$mime_types[$ext]);
			readfile($path);
			exit();
		 }
	 }
	HTTP::Status(404);
 }
else
 {
	@session_start();
	MSConfig::RequireFile('filesystemstorage');
	require_once(MSSE_INC_DIR.'/actions.php');
 }
?>