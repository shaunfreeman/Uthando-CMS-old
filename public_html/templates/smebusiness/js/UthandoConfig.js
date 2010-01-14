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
		load: ['fixPNG', 'Paginate', 'ajaxLinks', 'tips']
	},
	ajaxLinks: {
		enable: Uthando.enableAjaxLinks,
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
					baseHref: 'http://shaunfreeman.co.uk/Common/images/',
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
					fxOptions: {duration: 500}
				}
			},
			onPageLoaded: function(element) {
				Uthando.Paginate();
				if (Uthando.tips) Uthando.tips.hide();
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
 	}
});