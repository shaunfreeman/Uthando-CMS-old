
UthandoAdmin.extend({
});

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
		enable: UthandoAdmin.fileManagerInit,
		el: 'image',
		pathPrefix: '',
		directory: 'products',
		file: true,
		selectable: true,
		filter: null
	}
});

