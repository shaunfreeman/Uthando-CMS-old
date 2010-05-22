
window.addEvent('domready', function(){
	
	$('default-24').addEvent('click', function(e){
		e.stop();
		$('template').submit();
	});
	
	$('edit-24').addEvent('click', function(e){
		e.stop();
		
		$('template').getElements('input').each(function(item){
			if (item.get('checked')) {
				var tmpl = item.get('value').split(':');
				window.location = '/template/edit/type-'+tmpl[0]+'/id-'+tmpl[1];
			}
		});
	});
	
});
