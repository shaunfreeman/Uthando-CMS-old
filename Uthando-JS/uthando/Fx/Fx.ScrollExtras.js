/**
* @desc Fx.ScroolExtras - Extends Fx.Scroll Class.
* @author Shaun Freeman <shaun@shaunfreeman.co.uk> http:www.shaunfreeman.co.uk
* @date Fri 21 Nov 2008
*
*/
Fx.Scroll.extend({
	
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
