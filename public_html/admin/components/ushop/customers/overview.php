<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$customBar = array(
		'back' => '/ushop/overview',
		'new_customer' => ''
	);
	
	$menuBar = array_merge($customBar, $menuBar);
	unset($menuBar['customers']);
	
	$this->addContent($this->makeToolbar($menuBar, 24));
	
	$display = $ushop->getDisplay('customers');
	
	$num = count($this->getResult('user_id', $this->registry->user.'ushop_user_info'));
		
	$start = (isset($this->registry->params['cstart']) ? $this->registry->params['cstart'] : 0);
				
	if ($num > $display):
		$paginate = new HTML_Paginate('customers', $start, '/ushop/customers/cstart-{start}#customers', $num, $display, false);
		$content = $paginate->toHTML();
	endif;
	
	$customers = $this->getResult(
		"user_id, CONCAT(prefix, ' ', first_name, ' ', last_name) as name",
		$this->registry->user.'ushop_user_info',
		array($this->registry->user.'users', $this->registry->user.'ushop_user_prefix'),
		array('ORDER BY' => 'last_name, first_name', 'LIMIT' => "$start, $display")
	);
	
	if ($customers):
		$c = 0;
		$data = array();
		
		foreach ($customers as $row):
			$orders =  $this->getRow('
				SELECT COUNT(order_id) as num_orders
				FROM '.$this->registry->user.'ushop_orders
				WHERE user_id = :user_id
			', array(':user_id' => $row->user_id));
			
			$data[$c][] = $row->name;
			$data[$c][] = $orders->num_orders;
			$c++;
		endforeach;
		
		$header = array('Customer', 'Orders');
		
		$table = $this->dataTable($data, $header);
		
		$content = $table->toHtml();
	else:
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = '<h2>There are currently no customers.</h2>';
	endif;
	
	if (isset($params)) $content = $this->message($params);
	
	$this->addContent($content);
	
endif;
?>