/*

The MIT License

BySlideMenu (http://www.byscripts.info/mootools/byslidemenu)
Copyright (c) 2008 ByScripts.info (http://www.byscripts.info)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

var BySlideMenu = new Class({
	Implements: Options,

	options: {
		defaultIndex: false,
		expandMode: 'mouseover',
		pinMode: false,
		vertical: false,
		compressSize: 40,
		elementWidth: 320,
		elementHeight: 240,
		autoSize: true,
		duration: 500,
		transition: 'linear',
		containerWidth: null,
		containerHeight: null,
		useOverflow: false
	},
	
	initialize: function(containerId, options){
		this.setOptions(options);
		this.elementsId = [];
		this.containerId = $pick(containerId, 'byslidemenu');
		
		var container = $(this.containerId);	
		
		container.addEvent('mouseleave', function(){
			this.resetAll();
		}.bind(this));
		
		var elements = container.getChildren();
		var num = elements.length;

		var imgHeight = null, imgWidth = null;
		if(this.options.autoSize)
		{
			var firstImg = elements[0].getElement('img');
		
			if(firstImg)
			{
				imgHeight = firstImg.getHeight();
				imgWidth = firstImg.getWidth();
			}
		}
		
		var offsetWidth = 
			elements[0].getStyle('padding-left').toInt()
			+ elements[0].getStyle('padding-right').toInt()
			+ elements[0].getStyle('border-left-width').toInt()
			+ elements[0].getStyle('border-right-width').toInt();
		var offsetHeight = 
			elements[0].getStyle('padding-top').toInt()
			+ elements[0].getStyle('padding-bottom').toInt()
			+ elements[0].getStyle('border-top-width').toInt()
			+ elements[0].getStyle('border-bottom-width').toInt();
		
		if(this.options.vertical)
		{
			this.posAttr = 'top';
			var containerWidth = $pick(imgWidth, this.options.containerWidth, this.options.elementWidth);
			if(containerWidth == "full")
				containerWidth = container.getParent().getStyle('width').toInt();
			if(this.options.containerHeight)
			{
				if(this.options.containerWidth == 'full')
					var containerHeight = container.getParent().getStyle('height').toInt();
				else
					var containerHeight = this.options.containerHeight;

				this.openSize = containerHeight - ((num - 1) * this.options.compressSize);
			}
			else
			{
				this.openSize = $pick(imgHeight, this.options.elementHeight);
				var containerHeight = this.openSize + ((num - 1) * this.options.compressSize);
			}
			
			this.closeSize = containerHeight / num;
			
			var elementHeight = this.openSize;
			var elementWidth = containerWidth;
		}
		else
		{
			this.posAttr = 'left';
			var containerHeight = $pick(imgHeight, this.options.containerHeight, this.options.elementHeight);
			if(containerHeight == "full")
				containerHeight = container.getParent().getStyle('height').toInt();
			if(this.options.containerWidth)
			{
				if(this.options.containerWidth == 'full')
					var containerWidth = container.getParent().getStyle('width').toInt();
				else
					var containerWidth = this.options.containerWidth;

				this.openSize = containerWidth - ((num - 1) * this.options.compressSize);
			}
			else
			{
				this.openSize = $pick(imgWidth, this.options.elementWidth);
				var containerWidth = this.openSize + ((num - 1) * this.options.compressSize);
			}
			this.closeSize = containerWidth / num;
			
			var elementHeight = containerHeight;
			var elementWidth = this.openSize;
		}

		container.setStyles({
			padding: 0,
			position: 'relative',
			overflow: 'hidden',
			width: containerWidth,
			height: containerHeight
		});
		
		var id = 0;
		
		elements.each(function(element){
			var beforePos = id * this.options.compressSize;
			var afterPos = this.openSize + ((id - 1) * this.options.compressSize);
			var closePos = id * this.closeSize;
			element.setStyles({
				position: 'absolute',
				height: elementHeight - offsetHeight,
				width: elementWidth - offsetWidth
			});
			element.setStyle(this.posAttr, closePos);
			element.set('tween', {
				duration: this.options.duration,
				transition: this.options.transition
			});
			
			id++;
			
			element.set('id', this.containerId + '_Elm' + id);
			element.store('id', id);
			
			element.store('beforePos', beforePos);
			element.store('afterPos', afterPos);
			element.store('closePos', closePos);

			this.elementsId.include(id);
			
			if([this.options.pinMode, this.options.expandMode].contains('mouseover'))
			{
				element.addEvent('mouseenter', function(element){
					if(this.options.expandMode == 'mouseover')
						this.expand(element, this.options.pinMode == 'mouseover');
				}.bind(this, element));
			}
			
			if(this.options.pinMode || this.options.expandMode == 'click')
			{
				element.addEvent('click', function(element){
					if(this.options.defaultIndex == element.retrieve('id'))
					{
						this.options.defaultIndex = 0;
						this.resetAll();
					}
					else if(this.options.expandMode == 'click')
						this.expand(element, this.options.pinMode == 'click');
					else
						this.options.defaultIndex = element.retrieve('id');
				}.bind(this, element));
			}

		}, this);
		
		if(this.options.defaultIndex)
			this.expand(this.options.defaultIndex, false, true);
	},
	
	expand: function(element, setDefault, noAnim){
		if($type(element) == 'number')
			element = $(this.containerId + '_Elm' + element);
			
		if(this.options.useOverflow)
			this.clearOverflow();
		
		var currentId = element.retrieve('id');
		
		if(this.options.useOverflow)
			this.switchOverflowTimer = this.switchOverflow.delay(this.options.duration, this, element);
		
		if(setDefault)
			this.options.defaultIndex = currentId;
		
		this.elementsId.each(function(elementId){
			var elm = $(this.containerId + '_Elm' + elementId);
			if(elementId > currentId)
				this.compressAfter(elm, noAnim);
			else
				this.compressBefore(elm, noAnim);
		}, this);
	},
	
	switchOverflow: function(element){
		element.setStyle('overflow', 'auto');
	},
	
	clearOverflow: function(){
		$clear(this.switchOverflowTimer);
		$(this.containerId).getChildren().setStyle('overflow', '');
	},
	
	compressBefore: function(element, noAnim){
		var pos = element.retrieve('beforePos');
		var tween = element.get('tween', {property: this.posAttr, duration: this.options.duration, transition: this.options.transition});
		
		if(noAnim)
			tween.set(pos);
		else
			tween.start(pos);
	},
	
	compressAfter: function(element, noAnim){
		var pos = element.retrieve('afterPos');
		var tween = element.get('tween', {property: this.posAttr, duration: this.options.duration, transition: this.options.transition});
		if(noAnim)
			tween.set(pos);
		else
			tween.start(pos);
	},
	
	reset: function(element){
		var pos = element.retrieve('closePos');
		element.get('tween', {property: this.posAttr, duration: this.options.duration, transition: this.options.transition}).start(pos);
	},
	
	resetAll: function(){
		if(this.options.useOverflow)
			this.clearOverflow();

		if(this.options.defaultIndex)
			this.expand(this.options.defaultIndex);
		else
		{
			this.elementsId.each(function(elementId){
				this.reset($(this.containerId + '_Elm' + elementId));
			}, this);
		}
	}
});