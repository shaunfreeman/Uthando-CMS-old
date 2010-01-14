window.addEvent('domready', function() {
	$('loadingDivWrap').setStyle('display', 'none');
	
	var sslUrl = $('stage4').getElement('input[name=ssl_url]').getParent();
	var enableSSL = $('stage4').getElement('input[name=enable_ssl]');
	
	sslUrl.setStyle('display', 'none');
	
	enableSSL.addEvent('click', function(event){
		switch (this.get('checked')) {
			case true:
				sslUrl.setStyle('display', 'block');
				break;
			case false:
				sslUrl.setStyle('display', 'none');
				break;
		}
	});
	
	var scrollWindow = new Fx.GridScroll('setupContentWrap', {mode:'horizontal'});
	
	var smooth = new Fx.SmoothAnchors({links: '#licence a'}, 'licence');
	
	var messageFx = new Fx.Tween($('messageBox'),{duration:'short'});
	
	function checkSettings(stage,x,y) {
		var request = new Request.HTML({
			url: 'check_settings.php?stage='+stage,
			data: $('stage'+stage),
			update: $('messageBox'),
			onRequest: function() {
				$('messageBox').empty().erase('style');
				var windowSize = window.getSize();
				
				$('loadingDivWrap').setStyle('display', 'block');
				
				$('loadingDivWrap').setStyles({
					'left': ((windowSize.x / 2) - ($('loadingDivWrap').getSize().x / 2)) + 'px',
					'top': ((windowSize.y / 2) - ($('loadingDivWrap').getSize().y / 2)) + 'px'
				});
			},
			onComplete: function() {
				$('loadingDivWrap').setStyle('display', 'none');
				
				var windowSize = window.getSize();
				var messageBox = $('messageBox').getSize();
				var pos = $('stage'+stage).getElement('.formFooters').getCoordinates();
				
				$('messageBox').setStyles({
					'left': ((windowSize.x / 2) - ($('messageBox').getSize().x / 2)) + 'px',
					'top': pos.top + pos.height + 'px',
					'height': '0px'
				});
				
				messageFx.start('height',[0,messageBox.y]).chain(function(){
					if ($('messageBox').get('text').match('correct')) {
						(function(){ 
							scrollWindow.start(x,y);
							$('messageBox').empty();
						}).delay(1000);
					} else {
						$('messageBox').highlight('#f00');
					}
				});
			}
		});
		request.send();
	}
	
	$$('.next, .previous').each(function(item){
		var cell = item.getParent().getParent();
		var pos = cell.getPosition($('table-row'));
		var margin = cell.getStyle('margin-left').toInt();
		var width = $('setupContentWrap').getSize().x;
		
		item.addEvent('click', function(){
			var x = (item.hasClass('next')) ? (pos.x - margin) + width : (pos.x - margin) - width;
			
			if (cell.id.substr(-1) > 1 && item.hasClass('next')) {
				checkSettings(cell.id.substr(-1), x, 0);
			} else {
				scrollWindow.start(x, 0);
			}
			
			$('messageBox').empty();
		});
	});
	
	$('licence').addEvent('scroll', function(){
		if ($('licence').isScrollMaxY('bottom')) {
			$('stage1').getElement('p.next').setStyle('display', 'block');
		}
	});
	
});
