<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	if (isset($this->registry->params['id'])):
		
		$form = new HTML_QuickForm('contentPage', 'post', $_SERVER['REQUEST_URI']);
		
		// Remove name attribute for xhtml strict compliance.
		$form->removeAttribute('name');
		
		$menuBar = array(
			'html' => '',
			'edit' => '',
			'params' => '',
			'cancel' => '/content/overview',
			//'preview' => '/content/preview',
   			'save' => ''
		);
		
		$this->content .= $this->makeToolbar($menuBar, 24);
		
		$menuBar = array();
		
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

			$values['params'] = serialize($values['params']);
			
			$res = $this->update($values, $this->registry->core.'pages', array('where' => 'page_id='.$this->registry->params['id']));
		
			$menuBar['back'] = '/content/overview';
			
			if ($res):
				$params['TYPE'] = 'pass';
				$params['MESSAGE'] = '<h2>Page was successfully edited.</h2>';
			else:
				$params['TYPE'] = 'error';
				$params['MESSAGE'] = '<h2>Page could not be edited.</h2>';
			endif;
		else:
		
			$row = $this->getResult('page, content, params', $this->registry->core.'pages', null, array('where'=> 'page_id='.$this->registry->params['id']),false);

			$row->params = unserialize($row->params);
		
			$form->setDefaults(Uthando::objectToArray($row));
			
			$renderer = new UthandoForm(__SITE_PATH . '/templates/' . $this->get ('admin_config.site.template'));
			
			$renderer->setFormTemplate('form');
			$renderer->setHeaderTemplate('header');
			$renderer->setElementTemplate('element');
	
			$form->accept($renderer);
			
			// output the form
			$this->content .= $renderer->toHtml();
			
			$this->loadJavaScript(array(
				'/Common/editor/tiny_mce/tiny_mce_gzip.js',
				'/components/content/js/tinyMCEGz.js',
				'/Common/editor/CodeMirror/js/codemirror.js'
			));

			$this->registry->component_js = array(
				'/components/content/js/content.js',
				'/components/content/js/editor.js',
				'/components/content/js/editorConfig.js'
			);
			
			$this->addComponentCSS();

			$this->registry->component_css = array(
				'/templates/'.$this->get ('admin_config.site.template').'/css/FileManager.css',
				'/templates/'.$this->get ('admin_config.site.template').'/css/Additions.css'
			);
			
			$session = Utility::encodeString(session_id());
			$this->addScriptDeclaration("UthandoAdmin.sid = ['" . $session[0] . "','" . $session[1] . "'];");
			
		endif;
		
		if (isset($params)):
			$params['CONTENT'] = $this->makeMessageBar($menuBar, 24);
			$this->content .= $this->message($params);
		endif;
		
	else:
		goto('/content/overview');
	endif;
endif;
?>