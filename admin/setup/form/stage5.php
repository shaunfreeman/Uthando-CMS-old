<?php
/*
 * Uthando CMS - Content management system.
 * Copyright (C) 2010  Shaun Freeman <shaun@shaunfreeman.co.uk>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$form = new HTML_QuickForm('setupForm', 'post', $_SERVER['REQUEST_URI']);
$form->removeAttribute('name');


if ($form->validate()):
	
	$form->freeze();

	$values = $form->process(array($uthando, 'formValues'));
	
	try{
	} catch (PDOException $e) {
		$message = '<p class="fail">'.$e->getMessage().'</p>';
		$message .= "<script>setup.error = true;</script>";
	} catch (FTPException $e) {
		$message = '<p class="fail">'.$e->getMessage().'</p>';
		$message .= "<script>setup.error = true;</script>";
	} catch (SettingsException $e) {
		$message = '<p class="fail">'.$e->getMessage().'</p>';
		$message .= "<script>setup.error = true;</script>";
	}

	print $message;

else:
	
	$form->addElement('html', '<fieldset class="formFooters"><p id="submit" class="next">Submit</p><p id="previous" class="previous">Previous</p></fieldset></div>');
	
	$renderer = new UthandoForm(SETUP_PATH . '/template');
		
	$renderer->setFormTemplate('form');
	$renderer->setHeaderTemplate('header');
	$renderer->setElementTemplate('element');
	$renderer->setElementTemplate('footer', 'submit');
			
	$form->accept($renderer);
	
	// output the form
	
			print $renderer->toHtml();
	endif;
?>