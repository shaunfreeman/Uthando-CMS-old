
Element.implement({
	getScrollMax: function(x,y) {
		var offset = {'x':0, 'y':0};
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
	}
});

var setup = $H({
	title: 'Uthando CMS Setup | ',
	
	error: false,
	stage: 0,
	
	init: function(){
		this.request('stage=1');
	},
	
	stage1: function(){
		document.title = this.title + 'Server Check';
		if ($('next')) {
			$('next').addEvent('click', function(e) {
				this.request('stage=2');
			}.bind(this));
		}
	},
	
	stage2: function(){
		document.title = this.title + 'Licence';
		
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
		
		$('licence_accept').addEvent('click', function(e) {
			this.request('stage=3');
		}.bind(this));
		
		$('previous').addEvent('click', function(e) {
			this.request('stage=1');
		}.bind(this));
	},
	
	stage3: function() {
		document.title = this.title + 'FTP Settings';
		
		$('submit').addEvent('click', function(e) {
			this.submitForm('submit');
		}.bind(this));
		
		$('previous').addEvent('click', function(e) {
			this.request('stage=2');
		}.bind(this));
	},
	
	stage4: function() {
		document.title = this.title + 'Database Settings';
		
		$('submit').addEvent('click', function(e) {
			this.submitForm('submit');
		}.bind(this));
		
		$('previous').addEvent('click', function(e) {
			this.request('stage=3');
		}.bind(this));
	},
	
	request: function(postData){
		new Request.HTML({
			method: 'get',
			data: postData,
			url: '/setup/ajax.php',
			update: $('setupContentWrap'),
			useSpinner: true,
			onRequest: function(){
			}.bind(this),
			onSuccess: function(){
				this[postData.replace('=', '')]();
			}.bind(this),
			onFailure: function(){
			}.bind(this)
		}).send();
	},
	
	submitForm: function(el){

		var post = new Form.Request($('setupForm'), null, {
			requestOptions: {
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript){
					this.mask = new Mask($('setupForm')).show();
					this.messageBox(responseHTML);
				}.bind(this)
			}
		}).send();
	},
	
	messageBox: function(msg) {
		$('messageBox').set('html', '<div id="messageBoxHeader" class="headerDiv"><span>MessageBox</span></div><div id="messageBoxContent">' + msg + '</div><div id="messageBoxFooter"><p id="messageBoxOK" class="button">OK</p></div>');
		$('messageBox').position();
		
		if (this.error) {
			$('messageBoxOK').addEvent('click', function(){
				this.mask.hide();
				this.error = false;
				$('messageBoxOK').removeEvents('click');
				$('messageBox').empty();
			}.bind(this));
		} else {
			$('messageBoxOK').addEvent('click', function(){
				$('messageBoxOK').removeEvents('click');
				$('previous').removeEvents('click');
				$('submit').removeEvents('click');
				$('messageBox').empty();
				this.request('stage='+this.stage);
				this.mask.hide();
			}.bind(this));
		}
	}
});

window.addEvent('domready', function() { setup.init(); });
