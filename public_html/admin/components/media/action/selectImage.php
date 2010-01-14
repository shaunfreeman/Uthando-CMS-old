<?php

include('../Backend/FileManager.php');

$browser = new FileManager(array(
	'document_base_url' => 'http://uthandocms/',
	'directory' => $_SERVER['DOCUMENT_ROOT'].'/../userfiles',
	'assetBasePath' => '../Assets',
	'upload' => true,
	'destroy' => true,
	'filter' => 'image/',
));

$browser->fireEvent(!empty($_GET['event']) ? $_GET['event'] : null);
