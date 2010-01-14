
UthandoAdmin.extend({
	menuForm: function() {
		
		UthandoAdmin.hideElement('component_link');
		UthandoAdmin.hideElement('external_link');
		
		$('component').addEvent('click', function(){
			UthandoAdmin.hideElement('external_link');
			UthandoAdmin.showElement('component_link');
		});
	
		$('external').addEvent('click', function(){
			UthandoAdmin.hideElement('component_link');
			UthandoAdmin.showElement('external_link');
		});
		
		$('heading').addEvent('click', function(){
			UthandoAdmin.hideElement('component_link');
			UthandoAdmin.hideElement('external_link');
		});
		
		$$('input[name=item_type_id]').each(function(item){
			if (item.checked == true && item.id != 'heading_link') {
				UthandoAdmin.showElement(item.id + '_link');
			}
		});
		
	}
});

window.addEvent('domready', function(){
	UthandoAdmin.menuForm();
});