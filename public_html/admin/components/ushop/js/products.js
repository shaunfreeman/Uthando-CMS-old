
UthandoAdminConfig.plugins.load.push('tinyMCE', 'fileManager');

UthandoAdminConfig.extend({
	tinyMCE: {
		enable: UthandoAdmin.tinyMCEInit,
		tinyMCEElements: {
			textarea: {}
		},
		options: {
			mode : "textareas",
			theme : "simple"
		}
	},
	fileManager: {
		enable: UthandoAdmin.enableFileManager,
		el: 'image',
		pathPrefix: '',
		file: true
	}
});

