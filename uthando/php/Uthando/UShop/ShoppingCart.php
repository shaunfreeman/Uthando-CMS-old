<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class UShop_ShoppingCart
{
	public $cart;
	protected $registry;

	public function __construct($registry, $cart=null)
	{
		$this->registry = $registry;
		if ($cart) $this->cart = $cart;
		$this->checkUserCountry();
	}
		
	public function addItem($item)
	{
		if ($this->cart['items'][$item]):
			$this->cart['items'][$item]['qty'] = $this->cart['items'][$item]['qty'] + 1;
		else:
			$this->cart['items'][$item]['qty'] = 1;
		endif;
	}
	
	public function removeItem($item)
	{
		unset($this->cart['items'][$item]);
		if (empty($this->cart['items'])) $this->cart = null;
	}
	
	public function updateCart($item, $qty)
	{
		if ($qty == 0):
			$this->removeItem($item);
		else:
			$this->cart['items'][$item]['qty'] = $qty;
		endif;
		if (empty($this->cart['items'])) $this->cart = null;
	}

	private function checkUserCountry()
	{
		global $uthando, $registry;
		
		if (UthandoUser::authorize()):
			$row = $uthando->getResult(
				'country_id',
				$registry->user.$uthando->ushop->prefix.'user_info',
				null,
				array('WHERE' => 'user_id='.$_SESSION['user_id']),
				false
			);
			
			if ($row):
				if ($row->country_id > 0):
					$_SESSION['CountryCode'] = $row->country_id;
				else:
					unset($_SESSION['CountryCode']);
				endif;
			else:
				unset($_SESSION['CountryCode']);
			endif;
		endif;
	}

	public function calculateCartItems()
	{
		global $uthando;
		// reset values
		$this->cart['subTotal'] = 0;
		$this->cart['taxTotal'] = 0;
		$this->cart['postWeight'] = 0;
		$this->cart['noPostage'] = 0;
		$this->cart['postTax'] = 0;;
		$this->cart['postCost'] = 0;
		
		foreach ($this->cart['items'] as $key => $value):
			
			$row = $uthando->getResult(
				'sku, name, price, weight, tax_rate, image, image_status, vat_inc, postage, quantity',
				$uthando->ushop->db_name.'products',
				array(
					$uthando->ushop->db_name.'tax_rates'
				),
				array(
					'WHERE' => 'product_id='.$key,
					'AND' => array('enabled=1','discontinued=0')
				),
				false
			);

			if ($uthando->ushop->CHECKOUT['stock_control']):
				if ($value['qty'] > $row->quantity):
					$value['qty'] = $row->quantity;
					$this->updateCart($key, $value['qty']);
				endif;
				if (!$this->cart['items']) return '<h3>Shopping cart is empty</h3>';
				if ($value['qty'] == 0) continue;
			endif;

			$tax_array = $this->calculateVat($row->price, $value['qty'], $row->tax_rate, $row->vat_inc);

			$tax = $tax_array['tax'];
			$row->price = $tax_array['price'];
			
			$itemTotal = ($row->price * $value['qty']) + $tax;
			$this->cart['subTotal'] += $itemTotal;
			$this->cart['taxTotal'] += $tax;

			if ($row->postage == 1):
				$itemWeight = $row->weight * $value['qty'];
			else:
				$itemWeight = 0;
				$this->cart['noPostage'] += $row->price + $tax;
			endif;
			
			$this->cart['postWeight'] += $itemWeight;
			
			if (file_exists(__SITE_PATH.'/components/ushop/images/products/'.$row->image)):
				$image = '/components/ushop/images/products/'.$row->image;
			else:
				$image = '/components/ushop/images/noimage.png';
			endif;
			
			$items[] = array(
				'PRODUCT_ID' => $key,
				'QUANTITY' => $value['qty'],
				'SKU' => $row->sku,
				'NAME' => $row->name,
				'PRICE' => $row->price,
				'VAT' => $tax,
				'TOTAL' => number_format($itemTotal,2),
				'IMAGE' => $image,
				'IMAGE_STATUS' => 'image_'.$row->image_status
			);
			
		endforeach;
		
		return $items;
	}

	public function viewCart()
	{
		$vc = file_get_contents('ushop/html/view_cart.html', true);

		$cart_body = $this->displayCart();
		
		$html = Uthando::templateParser($vc, array('CART_BODY' => $cart_body, 'SSL_URL' => $this->registry->config->get('ssl_url', 'SERVER')), '{', '}');
		
		return UShop_Utility::removeSection($html, 'item_quantity');
	}
	
	public function displayCart()
	{
		global $uthando;
		$cb = file_get_contents('ushop/html/cart_body.html', true);
		$ci = file_get_contents('ushop/html/cart_items.html', true);
		
		if (!$uthando->ushop->CHECKOUT['vat_state']) $ci = UShop_Utility::removeSection($ci, 'vat');
		if (!$uthando->ushop->CHECKOUT['vat_state']) $cb = UShop_Utility::removeSection($cb, 'vat');

		$params = array(
			'COLSPAN' => ($uthando->ushop->CHECKOUT['vat_state']) ? 3 : 2,
			'CART_ITEMS' => null
		);

		$items = $this->calculateCartItems();
		
		if (is_array($items)):
			foreach ($items as $item):
				$tr = Uthando::templateParser($ci, $item, '{', '}');
				$params['CART_ITEMS'] .= $tr;
			endforeach;
			
			if (isset($_SESSION['CountryCode'])):
				$this->calculatePostage();
			else:
				$this->cart['postCost'] = 0;
				$this->cart['postTax'] = 0;
				$cb = UShop_Utility::removeSection($cb, 'postage');
			endif;
			
			$params = array_merge($params, $this->getCartTotals());
			$html = Uthando::templateParser($cb, $params, '{', '}');
		else:
			$html = $items;
		endif;
		
		return $html;
	}

	public function getCartTotals()
	{
		$cart_total['POST_COST'] = number_format($this->cart['postCost'], 2);
		$cart_total['VAT_TOTAL'] = number_format($this->cart['taxTotal'] + $this->cart['postTax'], 2);
		$cart_total['CART_TOTAL'] = number_format($this->cart['subTotal'] + $this->cart['postCost'], 2);
		return $cart_total;
	}

	public function calculatePostage()
	{
		global $uthando;
		
		if ($uthando->ushop->CHECKOUT['post_state'] == 1):
			$itemLevel = $this->cart['postWeight'];
		else:
			$itemLevel = $this->cart['subTotal'] - $this->cart['noPostage'];
		endif;

		if ($itemLevel == $this->cart['noPostage']):
			$this->cart['postTax'] = 0;
			$this->cart['postCost'] = 0;
			return;
		endif;

		$rows = $uthando->getResult(
			'cost, post_level, vat_inc, tax_rate',
			$uthando->ushop->db_name.'countries',
			array(
				$uthando->ushop->db_name.'post_zones',
				$uthando->ushop->db_name.'post_costs',
				$uthando->ushop->db_name.'post_levels',
				$uthando->ushop->db_name.'tax_codes',
				$uthando->ushop->db_name.'tax_rates'
			),
			array(
				'WHERE' => 'country_id='.$_SESSION['CountryCode'],
				'ORDER BY' => 'post_level ASC'
			)
		);

		foreach ($rows as $index => $row):
			if ($itemLevel > $row->post_level):
				$this->cart['postCost'] = $row->cost;
				$postVatInc = $row->vat_inc;
				$postTaxRate = $row->tax_rate;
			endif;
		endforeach;

		$tax_array = $this->calculateVat($this->cart['postCost'], 1, $postTaxRate, $postVatInc);

		$this->cart['postTax'] = $tax_array['tax'];
		$this->cart['postCost'] = $tax_array['price'] + $tax_array['tax'];
		
	}

	private function calculateVat($price, $qty, $tax_rate, $vat_inc)
	{
		global $uthando;
		$vat_inc = 1;
		if ($uthando->ushop->CHECKOUT['vat_state'] == 1 && $tax_rate != 0):
			if ($vat_inc == 0):
				$pat = round ($price * $tax_rate, 2);
				$tax = $pat - $price;
				$tax = $qty * $tax;
			else:
				$pbt  = round ($price / $tax_rate, 2);
				$tax = $price - $pbt;
				$price = $pbt;
				$tax = $qty * $tax;
			endif;
		else:
			$tax = 0;
		endif;

		return array(
			'tax' => number_format($tax, 2),
			'price' => number_format($price, 2)
		);
	}
}
?>