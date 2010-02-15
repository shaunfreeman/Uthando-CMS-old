<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class UShop_Core {
	
	protected $vars;
	
	public function __construct()
	{
		$this->uthando = $GLOBALS['uthando'];
		$this->registry = $GLOBALS['registry'];
		$this->setOptions();
		
		$this->img_dir = $this->registry->config->get('web_url', 'SERVER')."/components/ushop/images/products/";
		
		$this->prefix = 'ushop_';
		$this->db_name = $this->registry->core.$this->prefix;
		$this->tree = $tree = new NestedTree($this->db_name.'product_categories', null, 'category');
	}
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		return $this->vars[$index];
	}
	
	public function getDisplay($key)
	{
		return $this->FRONTEND_DISPLAY[$key];
	}
	
	private function setOptions()
	{
		// load in options.
		$options = new Config($this->registry, array('path' => $this->registry->ini_dir.'/ushop.ini.php', 'process_sections' => true));
		
		foreach ($options->vars as $key => $value) $this->$key = $value;
	}
	
	public function displayPathway($cid=null)
	{
		if (!$cid) $cid = $this->category_id;
		
		$pathway = '<span style="text-align:left;"><a href="/ushop/view/shopfront" class="Tips pathway" title="Shop Tip" rel="Click here to go to the shop front">Shop Front</a></span>';
		
		foreach ($this->tree->pathway($cid) as $id => $path):
		
			$pathway .= '<span style="text-align:left;">&nbsp;::&nbsp;';
			
			if (str_replace('_', ' ', stripslashes($this->registry->params[0])) != $path['category']):
				$pathway .= '<a href="/ushop/view/'.str_replace(' ', '_', $path['category']).'" class="Tips pathway" title="Shop Tip" rel="Click here to go to the '.$path['category'].' category">'.$path['category'].'</a>';
			else:
				$pathway .= $path['category'];
			endif;
		
			$pathway .= "</span>";
		
		endforeach;
		
		return $pathway;
	}
	
	private function getSubcategories()
	{
		$row = $this->tree->getCategory(str_replace('_', ' ', $this->uthando->escape_db_data($this->registry->params[0])));
		$this->category_id = $row['category_id'];
		$this->tree->setId($this->category_id);
		return $this->tree->getDecendants(true);
	}
	
	public function getCategories($top_level=false)
	{
		$rows = ($top_level) ? $this->tree->getTopLevelTree() : $this->getSubcategories();
		$display = $this->getDisplay('category');
		$num_rows = ceil(count($rows)/$display);
		return $this->categoryDisplay($rows, $display, $num_rows);
		
	}
	
	public function productList($rows, $num_rows)
	{
		$display = $this->getDisplay('product_list');
		$html = null;
		$start = 0;
		$base_dir = realpath(__SITE_PATH . '/components/ushop/images/products/');
		
		$message = file_get_contents('ushop/html/product_list_display.html', true);
		$popup = file_get_contents('ushop/html/popupDetails.html', true);
		$json_array = array();
		
		for ($n = 1; $n <= $num_rows; $n++):
		
			for ($d = $start; $d < ($display + $start); $d++):
				if ($rows[$d]):
					$message1 = $message;
					$params['NAME'] = HTML_Element::makeXmlSafe($rows[$d]->name);
					$params['PRICE'] = $rows[$d]->price;
					$params['WIDTH'] = number_format(100 / $display, 0);
					$params['IMAGE'] = '/components/ushop/images/' . (file_exists($base_dir.'/'.$rows[$d]->image) && $rows[$d]->image != null ? 'products/'.$rows[$d]->image : 'noimage.png');
					$params['LINK'] = '/ushop/view/product/id-'.$rows[$d]->product_id;
					$params['CART_LINK'] = '/ushop/view/cart/action-add/id-'.$rows[$d]->product_id;

					$json_array[] = array(
						"name" => $rows[$d]->name,
	  					"thumbnail" => $params['IMAGE'],
						"isbn" => $rows[$d]->isbn,
						"author" => $rows[$d]->author,
						"description" => HTML_Element::makeXmlSafe($rows[$d]->description)
					);
					
					if (!$rows[$d]->image_status) $message1 = UShop_Utility::removeSection($message1, 'image');
					
					if ($this->GLOBAL['catelogue_mode']) $message1 = UShop_Utility::removeSection($message1, 'add_cart');
					
					$html .= Uthando::templateParser($message1, $params, '{', '}');
					
				endif;
			endfor;
			$html .= '<div class="both"></div>';
			$start = $start + $display;
		endfor;
		
		$html = Uthando::templateParser($popup, array('POPUP_COLLECTION' => $html, 'JSON' => json_encode($json_array)), '{', '}');
		
		return $html;
	}

	public function productDetails($row)
	{
		$base_dir = realpath(__SITE_PATH . '/components/ushop/images/products/');
		
		$html = file_get_contents('ushop/html/product.html', true);

		$params = array(
			'LINK' => '/ushop/view/product/id-'.$row->product_id,
			'CART_LINK' => '/ushop/view/cart/action-add/id-'.$row->product_id,
			'SEARCH_LINK' => '#'
		);

		foreach ($row as $key => $value):
			
			if ($key == 'image'):
				$params[strtoupper($key)] = '/components/ushop/images/' . (file_exists($base_dir.'/'.$value) && $value != null ? 'products/'.$value : 'noimage.png');
			else:
				$params[strtoupper($key)] = $value;
			endif;
		endforeach;

		if (!$row->image_status) $html = UShop_Utility::removeSection($html, 'image');
					
		if ($this->GLOBAL['catelogue_mode']) $html = UShop_Utility::removeSection($html, 'add_cart');

		$html = Uthando::templateParser($html, $params, '{', '}');

		return $html;
	}
	
	private function categoryDisplay($rows, $display, $num_rows)
	{
		$html = null;
		$start = 0;
		
		$message = file_get_contents('ushop/html/category_display.html', true);
		
		for ($n = 1; $n <= $num_rows; $n++):
		
			for ($d = $start; $d < ($display + $start); $d++):
				if ($rows[$d]):
					$message1 = $message;
					$params['CATEGORY'] = $rows[$d]['category'];
					$params['WIDTH'] = number_format(100 / $display, 0);
					$params['IMAGE'] = '/components/ushop/images/' . ($rows[$d]['category_image'] ? 'products/'.$rows[$d]['category_image'] : 'noimage.gif');
					$params['LINK'] = '/ushop/view/'.str_replace(' ', '_', $rows[$d]['category']);
					
					if (!$rows[$d]['category_image_status']) $message1 = UShop_Utility::removeSection($message1, 'image');
					
					$html .= Uthando::templateParser($message1, $params, '{', '}');
					
				endif;
			endfor;
			$html .= '<div class="both"></div>';
			$start = $start + $display;
		endfor;
		
		return $html;
	}

	public function getUserInfo($user)
	{
		// check to see if user has a registered address, if not create one now.
		$user_info = $this->registry->db->query("
			SELECT CONCAT(prefix, ' ', first_name, ' ', last_name) AS name, address1, address2, address3, city, county, post_code, country, phone, email, user_cda_id
			FROM ".$this->registry->user."users
			NATURAL JOIN ".$this->registry->user."ushop_user_info
			NATURAL JOIN ".$this->registry->user."ushop_user_prefix
			NATURAL JOIN ".$this->registry->core."ushop_countries
			WHERE user_id = :userid
		", array(':userid' => $user));
		
		$num_rows = count($user_info);

		if ($num_rows == 1):
			// comfirm delivery address, or edit it.

			$cda_id = $user_info[0]->user_cda_id;
			$email = $user_info[0]->email;
			unset($user_info[0]->user_cda_id, $user_info[0]->email);
				
			$c = 0;
			$data = array();

			foreach ($user_info[0] as $key => $value):
				if ($value != ''):
					$data[$c] = array(ucwords(str_replace('_', ' ', $key)).':', $value);
					$c++;
				endif;
			endforeach;

			$header = array('Invoice Address');

			$user_info_table = Uthando::dataTable($data, $header);
			$user_info_table->setAttributes(array('id' => 'user_info'));
			$user_info_table->setCellAttributes(0, 0, 'colspan="2"');

			// reset counter and data array;
			$c = 0;
			$data = array();

			// get delivery address if there is one.
			if ($cda_id > 0):
				$user_info = $this->registry->db->query("
					SELECT CONCAT(prefix, ' ', first_name, ' ', last_name) AS name, user_cda.address1, user_cda.address2, user_cda.address3, user_cda.city, user_cda.county, user_cda.post_code, user_cda.country, user_cda.phone
					FROM ".$this->registry->user."users
					NATURAL JOIN ".$this->registry->user."ushop_user_cda AS user_cda
					NATURAL JOIN ".$this->registry->user."ushop_user_info AS user_info
					NATURAL JOIN ".$this->registry->user."ushop_user_prefix
					NATURAL JOIN ".$this->registry->core."ushop_countries
					WHERE user_id = :user_cda_id
				", array(':user_cda_id' => $cda_id));
			else:
				$data[$c] = array('', '<b>Same as Invoice Address</b>');
			endif;

			$header = array('Delivery Address');

			$user_cda_table = Uthando::dataTable($data, $header);
			$user_cda_table->setAttributes(array('id' => 'user_cda'));
			$user_cda_table->setCellAttributes(0, 0, 'colspan="2"');

			$user_info['info'] = $user_info_table->toHtml();
			$user_info['cda'] = $user_cda_table->toHtml();
			$user_info['email'] = $email;
			return $user_info;
		else:
			return false;
		endif;
	}

	public function getMerchantInfo()
	{
		$store = $this->STORE;

		$c = 0;
		$data = array();

		foreach ($store as $key => $value):
			if ($value != ''):
				$data[$c] = array(ucwords(str_replace('_', ' ', $key)).':', $value);
				$c++;
			endif;
		endforeach;

		array_unshift($data, array('Company', $this->registry->config->get('site_name', 'SERVER')));

		$data[] = array('Phone', $this->CONTACT['phone']);
		$data[] = array('Email', $this->CONTACT['email']);

		$header = array('From');

		$table = Uthando::dataTable($data, $header);
		$table->setAttributes(array('id' => 'merchant_info'));
		$table->setCellAttributes(0, 0, 'colspan="2"');

		return $table->toHtml();
	}

	public function displayInvoice($user, $invoice)
	{

		$cb = file_get_contents('ushop/html/cart_body.html', true);
		$ci = file_get_contents('ushop/html/cart_items.html', true);
		
		if (!$uthando->ushop->CHECKOUT['vat_state']) $ci = $this->removeSection($ci, 'vat');
		if (!$uthando->ushop->CHECKOUT['vat_state']) $cb = $this->removeSection($cb, 'vat');

		$params = array(
			'COLSPAN' => ($uthando->ushop->CHECKOUT['vat_state']) ? 3 : 2,
			'CART_ITEMS' => null
		);

		try {
			$conn = $this->registry->db->getConn();

			// get invoice
			$sth = $conn->prepare("
				SELECT *
				FROM ".$this->registry->user."ushop_orders
				WHERE invoice = ".$invoice."
				AND user_id = ".$user."
			");

			$sth->execute();
			$order = $sth->fetch(PDO::FETCH_OBJ);

			// now get the order lines.
			$sth = $conn->prepare("
				SELECT *
				FROM ".$this->registry->user."ushop_order_items
				WHERE order_id = ".$order->order_id."
			");

			$sth->execute();
			$order_lines = $sth->fetchAll(PDO::FETCH_ASSOC);
			
		}
		catch(PDOException $e)
		{
			$this->registry->Error ($e->getMessage());
		}
		
		// assemble items.
		
		foreach ($order_lines as $key => $value):
			try {
				$row = $this->registry->db->getResult(
					'sku, name, image, image_status',
					$this->registry->core.'ushop_products',
					null,
					array(
						'WHERE' => 'product_id='.$value['product_id']
					),
					false
				);
			}
			catch(PDOException $e)
			{
				$this->registry->Error ($e->getMessage());
			}
			
			if (file_exists(__SITE_PATH.'/components/ushop/images/products/'.$row->image)):
				$image = $this->registry->config->get('web_url', 'SERVER').'/components/ushop/images/products/'.$row->image;
			else:
				$image = $this->registry->config->get('web_url', 'SERVER').'/components/ushop/images/noimage.png';
			endif;
			
			$item = array(
				'PRODUCT_ID' => $value['product_id'],
				'QUANTITY' => $value['quantity'],
				'SKU' => $row->sku,
				'NAME' => $row->name,
				'PRICE' => $value['item_price'],
				'VAT' => $value['tax'],
				'TOTAL' => number_format($value['item_price'] * $value['quantity'],2),
				'IMAGE' => $image,
				'IMAGE_STATUS' => 'image_'.$row->image_status
			);
			
			$tr = Uthando::templateParser($ci, $item, '{', '}');
			$params['CART_ITEMS'] .= $tr;
			
		endforeach;

		$params = array_merge($params, array(
			'POST_COST' => $order->shipping,
			'VAT_TOTAL' => $order->tax,
			'CART_TOTAL' => $order->total
		));
		
		$cart = Uthando::templateParser($cb, $params, '{', '}');

		$user_info = $this->getUserInfo($user);

		$params = array(
			'CART' => $cart,
			'USER_INFO' => $user_info['info'],
			'USER_CDA' => $user_info['cda'],
			'USER_EMAIL' => $user_info['email'],
			'MERCHANT_DETAILS' => $this->getMerchantInfo()
		);

		$html = file_get_contents('ushop/html/invoice.html', true);
		
		$html = Uthando::templateParser($html, $params, '{', '}');

		$html = preg_replace("/<th>(.*?)<\/th>/s", "", $html);

		$remove = array('delete_item', 'item_quantity_input');
		if (!$this->INVOICE['display_top']) $remove[] = 'top';
		if (!$this->INVOICE['display_bottom']) $remove[] = "bottom";

		foreach ($remove as $value) $html = $this->removeSection($html, $value);

		return $html;
	}

	public function displayCartInvoice($user)
	{
		$html = file_get_contents('ushop/html/invoice.html', true);

		$cart = $this->retrieveCart();
		$user_info = $this->getUserInfo($user);

		$params = array(
			'CART' => $cart->displayCart(),
			'USER_INFO' => $user_info['info'],
			'USER_CDA' => $user_info['cda'],
			'USER_EMAIL' => $user_info['email'],
			'MERCHANT_DETAILS' => $this->getMerchantInfo()
		);
		
		$html = Uthando::templateParser($html, $params, '{', '}');

		$html = preg_replace("/<th>(.*?)<\/th>/s", "", $html);

		$remove = array('delete_item', 'item_quantity_input');
		if (!$this->INVOICE['display_top']) $remove[] = 'top';
		if (!$this->INVOICE['display_bottom']) $remove[] = "bottom";

		foreach ($remove as $value) $html = $this->removeSection($html, $value);

		return $html;
	}

	public function insertOrder($pay_method)
	{
		
		$cart = $this->retrieveCart();

		// check if order hasn't already been inserted.
		if (!$cart->cart) return false;

		$items = $cart->calculateCartItems();
		$cart->calculatePostage();
		$cart_totals = $cart->getCartTotals();
		
		$conn = $this->registry->db->db;
		try
		{
			$conn->beginTransaction();

			$sth = $conn->prepare("
				SELECT MAX(invoice) as invoice, status.order_status_id
				FROM ".$this->registry->user."ushop_orders, (
					SELECT order_status_id
					FROM ".$this->registry->core."ushop_order_status
					WHERE order_status = 'Waiting for Payment'
				) as status
			");
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_OBJ);
			
			$invoice_no = $result->invoice + 1;

			$query = "
				INSERT INTO ".$this->registry->user."ushop_orders (user_id, order_status_id, invoice, total, shipping, tax, payment_method)
				VALUES (".$_SESSION['user_id'].", ".$result->order_status_id.", ".$invoice_no.", ".$cart_totals['CART_TOTAL'].", ".$cart_totals['POST_COST'].", ".$cart_totals['VAT_TOTAL'].", '".$pay_method."')
			";
			
			$res = $conn->exec($query);

			if ($res):
				$id = $conn->lastInsertId();
				
				$sth = $conn->prepare("
					INSERT INTO ".$this->registry->user."ushop_order_items
					(user_id, order_id, product_id, quantity, item_price, tax)
					VALUES (:user, :order, :product, :qty, :price, :tax)
				");
				
				if ($this->CHECKOUT['stock_control']):
					$admin_conn = $this->getAdminConn();
					$qty_update = $admin_conn->prepare("
						UPDATE ".$this->registry->core."ushop_products
						SET quantity = quantity - :qty
						WHERE product_id = :pid
					");
				endif;

				foreach ($items as $value):
					$params = array(
						':user' => $_SESSION['user_id'],
						':order' => $id,
						':product' => $value['PRODUCT_ID'],
						':qty' => $value['QUANTITY'],
						':price' => $value['PRICE'],
						':tax' => $value['VAT']
					);
					$sth->execute($params);
					if ($this->CHECKOUT['stock_control']) $qty_update->execute(array(':qty' => $value['QUANTITY'], ':pid' => $value['PRODUCT_ID']));
					
				endforeach;
				
			endif;

			$conn->commit();
			
		} catch(PDOException $e)
		{
			$conn->rollBack();
			$this->registry->Error ($e->getMessage());
			return false;
		}
		
		$this->deleteCart();
		return $invoice_no;
	}
	
	private function getAdminConn()
	{
		$config = new ConfigMagik($this->registry, array('path' => $this->registry->ini_dir.'/uthandoAdmin.ini.php'));
		// connect user to database.

		$dsn = $config->get('DATABASE');
		$username = $dsn['username'];
		$password = $dsn['password'];

		$dsn = $dsn['phptype'] . ":host=" . $dsn['hostspec'] . ";dbname=" .$dsn['database'];
		
		$conn = new PDO($dsn, $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	}
	
	public function displayCartButtons()
	{
		if (isset($_SESSION['cart'])):
			$cart = $_SESSION['cart'];
		elseif (UthandoUser::authorize()):
			$cart = $this->getCart();
		endif;
		
		if (count($cart['items']) > 0):
			$buttons = '
				<div class="checkout_buttons">
				<a class="button" href="'.$this->registry->config->get('ssl_url', 'SERVER').'/ushop/view/checkout">Check Out</a>
				<a class="button" href="/ushop/view/cart">View Cart</a>
				<a class="button" href="/ushop/view/cart/action-empty">Empty Cart</a>
				</div>
			';
			return $buttons;
		endif;

		return null;
	}

	private function insertCart($cart)
	{
		$sql = $this->uthando->insert(
			array(
				'user_id' => $_SESSION['user_id'],
				'cart' => serialize($cart)
			),
			$this->registry->sessions.$this->prefix.'shoppingcart'
		);
		unset($_SESSION['cart']);
	}

	private function updateCart($cart)
	{
		$sql = $this->uthando->update(
			array(
				'cart' => serialize($cart)
			),
			$this->registry->sessions.$this->prefix.'shoppingcart',
			array(
				'WHERE' => 'user_id='.$_SESSION['user_id']
			)
		);
	}

	private function deleteCart()
	{
		if (isset($_SESSION['cart'])):
			unset($_SESSION['cart']);
		else:
			$sql = $this->uthando->remove($this->registry->sessions.$this->prefix.'shoppingcart', 'user_id='.$_SESSION['user_id']);
		endif;
	}

	private function getCart()
	{
		$sql = $this->uthando->getResult(
			'cart',
			$this->registry->sessions.$this->prefix.'shoppingcart',
			null,
			array(
				'WHERE' => 'user_id='.$_SESSION['user_id']
			),
			false
		);
		
		$cart = ($sql) ? unserialize($sql->cart) : null;
		
		return $cart;
	}
	
	public function storeCart($cart)
	{
		if (UthandoUser::authorize()):
			if ($cart->cart):
				if (!$this->getCart()):
					$this->insertCart($cart->cart);
				else:
					$this->updateCart($cart->cart);
				endif;
			else:
				$this->deleteCart();
			endif;
		else:
			$_SESSION['cart'] = $cart->cart;
		endif;
	}

	public function retrieveCart()
	{
		if (UthandoUser::authorize()):
			if (isset($_SESSION['cart'])):
				if (!$this->getCart()) $this->insertCart($_SESSION['cart']);
			endif;
			$cart = $this->getCart();
			return new UShop_ShoppingCart($this->registry, $cart);
		else:
			$cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : null;
		return new UShop_ShoppingCart($this->registry, $cart);
		endif;
	}
}

?>