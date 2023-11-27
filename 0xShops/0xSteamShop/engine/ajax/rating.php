<?php
/*
=====================================================
 Олег Александрович a.k.a. Sander
-----------------------------------------------------
 http://nfhelp.ru/
-----------------------------------------------------
 Copyright (c) 2008-2012
=====================================================
*/
@session_start();
@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );
define( 'DATALIFEENGINE', true );
define( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -12 ) );
define( 'ENGINE_DIR', ROOT_DIR . '/engine' );
$news_id = intval( $_REQUEST['news_id'] );
if( $news_id < 1 ) die( "Hacking attempt!" );
include ENGINE_DIR . '/data/config.php';
if( $config['http_home_url'] == "" ) {
	$config['http_home_url'] = explode( "engine/ajax/rating.php", $_SERVER['PHP_SELF'] );
	$config['http_home_url'] = reset( $config['http_home_url'] );
	$config['http_home_url'] = "http://" . $_SERVER['HTTP_HOST'] . $config['http_home_url'];
}
require_once ENGINE_DIR . '/classes/mysql.php';
require_once ENGINE_DIR . '/data/dbconfig.php';
require_once ENGINE_DIR . '/modules/functions.php';
$_REQUEST['skin'] = totranslit($_REQUEST['skin'], false, false);
if( $_REQUEST['skin'] ) {
	if( @is_dir( ROOT_DIR . '/templates/' . $_REQUEST['skin'] ) ) $config['skin'] = $_REQUEST['skin'];
	else die( "Hacking attempt!" );
}
if( $config["lang_" . $config['skin']] ) {
	if ( file_exists( ROOT_DIR . '/language/' . $config["lang_" . $config['skin']] . '/website.lng' ) ) {	
		include_once ROOT_DIR . '/language/' . $config["lang_" . $config['skin']] . '/website.lng';
	} else die("Language file not found");
} else include_once ROOT_DIR . '/language/' . $config['langs'] . '/website.lng';
$config['charset'] = ($lang['charset'] != '') ? $lang['charset'] : $config['charset'];
$user_group = get_vars( "usergroup" );
if( ! $user_group ) {
	$user_group = array ();
	$db->query( "SELECT * FROM " . USERPREFIX . "_usergroups ORDER BY id ASC" );
	while ( $row = $db->get_row() ) {
		$user_group[$row['id']] = array ();
		foreach ( $row as $key => $value ) $user_group[$row['id']][$key] = stripslashes($value);
	}
	set_vars( "usergroup", $user_group );
	$db->free();
}
require_once ENGINE_DIR . '/modules/sitelogin.php';
if( ! $is_logged ) $member_id['user_group'] = 5;
if( ! $user_group[$member_id['user_group']]['allow_rating'] ) die( "Hacking attempt!" );
$_IP = $db->safesql( $_SERVER['REMOTE_ADDR'] );
if( $is_logged ){
	$member_id['name'] = $db->safesql($member_id['name']);
	$where = "member = '{$member_id['name']}'";
}else{
	$member_id['name'] = "noname";
	$where = "ip ='{$_IP}'";
}
$row = $db->super_query( "SELECT news_id FROM " . PREFIX . "_logs where news_id ='$news_id' AND {$where}" );
if( !$row['news_id'] AND count( explode( ".", $_IP ) ) == 4 ) {
	$db->query( "UPDATE " . PREFIX . "_post_extras SET rating=rating+1 WHERE news_id ='$news_id'" );
	$db->query( "INSERT INTO " . PREFIX . "_logs (news_id, ip, member) values ('$news_id', '$_IP', '{$member_id['name']}')" );
	if ( $config['allow_alt_url'] == "yes" AND !$config['seo_type'] ) $cprefix = "full_"; else $cprefix = "full_".$news_id;
	clear_cache( array( 'news_', 'rss', $cprefix ) );
}
$row = $db->super_query( "SELECT rating FROM " . PREFIX . "_post_extras WHERE news_id ='$news_id'" );
$db->close();
echo ShowRating($news_id,$row['rating'],0,false);
?>