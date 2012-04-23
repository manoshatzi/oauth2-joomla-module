<?php

//εδώ μπαίνει το client id
$client_id = "";
//εδώ μπαίνει το client secret
$client_secret = "";
//εδώ μπαίνει το https url μόνο πχ https://www.skroutz.gr
$redirect_uri = "" . "/modules/mod_skroutz/callback.php";

define("CLIENT_ID", $client_id);
define("CLIENT_SECRET", $client_secret);
define("REDIRECT_URI", $redirect_uri);
define("SITE", "https://www.skroutz.gr");
define("AUTHORIZATION_URL", "/oauth2/authorizations/new");
define("TOKEN_URL", "/oauth2/token");
define("ADDRESS_URL", "/oauth2/address");
