
window.addEvent('domready', function() {
	var pngIEFix = (Browser.Engine.trident && !Browser.Engine.trident5 && document.body.filters) ? true : false;
	
	if (pngIEFix) {
		var pngfix = new pngFix({cssBgElements: ['h1']});
		pngfix.fixPNGElements(document.body);
	}
	
	var arVersion = navigator.appVersion.split("MSIE");
	var version = parseFloat(arVersion[1]);
	
	var compatBrowser = ((version > 5.5) || Browser.Engine.gecko || Browser.Engine.webkit || Browser.Engine.presto) ? true : false;

	var mooFlowOptions = {
		startIndex: 1,
		offsetY: 9,
		useCaption: true,
		useSlider: true,
		useAutoPlay: true,
		interval: 20000,
		factor: 110,
		bgColor: '#111',
		useMouseWheel: false,
		onEmptyinit: function(){
			this.loadJSON('/userfiles/file/testimonials.json');
		},
		onClickView: function(obj) {
			if ($('callback')) $('callback').set('html', obj.alt);
		},
		onStart: function(mf) {
			this.play();
		}
	};
	
	if (compatBrowser) {
		
		if ($('carousel')) var elSwap = new ElementSwapper('#carousel div.slide');
		
		if (!version || version > 6) {
			
			var ajaxlinks = new AjaxLinks('ajax_content', {
				updateMenus: '#MainMenu li',
				ajaxHistory: true,
				cache: false,
				ajaxOptions: {
					method: 'get',
					url: '/plugins/ajax_content/ajax_content.php',
					evalScripts: true,
					useSpinner: true,
					spinnerOptions: {
						styles: {
							background: '#0b0b0b'
						}
					}
				},
				onPageLoaded: function(element) {
					if ($('MooFlow')) var mf = new MooFlow($('MooFlow'), mooFlowOptions);
					if ($('carousel')) var elSwap = new ElementSwapper('#carousel div.slide');
				}

			});
			
			$('jump_top').getElement('a').addEvent('click', function(e){
				e.stop();
				ajaxlinks.Scroll.toTop();
			});
			
			if ($('MooFlow')) var mf = new MooFlow($('MooFlow'), mooFlowOptions);
		}
		
		var accordion = new Accordion('div.tabbed', 'div.stretcher', {
			opacity: true,
			height: true,
			duration: 400
		}, $('panel'));
		
	}
});
