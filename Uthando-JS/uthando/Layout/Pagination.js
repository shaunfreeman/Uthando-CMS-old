var PaginateSlider = new Class({
		
	Extends: Slider,
	
	initialize: function(element, knob, options){
		this.parent(element, knob, options);
		
		this.drag.addEvents({
			beforeStart: (function(){
				this.isDropping = true;
			}).bind(this),
			complete: (function(){
				this.isDropping = false;
			}).bind(this)
		});
	},
	
	clickedElement: function(event){
		if(this.isDropping) return;
		
		this.parent(event);
	}
	
});
