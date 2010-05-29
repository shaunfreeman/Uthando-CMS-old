<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class Mail_IMAP
{
	private $mbox;
	private $options = array();
	private $post;
	private $get;
	
	public function __construct($options=array())
	{
		$this->options = array_merge(array(
			'mboxconnstr' => '{localhost:143/imap/notls}',
			'username' => 'shaunfre',
			'password' => 'lusatacr'
		), $options);
		
		$this->mbox = imap_open($this->options['mboxconnstr'], $this->options['username'], $this->options['password']);
		
		header('Expires: Fri, 01 Jan 1990 00:00:00 GMT');
		header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		
		$this->get = $_GET;
		$this->post = $_POST;
	}
	
	public function fireEvent($event)
	{
		$event = $event ? 'on' . ucfirst($event) : null;
		if (!$event || !method_exists($this, $event)) $event = 'onView';
		$this->{$event}();
	}
}

?>