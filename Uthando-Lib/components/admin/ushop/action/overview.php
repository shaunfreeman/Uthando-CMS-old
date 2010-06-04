<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset ($_POST['oid']) && isset ($_POST['order_status'])):
		$this->update(
			array('order_status_id' => $_POST['order_status']),
			$this->registry->user.'ushop_orders',
			array('WHERE' => 'order_id='.$_POST['oid'])
		);
	endif;
		
	$this->addContent($this->makeToolbar($menuBar, 24));
	
	$orders = $this->getResult(
		"CONCAT(first_name, ' ', last_name ) AS name,
		invoice,
		order_status,
		DATE_FORMAT(order_date, '%D %M %Y') AS date,
		order_id,
		user_id",
		$this->registry->user.'ushop_orders',
		array(
			$this->registry->core.'ushop_order_status',
			$this->registry->user.'users'
		),
		array(
			'WHERE' => 'order_status_id',
			'IN' => "(
				SELECT order_status_id
				FROM ".$this->registry->user."ushop_orders
				WHERE order_status != 'Cancelled'
				AND order_status != 'Dispatched'
			)",
			'ORDER BY' => 'order_date DESC'
		)
	);
	
	// New orders.
	if ($orders):
		$c = 0;
		$data = array();
		$tab_array = array();
		
		$orderRow = $this->getResult('order_status_id, order_status', $this->registry->core.'ushop_order_status');
		
		foreach ($orders as $row):
			
			$data[$c][] = $row->name;
			$data[$c][] = $row->invoice;
			
			$form = '<form id="order'.$row->order_id.'" action="'.$_SERVER['REQUEST_URI'].'" method="post">';
			$form .= '<select name="order_status" onChange="this.form.submit()">';
			
			foreach ($orderRow as $or):
				$form .= '<option value="'.$or->order_status_id.'" ';
				if ($row->order_status == $or->order_status) $form .= 'selected="selected"';
				$form .= '>'.$or->order_status.'</option>';
			endforeach;
			
			$form .= '</select>';
			$form .= '<input type="hidden" name="oid" value="'.$row->order_id.'" />';
			$form .= '</form>';
			
			$data[$c][] = $form;
			$data[$c][] = $row->date;
			$c++;
		endforeach;
		
		$header = array('Customer', 'Invoice', 'Status', 'Date');
		
		$table = $this->dataTable($data, $header);
		
		$orders = $table->toHtml();
		$tab_array['New Orders'] = $orders;
		
		$tabs = new HTML_Tabs($tab_array);
		$this->addContent($tabs->toHtml());
	endif;
endif;
?>