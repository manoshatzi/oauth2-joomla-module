<?php
require_once (dirname(__FILE__).'/configure.php');

if (isset($_GET['code']))
{
	modCallback::test();
}

class modCallback
{
        
	function test()
	{

		$client_id = CLIENT_ID;
		$client_secret = CLIENT_SECRET;
		$redirect_uri = REDIRECT_URI;

		//set POST variables
		$url = 'https://www.skroutz.gr/oauth2/token';
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
		$url = 'https://www.skroutz.gr/oauth2/address';
		$qry_str = "?oauth_token=".urlencode($oauth_token);
		$ch = curl_init();

		// Set query data here with the URL
		curl_setopt($ch, CURLOPT_URL,$url . $qry_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, '3');
		$content = trim(curl_exec($ch));
		curl_close($ch);	

		$skroutz_user = json_decode($content);
		$name = $skroutz_user->name;
		$company = $skroutz_user->company;
		$city = $skroutz_user->city;
		$address = $skroutz_user->address;
		$region = $skroutz_user->region;
		$zip = $skroutz_user->zip;
		$invoice = $skroutz_user->invoice;
		$doy = $skroutz_user->doy;
		$company_phone = $skroutz_user->company_phone;
		$mobile = $skroutz_user->mobile;
		$phone = $skroutz_user->phone;
		$last_name = $skroutz_user->last_name;
		$afm = $skroutz_user->afm;
		$profession = $skroutz_user->profession;
		$first_name = $skroutz_user->first_name;
		$email = $skroutz_user->email;
		
		
		?>
		<form action="http://nohsys-projects.net/joomla_skroutz/index.php" method="post" id="form-login-skroutz">
			<input type="hidden" name="skroutz" value="skroutz" />
			<input type="hidden" name="name" value="<?=$name?>" />
			<input type="hidden" name="company" value="<?=$company?>" />
			<input type="hidden" name="city" value="<?=$city?>" />
			<input type="hidden" name="address" value="<?=$address?>" />
			<input type="hidden" name="region" value="<?=$region?>" />
			<input type="hidden" name="zip" value="<?=$zip?>" />
			<input type="hidden" name="invoice" value="<?=$invoice?>" />
			<input type="hidden" name="doy" value="<?=$doy?>" />
			<input type="hidden" name="company_phone" value="<?=$company_phone?>" />
			<input type="hidden" name="mobile" value="<?=$mobile?>" />
			<input type="hidden" name="phone" value="<?=$phone?>" />
			<input type="hidden" name="last_name" value="<?=$last_name?>" />
			<input type="hidden" name="afm" value="<?=$afm?>" />
			<input type="hidden" name="profession" value="<?=$profession?>" />
			<input type="hidden" name="first_name" value="<?=$first_name?>" />
			<input type="hidden" name="email" value="<?=$email?>" />
		</form>
		<script type="text/javascript">
        	document.forms["form-login-skroutz"].submit();
        </script>
	<?php }
	
	function login()
	{
		header("Location: https://www.skroutz.gr/oauth2/authorizations/new?client_id=".urlencode(CLIENT_ID)."&redirect_uri=".urlencode(REDIRECT_URI)."&response_type=code");
	}
}

