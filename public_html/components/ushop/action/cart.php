<?php
// no direct access
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );

$title .= 'Shopping Cart';

if ($this->ushop->GLOBAL['offline'] || $this->ushop->GLOBAL['catelogue_mode']) {
	$this->addContent('<h3>Shopping is unavialible</h3><p><a href="/ushop/view/shopfront">Click here to continue</a></p>');
} else {

	$item = $this->registry->params['id'];

	$cart = $this->ushop->retrieveCart();
	
	$this->addContent('<div id="products">');
	$this->addContent($this->ushop->returnLink());
	
	switch ($this->registry->params['action']) {
		case 'add':
			$cart->addItem($item);
			break;
		case 'remove':
			$cart->removeItem($item);
			break;
		case 'update':
			if (isset($_POST['items'])) {
				foreach ($_POST['items'] as $key => $value) {
					$cart->updateCart($key, $value);
				}
			}
			break;
		case 'empty':
			$cart->cart = null;
			break;
	}

	if (count($cart->cart['items']) > 0) {
		$this->addContent($cart->viewCart());
	} else {
		$this->addContent('<h3>Shopping cart is empty</h3>');
	}

	$this->ushop->storeCart($cart);
	
	$this->addContent('</div>');
	
}

?>