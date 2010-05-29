
var Webmail = new Class ({
	Implements: [Options, Events],
	
	Request: null,
	Directory: null,
	Current: null,
	
	options: {
		/*onComplete: $empty,
		onModify: $empty,
		onShow: $empty,
		onHide: $empty,*/
		directory: '',
		url: null,
		assetBasePath: null,
		selectable: false,
		hideOnClick: true,
		language: 'en'
	},
	
	initialize: function(options) {
		this.setOptions(options);
		this.options.assetBasePath = this.options.assetBasePath.replace(/(\/|\\)*$/, '/');
		this.droppables = [];
		
		this.language = FileManager.Language[this.options.language] || FileManager.Language.en;
		
	},
	
	onDragStart: $empty,
	onDragComplete: $lambda(false)
});

window.addEvent('domready',function() {
	UthandoAdmin.Webmail = new Webmail({
		url: '/plugins/ajax_content/webmail.php',
		assetBasePath: '/templates/admin/images/FileManager',
		language: 'en'
	});
});