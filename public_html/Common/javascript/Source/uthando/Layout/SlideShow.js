
var SlideShow = new Class({
	
	start: function() {
		this.slideShow = this.next.periodical(this.options.slideShowDelay * 1000, this);
	},
	
	stop: function() {
		this.clearChain();
		$clear(this.slideShow);
	},
	
	next: function() {
		var el = this.elements[this.now].getNext();
		if (!el) el = this.elements[0];
		this.show(this.elements.indexOf(el));
	},
	
	previous: function() {
		var el = this.elements[this.now].getPrevious();
		if (!el) el = this.elements[this.elements.length - 1];
		this.show(this.elements.indexOf(el));
	}
});
