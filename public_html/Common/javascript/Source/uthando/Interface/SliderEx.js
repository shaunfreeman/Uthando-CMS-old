
var SliderEx = new Class({
	Extends: Slider,
 set: function(step){
	 this.step = Math.round(step);
	 this.fireEvent('tick', this.toPosition(this.step));
	 return this;
 },
 clickedElement: function(event){
	 var dir = this.range < 0 ? -1 : 1;
	 var position = event.page[this.axis] - this.element.getPosition()[this.axis] - this.half;
	 position = position.limit(-this.options.offset, this.full -this.options.offset);
	 this.step = Math.round(this.min + dir * this.toStep(position));
	 this.checkStep();
	 this.fireEvent('tick', position);
 }
});
