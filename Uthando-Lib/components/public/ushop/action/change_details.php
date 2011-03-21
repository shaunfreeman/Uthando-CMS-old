<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if (UthandoUser::authorize()):

	$sql = "
		SELECT user_info_id, prefix_id, country_id, user_cda_id, address1, address2, address3, city, county, post_code, phone
		FROM ".$this->ushop->db_name."user_info
		WHERE user_id=:user_id
	";
		
	$user = $this->registry->db->getRow($sql, array(
		':user_id' => $_SESSION['user_id']
	));

	$form = new HTML_QuickForm('user_details', 'post', $_SERVER['REQUEST_URI']);

	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');

	$prefix = $this->registry->db->query("
		SELECT prefix_id, prefix
		FROM ".$this->ushop->db_name."user_prefix
	");
	
	foreach ($prefix as $value):
		$prefix_opts[$value->prefix_id] = $value->prefix;
	endforeach;

	$s = $form->createElement('select', 'prefix_id', 'Prefix:', null, array('class' => 'selectbox'));
	$s->loadArray($prefix_opts);
	$form->addElement($s);

	$form->addElement('html', '<tr><td align="right" valign="top"><b>Name:</b></td><td>'.$_SESSION['name'].'</td></tr>');

	$form->addElement('text', 'address1', 'Address Line 1:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));

	$form->addElement('text', 'address2', 'Address Line 2:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));

	$form->addElement('text', 'address3', 'Address Line 3:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));

	$form->addElement('text', 'city', 'City:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));

	$form->addElement('text', 'county', 'County:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));

	$form->addElement('text', 'post_code', 'Post Code:', array('size' => 30, 'maxlength' => 100, 'class' => 'inputbox'));

	$country = $this->registry->db->query("
		SELECT country_id, country
		FROM ".$this->ushop->db_name."countries
	");
	
	foreach ($country as $value):
		$country_opts[$value->country_id] = $value->country;
	endforeach;

	$s = $form->createElement('select', 'country_id', 'Country:', null, array('class' => 'selectbox'));
	$s->loadArray($country_opts);
	$form->addElement($s);

	$form->addElement('text', 'phone', 'Phone Number:', array('size' => 20, 'maxlength' => 100, 'class' => 'inputbox'));

	$form->addRule('address1', 'Please enter the first line of your address', 'required');
	$form->addRule('city', 'Please enter your city', 'required');
	$form->addRule('county', 'Please enter your county', 'required');
	$form->addRule('post_code', 'Please enter your postcode', 'required');
	$form->addRule('country_id', 'Please enter your country', 'required');
	$form->addRule('phone', 'Please enter your phone number', 'required');

	if ($form->validate()):

		$form->applyFilter('__ALL__', 'escape_data');
			
		$form->freeze();
		$values = $form->process(array(&$this, 'formValues'), false);

		try
		{
			$res = $this->registry->db->update($values,$this->ushop->db_name.'user_info', array('WHERE' => 'user_info_id='.$user->user_info_id));
		}
		catch (PDOException $e)
		{
			$this->registry->Error ($e->getMessage());
		}

		Uthando::go('/ushop/checkout');

	else:

		$form->setDefaults(array(
			'prefix_id' => $user->prefix_id,
			'address1' => $user->address1,
			'address2' => $user->address2,
			'address3' => $user->address3,
			'city' => $user->city,
			'county' => $user->county,
			'post_code' => $user->post_code,
			'country_id' => $user->country_id,
			'phone' => $user->phone
		));
			
		$form->addElement('submit', null, 'Send', array('class' => 'button'));
			
		// Output the form
		$this->addContent('<div id="products">');
		$this->addContent($form->toHtml());
		$this->addContent('</div>');
	endif;

else:
	header("Location" . $this->registry->config->get('web_url', 'SERVER'));
	exit();
endif;
