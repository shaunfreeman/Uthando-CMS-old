
UthandoAdmin.extend({
	// ============================================================
	// = tinyMCE Height Fix                                       =
	// ============================================================
	tinyMCESize: function() {
		if ($('content_textarea_parent')) {
			var pos = $("contentPage").getCoordinates();
			var toolbarPos = $('content_textarea_toolbar1').getCoordinates();
			var newHeight = pos.height - 45;
		
			$$('.formError').each(function(item){
				newHeight -= item.getCoordinates().height;
			});
		
			$('content_textarea_tbl').setStyles({
				height: newHeight  + 'px',
				width: pos.width - 25 + 'px'
			});
		
			$('content_textarea_ifr').setStyles({
				height: newHeight - (toolbarPos.height * 5) + 'px',
				width: pos.width - 25 + 'px'
			});
		}
	},
	// ============================================================
	// = tinyMCE initialize function                              =
	// ============================================================
	tinyMCE: $H({}),
	tinyMCEInit: function() {
		
		this.tinyMCEConfig = $H(UthandoAdminConfig.get('tinyMCE'));
		this.tinyMCE = $H(this.tinyMCEConfig.get('tinyMCEElements'));
		
		this.tinyMCE.each(function(value, key) {
			this.params = $H(value);
			if (document.getElement(key)) {
				this.get('tinyMCE').set(key, tinyMCE.init(this.tinyMCEConfig.get('options')));
			}
			
		},this);

		window.addEvent('resize', function(){
			UthandoAdmin.tinyMCESize();
		});
	},
	// ============================================================
	// = codeMirror initialize function                           =
	// ============================================================
 	initCodeMirror: function() {
		var w = $('edit_html').getWidth()-30;
		this.codeEditor = CodeMirror.fromTextArea('content_textarea', {
			width: w+"px",
			height: "325px",
			parserfile: "parsexml.js",
			stylesheet: "/Common/editor/CodeMirror/css/xmlcolors.css",
			path: "/Common/editor/CodeMirror/js/",
			//continuousScanning: 500,
			//lineNumbers: false,
			indentUnit: 4,
			tabMode:"shift"
  		});
	},
	// ============================================================
	// = Submit form button                                       =
	// ============================================================
	saveFormButton: function() {
		if ($('save-24')) {
			$('save-24').addEvent('click', function(e){
				e.stop();
				try {
					$('content_textarea').value = this.codeEditor.getCode();
				} catch (e){}
				$('mainDiv').getElement('form').submit();
			}.bind(this));
		}
	}
});
