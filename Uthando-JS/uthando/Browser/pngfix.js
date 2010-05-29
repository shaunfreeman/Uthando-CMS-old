
var pngFix = new Class({
	Implements: [Options],
	options: {
		el: '',
		cssBgElements: false,
		initializeOnLoad: true
	},
	initialize: function(options) {
		this.setOptions(options);
		//if (this.options.initializeOnLoad) this.fixPNGElements(this.options.el);
	},
	fixPNGElements: function(element) {
		var allImages = $(element).getElements('img');
		allImages.each(function(img) {
			this.fixPNGImg(img);
		}.bind(this));
		if (this.options.cssBgElements) this.bgImgFix(this.options.cssBgElements);
	},
	fixPNGImg: function(img) {
		var imgProps = img.getProperties('id', 'src', 'title', 'alt', 'align');
		if (imgProps.src.test('.png', 'i')) {
			var imgStyles = img.getStyles('float', 'margin');
			var imgDisplay = 'inline-block';
			if (imgProps.align == 'left') var imgFloat = 'left';
			if (imgProps.align == 'right') var imgFloat = 'right';	
			if (img.getParent().getProperty('href')) var imgCursor = 'hand';
			var replacement = new Element('span', {
				'id': (imgProps.id) ? imgProps.id : '',
				'class': (img.className) ? img.className : '',
				'title': (imgProps.title) ? imgProps.title : (imgProps.alt) ? imgProps.alt : '',
				'styles': {
					'display': imgDisplay,
					'width': img.getWidth() + 'px',
					'height': img.getHeight() + 'px',
					'cursor': imgCursor,
					'float': (imgFloat) ? imgFloat : '',
					'filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader (src='" + imgProps.src + "', sizingMethod='scale')"	
				},
				'src': imgProps.src
			}).setStyles(imgStyles).cloneEvents(img).replaces(img);
		}
	},
	bgImgFix: function(bgElements) {
		var cssImages = $$(bgElements);
		cssImages.each(function(img) {
			var imgURL = img.getStyle('background-image');
			if (imgURL.test(/\((.+)\)/)){
				img.setStyle('background-image', 'none');
				var styles = img.getStyles('position', 'top', 'left', 'width', 'height');
				
				var wrap = new Element('div', {
					styles: {
						'z-index': -1,
						'filter': "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='crop', src=" + imgURL.match(/\((.+)\)/)[1] + ")"
					}
				}).setStyles(styles).inject(img, 'top');
			}
		});
	}
});
