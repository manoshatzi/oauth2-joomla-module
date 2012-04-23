	<form action="<?php JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="form-login-skroutz">
		<input type="hidden" name="skroutz" value="skroutz" />
		<input type="hidden" name="name" value="<?= $name ?>" />
		<input type="hidden" name="company" value="<?= $company ?>" />
		<input type="hidden" name="city" value="<?= $city ?>" />
		<input type="hidden" name="address" value="<?= $address ?>" />
		<input type="hidden" name="region" value="<?= $region ?>" />
		<input type="hidden" name="zip" value="<?= $zip ?>" />
		<input type="hidden" name="invoice" value="<?= $invoice ?>" />
		<input type="hidden" name="doy" value="<?= $doy ?>" />
		<input type="hidden" name="company_phone" value="<?= $company_phone ?>" />
		<input type="hidden" name="mobile" value="<?= $mobile ?>" />
		<input type="hidden" name="phone" value="<?= $phone ?>" />
		<input type="hidden" name="last_name" value="<?= $last_name ?>" />
		<input type="hidden" name="afm" value="<?= $afm ?>" />
		<input type="hidden" name="profession" value="<?= $profession ?>" />
		<input type="hidden" name="first_name" value="<?= $first_name ?>" />
		<input type="hidden" name="email" value="<?= $email ?>" />
	</form>

	<script type="text/javascript">
		document.forms["form-login-skroutz"].submit();
	</script>

