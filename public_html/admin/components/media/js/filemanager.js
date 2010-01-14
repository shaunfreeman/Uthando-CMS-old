
window.addEvent('domready', function(){
	var manager = new FileManager({
		url: '/plugins/ajax_content/filemanager.php',
		assetBasePath: '/templates/admin/images/FileManager',
		language: 'en',
		uploadAuthData: {session: '{SESSION_ID}'}
	});

	manager.show();
});