<?php
// no direct access
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );

if ($this->ushop->global['offline'] || $this->ushop->global['catelogue_mode']):
	$this->addContent('<h3>Shopping is unavialible</h3><p><a href="/ushop/view/shopfront">Click here to continue</a></p>');
else:
	if (UthandoUser::authorize()):
		
		foreach ($this->ushop->checkout as $key => $value):
			if (preg_match('/^pay_/', $key) && $value) $payment_options[] = $key;
		endforeach;

		$this->addContent('<div id="products">');
		
		$form = new HTML_QuickForm('order_confirm', 'post', $this->get('config.server.ssl_url').'/ushop/view/checkout/stage-2');

		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');

		$form->addElement('header', null, 'Choose a payment option:');
		
		foreach ($payment_options as $value):
			$value = str_replace('pay_', '', $value);
			$form->addElement('radio', 'payment_method', ucwords(str_replace('_', ' ', $value)).':', null, $value);
		endforeach;

		$form->addElement('header', null, 'Additional requirements:');

		$form->addElement('textarea', 'requirements', null, array('class' => 'text_area'));

		$s = $form->createElement('select', 'terms', 'I agree to the Terms of Service:', null, array('class' => 'selectbox'));
		$s_opts = array(2 => 'Select One', 1 => 'Yes', 0 => 'No');
	
		$s->loadArray($s_opts);
		$form->addElement($s);

		$form->addRule('terms', 'You have to agree to the teams', 'required');
		$form->addRule('terms', 'You have to agree to the teams', 'regex', '/^1$/');
		$form->addRule('payment_method', 'Please select a payment method', 'required');
		
		if ($form->validate()):

			// Apply form element filters.
			$form->applyFilter('__ALL__', 'escape_data');
				
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);

			$pay_method = str_replace('_', ' ', $values['payment_method']);

			$invoice = $this->ushop->insertOrder($pay_method);
			
			if ($invoice):
				
				// email order to user and merchant.
				// get mail config.
				$this->registry->mail_config = new Config($this->registry, array('path' => $this->registry->ini_dir.'/mail.ini.php'));

				// get mailer type and call class instance.
				$mailer = $this->registry->mail_config->get('type', 'mailer');

				$mail = new Mailer($mailer, $this->registry);

				$mail->setMailBody($this->ushop->displayInvoice($_SESSION['user_id'], $invoice));

				if ($values['requirements']) $mail->addMailBody('<p>'.$values['requirements'].'</p>');
				$mail->addMailBody('<p><b>Payment Method: </b>'.$pay_method.'</p>');

				$mail->addCSS(file_get_contents('ushop/css/ushop.css', true));

				$email_type = 'html';
				$mail->setEmailType($email_type);

				$user = $this->registry->db->getRow("
					SELECT email
					FROM ".$this->registry->user."users
					WHERE user_id = :user
				", array(':user' => $_SESSION['user_id']));

				// set some headers.
				$headers = array(
					'From' => $this->ushop->checkout['orders_email'],
					'To' => $user->email,
					 'Subject' => 'Purchase Order form  - ' . $this->get('config.server.site_name') . ': Invoice #' . $invoice,
					'MIME-Version' => "1.0",
					'X-Priority' => "1",
					'Content-Type' => 'text/'.$email_type.'; charset="utf-8"',
					'X-Mailer: PHP' => phpversion()
				);

				$mail->setHeaders($headers);

				// mail to customer.
				$mail->setRecipients($user->email);

				$sent_mail = $mail->send();

				if (PEAR::isError($sent_mail)):
					$this->registry->Error ($sent_mail->getMessage(), 'email failed due to a system error');
				endif;

				// mail to merchant.
				$mail->setHeaders(array(
					'From' => $user->email,
					'To' => $this->ushop->checkout['orders_email']
				));

				// mail to customer.
				$mail->setRecipients($this->ushop->checkout['orders_email']);

				$sent_mail = $mail->send();

				if (PEAR::isError($sent_mail)):
					$this->registry->Error ($sent_mail->getMessage(), 'email failed due to a system error');
				endif;

				// load payment info.
				define( 'SHOP_STAGE_2', 1 );
				require_once('ushop/checkout/payment/'.$values['payment_method'].'.php');
				
			else:
				Uthando::go();
			endif;
			
		else:
			
			$form->addElement('submit', null, 'Submit Order', array('class' => 'button'));
			
			// Output the form
			$title .= ' - Comfirm Order';
			$this->addContent('<h2>Confirm Order: Step 2 of 3</h2>');
			$this->addContent($this->ushop->displayCartInvoice($_SESSION['user_id']));
			$this->addContent($form->toHtml());
		endif;

		$this->addContent('</div>');
		
	else:
		Uthando::go();
	endif;
endif;
?>