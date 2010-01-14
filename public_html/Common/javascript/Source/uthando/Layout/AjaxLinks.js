
var AjaxLinks = new Class({
	
	Implements: [Events,Options,Chain],
	
	options: {
		updateMenus: null,
		cache: false,
		ajaxHistory: false,
		autoStartHistory: true,
		errorText: 'The Server is not responding. Please check you connection and try again!',
		historyKey: 'page',
		ajaxOptions: {
			method: 'get',
			url: ''
		},
		includePageAnchors: true,
		anchorSeparator: ';',
		onPageLoaded: $empty
	},
	
	initialize: function(container,options) {
		
		this.setOptions(options);
		this.container = document.id(container);
		this.uri = new URI(window.location);
		this.failed = 0;
		
		this.Scroll = new Fx.Scroll(window);
		
		this.domain = this.uri.get('scheme') + '://' + this.uri.get('host');
		this.currentUrl = this.uri.get('directory') + this.uri.get('file');
		
		this.links = $$('a').filter('[href^='+this.domain+']').combine($$('a').filter('[href^=/]'));
		
		if (this.options.includePageAnchors) this.getAnchors(document);
		
		this.titles = $$(this.options.updateMenus);
		
		this.attach(this.links);
		
		if (this.options.ajaxHistory && !Browser.Engine.webkit) {
			// register the history manager.
			this.history = HistoryManager.register(
				this.options.historyKey,
				[0], // default, entry page
				this.onHistoryChange.bind(this),
				// onGenerate - callback that returns the hash string
				this.historyHash.bind(this),
				// regexp - to decode the hash string,
				this.options.historyKey + '-(.*)'
			);
			if (this.options.autoStartHistory) HistoryManager.start();
		}
	},
	
	attach: function(elements) {
		elements.each(function(element) {
			var url = element.get('href').replace(''+this.domain+'', '');
			element.addEvent('click', function(e) {
				e.preventDefault();
				this.elementClick(url);
			}.bind(this));
		},this);
	},
	
	historyHash: function(values) {
		return [this.options.historyKey, values[0]].join('-');
	},
	
	onHistoryChange: function(values) {
		var url = unescape(values[0]);
		// if there is no location or if this is the entry page then return
  		if (url == "" || url == 0) return;
		if (url.split(this.options.anchorSeparator)[0] != this.currentUrl.split(this.options.anchorSeparator)[0]) this.getContent(url);
	},
	
	getAnchors: function(context) {
		var anchors = $$(context, 'a').filter('[href^=#]');
		anchors.each(function(item, index){
			item.addEvent('click', function(e) {
				e.preventDefault();
				var anchor = item.get('href').split("#")[1];
				//this.pageLoaded(this.currentUrl.split('#')[0] + '#' + anchor);
				if (this.options.ajaxHistory && !Browser.Engine.webkit) this.history.setValue(0, this.currentUrl.split(this.options.anchorSeparator)[0] + this.options.anchorSeparator + anchor);
				
				this.Scroll.toElement(anchor);
			}.bind(this));
		},this);
	},
	
	getContent: function(url) {
	
		var cachedUrl = url.split(this.options.anchorSeparator)[0];
		
		var request = this.container.retrieve(cachedUrl+':request');
		
		if (!request) {
			var params = 'path='+cachedUrl;
			var request = new Request.HTML($merge(this.options.ajaxOptions, {
				data: params,
				update: this.container,
				onSuccess: function() {
					this.pageLoaded(url);
				}.bind(this),
				onFailure: function() {
					if (this.failed < 10) {
						this.failed++;
						this.getContent(url);
					} else {
						this.pageFailed();
					}
				}.bind(this)
			}));
			this.container.store(cachedUrl+':request', request);
		}
		request.send();
	},
	
	pageLoaded: function(url) {
		
		this.currentUrl = url;
		
		if (this.options.ajaxHistory && !Browser.Engine.webkit) this.history.setValue(0, url);
		
		var cachedUrl = url.split(this.options.anchorSeparator)[0];
		
		if (this.options.cache) {
			if (this.container.retrieve(cachedUrl+':loaded')) {
				this.container.empty().set('html', this.container.retrieve(cachedUrl+':html'));
				document.title = this.container.retrieve(url+':title');
			} else {
				this.container.store(cachedUrl+':html', this.container.get('html'));
				this.container.store(cachedUrl+':title', document.title);
				this.container.store(cachedUrl+':loaded', true);
			}
		}
		
		this.fireEvent('pageLoaded', this.container);
		
		// add new container links.
		var newLinks = $$('#'+this.container.id+' a').filter('[href^='+this.domain+']').combine($$('#'+this.container.id+' a').filter('[href^=/]'));
		
		if (this.options.includePageAnchors) this.getAnchors(this.container);
		
		this.attach(newLinks);
		
		// if there is an scroll link scroll to it, otherwise scroll to top.
		var anchor = url.split(this.options.anchorSeparator)[1];
		
		if (anchor) this.Scroll.toElement(anchor);
		
		// update menus if specified.
		if ($type(this.options.updateMenus) == 'string') {
			// update the active menu id and class
			this.titles.removeClass('active');
			this.titles.removeProperty('id');
			
			var activeLink = this.titles.getElement('a[href$='+url+']').clean();
					
			if ($chk(activeLink[0])) {
				var activeLinkParent = activeLink[0].getParent();
				activeLinkParent.setProperty('id', 'current');
				activeLinkParent.addClass('active');
			}
		}
		
		// reset failed counter;
		this.failed = 0;
	},
	
 	pageFailed: function() {
 		if (!this.pageError) {
			this.pageError = new Element('p', {
				'id': 'ajaxLinks_error',
				'text': this.options.errorText
			}).inject(this.container, 'top');
		} else {
			this.pageError.empty().set('text', this.options.errorText);
		}
		// reset failed counter;
		this.failed = 0;
	},
	
	elementClick: function(url) {
		//url = unescape(url);
		var cachedUrl = url.split(this.options.anchorSeparator)[0];
		if (url == this.currentUrl || url == "/") return;
		if (this.options.cache && this.container.retrieve(cachedUrl+':loaded')) {
			this.Scroll.toTop().chain(function(){
				if (this.options.ajaxOptions.useWaiter) this.waiter.start();
				this.pageLoaded(url);
			}.bind(this));
			(function(){
				if (this.options.ajaxOptions.useWaiter) this.waiter.stop();
			}).delay(1000, this);
		} else {
			this.failed = 0;
			this.Scroll.toTop().chain(function(){
				this.getContent(url);
			}.bind(this));
		}
	}
});
