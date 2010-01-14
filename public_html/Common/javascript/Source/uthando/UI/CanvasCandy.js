
var CanvasCandy = new Class({
	
	Implements: [Events, Options],
 
	options: {
		size : {
			x: 100,
			y: 200
		},
		actions: $H({})
	},
 
	initialize: function(el, options) {
		
		this.setOptions(options);
		this.el = $(el);
		
		this.options.size = this.el.getSize();
		
		this.options.size.x = this.options.size.x - (this.el.getStyle('border-left').toInt() + this.el.getStyle('border-right').toInt());
				
		this.options.size.y = this.options.size.y - (this.el.getStyle('border-top').toInt() + this.el.getStyle('border-bottom').toInt());
		
		this.el.getDivWrap({
			'class': 'canvasContentDivWrap',
			styles: {
				'position': 'relative',
				'padding':'0px',
				'margin':'0px'
			}
		}, this.el,null,true);
		
		this.wrap = this.el.getDivWrap({
			'class': 'canvasDivWrap',
			styles: {
				'position': 'relative',
				'padding':'0px',
				'margin':'0px'
			}
		}, this.el, 'top');
		
		this.setCanvas();
		
		this.attach(this.el);
		
		//this.paint();
		
		window.addEvent('resize',function (e) {
			this.resize();
		}.bind(this));
	},
 
	attach: function(element) {
		
	},
 
	setCanvas: function() {
		this.canvas = new Canvas({
			id: this.el.get('id')+'_canvasCandy'+$random(1, 100),
			width: this.options.size.x,
			height: this.options.size.y
		});
		
		$(this.wrap).adopt(this.canvas);
		
		this.ctx = this.canvas.getContext('2d');
		
		this.canvas.setStyles({
			'position': 'absolute',
   			'left': 0 - this.el.getStyle('padding-left').toInt() + 'px',
   			'top':'0px',
   			'padding':'0px',
   			'margin':'0px'
		});
		
		this.el.setStyle('background', 'none');
	},
 
	paint: function() {
		
		this.options.actions.each(function(item, enable) {
			CanvasCandy.Plugins[enable].run(item, this);
		}.bind(this));
	},
	
	store: function(plugin, opts) {
		this.options.actions.set(plugin, opts || {});
	},
 
	retrieve: function(plugin) {
		return this.options.actions.get(plugin);
	},
	
 	resize: function() {
		var size = this.el.getSize();
		
		size.x = size.x - (this.el.getStyle('border-left').toInt() + this.el.getStyle('border-right').toInt());
				
		size.y = size.y - (this.el.getStyle('border-top').toInt() + this.el.getStyle('border-bottom').toInt());
		
		this.canvas.setProperties({
			width: size.x,
			height: size.y
		});
		this.options.size.x = size.x;
		this.options.size.y = size.y;
		
		this.paint();
	}
});

CanvasCandy.Plugins = $H({
	
	rect: function (opts) {
		
		var height = this.options.size.y;
		var width = this.options.size.x;
		
		this.ctx.beginPath();
		this.ctx.rect(0, 0, width, height);
		this.ctx.closePath();
	},
	
	roundedRect: function (opts){
		
		if ($type(opts.radius) != 'array') return false;
		
		var height = this.options.size.y;
		var width = this.options.size.x;
		
		this.ctx.strokeStyle = opts.background;
		
		this.ctx.beginPath();
		
		this.ctx.moveTo(0,opts.radius[0]);
		this.ctx.lineTo(0,height-opts.radius[3]);
		this.ctx.quadraticCurveTo(0,height,opts.radius[3],height);
		this.ctx.lineTo(width-opts.radius[2],height);
		this.ctx.quadraticCurveTo(width,height,width,height-opts.radius[2]);
		this.ctx.lineTo(width,opts.radius[1]);
		this.ctx.quadraticCurveTo(width,0,width-opts.radius[1],0);
		this.ctx.lineTo(opts.radius[0],0);
		this.ctx.quadraticCurveTo(0,0,0,opts.radius[0]);
		
		this.ctx.closePath();
		this.ctx.stroke();
		
	},

 	fill: function(opts) {
		this.ctx.fillStyle = opts.color;
		this.ctx.fill();
	},

	gradient: function(opts) {
		
		var lingrad = this.ctx.createLinearGradient(0,0,0,this.options.size.y);
		
		opts.colorStop.each(function(item){
			lingrad.addColorStop(item[0], item[1]);
		});

  		// assign gradients to fill and stroke styles
		this.ctx.fillStyle = lingrad;
		
		this.ctx.fill();
	},

	border: function(opts) {
		
		var height = this.options.size.y;
		var width = this.options.size.x;
		this.ctx.strokeStyle = opts.background;
		this.ctx.strokeRect(0,0,width,height);
		this.ctx.stroke();
	},
 
	shadow: function(opts) {
	},
 
	image: function(opts) {
	},
 
 	reflect: function(opts) {
	}
	
});

CanvasCandy.gradients = $H({});
