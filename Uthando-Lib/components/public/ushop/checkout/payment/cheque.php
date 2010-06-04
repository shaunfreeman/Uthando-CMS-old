<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );
defined( 'SHOP_STAGE_2' ) or die( 'Restricted access' );

if (UthandoUser::authorize()):

	$title .= ' - Cheque Payment';
	$this->addContent('<h2>Payment: Step 3 of 3</h2>');

	$this->addContent('<p>Thank you for your order we will depatch your goods as soon as we receive your cleared payment</p>');
	$this->addContent('<p>Please make cheques payable to: '. $this->get('config.server.site_name').'</p><p>And send it to:-</p>');

	$store = $this->ushop->store;

	$c = 0;
	$data = array();

	foreach ($store as $key => $value):
		if ($value != ''):
			$data[$c] = array(ucwords(str_replace('_', ' ', $key)).':', $value);
			$c++;
		endif;
	endforeach;

	array_unshift($data, array('Company', $this->get('config.server.site_name')));

	$table = Uthando::dataTable($data);
	$table->setAttributes(array('id' => 'merchant_address'));

	$html = $table->toHtml();
	
	$html = preg_replace("/<th>(.*?)<\/th>/s", "", $html);
	$this->addContent($html);
else:
	header("Location" . $this->get('config.server.web_url'));
	exit();
endif;
?>