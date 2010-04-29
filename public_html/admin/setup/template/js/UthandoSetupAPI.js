
Element.implement({
	getScrollMax: function(x,y,offset) {
		if (!offset) var offset = {'x':0, 'y':0};
		var offsetSize = this.getSize(), scrollSize = this.getScrollSize();
		var scroll = this.getScroll(), values = {'x': x, 'y': y};
		for (var z in values){
			var max = scrollSize[z] - offsetSize[z];
			if ($chk(values[z])) {
				values[z] = ($type(values[z]) == 'number') ? values[z].limit(0, max) : max;
			} else {
				values[z] = scroll[z];
			}
			values[z] += offset[z];
		}
		return {now:{'x':scroll.x, 'y':scroll.y}, max:{'x':values.x, 'y':values.y}};
	},
	
	isScrollMaxY: function() {
		var scroll = this.getScrollMax(false,'bottom');
		return (scroll.now.y == scroll.max.y) ? true : false;
	},
	
	isScrollMaxX: function() {
		var scroll = this.getScrollMax('right',false);
		return (scroll.now.x == scroll.max.x) ? true : false;
	}
});

window.addEvent('domready', function() {
	
	elements = $$('#licence a');
	
	var fx = new Fx.Scroll($('licence'));
	
	elements.each(function(item){
		item.addEvent('click', function(e){
			e.stop();
			fx.toElement(this.get('href').replace('#', ''));
		});
	});
	
	$('licence').addEvent('scroll', function(e){
		if (this.isScrollMaxY()) $('licence_accept').setStyle('display', 'block');
	});
		
});
