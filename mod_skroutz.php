<?php
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$type 	= modSkroutzHelper::getType();
$return	= modSkroutzHelper::getReturnURL($params, $type);

$user =& JFactory::getUser();

if($_POST['login']=='skroutz')
{
	require_once (dirname(__FILE__).DS.'callback.php');
	modCallback::login();
}

require(JModuleHelper::getLayoutPath('mod_skroutz'));
