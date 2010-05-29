
var ElementSwapper = new Class({
	Implements: [Options, Events, SlideShow],
	
	options: {
		selectedClass: 'active',
		panelWrapClass: 'element_swap',
		activateOnLoad: 0,
		slideShowDelay: 3,
		transition: {
			duration: 'long'
		}
	},
	
	initialize: function(elements, options) {
		this.setOptions(options);
		this.elements = $$(elements);
		
		this.wrap = new Element('div', {
			'id': 'elementswap_wrap',
			'class': this.options.panelWrapClass
		}).inject(this.elements[0], 'before');
		
		this.addToWrap(this.elements);
		this.show(this.options.activateOnLoad);
		this.start();
	},
	
	addToWrap: function(elements) {
		$$(elements).each(function(element){
			this.wrap.adopt(element);
			element.set('tween', this.options.transition).fade('hide');
			this.elements.include(element);
		},this);
	},
	
	show: function(index) {
		if ($type(index) != 'number') index = 0;
		if (this.elements[this.now]) this.elements[this.now].fade('out');
		this.now = index;
		this.elements.removeClass(this.options.selectedClass);
		this.elements[this.now].addClass(this.options.selectedClass);
		this.elements[this.now].fade('in');
	}
});
