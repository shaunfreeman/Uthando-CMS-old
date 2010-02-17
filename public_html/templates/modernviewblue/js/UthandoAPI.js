// ============================================================
// = Uthando API                                              =
// ============================================================
var Uthando = $H({
	// ============================================================
	// initialize Uthando Object                                  =
	// ============================================================
	initialize: function() {
	
		this.server = new URI (window.location).get('host').split('.');
		
		if (this.server[0] == 'www'){
			this.server = this.server[1];
		}else{
			this.server = this.server[0];
		}
		
		this.dirs = $H({
			image: '/userfiles/'+this.server+'/image/',
			file: '/userfiles/'+this.server+'/file/',
			images: '/userfiles/'+this.server+'/media/',
			flash: '/userfiles/'+this.server+'/flash/'
		});
		
		this.compatBrowser = (Browser.Engine.trident && Browser.Engine.version <= 4) ? false : true;
		
		this.setupPlugins();
		this.setupVertialMenus();
		
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
	// vertical menu setup                                        =
	// ============================================================
 	setupVertialMenus: function() {
		
		if(window.ie6) {
			var heightValue='100%';
		} else {
			var heightValue='';
		}
	
		// Selektoren der Container für Schalter und Inhalt
		var togglerName='span.accordion_toggler_';
		var contentName='ul.accordion_content_';
	
		// Selektoren setzen
		var counter = 1;
		var toggler = $$(togglerName+counter);
		var content = $$(contentName+counter);
		
		while(toggler.length > 0) {
			// Accordion anwenden
			
			toggler.removeEvent('click');
			
			new Accordion(toggler, content, {
				opacity: false,
				display: -1,
				alwaysHide: true,
				onComplete: function() { 
					var element=document.id(this.elements[this.previous]);
					if(element && element.offsetHeight > 0) element.setStyle('height', heightValue);
				},
				onActive: function(toggler, content) {
					toggler.addClass('open');
				},
				onBackground: function(toggler, content) {
					toggler.removeClass('open');
				}
			});
		
			// Selektoren für nächstes Level setzen
			counter++;
			toggler = $$(togglerName+counter);
			content = $$(contentName+counter);
		}
		
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
			
			this.get('accordion').set(key, new Accordion(this.params.togglers, this.params.elements, this.params.options, this.params.container));
			
		},this);
	},
	// ============================================================
	// = Setup mootools popupWindow Class                         =
	// ============================================================
 	enablePopupWindow: function() {
		this.popupWindow = new PopupWindow();
	},
	// ============================================================
	// = Setup mootools PNGFix Class                              =
	// ============================================================
	enableFixPNG:  function() {
		if (!this.compatBrowser) {
			this.fixpng =  new pngFix({
				cssBgElements: '#top_wrap #menu'
			});
			this.fixpng.fixPNGElements(document.body);
		}
	},
	// ============================================================
	// = Setup mootools Paginate Class                            =
	// ============================================================
	Paginate: function() {
		
		$$('div.paginate').each(function(el){
			
			if(el.retrieve('paginate')) return;
			
			if (!this.compatBrowser) {
				return;
			} else {
				el.getElement('.numbers').setStyle('display', 'none');
			}
			
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
						window.location.href = unescape(link.get('href')).substitute({start: step*per});
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
	},
 	enablePopupDetail: function() {
		if ($('popupDetailCollectionThumbs')) {
			var myRequest = new Request({
				url: '/components/ushop/html/popupDetailsTemplate.html',
				onSuccess: function (responseText) {
					this.popupDetail = new PopupDetailCollection($$('#popupDetailCollectionThumbs img'), {
						details: products,
						template: responseText,
						popupDetailOptions: {
							stickyWinOptions: {
								edge: 'upperLeft',
								position: 'upperLeft',
								offset: {
									x: -325,
									y: -100
								}
							}
						}
					});
				}.bind(this)
			});
			myRequest.send();
		}
	},
 	enableTabs: function() {
		if ($('morphTabs')) {
			this.tabs = new MorphTabs('morphTabs', {
				panelStartFx: 'fade',
				panelEndFx: 'fade'
			});
		}
	}
});

window.addEvent('domready', function(){
 	Uthando.initialize();
	
});

