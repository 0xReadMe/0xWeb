<?php

/**
 * UserBox - ������ ������ ���������� � ������������ ��� DLE 9.8-10.2
 * =======================================================
 * �����: 	��������
 * URL:   	http://pafnuty.name/
 * ICQ:   	817233
 * email: 	pafnuty10@gmail.com
 * =======================================================
 * ����:  	userbox.php
 * -------------------------------------------------------
 * ������:	1.4 (11.04.2014)
 * =======================================================
 */

// ��� ������ ������� ������)))

if (!defined('DATALIFEENGINE')) {
	die("Go fuck yourself!");
}

// userName ������ ���� �������, ���� ��� � �� �����������, �� ��������.
$userName = !empty($userName) ? $db->safesql(strip_tags(stripcslashes($userName))) : false;

// ���� userName=this, �� ���� �������� ������������.
$userName = ($userName == 'this' && $member_id['user_group'] != 5) ? $member_id['name'] : $userName;

// ���� userName=thisNewsId, �� ���� ������������ �� ������ �������.
$userName = ($userName == 'thisNewsId' && $_REQUEST['newsid'] > 0) ? 'thisNewsId' : $userName;

$cfg = array(
	// ���������� ���������� userName
	'userName'    => $userName,

	// ���������� ��������� ������, �� ������ ���� ���� �� �������� ���.
	'defAvatar'   => !empty($defaultAvatar) ? $defaultAvatar : 'dleimages/noavatar.png',

	// ���������� ������ ������.
	'template'    => !empty($template) ? $template : 'default',

	// ID �������, �� ������� ����� ���� ����� �����.
	'newsId'      => ($userName == 'thisNewsId' && $_REQUEST['newsid'] > 0) ? (int)$_REQUEST['newsid'] : false,

	// ������� ���� (������ �� ����� ������).
	'cachePrefix' => !empty($cachePrefix) ? $cachePrefix : 'userbox_',

	// ������� ���� ����� �� ����� ������ ������, ���� �� ��������� ������ ����� ��� ������ ����� �������������. 
	'cacheSuffix' => !empty($cacheSuffix) ? true : false
);
$cacheName = md5(implode('_', $cfg));

$showUserInfo = false;

// ���� � ������ ������� ������������ �������� &userName - ��������.

