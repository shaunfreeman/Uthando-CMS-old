// ============================================================
// = Uthando Congiguration                                    =
// ============================================================
var UthandoConfig = $H({
	dirs: {
		image: '/userfiles/image/',
		file: '/userfiles/file/',
		images: '/userfiles/media/',
		flash: '/userfiles/flash/'
	},
	plugins: {
		path: '/Common/javascript/plugins/',
		load: ['Paginate', 'ajaxLinks', 'accordion', 'swiff', 'tips']
	},
	swiff: {
		enable: Uthando.enableSwiff,
		swiffDivs: {
			uthandoLogo: {
				id: 'uthandoLogoFlash',
				container: 'uthandoLogo',
				width: 186,
				height: 100,
				params: {
					wmode: 'opaque',
					bgcolor: '#ffffff'
				}
			}
		}
	},
	ajaxLinks: {
		enable: Uthando.enableAjaxLinks,
		container: 'ajax_content',
		options: {
			updateMenus: '#MainMenu li',
			cache: false,
			ajaxHistory: true,
			ajaxOptions: {
				method: 'get',
				url: '/plugins/ajax_content/ajax_content.php',
				evalScripts: true,
				useWaiter: true,
 				/* waiterOptions is the options object for the Waiter class */
 				waiterOptions: {
					baseHref: 'http://uthandocms/Common/images/',
					containerPosition: {
						relativeTo: document.id('ajaxlinks_container'),
						position: 'center'
					},
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
							background: '#eee'
						}
					},
	 				fxOptions: {duration: 500}
				}
			},
			onPageLoaded: function(element) {
				Uthando.Paginate();
				//Uthando.detach('#'+element.id+' .Tips');
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
	popupWindow: {
		enable: false
	},
	accordion: {
		enable: Uthando.enableAccordion,
		accordionDivs: {
			panel: {
				element: 'panel',
				togglers: 'div.tabbed',
				elements: 'div.stretcher',
				options: {
					opacity: true,
					height: true,
					duration: 400
				}
			}
		}
	}
});