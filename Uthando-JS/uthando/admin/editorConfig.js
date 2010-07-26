
UthandoAdminConfig.plugins.load.push('tinyMCE');

var url = new URI(window.location);
var server = url.get('host').split('.');
var loc = 'http://';
var dot = '';
if (server.length > 2) dot = '.';
server.each(function(item, index){
	if (index != 0) {
		loc += item;
		if (index != server.length - 1) loc += dot;
	}
});

UthandoAdminConfig.extend({
	tinyMCE: {
		enable: UthandoAdmin.tinyMCEInit,
		tinyMCEElements: {
			textarea: {}
		},
		options: {
			mode : "textareas",
			elements : "absurls",
			editor_selector : "mceEditor",
			theme : "advanced",
			skin: 'o2k7',
			skin_variant: 'silver',
			relative_urls : false,
			document_base_url : loc,
			extended_valid_elements: 'div[*]',
			file_browser_callback: FileManager.TinyMCE(function(type){
				//type=='image' ?
				return {
					url: '/ajax/filemanager.php',
					assetBasePath: '/images/FileManager/',
					language: 'en',
					selectable: true,
					uploadAuthData: {
						session: UthandoAdmin.sid
					}
				};
			}),
			init_instance_callback : 'UthandoAdmin.tinyMCESize',
   			plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,rj_insertcode",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
   			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,rj_insertcode"
		}
	}
});
