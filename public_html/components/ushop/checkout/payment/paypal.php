<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );

if (UthandoUser::authorize()):

	$paypal_action = ($this->registry->params['callback']) ? $this->registry->params['callback'] : 'pay';
	
	$paypal = ($this->ushop->PAYPAL['ipn']) ? new Payment_Paypal_IPN($this->registry) : new Payment_Paypal($this->registry);
	
	switch ($paypal_action):
		case 'cancel':
			defined( 'SHOP_STAGE_3' ) or die( 'Restricted access' );
			$this->addContent($paypal->cancelReturn($this->registry->params['oid']));
			// email customer and merchant that order has been cancelled.
			break;
		case 'return':
			defined( 'SHOP_STAGE_3' ) or die( 'Restricted access' );
			$this->addContent($paypal->payReturn($this->registry->params['oid']));
			break;
		case 'pay':
		default:
			defined( 'SHOP_STAGE_2' ) or die( 'Restricted access' );
			$site = $this->registry->config->get('ssl_url', 'SERVER');
			$this_script = $site.'/ushop/view/checkout/stage-3/payment-paypal';
			
			try
			{
				// get order
				$order = $this->registry->db->getRow("
					SELECT *
					FROM ".$this->registry->user."ushop_orders
					WHERE invoice = :invoice_no
				", array(':invoice_no' => $invoice));
			}
			catch(PDOException $e)
			{
				$this->registry->Error ($e->getMessage());
			}
			
			$paypal->addField('business', $this->ushop->PAYPAL['pp_merchant_id']);
			$paypal->addField('cmd','_cart');
			$paypal->addField('upload','1');
			if ($this->ushop->PAYPAL['pp_auto_return']) $paypal->addField('return', $this_script.'/callback-return/oid-'.$order->order_id);
			if ($this->ushop->PAYPAL['pp_cancel_return']) $paypal->addField('cancel_return', $this_script.'/callback-cancel/oid-'.$order->order_id);
			if ($this->ushop->PAYPAL['pp_ipn']) $paypal->addField('notify_url', $site.'/components/ushop/paypal/ipn.php');
			if ($this->ushop->PAYPAL['pp_merchant_logo']) $paypal->addField('image_url', $site.$this->ushop->PAYPAL['pp_merchant_logo']);
			$paypal->addField('custom', $order->order_id);
			$paypal->addField('invoice', $invoice);
			$paypal->addField('rm','2');
			
			// add cart items
			try
			{
				// get order
				$order_lines = $this->registry->db->query("
					SELECT *
					FROM ".$this->registry->user."ushop_order_items
					WHERE order_id = :order_no
				", array(':order_no' => $order->order_id));
				
				$c = 1;
				foreach ($order_lines as $key => $value):
					$row = $this->registry->db->getRow("
						SELECT sku, name
						FROM ".$this->registry->core."ushop_products
						WHERE product_id = :item_id
							
					", array(':item_id' => $value->product_id));
				
					$paypal->addField('item_number_' . $c, $row->sku);
					$paypal->addField('item_name_' . $c, $row->name);
					$paypal->addField('quantity_' . $c, $value->quantity);
					$paypal->addField('amount_' . $c, $value->item_price);
					
					$c++;
				endforeach;
			}
			catch(PDOException $e)
			{
				$this->registry->Error ($e->getMessage());
			}
				
			$paypal->addField('shipping_1', $order->shipping);
			$paypal->addField('currency_code', $this->ushop->PAYPAL['pp_currency']);
			
			// add address fields for customer convienience
			
			$this->addContent($paypal->submitPaypalPost());
			
			$this->registry->component_js = array(
				'/components/ushop/js/paypal.js'
			);
			
			break;
	endswitch;
	
else:
	header("Location: " . $this->registry->config->get('web_url', 'SERVER'));
	exit();
endif;
?>