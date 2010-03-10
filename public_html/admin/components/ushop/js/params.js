
UthandoAdmin.extend({
	menuForm: function() {
		
		UthandoAdmin.hideElement('paypal');
		
		var vat = $('vat_no').getParent().getParent().getParent();
		
		UthandoAdmin.hideElement(vat);
		
		$('paypal_y').addEvent('click', function(){
			UthandoAdmin.showElement('paypal');
		});
		
		$('paypal_n').addEvent('click', function(){
			UthandoAdmin.hideElement('paypal');
		});
		
		if ($('paypal_y').checked == true) {
			UthandoAdmin.showElement('paypal');
		}
		
		$('vat_on').addEvent('click', function(){
			UthandoAdmin.showElement(vat);
		});
		
		$('vat_off').addEvent('click', function(){
			UthandoAdmin.hideElement(vat);
		});
		
		if ($('vat_on').checked == true) {
			UthandoAdmin.showElement(vat);
		}
		
	}
});

UthandoAdminConfig.plugins.load.push('tinyMCE');

UthandoAdminConfig.extend({
	tinyMCE: {
		enable: UthandoAdmin.tinyMCEInit,
		tinyMCEElements: {
			textarea: {}
		},
		options: {
			mode : "textareas",
			elements : "absurls",
			theme : "advanced",
			skin: 'o2k7',
			skin_variant: 'silver',
			plugins: 'inlinepopups',
			theme_advanced_toolbar_location : "top",
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent|,undo,redo,|,link,unlink,cleanup|,sub,supt",
   			theme_advanced_buttons2 : ""
		}
	},
	fileManager: {
		el: 'pp_merchant_logo',
		pathPrefix: '/userfiles/',
		file: false
	}
});

window.addEvent('domready', function(){
	UthandoAdmin.menuForm();
});