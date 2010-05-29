
Fx.MorphElement = new Class({
	
	Extends: Fx.Morph,
	
	options: {
		wrap: true,
		wrapClass: 'morphElementWrap',
		FxTransition : $empty,
		hideOnInitialize: true
	},
	
	initialize: function(el, options) {
		this.setOptions(options);
		this.parent(el, options);
		
		if (this.options.wrap) this.setup();
		
		if (this.options.hideOnInitialize) {
			this.element.store('fxEffect:flag', 'hide');
			this.getFx('fade');
		}
	},
	
	setup: function() {
		var wrap = new Element('div', {
			'id': this.element.get('id') + '_wrap',
			'class': this.options.wrapClass,
			'styles': {
				'height': this.options.height,
				'width': this.options.width,
				'overflow': 'hidden'
			}
		}).wraps(this.element);
	},
	
	getFx: function(fx) {
		
		var flag = this.element.retrieve('fxEffect:flag', 'show');
		
		var styles = {
			'margin-top': [0, 0],
			'margin-left': [0, 0],
			'width': [this.options.width, this.options.width],
			'height': [this.options.height, this.options.height],
			'opacity': [1, 1]
		};
		
		fxEffect = this.element.get('morph', this.options.FxTransition);
		
		fx = fx.split(':');
		
		if (fx.length > 1) {
			fx = Fx.MorphElement.Effects[fx[0]][fx[1]][flag];
		} else {
			fx = Fx.MorphElement.Effects[fx[0]][flag];
		}
		
		$H(fx).each(function(hash, hashIndex){
			hash.each(function(item, index){
				if ($type(item) == 'string') {
					hash[index] = item.substitute({'width': this.options.width, 'height': this.options.height});
				}
			}.bind(this));
			styles[hashIndex] = hash
		}.bind(this));
		
		styles = fxEffect.start(styles);
		
		this.element.store('fxEffect:flag', (flag == 'hide') ? 'show' : 'hide');
		
		return styles;
	}
});

Element.Properties.morphElement = {

	set: function(options){
		var morphElement = this.retrieve('morphElement');
		if (morphElement) morphElement.cancel();
		return this.eliminate('morphElement').store('morphElement:options', $extend({link: 'cancel'}, options));
	},

	get: function(options){
		if (options || !this.retrieve('morphElement')){
			if (options || !this.retrieve('morphElement:options')) this.set('morphElement', options);
			this.store('morphElement', new Fx.MorphElement(this, this.retrieve('morphElement:options')));
		}
		return this.retrieve('morphElement');
	}

};

Element.implement({

	morphElement: function(props){
		this.get('morphElement').getFx(props);
		return this;
	}

});

Fx.MorphElement.Effects = $H({
	blind: {
		up: {
			hide: {
				'height': ['{height}', 0]
			},
			show: {
				'margin-top': ['{height}', 0],
				'height': [0, '{height}']
			}
		},
		down: {
			hide: {
				'margin-top': ['{height}'],
				'height': [0]
			},
			show: {
				'height': [0, '{height}']
			}
		},
		left: {
			hide: {
				'width': ['{width}', 0]
			},
			show: {
				'margin-left': ['{width}', 0],
				'width': [0, '{width}']
			}
		},
		right: {
			hide: {
				'margin-left': ['{width}'],
				'width': [0]
			},
			show: {
				'width': [0, '{width}']
			}
		}
	},
	slide: {
		up: {
			hide: {
				'margin-top': [0, '-{height}'],
				'width': ['{width}'],
				'height': ['{height}']
			},
			show: {
				'margin-top': ['{height}', 0]
			}
		},
		down: {
			hide: {
				'margin-top': [0, '{height}'],
				'width': ['{width}'],
				'height': ['{height}']
			},
			show: {
				'margin-top': ['-{height}', 0]
			}
		},
		left: {
			hide: {
				'margin-left': [0, '-{width}'],
				'width': ['{width}'],
				'height': ['{height}']
			},
			show: {
				'margin-left': ['{width}', 0]
			}
		},
		right: {
			hide: {
				'margin-left': [0, '{width}'],
				'width': ['{width}'],
				'height': ['{height}']
			},
			show: {
				'margin-left': ['-{width}', 0]
			}
		}
	},
	fade: {
		hide: {
			'opacity': [1, 0]
		},
		show: {
			'opacity': [0, 1]
		}
	}
});
