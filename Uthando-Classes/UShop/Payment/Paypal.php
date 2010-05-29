<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class UShop_Payment_Paypal extends HTML_Element
{
	private $fields = array(); // array holds the fields to submit to paypal
	protected $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
	protected $registry;
	protected $uthando_dir;
	
	public function __construct($registry)
	{
		$this->registry = $registry;
		parent::__construct();
	}

	public function addField($field, $value)
	{
		$this->fields[$field] = $value;
	}

	public function submitPaypalPost()
	{	
		$post = $this->createElement('div');
		
		$post->appendChild($this->createElement('h2', 'Please wait, your order is being processed and you will be redirected to the paypal website.'));

		$form = $this->createElement('form', null, array(
			'id' => 'paypal_form',
			'method' => 'post',
			'action' => $this->paypal_url
		));

		foreach ($this->fields as $name => $value):
			$form->appendChild($this->createElement('input', null, array(
				'type' => 'hidden',
				'name' => $name,
				'value' => $value
			)));
		endforeach;

		$form->appendChild($this->createElement('h3', 'If you are not automatically redirected to paypal within 10 seconds...'));

		$form->appendChild($this->createElement('input', null, array(
			'type' => 'submit',
			'class' => 'button',
			'value' => 'Click Here'
		)));

		$post->appendChild($form);
		$this->appendChild($post);
			
		return $this->returnHTML();
	}
	
	private function getOrderStatus($oid)
	{
		return $this->registry->db->getRow("
			SELECT order_id, order_status, invoice, total
			FROM ".$this->registry->user."ushop_orders
			NATURAL JOIN ".$this->registry->core."ushop_order_status
			WHERE order_id = :order_id
		", array(':order_id' => $oid));
	}
	
	public function payReturn($oid)
	{
		$row = $this->getOrderStatus($oid);
		
		$this->appendChild($this->createElement('h2', 'Thank you for your order. We will process and dispatch your order as soon as possible.'));
		
		$this->appendChild($this->createElement('h3', 'Invoice No. '.$row->invoice));
		
		$this->appendChild($this->createElement('p', 'Order Status: '.$row->order_status));
		
		$this->appendChild($this->createElement('p', 'Total Amount: '.$row->total));
		
		return $this->returnHTML();
	}
	
	public function cancelReturn($oid)
	{
		$row = $this->registry->db->getRow("
			SELECT order_status_id
			FROM ".$this->registry->core."ushop_order_status
			WHERE order_status = 'Cancelled'
		");
		
		$query = $this->registry->db->update(
			array('order_status_id' => $row->order_status_id),
			$this->registry->user.'ushop_orders',
			array('WHERE' => 'order_id='.$oid),
			false
		);
		
		if ($query):
			
			// email merchant that order was cancelled maybe!
			
			$row = $this->getOrderStatus($oid);
			
			$this->appendChild($this->createElement('h3', 'Please make a note of the cancelled order for your records.'));
			
			$this->appendChild($this->createElement('p', 'Order ID: '.$row->order_id));
			
			$this->appendChild($this->createElement('p', 'Invoice No. '.$row->invoice));
			
			
			$this->appendChild($this->createElement('p', 'Total Amount: '.$row->total));
			
			return $this->returnHTML();
		endif;
	}
	
	private function returnHTML()
	{
		return $this->saveXML();
	}
}

?>