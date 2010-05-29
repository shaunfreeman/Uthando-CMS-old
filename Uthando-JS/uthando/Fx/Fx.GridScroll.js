/**
* @desc GridScroll - GridScroll Class.
* @author Shaun Freeman <shaun@shaunfreeman.co.uk> http:www.shaunfreeman.co.uk
* @date Fri 21 Nov 2008
* @license      GNU/GPL, see LICENSE.txt
*   This program is free software: you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation, either version 3 of the License, or
*   (at your option) any later version.
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with this program.  If not, see <http://www.gnu.org/licenses/>.
* @version 1.0 - Fri 21 Nov 2008
*     - 1st release
*     - Based on Fx.Scroll.js
*/
Fx.GridScroll = new Class({
	
	Extends: Fx,
	
	options: {
		offset: {'x': 0, 'y': 0},
		wheelStops: true,
		activateElement: '',
		mode: 'diagonal'
	},
 
	position: {'x':0, 'y':0},
		
	initialize: function(element, options) {
		this.element = this.subject = $(element);
		this.parent(options);
		var cancel = this.cancel.bind(this, false);

		if ($type(this.element) != 'element') this.element = $(this.element.getDocument().body);

		var stopper = this.element;

		if (this.options.wheelStops){
			this.addEvent('start', function(){
				stopper.addEvent('mousewheel', cancel);
			}, true);
			this.addEvent('complete', function(){
				stopper.removeEvent('mousewheel', cancel);
			}, true);
		}
		
		this.setList(this.element, true);
		this.list.each(function(element){
			this.setPosition(element);
		},this);
		if (this.options.activateElement) this.toElement(this.options.activateElement);
		$(element).addEvent('scroll', function() {
			this.position = this.element.getScroll();
		}.bind(this));
		window.addEvent('resize', function() {
			this.list.each(function(element){
				this.setPosition(element);
			},this);
		}.bind(this));
	},
 
	setList: function(element, deleteList){
		if (deleteList) this.list = [];
		if($type(element) == 'element') {
			var el = element.getChildren();
			el.each(function(item) {
				this.list.push(item);
				this.setList($(item), false);
			},this);
		}
		return this;
	},
 
	setPosition: function(element) {
		$(element).store('FxScroll:position', $(element).getPosition(this.element));
		return this;
	},
	
	set: function(){
		var now = Array.flatten(arguments);
		this.element.scrollTo(now[0], now[1]);
	},

	compute: function(from, to, delta){
		var now = [];
		var x = 2;
		x.times(function(i){
			now.push(Fx.compute(from[i], to[i], delta));
		});
		return now;
	},

	start: function(x, y){
		if (!this.check(arguments.callee, x, y)) return this;
		var pos = this.element.getScrollMax(x,y,this.options.offset);
		var scroll = pos.now, values = pos.max;
		return this.parent([scroll.x, scroll.y], [values.x, values.y]);
	},
 
	getPosition: function(el) {
		return $(el).retrieve('FxScroll:position');
	},

	toTop: function(){
		return this.start(false, 0);
	},

	toLeft: function(){
		return this.start(0, false);
	},

	toRight: function(){
		return this.start('right', false);
	},

	toBottom: function(){
		return this.start(false, 'bottom');
	},
	
	toElement: function(el) {
		var position = this.getPosition(el);
		return this[this.options.mode](position);
	},
	
	diagonal: function(position) {
		return this.start(position.x, position.y);
	},
	
	horizontal: function(position) {
		this.chain(
  			function() { (position.x != this.position.x) ? this.start(position.x, false) : this.callChain(); },
  			function() { this.start(false, position.y); }
		);
		return this.callChain();
	},
 
	vertical: function(position) {
		this.chain(
  			function() { (position.y != this.position.y) ? this.start(false, position.y) : this.callChain(); },
			function() { this.start(position.x, false); }
		);
		return this.callChain();
	}
});
