<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($this->registry->params['id'])):
		
		$form = new HTML_QuickForm('contentPage', 'post', $_SERVER['REQUEST_URI']);
		
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
		
		$form->addElement('html', '<div id="edit_params">');
		
		$form->addElement('text', 'page', 'Page Title:', array('size' => 50, 'maxlength' => 255, 'class' => 'inputbox'));

		$form->addElement('html', '<fieldset>');
		$form->addElement('header','parameters','Parameters');

		$params = array('show_title', 'show_cdate', 'show_mdate');

		foreach ($params as $value):
			$radio_set = array(
				$form->createElement('radio', null, null, 'Yes', '1'),
				$form->createElement('radio', null, null, 'No', '0')
			);
			
			$form->addGroup($radio_set, 'params['.$value.']', ucwords(str_replace('_', ' ', $value)).':');
		endforeach;

		$form->addElement('html', '</fieldset>');

		$form->addElement('html', '<fieldset>');
		$form->addElement('header','metadata','Metadata');

		$form->addElement('textarea', 'params[metadata][description]', 'Description:');
		$form->addElement('textarea', 'params[metadata][keywords]', 'Keywords:');
		
		$form->addElement('html', '</fieldset>');
		
		$form->addElement('html', '</div>');
		
		$form->addElement('html', '<div id="edit_html">');

		$form->addElement('textarea', 'content', null, array('id' => 'content_textarea', 'class' => 'mceEditor'));
		
		$form->addElement('html', '</div>');
		
		$form->addRule('page', 'Please enter a title', 'required');
		
		if ($form->validate()):
			
			// Apply form element filters.
			$form->freeze();
			$values = $form->process(array(&$this, 'formValues'));
			
			//$values['params'] = serialize($values['params']);
			$p = null;
			foreach ($values['params'] as $key => $value):
				if (is_array($value)):
					$p .= "[".$key."]\n";
					foreach ($value as $key2 => $value2):
						$p .= $key2." = \"".$value2."\"\n";
					endforeach;
				else:
					$p .= $key." = \"".$value."\"\n";
				endif;
			endforeach;
			
			$values['params'] = $p;
			
			$res = $this->update($values, $this->registry->core.'pages', array('where' => 'page_id='.$this->registry->params['id']));
		
			$menuBar['back'] = '/content/overview';
			
			if ($res):
				$ed_message['TYPE'] = 'pass';
				$ed_message['MESSAGE'] = '<h2>Page was successfully edited.</h2>';
			else:
				$ed_message['TYPE'] = 'error';
				$ed_message['MESSAGE'] = '<h2>Page could not be edited.</h2>';
			endif;
		else:
		
			$row = $this->getResult('page, content, params', $this->registry->core.'pages', null, array('where'=> 'page_id='.$this->registry->params['id']),false);

			$row->params = parse_ini_string($row->params,true);
		
			$form->setDefaults(Uthando::objectToArray($row));
			
			$renderer = new UthandoForm(TEMPLATES . $this->get ('admin_config.site.template'));
			
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
	
			$form->accept($renderer);
			
			// output the form
			$menuBar = array(
				'html' => '',
				'edit' => '',
				'params' => '',
				'cancel' => '/'.$this->registry->component.'/overview',
				//'preview' => '/content/preview',
				'save' => ''
			);
		
			$this->content .= $this->makeToolbar($menuBar, 24);
			$this->content .= $renderer->toHtml();
			
			$this->loadJavaScript(array(
				'/editors/tiny_mce/tiny_mce_gzip.js',
				'/uthando-js/uthando/admin/tinyMCEGz.js',
				'/editors/CodeMirror/js/codemirror.js'
			));
			
			$this->addComponentJS(array('article','editor', 'editorConfig'));
			$this->addComponentCSS(array('FileManager','Additions'));
			
			$session = Utility::encodeString(session_id());
			$this->addScriptDeclaration("UthandoAdmin.sid = ['" . $session[0] . "','" . $session[1] . "'];");
			
		endif;
		
		if (isset($ed_message)):
			$ed_message['CONTENT'] = $this->makeMessageBar($menuBar, 24);
			$this->content .= $this->message($ed_message);
		endif;
		
	else:
		Uthando::go('/'.$this->registry->component.'/overview');
	endif;
endif;
?>