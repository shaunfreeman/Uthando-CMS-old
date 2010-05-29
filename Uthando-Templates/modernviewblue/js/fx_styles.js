window.addEvent('domready', function() {
var list = $$('#left_col div table tr td a.mainlevel');
list.each(function(element) {
 
	var fx = new Fx.Morph(element, {duration:300, wait:false});
 
	element.addEvent('mouseenter', function(){
		fx.start({
			'margin-left': 10,
			'margin-right' : 10,
			'color': '#ffffff'
		});
	});
 
	element.addEvent('mouseleave', function(){
		fx.start({
			'margin-left': 0,
			'margin-right' : 0,
			'color': '#7e7e7e'
		});
	});
 
});

var list = $$('#mainlevel-nav li a');
list.each(function(element) {
 
	var fx = new Fx.Morph(element, {duration:400, wait:false});
 
	element.addEvent('mouseenter', function(){
		fx.start({
			'color': '#58A4D6'
		});
	});
 
	element.addEvent('mouseleave', function(){
		fx.start({
			'color': '#FFFFFF'
		});
	});
 
});

});