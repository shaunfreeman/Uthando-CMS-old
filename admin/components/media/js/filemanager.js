UthandoAdminConfig.plugins.load.push('fileManager');

UthandoAdminConfig.extend({
	fileManager: {
		enable: UthandoAdmin.fileManagerInit,
		el: false,
		directory: '',
		pathPrefix: '/userfiles/',
		file: false,
		selectable: false,
		filter: null
	}
});