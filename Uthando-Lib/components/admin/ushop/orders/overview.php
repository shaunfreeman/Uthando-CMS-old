<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$customBar = array(
		'back' => '/ushop/overview'
	);
	
	$menuBar = array_merge($customBar, $menuBar);
	unset($menuBar['orders']);
	
	$this->addContent($this->makeToolbar($menuBar, 24));
	
	$display = $ushop->getDisplay('orders');
	
	$num = count($this->getResult('order_id', $ushop->db_name.'orders'));
		
	$start = (isset($this->registry->params['cstart']) ? $this->registry->params['cstart'] : 0);
				
	if ($num > $display):
		$paginate = new HTML_Paginate('orders', $start, '/ushop/orders/ostart-{start}#orders', $num, $display, false);
		$content = $paginate->toHTML();
	endif;
	
	$orders = $this->getResult(
		"order_id, user_id, order_date, invoice",
		$ushop->db_name.'orders',
		null,
		array('LIMIT' => "$start, $display")
	);

	if ($orders):
		$c = 0;
		$data = array();
		
		foreach ($orders as $row):
			$data[$c][] = $row->order_id;
            $data[$c][] = $row->invoice;
            $date = new DateTime($row->order_date);
			$data[$c][] = $date->format('D jS F Y');
            $data[$c][] = '<a href="/ushop/orders/action-view/uid-'.$row->user_id.'/inv-'.$row->invoice.'"  style="text-decoration:none;" ><img src="/images/24x24/Preview.png" class="Tips" title="View Menu" rel="Click to view this order" /></a>';
			$c++;
		endforeach;
		
		$header = array('Order', 'Invoice No', 'Date', '');
		
		$table = $this->dataTable($data, $header);

        $content = '<div id="contentPage">';
		$content .= $table->toHtml();
        $content .= '</div>';
	else:
		$params['TYPE'] = 'info';
		$params['MESSAGE'] = '<h2>There are currently no customers.</h2>';
	endif;
	
	if (isset($params)) $content = $this->message($params);
	
	$this->addContent($content);
	
endif;
?>