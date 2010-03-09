<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );
	
// CAPTCHA ConfigArray
$captcha_config = new Config($registry, array('path' => $this->registry->ini_dir.'/user/captcha.ini.php'));

$captcha_init = $captcha_config->get('CAPTCHA');
$ttf_range = $captcha_config->get ('TTF_RANGE', 'CAPTCHA');
	
if ($captcha_init['TTF_RANGE'] != "auto"):
	$ttf_range = explode (',', $captcha_config->get ('TTF_RANGE', 'CAPTCHA'));
endif;
	
$captcha_init['tempfolder'] = $_SERVER['DOCUMENT_ROOT'] . $captcha_config->get ('tempfolder', 'CAPTCHA');
	
$captcha_init['TTF_folder'] = $_SERVER['DOCUMENT_ROOT'] . $captcha_config->get ('TTF_folder', 'CAPTCHA');

$captcha_init['TTF_RANGE'] = $ttf_range;

$captcha_init['counter_filename'] =  $_SERVER['DOCUMENT_ROOT'] . $captcha_config->get ('counter_filename', 'CAPTCHA');

$captcha = new Security_HnCaptchaX1 ($captcha_init);

// Add form elements.
// add html lines.
$form->addElement('html', '<tr><td colspan="2" style="text-align:center;">'.$captcha->display_form_part('text_notvalid').'</td></tr>');
$form->addElement('html', '<tr><td colspan="2" style="text-align:center;">'.$captcha->display_form_part('image').'</td></tr>');
$form->addElement('html', '<tr><td colspan="2" style="text-align:center;">'.$captcha->display_form_part('input').'</td></tr>');
$form->addElement('html', '<tr><td colspan="2" style="text-align:center;">'.$captcha->display_form_part('text').'</td></tr>');
		
$form->addElement('submit', null, 'Send', array('class' => 'button'));

$form->addElement('html', '<tr><td align="right"><b>'.$captcha->display_form_part('refresh_text').'</b></td><td align="left">'.$captcha->display_form_part('refresh_button').'</td></tr>');

switch($captcha->validate_submit()):

     // was submitted and has valid keys
	case 1:
		// PUT IN ALL YOUR STUFF HERE //
		$action = $this->registry->action.":validate";
		require_once('captcha.php');
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
		require_once('captcha.php');
		break;
endswitch;
	
?>