if ($cfg['userName']) {

	// ���������� ��������� ������ �� ����.
	$showUserInfo = dle_cache($cfg['cachePrefix'], $cacheName . $config['skin'], $cfg['cacheSuffix']);

	// �c�� � ���� ������ ��� - ��������.
	if (!$showUserInfo) {
		if (file_exists(TEMPLATE_DIR . '/userbox/' . $cfg['template'] . '.tpl')) {

			// ������ � ������ ��� ������� �� �� � ������ � ������
			$arrUF = array(
				'email',
				'name',
				'news_num',
				'user_id',
				'comm_num',
				'user_group',
				'lastdate',
				'reg_date',
				'info',
				'foto',
				'fullname',
				'land',
			);
			// ���������� ��� ��� ������� � ������.
			$selectFields = implode(', ', $arrUF);

			// ��������� ��� ������, ���� �� ����
			if (!isset($tpl)) {
				$tpl = new dle_template();
				$tpl->dir = TEMPLATE_DIR;
			}
			else {
				$tpl->result['showUserInfo'] = '';
			}

			$tpl->load_template('userbox/' . $cfg['template'] . '.tpl');

			// ���� ����� &userName=thisNewsId - ��������� ������ �� ��������� ������������ �� ������� �������.
			if ($cfg['userName'] == 'thisNewsId' && $cfg['newsId']) {
				$_username = $db->super_query("SELECT autor FROM " . PREFIX . "_post WHERE id='" . $cfg['newsId'] . "'");
			}

			$_uname = ($_username['autor']) ? $_username['autor'] : $cfg['userName'];

			// super_query ���������, ��� ������� ������ (��������).
			$userField = $db->super_query("SELECT " . $selectFields . ", xfields FROM " . USERPREFIX . "_users WHERE name='" . $_uname . "'");

			if ($userField['name'] === $_uname) {
				// ���� ��� ������������ ��������� � ���, ��� ������ � ������ ����������� - ��������.

				if (count(explode("@", $userField['foto'])) == 2) {
					// ���� ��������
					$userField['foto'] = 'http://www.gravatar.com/avatar/' . md5(trim($userField['foto'])) . '?s=' . intval($user_group[$userField['user_group']]['max_foto']);

				}
				else {
					// ���� � ���
					if ($userField['foto'] and (file_exists(ROOT_DIR . "/uploads/fotos/" . $userField['foto'])))
						$userField['foto'] = $config['http_home_url'] . 'uploads/fotos/' . $userField['foto'];
					else
						$userField['foto'] = $config['http_home_url'] . 'templates/' . $config['skin'] . '/' . $cfg['defAvatar'];

				}

				// �������� ������ �����
				$userField['user_group'] = $user_group[$userField['user_group']]['group_prefix'] . $user_group[$userField['user_group']]['group_name'] . $user_group[$userField['user_group']]['group_suffix'];

				// �������� ���� ���������� ������ � �����������
				$userField['lastdate'] = langdate("j F Y H:i", $userField['lastdate']);
				$userField['reg_date'] = langdate("j F Y H:i", $userField['reg_date']);

				// ������� �������
				$tpl->set('{user_rating}', userrating($userField['user_id']));

				// ���������� ��� ����� ��������� ������ �� ������� �����
				if ($config['allow_alt_url'] && $config['allow_alt_url'] != "no") {
					$user_page = $config['http_home_url'] . "user/" . urlencode($userField['name']) . "/";
				}
				else {
					$user_page = "$PHP_SELF?subaction=userinfo&amp;user=" . urlencode($userField['name']);
				}
				// ������� ��� �����
				$tpl->set('{user_url}', $user_page);

				// ������������ ���� ������� (��� ��������� � ������ �����).
				foreach ($arrUF as $field) {
					if ($userField[$field]) {
						$tpl->set('{user_' . $field . '}', $userField[$field]);
						$tpl->copy_template = preg_replace("'\\[not_user_" . $field . "\\](.*?)\\[/not_user_" . $field . "\\]'is", "", $tpl->copy_template);
						$tpl->copy_template = str_replace("[user_" . $field . "]", "", $tpl->copy_template);
						$tpl->copy_template = str_replace("[/user_" . $field . "]", "", $tpl->copy_template);

					}
					else {
						$tpl->set('{user_' . $field . '}', "");
						$tpl->copy_template = preg_replace("'\\[user_" . $field . "\\](.*?)\\[/user_" . $field . "\\]'is", "", $tpl->copy_template);
						$tpl->copy_template = str_replace("[not_user_" . $field . "]", "", $tpl->copy_template);
						$tpl->copy_template = str_replace("[/not_user_" . $field . "]", "", $tpl->copy_template);
					}
				}

				// �������� � ���������
				if (strpos($tpl->copy_template, "[ufvalue_") !== false) {

					$xfields = xfieldsload(true);
					$xfieldsdata = xfieldsdataload($userField['xfields']);

					foreach ($xfields as $value) {
						$preg_safe_name = preg_quote($value[0], "'");

						if ($value[5] != 1) {

							if (empty($xfieldsdata[$value[0]])) {

								$tpl->copy_template = preg_replace("'\\[ufgiven_{$preg_safe_name}\\](.*?)\\[/ufgiven_{$preg_safe_name}\\]'is", "", $tpl->copy_template);
								$tpl->copy_template = str_replace("[ufnotgiven_{$preg_safe_name}]", "", $tpl->copy_template);
								$tpl->copy_template = str_replace("[/ufnotgiven_{$preg_safe_name}]", "", $tpl->copy_template);

							}
							else {
								$tpl->copy_template = preg_replace("'\\[ufnotgiven_{$preg_safe_name}\\](.*?)\\[/ufnotgiven_{$preg_safe_name}\\]'is", "", $tpl->copy_template);
								$tpl->copy_template = str_replace("[ufgiven_{$preg_safe_name}]", "", $tpl->copy_template);
								$tpl->copy_template = str_replace("[/ufgiven_{$preg_safe_name}]", "", $tpl->copy_template);
							}

							$tpl->copy_template = preg_replace("'\\[ufvalue_{$preg_safe_name}\\]'i", stripslashes($xfieldsdata[$value[0]]), $tpl->copy_template);

						}
						else {

							$tpl->copy_template = preg_replace("'\\[ufgiven_{$preg_safe_name}\\](.*?)\\[/ufgiven_{$preg_safe_name}\\]'is", "", $tpl->copy_template);
							$tpl->copy_template = preg_replace("'\\[ufvalue_{$preg_safe_name}\\]'i", "", $tpl->copy_template);
							$tpl->copy_template = preg_replace("'\\[ufnotgiven_{$preg_safe_name}\\](.*?)\\[/ufnotgiven_{$preg_safe_name}\\]'is", "", $tpl->copy_template);

						}
					}
				}

				// �������� ������
				$tpl->compile('showUserInfo');

				$showUserInfo = $tpl->result['showUserInfo'];
				// ���������� ��������� ������ � ���.
				create_cache($cfg['cachePrefix'], $showUserInfo, $cacheName . $config['skin'], $cfg['cacheSuffix']);

				$tpl->clear();
			}
			else {
				$showUserInfo = '<b style="color:red">������������ � ������� ' . $_uname . ' �� ������.</b>';
			}


		}
		else {
			// ���� ������� ��� - ������ �� ����.
			$showUserInfo = '<b style="color:red">����������� ���� �������: ' . $config['skin'] . '/userbox/' . $cfg['template'] . '.tpl</b>';
		}

	}

}
else {

	// ������� ��������� �� ������, ���� ������ ����������� �� ����������.
	$showUserInfo = '<b style="color:red">������ ����������� �� �������� ������������� ��������� &userName</b>';

}

// ������� ��������� ������ ������.
echo $showUserInfo;
