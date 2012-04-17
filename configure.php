<?php

//εδώ μπαίνει το client id
$client_id = "";
//εδώ μπαίνει το client secret
$client_secret = "";
//εδώ μπαίνει το https url μόνο πχ https://www.skroutz.gr
$redirect_uri = "";

define("CLIENT_ID", $client_id);
define("CLIENT_SECRET", $client_secret);
define("REDIRECT_URI", $redirect_uri . "/modules/mod_skroutz/callback.php");
