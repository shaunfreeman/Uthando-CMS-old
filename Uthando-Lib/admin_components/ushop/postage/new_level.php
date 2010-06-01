<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$menuBar = array(
		'cancel' => '/ushop/postage/overview',
		'save' => null
	);
		
	$this->content .= $this->makeToolbar($menuBar, 24);
	
	$menuBar = array();
			
	$form = new HTML_QuickForm('add_level', 'post', $_SERVER['REQUEST_URI']);
			
	// Remove name attribute for xhtml strict compliance.
	$form->removeAttribute('name');
			
	$form->addElement('html', '<fieldset>');
	$form->addElement('header','new_level','New Post Level');
		
	$form->addElement('text', 'post_level', 'Post Level:', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox'));
			
	$form->addElement('html', '</fieldset>');
		
	$form->addRule('post_level', 'Please enter a post level', 'required');
	$form->addRule('post_level', 'Post Levels have to be a number.', 'numeric');
			
	if ($form->validate()):
			
		$form->freeze();
		$values = $form->process(array(&$this, 'formValues'), false);
			
		$menuBar['add_level'] = '/ushop/postage/action-new_level';
		$menuBar['back'] = '/ushop/postage/overview';
			
		//check then enter the record.
		if (!$this->getResult('post_level_id', $ushop->db_name.'post_levels', null, array('where' => "post_level='".$values['post_level']."'"))):
				
			$res = $this->insert($values, $ushop->db_name.'post_levels');
			
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Post level was successfully entered.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Post level could not be entered into the database.</h2>';
			endif;
		else:
			$params['TYPE'] = 'warning';
			$params['MESSAGE'] = '<h2>This post level already exits.</h2>';
		endif;	
		// done!
	else:
				
		$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $template);
			
		$renderer->setFormTemplate('form');
		$renderer->setHeaderTemplate('header');
		$renderer->setElementTemplate('element');
		
		$form->accept($renderer);
		
		// output the form
		$this->content .= $renderer->toHtml();
	endif;
	
	if (isset($params)):
		$params['CONTENT'] = $this->makeMessageBar($menuBar, 24);
		$this->content .= $this->message($params);
	endif;
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>