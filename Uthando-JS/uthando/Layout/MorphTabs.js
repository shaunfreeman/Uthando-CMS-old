
var MorphTabs = new Class({
	Implements: [Chain],

	Extends: Tabs,
 
	options: {
		panelWrap: 'morphtabs_panelwrap',
		TransitionFx: {
			transition: 'linear',
			duration: 'long'
		},
		panelStartFx: 'blind:left',
		panelEndFx: 'blind:right',
		onActiveAfterFx: $empty,
	},
 
	initialize: function(element, options) {
		
		this.firstRun = true;
		
		this.parent(element, options);
	},
 
	attach: function(elements) {
		$$(elements).each(function(element) {
			this.parent(element);
			element.store('tab:effect', document.id(element.title).get('morphElement', {
				wrap: false,
				width: document.id(this.options.panelWrap).getStyle('width'),
				height: document.id(this.options.panelWrap).getStyle('height'),
				FxTransition: this.options.TransitionFx
			}));
		}, this);
		return this;
	},
 
	activate: function(tab) {
		
		tab = this.getTab(tab);
		
		if($type(tab) == 'element') {
			
			// panel fx here..
			switch (this.firstRun) {
				case true:
					var newTab = this.showTab(tab);
					break;
				default:
					this.effect = this.activeTitle.retrieve('tab:effect');
					this.activePanel.setStyle('overflow', 'hidden');
					this.effect.getFx(this.options.panelStartFx).chain(
						function() {
							var newTab = this.showTab(tab);
						}.bind(this)
					);
					break;
			}
			
			if (this.firstRun) this.firstRun = false;
		}
		
	},
	
	showTab: function(tab) {
		var newTab = this.parent(tab);
		this.activePanel.setStyle('overflow', 'hidden');
		this.effect = tab.retrieve('tab:effect');
		this.showTabFx();
		return newTab;
	},
	
	showTabFx: function() {
		this.effect.getFx(this.options.panelEndFx).chain(
			function() {
				this.activePanel.setStyle('overflow', 'auto');
			}.bind(this)
		);
	},
	
	changeFx: function(elements, fx) {
		if (elements == 'all') elements = this.tabs;
		fx = {FxTransition:fx};
		$$(elements).each(function(el) {
			var morphElement = document.id(el.title).retrieve('morphElement');
			morphElement.setOptions(fx);
			el.eliminate('tab:effect').store('tab:effect', morphElement);
		}.bind(this));
	},
 
	elementClick: function(event, element) {
		this.parent(event, element);
		if (this.slideShow) this.activePanel.store('fxEffect:flag', 'show');
	},
	
	addTab: function(title, label, content) {
		var newTitle = this.parent(title, label, content);
		this.addToWrap(newTitle);
	}
});
