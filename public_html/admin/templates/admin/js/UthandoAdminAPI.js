// ============================================================
// = Uthando Admin API                                        =
// ============================================================
var UthandoAdmin = $H({
	// ============================================================
	// initialize Uthando Object                                  =
	// ============================================================
	initialize: function() {
		
		this.dirs = $H(UthandoAdminConfig.get('dirs'));
		
		this.setupPlugins();
		this.HeightFix();
		this.saveFormButton();
		
		if ($('errors')) this.stickyWin();
		
		window.addEvent('resize', function(){
			UthandoAdmin.HeightFix();
		});
		
	},
	// ============================================================
	// setup all site plugins                                     =
	// ============================================================
	setupPlugins: function() {
		
		this.plugins = $H(UthandoAdminConfig.get('plugins'));
		
		this.plugins.get('load').each(function(item) {
			
			this.plugin = $H(UthandoAdminConfig.get(item));
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
	hideElement: function (element) {
	 	var el = $(element);
		if (el.getStyle('display') == 'block') {
			el.setStyle('display', 'none');
		}
	},
	showElement: function (element) {
		var el = $(element);
		if (el.getStyle('display') == 'none') {
			el.setStyle('display', 'block');
		}
	},
	stickyWin: function() {
		var stickyWin = new StickyWin.Modal({
			content: $('errors'),
	  		width: 400,
	 		className: 'sticky_win',
  			maskOptions: {
    			style:{
      				'background-color':'#fff',
      				'opacity':.6,
		 			'cursor': 'pointer'
    			}
  			}
		});
		
		$('closeBox').addEvent('click', function(e){
			stickyWin.hide();
		});
	},
	// ============================================================
	// = Setup mootools FileManager callback                      =
	// ============================================================
	fileManagerCallback: function(path, file) {
		var filePath = (UthandoAdminConfig.fileManager.file) ? file.name : path;
		$(UthandoAdminConfig.fileManager.el).set('value', UthandoAdminConfig.fileManager.pathPrefix + filePath);
	},
	// ============================================================
	// enable AjaxLinks Class                                     =
	// ============================================================
	enableAjaxLinks: function() {
		this.ajaxlinks = new AjaxLinks(UthandoAdminConfig.ajaxLinks.container, UthandoAdminConfig.ajaxLinks.options);
	},
	// ============================================================
	// = Setup mootools Paginate Class                            =
	// ============================================================
	Paginate: function() {

		$$('div.paginate').each(function(el) {
			
			if(el.retrieve('paginate')) return;
			
			el.store('paginate', true);
			var link = el.getElement('a.link'),
				per = el.getElement('span.per').get('text').toInt(),
				page = el.getElement('span.current').get('text').toInt()-1;
			
			new PaginateSlider(el.getElement('div.slider'), el.getElement('div.knob'), {
				wheel: false,
				steps: link.get('text').toInt()-1,
				onChange: function(step){
					el.getElement('span.current').set('text', step+1);
				},
				onComplete: function(step){
					if (step!=page && !UthandoAdminConfig.ajaxLinks.enable) { 
						var url = unescape(link.get('href')).substitute({start: step*per});
						window.location.href = url;
					} else if (step!=page) {
						var url = unescape(link.get('href').replace(''+UthandoAdmin.ajaxlinks.domain+'', '')).substitute({start: step*per});
						UthandoAdmin.ajaxlinks.getContent(url);
					}
				}
			}).set(page);
		});
	},
	// ============================================================
	// = Setup mootools Accordion Class                           =
	// ============================================================
	accordion: $H({}),
	enableAccordion: function() {
		
		this.accordionConfig = $H(UthandoAdminConfig.get('accordion'));
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
	// = Browser Height Fix                                       =
	// ============================================================
	HeightFix: function() {
		if (window.getWidth() < 800) {
			window.resizeTo(800, 600);
		}
	},
	// ============================================================
	// = Submit form button                                       =
	// ============================================================
	saveFormButton: function() {
		if ($('save-24')) {
			$('save-24').addEvent('click', function(event){
				event.stop();
				$('mainDiv').getElement('form').submit();
			});
		}
	},
	// ============================================================
	// = Enable tooltips                                          =
	// ============================================================
	enableTips: function() {
		this.tips = new Tips(UthandoAdminConfig.tips.elements, UthandoAdminConfig.tips.options);
	},
	// ============================================================
	// = Enable tooltips                                          =
	// ============================================================
	enableIconMenu: function() {
		if ($('menuToolbarWrap')) this.IconMenu = new IconMenu(UthandoAdminConfig.iconMenu.options);
	},
	// ============================================================
	// = tinyMCE initialize function                              =
	// ============================================================
	tinyMCE: $H({}),
	tinyMCEInit: function() {
		
		this.tinyMCEConfig = $H(UthandoAdminConfig.get('tinyMCE'));
		this.tinyMCE = $H(this.tinyMCEConfig.get('tinyMCEElements'));
		
		this.tinyMCE.each(function(value, key) {
			this.params = $H(value);
			if (document.getElement(key)) {
				this.get('tinyMCE').set(key, tinyMCE.init(this.tinyMCEConfig.get('options')));
			}
		},this);
	},
 	enableTabs: function() {
		if ($('morphTabs')) {
			$$('.paginate_wrap').each(function(el) {
				el.fade('hide');
			});
			this.tabs = new MorphTabs('morphTabs', {
				panelStartFx: 'fade',
				panelEndFx: 'fade',
				onBackground: function(tab) {
					var id = tab.getProperty('title');
					if ($('paginate_'+id)) $('paginate_'+id).fade('out');
				},
				onActive: function(tab) {
					var id = tab.getProperty('title');
					if ($('paginate_'+id)) $('paginate_'+id).fade('in');
				}
			});
			
			window.addEvent('resize',function(){
				var size = $('morphtabs_panelwrap').getSize();
				$$('.morphtabs_title li').each(function(el){
					var effect = el.retrieve('tab:effect');
					effect.options.width = size.x - 10;
					effect.options.height = size.y - 10;
					$((el.title)).setStyles({
						width: size.x - 10 + 'px',
						height: size.y - 10 + 'px'
					});
				});
			});
		}
	}
});

UthandoAdmin.uri = new URI(window.location);

window.addEvent('domready', function(){
	UthandoAdmin.initialize();
});
