<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class modSkroutzHelper
{
	function getReturnURL($params, $type)
	{
		if($itemid =  $params->get($type))
		{
			$menu =& JSite::getMenu();
			$item = $menu->getItem($itemid); //var_dump($menu);die;
			if ($item)
			{
				$url = JRoute::_($item->link.'&Itemid='.$itemid, false);
			}
			else
			{
				// stay on the same page
				$uri = JFactory::getURI();
				$url = $uri->toString(array('path', 'query', 'fragment'));
			}

		}
		else
		{
			// stay on the same page
			$uri = JFactory::getURI();
			$url = $uri->toString(array('path', 'query', 'fragment'));
		}

		return base64_encode($url);
	}

	function getType()
	{
		$user = & JFactory::getUser();
		return (!$user->get('guest')) ? 'logout' : 'login';
	}

	function getAuthorizationURL($params) {
		$site = $params->get('site');
		$authorization_url = $params->get('authorization_url');

		$url = $site . $authorization_url;

		$client_id = urlencode($params->get('client_id'));
		$redirect_uri = urlencode($params->get('redirect_uri') . modSkroutzHelper::getCallbackPath());

		return $site . $authorization_url . "?client_id=" . $client_id . "&redirect_uri=" . $redirect_uri . "&response_type=code";
	}

	function isLogin() {
		if (JRequest::getVar('login') == 'skroutz') {
			return true;
		} else {
			return false;
		}
	}

	function isCallback() {
		if (JRequest::getVar('code')) {
			return true;
		} else {
			return false;
		}
	}

	function getAddress($params) {
		$client_id = $params->get('client_id');
		$client_secret = $params->get('client_secret');
		$redirect_uri = $params->get('redirect_uri');

		//set POST variables
		$url = SITE . TOKEN_URL;
		$fields = array(
			'code'=>urlencode($_GET['code']),
			'client_id'=>urlencode($client_id),
			'client_secret'=>urlencode($client_secret),
			'redirect_uri'=>urlencode($redirect_uri),
			'grant_type'=>urlencode('authorization_code')
		);

		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
		$theResult=json_decode($result);
		$oauth_token=$theResult->access_token;
		$url = SITE . ADDRESS_URL;
		$qry_str = "?oauth_token=".urlencode($oauth_token);
		$ch = curl_init();

		// Set query data here with the URL
		curl_setopt($ch, CURLOPT_URL,$url . $qry_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, '3');
		$content = trim(curl_exec($ch));
		curl_close($ch);


	}

	private function getCallbackPath() {
		return "/modules/mod_skroutz/callback.php";
	}
}
