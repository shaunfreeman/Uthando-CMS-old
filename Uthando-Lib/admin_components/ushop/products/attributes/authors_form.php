<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):
	
	$authors = $this->getResult('author_id, forename, surname', $ushop->db_name.'authors');

	//$author_radio[] = $form->createElement('radio', null, null, 'new', '1');
	//$author_radio[] = $form->createElement('radio', null, null, 'Existing', '0');
	//$form->addGroup($author_radio, 'author', 'Author:');
		
	if ($authors):
			
		$authors_s = $form->createElement('select', 'author_id', 'Author:');
		$authors_opts[0] = 'Select One';
			
		foreach ($authors as $value):
			$authors_opts[$value->author_id] = HTML_Element::makeXmlSafe($value->forename, true) . ' ' . HTML_Element::makeXmlSafe($value->surname, true);
		endforeach;
		
		$authors_s->loadArray($authors_opts);
		$form->addElement($authors_s);
		$errors[] = 'author_id';
	else:
		$authors = $this->templateParser($tmpl, array('LABEL' => 'Authors:', 'ELEMENT' => 'No authors aviliable'), '{', '}');
		$form->addElement('html', $authors);
	endif;
	
	$form->addRule('author_id', 'Please select an author.', 'required');
	$form->addRule('author_id', 'Please select an author.', 'nonzero');

endif;
?>