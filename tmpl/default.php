<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>


<?php if($type == 'logout') : ?>

	<form action="index.php" method="post" name="login" id="form-login">
		<div align="center">
			<input type="submit" name="Submit" class="button" value="Log out" />
		</div>
		<input type="hidden" name="option" value="com_user" />
		<input type="hidden" name="task" value="logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
	</form>
    <p>You are Logedin</p>

<?php else : ?>

    <form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" >
        <input type="hidden" name="login" value="skroutz" />
        <input type="submit" name="Login With Skroutz" class="button" value="<?php echo JText::_('Login With Skroutz') ?>" />
    </form>

    <?php if($_POST['skroutz']=='skroutz') : ?>
        <?php
		$zip = $_POST['zip'];
		$mypassword = intval($zip);
		foreach (count_chars($zip, 1) as $k=>$v)
		{
			$mypassword = $mypassword + $v;
		}
		$mypassword * rand(1212, 89898);
		
		// Lets fix the password
		jimport('joomla.user.helper');
		$salt  = JUserHelper::genRandomPassword(32);
		$crypt = JUserHelper::getCryptedPassword($mypassword, $salt);
		$password = $crypt.':'.$salt;

        // Get a database object
        $db =& JFactory::getDBO();
        $query = 'SELECT `id` '.' FROM `#__users`'.' WHERE username='.$db->Quote($_POST['email']);
        $db->setQuery($query);
        $result = $db->loadObject();
        
        if($result->id != "") :
    	    // Check the password
	        $db =& JFactory::getDBO();
        	$query = 'SELECT password` '.' FROM `#__users`'.' WHERE username='.$db->Quote($_POST['email']);
	        $db->setQuery($query);
    	    $pass = $db->loadObject();
    	    if($pass->password != $password) :
				$query = "UPDATE #__users SET password='".$password."' WHERE username=".$db->Quote($_POST['email']);
				$db->setQuery($query);
				$db->query();
			endif;
    	    ?>
            <form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login-skroutz" >
                <input type="hidden" name="username" value="<?=$_POST['email']?>" />
                <input type="hidden" name="passwd" value="<?=$mypassword?>" />
                <input type="hidden" name="option" value="com_user" />
                <input type="hidden" name="task" value="login" />
                <input type="hidden" name="return" value="<?php echo $return; ?>" />
                <?php echo JHTML::_( 'form.token' ); ?>
            </form>
            <script type="text/javascript">
                document.forms["form-login-skroutz"].submit();
            </script>
        <?php else: ?>
        	<?php
        		$query = "INSERT INTO #__users (name,username,email,password,usertype,block) VALUES ('".$_POST['first_name']." ".$_POST['last_name']."', '".$_POST['email']."', '".$_POST['email']."', '".$password."', 'Registered',0)";
				$db->setQuery($query);
				$db->query();
				$user_id = $db->insertid();
				
				
				$query = "INSERT INTO #__core_acl_aro (section_value,value,order_value,name,hidden) VALUES ('users', '".$user_id."', 0, '".$_POST['first_name']." ".$_POST['last_name']."', 0)";
				$db->setQuery($query);
				$db->query();
				$acl_aro_id = $db->insertid();
				
				$query = "INSERT INTO #__core_acl_groups_aro_map (group_id,section_value,aro_id) VALUES (18, '', '".$acl_aro_id."')";
				$db->setQuery($query);
				$db->query();
				
				$timestamp = time();
				$hash_secret = "VirtueMartIsCool";
				$user_info_id = md5(uniqid($hash_secret));
				$doy = str_replace("'", "&#039;", $_POST['doy']);

				$fields = "(user_info_id,user_id,address_type,address_type_name,last_name,first_name,address_1,city,country,zip,user_email,cdate,mdate";
				$values = "('".$user_info_id."',".$user_id.", 'BT', '-default-', '".$_POST['last_name']."', '".$_POST['first_name']."', '".$_POST['address']."', '".$_POST['city']."', 'GRC', '".$zip."', '".$_POST['email']."', '".$timestamp."', '".$timestamp."'";
				if($_POST['company']!=""){
					$fields .= ",company";
					$values .= ", '".$_POST['company']."'";
				}
				if($_POST['phone']!=""){
					$fields .= ",phone_1";
					$values .= ", '".$_POST['phone']."'";
				}
				if($_POST['mobile']!=""){
					$fields .= ",phone_2";
					$values .= ", '".$_POST['mobile']."'";
				}
				if($_POST['afm']!=""){
					$fields .= ",vm_afm";
					$values .= ", '".$_POST['afm']."'";
				}
				if($doy!=""){
					$fields .= ",vm_doy";
					$values .= ", '".$doy."'";
				}
				$fields .= ")";
				$values .= ")";
				$query = "INSERT INTO #__".VM_TABLEPREFIX."_user_info ".$fields." VALUES ".$values."";
				$db->setQuery($query);
				$db->query();

				// Insert vendor relationship
				$ps_vendor_id = $_SESSION["ps_vendor_id"];
				$q = "INSERT INTO #__".VM_TABLEPREFIX."_auth_user_vendor (user_id,vendor_id) VALUES (".$user_id.",".$ps_vendor_id.")";
				$db->setQuery($q);
				$db->query($q);
		
				// Update 02042011
				$customer_number = uniqid(rand());
				// Enc Update 02042011
				// Insert Shopper -ShopperGroup - Relationship
				$q  = "INSERT INTO #__".VM_TABLEPREFIX."_shopper_vendor_xref (user_id,vendor_id,shopper_group_id,customer_number) VALUES (".$user_id.", ".$ps_vendor_id.", 5, '".$customer_number."')";
				$db->setQuery($q);
				$db->query($q);

        	?>

            <form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login-skroutz" >
                <input type="hidden" name="username" value="<?=$_POST['email']?>" />
                <input type="hidden" name="passwd" value="<?=$mypassword?>" />
                <input type="hidden" name="option" value="com_user" />
                <input type="hidden" name="task" value="login" />
                <input type="hidden" name="return" value="<?php echo $return; ?>" />
                <?php echo JHTML::_( 'form.token' ); ?>
            </form>
            <script type="text/javascript">
                document.forms["form-login-skroutz"].submit();
            </script>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>