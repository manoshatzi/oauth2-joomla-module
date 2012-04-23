<?php
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$type 	= modSkroutzHelper::getType();
$return	= modSkroutzHelper::getReturnURL($params, $type);

$user =& JFactory::getUser();

if (modSkroutzHelper::isLogin()) {
	$layout = 'login';
} elseif (modSkroutzHelper::isCallback()) {
	//modSkroutzHelper::authenticate();
	// do something more

	$layout = 'callback';
} else {
	$layout = 'default';
}

$path = JModuleHelper::getLayoutPath('mod_skroutz', $layout);

if (file_exists($path)) {
	require($path);
}
