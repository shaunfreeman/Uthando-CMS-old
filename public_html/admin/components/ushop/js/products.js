
UthandoAdmin.extend({
	fileManagerProductsInit: function() {
		if ($(UthandoAdminConfig.fileManager.el)) {
			this.fileManagerInit();
			$(UthandoAdminConfig.fileManager.el).addEvent('click', function(){
				var cat = $('category').getElements(':selected')[0].text.replace(/ /g, '_');
				var dir = (cat == 'Select_One') ? Uthando.resolve+'/products' : Uthando.resolve+'/products/'+cat
				this.manager.Directory = dir;
				this.manager.show();
			}.bind(this));
		}
	}
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
		enable: UthandoAdmin.fileManagerProductsInit,
		el: 'image',
		pathPrefix: '',
		directory: '',
		file: true,
		selectable: true,
		filter: null
	}
});
