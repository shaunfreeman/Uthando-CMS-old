
Request.implement({
	success: function(text, xml){
		this.onSuccess(text, xml);
	}
});

function initCodeMirror() {
	UthandoAdmin.codeEditor = CodeMirror.fromTextArea('code', {
		width:"100%",
		height: "350px",
		parserfile: "parsexml.js",
		stylesheet: "/Common/editor/CodeMirror/css/xmlcolors.css",
  		path: "/Common/editor/CodeMirror/js/",
		continuousScanning: 500,
		lineNumbers: true,
		textWrapping: true,
		indentUnit: 4,
		tabMode:"shift"
  });
}

window.addEvent('domready', function(){
	
	var code = $('code').get('text');
	
	var request = new Request({
		url: '/plugins/ajax_content/codemirror.php',
		data: 'url='+code,
		evalScripts: false,
		evalResponse: false,
		onComplete: function(response){
			$('code').set('text', response);
			initCodeMirror();
		}
	}).send();
});
