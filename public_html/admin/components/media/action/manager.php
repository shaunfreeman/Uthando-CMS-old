<?php

try {
	if (Uthando::authorize()) {

		// Please add your own authentication here
		function UploadIsAuthenticated($get){
			if(!empty($get['session'])) return true;

			return false;
		}

		$browser = new FileManager(array(
			'document_base_url' => 'http://uthandocms/',
			'directory' => $_SERVER['DOCUMENT_ROOT'].'/../userfiles',
			'assetBasePath' => $_SERVER['DOCUMENT_ROOT'].'/templates/admin/images/FileManager',
			'upload' => true,
			'destroy' => true,
		));

		$browser->fireEvent(!empty($_GET['event']) ? $_GET['event'] : null);
	} else {
		throw new FileManagerException('authenticated');
	}
} catch(FileManagerException $e) {
	echo json_encode(array(
		'status' => 0,
		'error' => '${upload.'.$e->getMessage().'}',
	));
}

?>