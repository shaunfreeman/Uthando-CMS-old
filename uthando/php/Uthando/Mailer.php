<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Mailer {

	private $css = null;
	private $headers = array();
	private $template;
	private $body = 'components/mail/templates/default.html';
	private $mail_body = '';
	private $mail;
	private $recipients;
	private $email;
	protected $registry;
	
	public function __construct($mailer, $registry) {
		$this->registry = $registry;
		$params = $this->getParams($mailer);
		
		$this->mail = Mail::factory($mailer, $params);
	}
	
	public function __destruct() {
		unset($this);
	}
	
	private function getParams($mailer) {
		
		switch ($mailer) {
			case 'mail':
				return $this->registry->mail_config->get('mail');
				break;
			case 'sendmail':
				return $this->registry->mail_config->get('sendmail');
				break;
			case 'smtp':
				return $this->registry->mail_config->get('smtp');
				break;
		}
	}
	
	private function createMailBody() {
		$email = new HTML_Page();
		$email->setTitle(ucwords($this->template));
		$email->setMetaData("content-type", "text/html; charset=utf-8", true);
		$email->setMetaData("Content-Language", "english");
		if ($this->css) $email->addStyleDeclaration($this->css);
		$email->xmlProlog = false;
		
		switch ($this->email_type) {
			case 'html':
				$email->addBodyContent($this->mail_body);
				break;
			case 'plain':
				$email->addBodyContent(html_entity_decode(strip_tags($this->mail_body),ENT_QUOTES, 'UTF-8'));
				break;
		}
		
		return $email->toHTML();
	}
	
	public function setTemplate($template) {
		$this->template = $template;
	}
	
	private function getTemplate($params) {
		
		$sql = "
			SELECT body
			FROM email_body
			WHERE template='".$this->template."'
		";
		
		$message = $this->registry->db->getRow($sql);
		
		if (PEAR::isError($message)) {
			
			$this->registry->Error ($message->getMessage(), $message->getDebugInfo ());
			$this->setMailBody(PEAR::raiseError('Database query failed.'));
		
		} else {
			
			$message->body = Uthando::templateParser($message->body, $params, '####', '####');
			
			$this->setMailBody($message->body);
		}
		
	}

	public function addCSS($css) {
		$this->css .= $css;
	}

	public function setMailBody($body) {
		$this->mail_body = $body;
	}

	public function addMailBody($body) {
		$this->mail_body .= $body;
	}
	
	public function setHeader($key, $value) {
		$this->headers[$key] = $value;
	}
	
	public function setHeaders($array) {
		foreach ($array as $key => $value) {
			$this->headers[$key] = $value;
		}
	}
	
	public function setRecipients($recipients) {
		$this->recipients = $recipients;
	}
	
	public function setEmailType($type) {
		$this->email_type = $type;
	}
	
	public function send($params=null) {
		
		if ($params) $this->getTemplate($params);
		
		if (is_a($this->mail_body, 'PEAR_Error')) {
			return $this->mail_body;
		}

		//$this->createMailBody($this->mail_body);
		
		return $this->mail->send($this->recipients, $this->headers, $this->createMailBody());
	}

}

?>