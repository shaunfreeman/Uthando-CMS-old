<?php

ob_start('ob_gzhandler');
	
// Set flag that this is a parent file.
define( 'PARENT_FILE', 1 );

$site_path = realpath('../../');
define ('__SITE_PATH', $site_path);

/*{START_PHP_INI_PATH}*/
define ('__PHP_PATH', realpath(__SITE_PATH.'/../../uthando/php'));
/*{END_PHP_INI_PATH}*/

// Set include paths.
$ini_path = ini_get('include_path') .
	PATH_SEPARATOR . __PHP_PATH .
	PATH_SEPARATOR . __PHP_PATH . '/PEAR' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/functions';

set_include_path($ini_path);

// Include functions.
require_once('functions.php');

$registry = new Registry();

/*{START_INI_DIR}*/
$registry->ini_dir = realpath(__SITE_PATH.'/../../uthando/ini');
/*{END_INI_DIR}*/

$registry->config = new Config($registry, array('path' => $registry->ini_dir.'/uthando.ini.php'));

$registry->ushop_config = new Config($registry, array('path' => $registry->ini_dir.'/ushop.ini.php'));

$core = $registry->config->get('core', 'DATABASE').'.';
$user = $registry->config->get('user', 'DATABASE').'.';
	
try
{
	// connect user to database.
	$dsn = array(
		'hostspec' => $registry->config->get('hostspec','DATABASE'),
		'phptype' => $registry->config->get('phptype','DATABASE'),
		'database' => $registry->config->get('user','DATABASE')
	);

	$dsn = array_merge($dsn, $registry->config->get('DATABASE_USER'));
		
	$db = DB_Connect::getInstance($dsn['phptype'].":host=".$dsn['hostspec'] . ";dbname=".$dsn['database'], $dsn['username'], $dsn['password']);

	$paypal = new Payment_Paypal_IPN($registry);
	
	if ($paypal->validateIPN()):
		$verified = array();
		
		// check invoice.
		if (isset($paypal->ipn_data['invoice'])):
			$stmt = $db->prepare("
				SELECT order_id
				FROM ".$user."ushop_orders
				WHERE invoice = :invoice
				LIMIT 1
			");
			$stmt->execute(array(':invoice' => $paypal->ipn_data['invoice']));
			$res = $stmt->fetch(PDO::FETCH_OBJ);
			$verified['order_id'] = $res->order_id;
		else:
			$verified['order_id'] = false;
		endif;
		
		// check payment status
		if ($paypal->ipn_data['payment_status'] == "Completed"):
			$verified['payment_status'] = true;
	  	else:
			$verified['payment_status'] = false;
	  	endif;
		
		// check txn id of order.
		if ($paypal->ipn_data['txn_id'] && $verified['order_id']):
			// Check to see if txn has been set or duplicate.
			$stmt = $db->prepare("
				SELECT txn_id
				FROM ".$user."ushop_orders
				WHERE txn_id = :txn_id
			");
			$stmt->execute(array(':txn_id' => $paypal->ipn_data['txn_id']));
			$res = $stmt->fetch(PDO::FETCH_OBJ);
			if (!$res):
				$verified['txn_id'] = $paypal->ipn_data['txn_id'];
			else:
				$verified['txn_id'] = false;
			endif;
		else:
			$verified['txn_id'] = false;
		endif;
		
		// check merchant currency code
		if ($paypal->ipn_data['mc_currency'] == $registry->ushop_config->get('pp_currency', 'PAYPAL')):
			$verified['mc_currency'] = true;
		else:
			$verified['mc_currency'] = false;
		endif;
		
		// check merchant email
		if ($paypal->ipn_data['receiver_email'] == $registry->ushop_config->get('pp_merchant_id', 'PAYPAL')):
			$verified['receiver_email'] = true;
		else:
			$verified['receiver_email'] = false;
		endif;
		
		// check total of shopping cart.
		if ($paypal->ipn_data['mc_gross'] && $verified['order_id']):
			$stmt = $db->prepare("
				SELECT total
				FROM ".$registry->user."ushop_orders
				WHERE order_id = :order_id
			");
			$stmt->execute(array(':order_id' => $verified['order_id']));
			$res = $stmt->fetch(PDO::FETCH_OBJ);
			if ($paypal->ipn_data['mc_gross'] == $res->total):
				$verified['total'] = true;
			else:
				$verified['total'] = false;
			endif;
		else:
			$verified['total'] = false;
		endif;
		
		$pass = true;
		
		foreach ($verified as $key => $value):
			if ($value == false) $pass = false;
		endforeach;
		
		// if all is well update the payment status.
		if ($pass) {
			
			$stmt = $db->prepare("
				SELECT order_status_id
				FROM ".$core."ushop_order_status
				WHERE order_status = 'Paypal Payment Completed'
			");
			$stmt->execute();
			$res = $stmt->fetch(PDO::FETCH_OBJ);
			
			$stmt = $db->prepare("
				UPDATE ".$user."ushop_orders
				SET
					order_status_id = :order_status_id,
					txn_id = :txn_id
				WHERE order_id = :order_id
			");
			$stmt->execute(array(
				':order_status_id' => $res->order_status_id,
				':order_id' => $verified['order_id'],
				'txn_id' => $verified['txn_id']
			));
		}
		
	endif;
	
}
catch (PDOException $e)
{
	print_rr($e->getMessage());
}

//print_rr($registry);

$db = null;
	
unset ($registry);
	
ob_end_flush();

?>