<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class UShop_Payment_Paypal_IPN extends UShop_Payment_Paypal
{
	private $last_error = '';                 // holds the last error encountered
	private $ipn_log = true;                    // bool: log IPN results to text file?
	private $ipn_log_file = 'paypalIPN.log';               // filename of the IPN log
	private $ipn_response = '';               // holds the IPN response from paypal
	public $ipn_data = array();         // array contains the POST values for IPN

	public function __construct($registry)
	{
		parent::__construct($registry);
	}

	public function validateIPN()
	{
		// parse the paypal URL
		$url_parsed = parse_url($this->paypal_url);

		// generate the post string from the _POST vars aswell as load the
		// _POST vars into an array so we can play with them from the calling
		// script.
		$post_string = '';

		foreach ($_POST as $field => $value):
			$this->ipn_data[$field] = $value;
			$post_string .= $field.'='.urlencode(stripslashes($value)).'&';
		endforeach;
		
		//if ($this->ipn_data['txn_type'] != 'cart') return;
		
		$post_string.="cmd=_notify-validate"; // append ipn command

		// open the connection to paypal
		if ($url_parsed['scheme'] == "https"):
			$url_parsed['port']="443";
			$ssl="ssl://";
		else:
			$url_parsed['port']="80";
		endif;

		$fp = fsockopen($ssl . $url_parsed['host'], $url_parsed['port'], $err_num, $err_str, 300);
		
		if (!$fp):
			
			// could not open the connection.  If loggin is on, the error message
			// will be in the log.
			$this->last_error = "fsockopen error no. $errnum: $errstr";
			$this->logIPNResults(false);
			return false;
			
		else:
			stream_set_timeout($fp, 300);
			// Post the data back to paypal
			fputs($fp, "POST ".$url_parsed['path']." HTTP/1.1\r\n");
			fputs($fp, "Host: ".$url_parsed['host'].":".$url_parsed['port']."\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ".strlen($post_string)."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $post_string . "\r\n\r\n");

			// loop through the response from the server and append to variable
			while(!feof($fp)) $this->ipn_response .= fgets($fp, 1024);

			fclose($fp); // close connection

		endif;
		
		if (eregi("VERIFIED", $this->ipn_response)):

			// Valid IPN transaction.
			$this->logIPNResults(true);
			return true;
			
		else:

			// Invalid IPN transaction.  Check the log for details.
			$this->last_error = 'IPN Validation Failed.';
			$this->logIPNResults(false);
			return false;
			
		endif;
	}
	
	// Method to do.
	public function verifyIPNResults($results)
	{
	}

	public function logIPNResults($success)
	{
		if (!$this->ipn_log) return;  // is logging turned off?

		// Timestamp
		$text = '['.date('m/d/Y g:i A').'] - ';

		// Success or failure being logged?
		if ($success):
			$text .= "SUCCESS!\n";
		else:
			$text .= 'FAIL: '.$this->last_error."\n";
		endif;

		// Log the POST variables
		$text .= "IPN POST Vars from Paypal:\n";
		foreach ($this->ipn_data as $key=>$value) $text .= "$key=$value, ";

		// Log the response from the paypal server
		$text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;
		
		$ftp = new File_FTP($this->registry);
		
		if ($ftp):
			
			$logs = __SITE_PATH.'/../../uthando/logs';
			
			if (!is_file($logs.'/'.$this->ipn_log_file)) $this->makeLogFile();
			
			$ftp->chmod($ftp->uthando_dir.'/logs/'.$this->ipn_log_file, 0646);
			// Write to log
			file_put_contents($logs.'/'.$this->ipn_log_file, $text . "\n\n", FILE_APPEND);
			$ftp->chmod($ftp->uthando_dir.'/logs/'.$this->ipn_log_file, 0644);
			
		endif;
	}
	
	private function makeLogFile()
	{
		if (!is_dir($logs)) $dir = $ftp->mkdir($ftp->uthando_dir.'/logs');
				
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/Common/tmp/'.$this->ipn_log_file, '');
		
		$f = $ftp->put($_SERVER['DOCUMENT_ROOT'] . '/Common/tmp/'.$this->ipn_log_file, $ftp->uthando_dir.'/logs/'.$this->ipn_log_file, true);
		
		unlink($_SERVER['DOCUMENT_ROOT'] . '/Common/tmp/'.$this->ipn_log_file);
		
		$ftp->chmod($ftp->uthando_dir.'/logs', 0755);
	}
}

?>