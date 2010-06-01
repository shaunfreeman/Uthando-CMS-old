
UthandoAdmin.extend({
	fileManagerProductsInit: function() {
		if ($(UthandoAdminConfig.fileManager.el)) {
			this.fileManagerInit();
			$(UthandoAdminConfig.fileManager.el).addEvent('click', function(){
				var cat = $('category').get('value').replace(/ /g, '_');
				this.manager.Directory = Uthando.resolve+'/products/'+cat;
				this.manager.show();
			}.bind(this));
		}
	},
	fileManagerCallback: function(path, file) {
		var filePath = path;
		returnpath = path.replace(Uthando.resolve+'/products/', '');
		$('edit_category').getElement('input[name=category_image]').set('value', returnpath);
		var url = this.uri.get('scheme') + '://' + this.uri.get('host').replace('admin.', '') + '/userfiles/';
		$(UthandoAdminConfig.fileManager.el).set('src', url + path);
	}
});

UthandoAdminConfig.plugins.load.push('fileManager');

UthandoAdminConfig.extend({
	fileManager: {
		enable: UthandoAdmin.fileManagerProductsInit,
		el: 'image',
		directory: '',
		selectable: true,
		filter: null
	}
});