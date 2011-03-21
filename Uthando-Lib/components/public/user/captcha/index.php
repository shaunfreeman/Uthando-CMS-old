<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );
	
// CAPTCHA ConfigArray
$captcha_config = new Config($registry, array('path' => $this->registry->ini_dir.'/user/captcha.ini.php'));

$captcha_init = $captcha_config->get('CAPTCHA');
$ttf_range = $captcha_config->get ('TTF_RANGE', 'CAPTCHA');
	
if ($captcha_init['TTF_RANGE'] != "AUTO") $ttf_range = explode (',', $captcha_config->get ('TTF_RANGE', 'CAPTCHA'));
	
$captcha_init['tempfolder'] = $_SERVER['DOCUMENT_ROOT'] . $captcha_config->get ('tempfolder', 'CAPTCHA');
	
$captcha_init['TTF_folder'] = $_SERVER['DOCUMENT_ROOT'] . $captcha_config->get ('TTF_folder', 'CAPTCHA');

$captcha_init['TTF_RANGE'] = $ttf_range;

$captcha_init['counter_filename'] =  $_SERVER['DOCUMENT_ROOT'] . $captcha_config->get ('counter_filename', 'CAPTCHA');

$captcha = new Security_HnCaptchaX1 ($captcha_init);

// Add form elements.
// add html lines.
$form->addElement('html', '<tr>');
$form->addElement('html', '<td align="center" colspan="2">');
//$form->addElement('header','captcha','Captcha Image');

$form->addElement('html', '<p>'.$captcha->display_form_part('text_notvalid').'</p>');
$form->addElement('html', '<p>'.$captcha->display_form_part('image').'</p>');
$form->addElement('html', '<p>'.$captcha->display_form_part('input').'</p>');
$form->addElement('html', '<p>'.$captcha->display_form_part('text').'</p>');

$form->addElement('html', '<div class="refresh_captcha"> <p>'.$captcha->display_form_part('refresh_text').'&nbsp;</p><p>'.$captcha->display_form_part('refresh_button').'</p><div class="both"></div></div>');

$form->addElement('html', '</td>');
$form->addElement('html', '</tr>');

$form->addElement('submit', 'submit', 'Submit');

switch($captcha->validate_submit()):

     // was submitted and has valid keys
	case 1:
		// PUT IN ALL YOUR STUFF HERE //
		$action = $this->registry->action.":validate";
		require_once('user/captcha/captcha.php');
		break;

	// was submitted, has bad keys and also reached the maximum try's
	case 3:
		if(!headers_sent() && isset($captcha->badguys_url)) header('Location: '.$this->get('config.server.web_url'));
		break;

	// was submitted with no matching keys, but has not reached the maximum try's
	case 2:
	
	// was not submitted, first entry
	default:
        // create captcha formpart
		$action = $this->registry->action.":display";
		require_once('user/captcha/captcha.php');
		break;
endswitch;
	
?>