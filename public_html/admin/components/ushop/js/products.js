
UthandoAdminConfig.plugins.load.push('tinyMCE');

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
		el: 'image',
		pathPrefix: '',
		file: true
	}
});

