
var UShopManager = new Class({
	
	Implements: [Events, Options],
	
	options: {
		url: '/plugins/ajax_content/ushopmanager.php',
		html: '<div id="Header" class="headerDiv"><span id="HeaderText">UShop Control Panel</span><div id="closeBox">X</div></div><div id="UShopControlPanelContent"></div>',
		contentId: 'UShopControlPanelContent'
	},
	
	action: null,
	update: null,
	
	initialize: function(options) {
		this.setOptions(options);
		this.controlPanel = new Element('div', {
			id: 'ushop_control_panel',
			html: this.options.html
		}).inject(document.body);
		this.stickyWinInit();
	},
	
	stickyWinInit: function() {
		this.stickyWin = new StickyWin.Modal({
			content: $('ushop_control_panel'),
			className: 'sticky_win',
			showNow: false,
			maskOptions: {
				style: {
					'background-color': '#000',
					'opacity': .8,
					'cursor': 'pointer'
				}
			},
			closeOnEsc: true,
			onClose: this.hide.bind(this)
		});
	},
	
	hide: function() {
		$('closeBox').removeEvent('click');
		$(this.options.contentId).empty();
	},
	
	show: function() {
		this.stickyWin.show();
		$('closeBox').addEvent('click', this.closeBox.bind(this));
		new Request.HTML({
			url: this.options.url,
			update: this.options.contentId,
			onComplete: this[this.action].bind(this)
		}).send('action='+this.action);
	},
	
	newAttribute: function() {
		$('add_attr_button').addEvent('click', function(e) {
			var attr = $('attr').get('value');
			new Request.HTML({
				url: this.options.url,
				update: this.options.contentId,
				onComplete: function() {
					this.action = 'addAttributeList';
					this.show();
				}.bind(this)
			}).send('action=newAttribute&attr='+attr);
		}.bind(this));
	},
	
	addAttributeList: function() {
		$('HeaderText').set('text', 'Add Attribute');
		
		$('attr_select').addEvent('change', function(e){
			var selected = $('attr_select').getElement(':selected');
			
			if (selected.id == 'new_attr') {
				UthandoAdmin.showElement('add_new_attr');
				this.stickyWin.position();
				this.newAttribute();
			} else {
				UthandoAdmin.hideElement('add_new_attr');
				this.stickyWin.position();
				v = selected.get('value');
				this.attributeTable = new HtmlTable($('attrs_table'));
				this.attributeTable.push([selected.get('text'), 'delete']);
				this.stickyWin.hide();
			}
		}.bind(this));
	},
	
	closeBox: function() { this.stickyWin.hide(); }
});

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
	},
	
	ushopManagerInit: function() {
		this.UShopManager = new UShopManager();
		$$('.ushopShow').addEvent('click', function(e){
			e.stop();
			UthandoAdmin.UShopManager.action = this.get('action');
			UthandoAdmin.UShopManager.update = this.getParent('fieldset');
			UthandoAdmin.UShopManager.show();
		});
	}
});

UthandoAdminConfig.plugins.load.push('tinyMCE', 'ushopManager', 'fileManager');

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
	ushopManager: {
		enable: UthandoAdmin.ushopManagerInit
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
