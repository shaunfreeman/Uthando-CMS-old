// ============================================================
// = Uthando Congiguration                                    =
// ============================================================
var UthandoConfig = $H({
	plugins: {
		path: '/Common/javascript/plugins/',
		load: ['fixPNG', 'Paginate', 'ajaxLinks', 'swiff', 'tips', 'tabs', 'popupDetail']
	},
	swiff: {
		enable: Uthando.enableSwiff,
		swiffDivs: {
			book: {
				id: 'uthandoLogoFlash',
				container: 'uthandoLogo',
				width: 200,
				height: 150,
				params: {
					wmode: 'opaque',
					bgcolor: '#ffffff'
				}
			}
		}
	},
	ajaxLinks: {
		enable: false, //Uthando.enableAjaxLinks,
		container: 'ajax_content',
		options: {
			updateMenus: '#MainMenu li',
			ajaxHistory: true,
			ajaxOptions: {
				method: 'get',
				url: '/plugins/ajax_content/ajax_content.php',
				evalScripts: true,
				useWaiter: true,
 				/* waiterOptions is the options object for the Waiter class */
 				waiterOptions: {
					baseHref: '/Common/images/',
					
					msg: 'Please wait while we load the page.',
					img: {
						src: 'loader.gif',
						styles: {
							width: 31,
							height: 31
						}
					},
					layer:{
						id: 'ajaxlinks_container',
						styles: {
							background: '#fff'
						}
					},
	 				fxOptions: {duration: 1000}
				}
			},
			onPageLoaded: function(element) {
				Uthando.Paginate();
				if (Uthando.tips) Uthando.tips.hide();
				if ($('morphTabs')) Uthando.enableTabs();
				if ($('popupDetailHTML')) Uthando.enablePopupDetail();
				Uthando.tips.attach('#'+element.id+' .Tips');
			}
		}
	},
	tips : {
		enable: Uthando.enableTips,
		elements: '.Tips',
		options: {}
	},
	Paginate: {
		enable: Uthando.Paginate
	},
 	fixPNG: {
		enable: Uthando.enableFixPNG
 	},
	popupDetail : {
		enable: Uthando.enablePopupDetail
	},
	tabs : {
		enable: Uthando.enableTabs
	}
});