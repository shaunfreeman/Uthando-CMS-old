// ============================================================
// = Uthando API                                              =
// ============================================================
var Uthando = $H({
	// ============================================================
	// initialize Uthando Object                                  =
	// ============================================================
	initialize: function() {
		
		this.dirs = $H(UthandoConfig.get('dirs'));
		
		this.setupPlugins();
		
	},
	// ============================================================
	// setup all site plugins                                     =
	// ============================================================
	setupPlugins: function() {
		
		this.plugins = $H(UthandoConfig.get('plugins'));
		
		this.plugins.get('load').each(function(item) {
			
			this.plugin = $H(UthandoConfig.get(item));
			this.enable = this.plugin.get('enable');
			
			if ($type(this.enable) == 'function') {
				this.enable = this.enable.run(this.dirs, this);
			}
			
			if ($chk(this.enable)) {
				
				this.pluginPath = (this.plugin.get('pluginPath')) ? this.plugin.get('pluginPath') : this.plugins.get('path');
				
				this.set(item, new Asset.javascript(this.pluginPath + item + '.js'));
			}
			
		},this);
		
	},
	// ============================================================
	// enable AjaxLinks Class                                     =
	// ============================================================
	enableAjaxLinks: function() {
		this.ajaxlinks = new AjaxLinks(UthandoConfig.ajaxLinks.container, UthandoConfig.ajaxLinks.options);
	},
	// ============================================================
	// enable Flash Class                                         =
	// ============================================================
	swiff: $H({}),
	enableSwiff: function(dirs) {
		
		this.flashConfig = $H(UthandoConfig.get('swiff'));
		this.flashMovies = $H(this.flashConfig.get('swiffDivs'));
		this.flashDir = this.dirs.get('flash');
		
		this.flashMovies.each(function(value, key) {
			this.params = $H(value);
			$(this.params.get('container')).fade('hide');
			this.file = this.flashDir + key + ".swf";
			
			this.get('swiff').set(key, new Swiff(this.file, value));
			$(this.params.get('container')).fade('in');
		},this);
		
	},
	// ============================================================
	// = Setup mootools Accordion Class                           =
	// ============================================================
	accordion: $H({}),
	enableAccordion: function() {
		
		this.accordionConfig = $H(UthandoConfig.get('accordion'));
		this.accordion = $H(this.accordionConfig.get('accordionDivs'));
		this.accordion.each(function(value, key) {
			this.params = $H(value);
			
			this.get('accordion').set(key, new Fx.Accordion(this.params.togglers, this.params.elements, this.params.options, this.params.container));
			
		},this);
	},
	// ============================================================
	// = Setup mootools popupWindow Class                         =
	// ============================================================
 	enablePopupWindow: function() {
		this.popupWindow = new PopupWindow();
	},
	// ============================================================
	// = Setup mootools Paginate Class                            =
	// ============================================================
	Paginate: function() {

		$$('div.paginate').each(function(el){
			
			if(el.retrieve('paginate')) return;
			
			el.store('paginate', true);
			var link = el.getElement('a.link'),
				per = el.getElement('span.per').get('text').toInt(),
				page = el.getElement('span.current').get('text').toInt()-1;
			
			el.getElement('div.slider').setStyle('display', 'block');
			
			new PaginateSlider(el.getElement('div.slider'), el.getElement('div.knob'), {
				wheel: false,
				steps: link.get('text').toInt()-1,
				onChange: function(step){
					el.getElement('span.current').set('text', step+1);
				},
				onComplete: function(step){
					if (step!=page && !UthandoConfig.ajaxLinks.enable) { 
						window.location.href = link.get('href').substitute({start: step*per});
					} else if (step!=page) {
						var url = unescape(link.get('href').replace(''+Uthando.ajaxlinks.domain+'', '')).substitute({start: step*per});
						if (Browser.Engine.trident) {
							url = url.substring(1);
							if (url.substring(0,1) != "/") url = "/"+url;
						}
						this.ajaxlinks.elementClick(url);
					}
				}.bind(this)
			}).set(page);
			
		}.bind(this));
	},
	// ============================================================
	// = Enable tooltips                                          =
	// ============================================================
	enableTips: function() {
		this.tips = new Tips(UthandoConfig.tips.elements, UthandoConfig.tips.options);
	}
});

window.addEvent('domready', function(){
	Uthando.initialize();
});
