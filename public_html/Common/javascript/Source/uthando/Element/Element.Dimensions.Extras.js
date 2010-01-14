/*
Script: Element.Dimensions.Extras.js
/**
* @desc Element.Dimensions.Extras.js - Scroll detection for elements.
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
* @version 1.0 - Wed Dec 17 2008
*     - 1st release
*/

Element.implement({
	computeScroll: function(x,y,offset) {
		if (!offset) var offset = {x:0, y:0};
		var offsetSize = this.getSize(), scrollSize = this.getScrollSize();
		var scroll = this.getScroll(), values = {x: x, y: y};
		for (var z in values){
			var max = scrollSize[z] - offsetSize[z];
			if ($chk(values[z])) {
				values[z] = ($type(values[z]) == 'number') ? values[z].limit(0, max) : max;
			} else {
				values[z] = scroll[z];
			}
			values[z] += offset[z];
		}
		return {now:{x:scroll.x, y:scroll.y}, max:{x:values.x, y:values.y}};
	},
	
	isScrollMaxY: function() {
		var scroll = this.computeScroll(false,'bottom');
		if (scroll.now.y == scroll.max.y) return true;
	},
	
	isScrollMaxX: function() {
		var scroll = this.computeScroll('right',false);
		if (scroll.now.x == scroll.max.x) return true;
	}
});
