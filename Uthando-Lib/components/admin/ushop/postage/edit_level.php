<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if ($this->registry->params['id']):
		
		$rows = $this->getResult('post_level_id, post_level', $ushop->db_name.'post_levels',null, array('where' => 'post_level_id = '.$this->registry->params['id']));
			
		$form = new HTML_QuickForm('edit_level', 'post', $_SERVER['REQUEST_URI']);
			
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
			
		$form->addElement('html', '<fieldset>');
		$form->addElement('header','edit_level','Edit Post Level');
		
		$form->addElement('text', 'post_level', 'Post Level:', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox'));
			
		$form->addElement('html', '</fieldset>');
		
		$form->addRule('post_level', 'Please enter a post level', 'required');
		$form->addRule('post_level', 'Post Levels have to be a number.', 'numeric');
			
		if ($form->validate()):
			
			$menuBar = array();
			
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'), false);
			
			$menuBar['back'] = '/ushop/postage/overview';
			
			//check then enter the record.
			$res = $this->update($values, $ushop->db_name.'post_levels', array('where' => 'post_level_id='.$this->registry->params['id']));
			
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Post Level was successfully edited.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Post Level could not be edited due to an error.</h2>';
			endif;
			// done!
		else:
			
			$menuBar = array(
				'cancel' => '/ushop/postage/overview',
				'save' => null
			);
				
			$this->content .= $this->makeToolbar($menuBar, 24);
				
			$form->setDefaults(array(
   			'post_level' => $rows[0]->post_level,
			));
				
			$renderer = new UthandoForm(TEMPLATES . $template);
			
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
	endif;
else:
	header("Location:" . $this->get('config.server.web_url'));
	exit();
endif;
?>