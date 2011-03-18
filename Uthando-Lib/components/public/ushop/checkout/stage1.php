<?php
// no direct access
defined( 'SHOP_PARENT_FILE' ) or die( 'Restricted access' );

$title .= ' - Comfirm Address';

if ($this->ushop->global['offline'] || $this->ushop->global['catelogue_mode']):
	$this->addContent('<h3>Shopping is unavialible</h3><p><a href="/ushop/view/shopfront">Click here to continue</a></p>');
else:
	if (UthandoUser::authorize()):
		
		// check to see if user has a registered address, if not create one now.
		$user_info = $this->ushop->getUserInfo($_SESSION['user_id']);
		
		if ($user_info):
			// comfirm delivery address, or edit it.

			$this->addContent('<h2>Confirm Address: Step 1 of 3</h2>');

			$this->addContent($user_info['info']);
			$this->addContent($user_info['cda']);
			$this->addContent('<div class="both"></div>');
			$this->addContent('<div id="products"><a href="'.$this->get('config.server.ssl_url').'/ushop/user/change_details" class="button">Update Details</a><p>Please click confirm address to continue to check out.</p><a href="'.$this->get('config.server.ssl_url').'/ushop/checkout/stage-2" class="button">Confirm Address</a></div>');
			
		else:
			// no address, create one.
			$this->addContent('<div id="products">');
			require_once('ushop/user/user_details_form.php');
			$this->addContent('</div>');
		endif;
		
	else:
		header("Location" . $this->get('config.server.web_url'));
		exit();
	endif;
endif;
?>