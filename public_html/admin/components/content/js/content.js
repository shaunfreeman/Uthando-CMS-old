
window.addEvent('domready', function() {
	
	$('edit_params').fade('hide').store('fade:flag', 0);
	
	$('params-24').addEvent('click', function(event){
		event.stop();
		if ($('edit_params').retrieve('fade:flag') == 0) {
			$('edit_html').fade('toggle').setStyle('display', 'none');
			$('edit_params').setStyle('display', 'block');
			$('edit_params').fade('toggle');
		}
	});

	$('edit-24').addEvent('click', function(event){
		event.stop();
		if ($('edit_html').retrieve('fade:flag') == 0) {
			$('edit_params').fade('toggle').setStyle('display', 'none');
			$('edit_html').setStyle('display', 'block');
			$('edit_html').fade('toggle');
		}
	});
});