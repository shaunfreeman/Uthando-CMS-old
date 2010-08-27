<?php
	define ('SCHEME', (isset ($_SERVER['HTTPS'])) ? 'https://' : 'http://');
	define ('HOST', $_SERVER['HTTP_HOST']);
	
	header ('Location: ' . SCHEME . HOST . '/awstats/awstats.pl');
	ob_end_clean();
	exit;

?>