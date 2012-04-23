<?php
	header("Location: " . SITE . AUTHORIZATION_URL . "?client_id=".urlencode(CLIENT_ID)."&redirect_uri=".urlencode(REDIRECT_URI)."&response_type=code");
?>
