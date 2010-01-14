<?php

// no direct access
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );

$this->registry->page_title = 'ushop/view/shopfront';

$title .= 'Shop Front';

if ($this->ushop->GLOBAL['offline']) {

	$content = '<center><img src="/components/ushop/images/closed-sign.png" /></center>';
	$content .= file_get_contents('ushop/html/offline_message.html', true);
	
} else {

	$content = '<div id="products">';

	$content .= $this->ushop->displayCartButtons();

	$content .= $this->displayContentpane($this->ushop->getCategories(true), 'Shop Front');
	
	$content .= '</div>';
}

$this->addContent($content);

?>