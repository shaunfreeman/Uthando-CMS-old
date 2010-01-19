
window.addEvent('domready', function() {
	
	$('edit_html').fade('hide').store('fade:flag', 0);
	$('edit_html').setStyle('display', 'none');
	
	var id = 'content_textarea';
	
	tinyMCE.execCommand('mceRemoveControl', false, id);
	
	var menuItems = UthandoAdmin.IconMenu.imgs;
	
	UthandoAdmin.IconMenu.removeItems([menuItems[0], menuItems[2]]);
	
	$('params-24').addEvent('click', function(event){
		event.stop();
		
		var li = new Element('li').inject('iconMenuStrip', 'top');
		menuItems[1].inject(li);
		
		UthandoAdmin.IconMenu.addItem(menuItems[1]);
		UthandoAdmin.IconMenu.removeItems([menuItems[0], menuItems[2]]);
		
		if ($('edit_params').retrieve('fade:flag') == 0) {
			$('edit_html').fade('toggle').setStyle('display', 'none');
			$('edit_params').setStyle('display', 'block');
			$('edit_params').fade('toggle');
		}
	});

	$('edit-24').addEvent('click', function(event){
		event.stop();
		
		var li = new Element('li').inject('iconMenuStrip', 'top');
		menuItems[2].inject(li);
		
		var li = new Element('li').inject('iconMenuStrip', 'top');
		menuItems[0].inject(li);
		
		UthandoAdmin.IconMenu.addItem(menuItems[0]);
		UthandoAdmin.IconMenu.addItem(menuItems[2]);
		UthandoAdmin.IconMenu.removeItems([menuItems[1]]);
		
		if ($('edit_html').retrieve('fade:flag') == 0) {
			$('edit_params').fade('toggle').setStyle('display', 'none');
			$('edit_html').setStyle('display', 'block');
			$('edit_html').fade('toggle');
			if (tinyMCE.get(id)) UthandoAdmin.tinyMCESize();
		}
	});
	
	$('html-24').addEvent('click', function(e){
		e.stop();
		var buttonText = this.getElement('span');
		if (!tinyMCE.get(id)){
			$(id).value = UthandoAdmin.codeEditor.getCode();
			$('edit_html').removeClass('codeWrap');
			$('content_textarea').removeClass('code');
			UthandoAdmin.codeMirror = $(id).getNext().dispose();
			tinyMCE.execCommand('mceAddControl', false, id);
			$(id).getNext().removeProperty('style');
			buttonText.set('text', 'Html');
		} else {
			tinyMCE.execCommand('mceRemoveControl', false, id);
			$('edit_html').addClass('codeWrap');
			$('content_textarea').addClass('code');
			UthandoAdmin.initCodeMirror();
			buttonText.set('text', 'TinyMCE');
		}
	})
});