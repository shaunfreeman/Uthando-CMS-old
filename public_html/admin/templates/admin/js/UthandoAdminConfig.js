// ============================================================
// = Uthando Congiguration                                    =
// ============================================================
var UthandoAdminConfig = $H({
	dirs: {},
	plugins: {
		load: ['Paginate', 'ajaxLinks', 'tips', 'tabs', 'iconMenu']
	},
	ajaxLinks: {
		enable: false,
		container: 'ajax_content',
		options: {
			updateMenus: '#MainMenu li',
			ajaxOptions: {
				method: 'get',
				url: '/plugins/ajax_content/ajax_content.php',
				evalScripts: true,
				useWaiter: true,
 				/* waiterOptions is the options object for the Waiter class */
 				waiterOptions: {
					baseHref: 'http://uthandocms/Common/images/',
					img: {
						src: 'loader.gif',
						styles: {
							width: 31,
							height: 31
						}
					},
					layer:{
						styles: {
							background: '#eee'
						}
					},
	 				fxOptions: {duration: 500}
				}
			},
			onPageLoaded: function(element) {
				UthandoAdmin.Paginate();
			}
		}
	},
	tips : {
		enable: UthandoAdmin.enableTips,
		elements: '.Tips',
		options: {}
	},
	Paginate: {
		enable: UthandoAdmin.Paginate
	},
	tabs : {
		enable: UthandoAdmin.enableTabs
	},
	iconMenu : {
		enable: UthandoAdmin.enableIconMenu,
		options: {
			container: 'iconMenuStrip',
			scrollFxOptions: {
				duration: 'long',
				transition: 'back:in:out'
			},
			onItemsAdded: function() {
				if (this.imgs.length > 5) {
					$('scrollLeft').setStyle('display', 'none');
					$('scrollRight').setStyle('display', 'block');
				} else {
					$('scrollLeft').setStyle('display', 'none');
					$('scrollRight').setStyle('display', 'none');
				}
			},
			onScroll: function(index, newRange) {
				if (newRange.start > 0) $('scrollLeft').setStyle('display', 'block');
				if (newRange.start == 0) {
					$('scrollLeft').setStyle('display', 'none');
					$('scrollRight').setStyle('display', 'block');
				}
				if (newRange.elements.length < 5 || newRange.end <= this.imgs.length) $('scrollRight').setStyle('display', 'none');
				if (newRange.end < this.imgs.length) $('scrollRight').setStyle('display', 'block');
			}
		}
	}
});
