<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );
define( 'SHOP_PARENT_FILE', 1 );

$title .= " : ";

$this->ushop = new UShop();

switch ($this->registry->params[0]) {
	case 'shopfront':
		require_once('ushop/action/shopfront.php');
		break;
	case 'terms':
		require_once('ushop/action/terms.php');
		break;
	case 'product':
		require_once('ushop/action/product.php');
		break;
	case 'cart':
		require_once('ushop/action/cart.php');
		break;
	case 'checkout':
		require_once('ushop/action/checkout.php');
		break;
	case 'change_details':
		require_once('ushop/user/change_details.php');
		break;
	default:
		require_once('ushop/action/browse.php');
		break;
}

?>