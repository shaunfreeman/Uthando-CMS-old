
UthandoAdminConfig.plugins.load.push('tinyMCE');

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
			//relative_urls : false,
			document_base_url : 'http://uthandocms/',
			file_browser_callback: FileManager.TinyMCE(function(type){
				//type=='image' ?
				return {
					url: '/plugins/ajax_content/filemanager.php',
					assetBasePath: '/templates/admin/images/FileManager',
					language: 'en',
					selectable: true//,
					//uploadAuthData: {session: 'MySessionId'}
				};
			}),
			init_instance_callback : 'UthandoAdmin.tinyMCESize',
   			plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,rj_insertcode",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
   			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,rj_insertcode"
		}
	}
});
