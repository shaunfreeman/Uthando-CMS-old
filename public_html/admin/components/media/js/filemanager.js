window.addEvent('domready', function(){
	UthandoAdmin.manager = new FileManager({
		url: '/plugins/ajax_content/filemanager.php',
		assetBasePath: '/templates/admin/images/FileManager',
		language: 'en',
		selectable: /*{SELCETABLE}*/,
		uploadAuthData: {
			session: '/*{SESSION_ID}*/',
			folder: '/*{FOLDER}*/',
			filter: /*{FILTER}*/
		},
		onComplete: UthandoAdmin.fileManagerCallback
	});
	/*{MANAGER_INIT_CODE}*/
});