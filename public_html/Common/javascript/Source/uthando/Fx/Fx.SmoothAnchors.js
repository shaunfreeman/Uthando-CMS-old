/**
* @desc Fx.SmoothAnchors - Fx.SmoothAnchors Class.
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
*     - Based on SmoothScroll.js
*/

Fx.SmoothAnchors = new Class({
	
	Extends: Fx.GridScroll,
 
	options: {
		links: ''
	},

	initialize: function(options, context){
		context = $(context) || document;
		var doc = context.getDocument();
		this.win = context.getWindow();
		this.parent(context, options);
		this.links = (this.options.links) ? $$(this.options.links) : $$(doc.links);
		this.attach(this.links);
	},

	attach: function(elements) {
		var location = this.win.location.href.match(/^[^#]*/)[0] + '#';
		$$(elements).each(function(link) {
			if (link.get('href')) {
				if (link.href.indexOf(location) != 0) return;
				var anchor = link.href.substr(location.length);
				if (anchor && $(anchor)) {
					var mouseclick = link.retrieve('FxSmoothAncors:click', this.elementClick.bindWithEvent(this, link));
					link.addEvents({ click: mouseclick });
					link.store('FxSmoothAncors:id', anchor);
				}
			}
		},this);
		return this;
	},
	
	elementClick: function(event, element) {
		event.stop();
		this.toElement(element.retrieve('FxSmoothAncors:id'));
	}
});
