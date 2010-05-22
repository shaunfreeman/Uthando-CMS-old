
UthandoAdmin.extend({
	saveFormButton: function() {
		if ($('save-24')) {
			$('save-24').addEvent('click', function(event){
				event.stop();
				$('mootools_edit').submit();
			});
		}
	}
});

var Download = {
	start: function(){
		Download.trs = $$('.option');
		Download.chks = $$('#download div.check');
		Download.radios = $$('#options div.check');
		
		Download.fx = [];
		Download.parse();
		
		[].extend(Download.chks).extend(Download.radios).each(function(chk){
			chk.inputElement = chk.getElement('input').setStyle('display', 'none');
		});
		
		Download.chks.each(function(chk){
			if (chk.inputElement.checked) Download.select(chk);
		});
		
		Download.select(Download.chks[0]);
		//Download.select(Download.radios[0]);
	},

	select: function(chk){
		chk.inputElement.checked = 'checked';
		
		Download.fx[chk.index].start({
			'color': '#fff'
		});
		
		chk.addClass('selected');
		
		if (chk.deps){
			chk.deps.each(function(id){
				if (!$(id).hasClass('selected')) Download.select($(id));
			});
		} else {
			Download.radios.each(function(other){
				if (other == chk) return;
				Download.deselect(other);
			});
		}
	},
	
	all: function(){
		Download.chks.each(function(chk){
			Download.select(chk);
		});
	},
	
	none: function(){
		Download.chks.each(function(chk){
			Download.deselect(chk);
		});
	},

	deselect: function(chk){
		chk.inputElement.checked = false;
		Download.fx[chk.index].start({
			'color': '#000'
		});
		chk.removeClass('selected');
		
		if (chk.deps){
			Download.chks.each(function(other){
				if (other == chk) return;
				if (other.deps.contains(chk.id) && other.hasClass('selected')) Download.deselect(other);
			});
		}
	},

	parse: function(){
		Download.trs.each(function(tr, i){
			Download.fx[i] = new Fx.Morph(tr, {wait: false, duration: 300});

			var chk = tr.getElement('div.check');
			chk.index = i;
			var dp = chk.getProperty('deps');
			if (dp) chk.deps = dp.split(',');

			tr.onclick = function(){
				if (Download.isQuick && tr.hasClass('file')){
					Download.quicks.each(function(lee, e){
						if (lee.chosen) Download.quickFx[e].start('0 0');
					});
					Download.isQuick = false;
				}
				
				if (!chk.hasClass('selected')) Download.select(chk);
				else if (tr.hasClass('file')) Download.deselect(chk);
			};
			
			tr.addEvent('mouseenter', function(){
				if (!chk.hasClass('selected')){
					Download.fx[i].start({
						'color': '#fff'
					});
				}
			});
			
			tr.addEvent('mouseleave', function(){
				if (!chk.hasClass('selected')){
					Download.fx[i].start({
						'color': '#000'
					});
				}
			});

		});
	}
};

window.addEvent('domready', function(){
	
	Download.start();
	
	$('template_select').addEvent('change', function(e){
		this.form.submit();
	});
});