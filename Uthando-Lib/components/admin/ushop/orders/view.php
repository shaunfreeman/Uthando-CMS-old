<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
    $customBar = array(
		'back' => '/ushop/orders'
	);

    $menuBar = array_merge($customBar, $menuBar);
    unset($menuBar['orders']);

    $this->addContent($this->makeToolbar($menuBar, 24));

    $uid = $this->registry->params['uid'];
    $inv = $this->registry->params['inv'];

    $invoice = $ushop->displayInvoice($uid, $inv);

    $this->addContent($invoice);


    if (isset($params)) $content = $this->message($params);

	$this->addContent($content);
endif;

?>