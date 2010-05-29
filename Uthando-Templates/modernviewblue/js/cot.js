var Ovr2='';
if (typeof document.compatMode!='undefined'&&document.compatMode!='BackCompat') {
	cot_t1_DOCtp="_top:expression(document.documentElement.scrollTop+document.documentElement.clientHeight-this.clientHeight);_left:expression(document.documentElement.scrollLeft + document.documentElement.clientWidth - offsetWidth);}";
} else {
	cot_t1_DOCtp="_top:expression(document.body.scrollTop+document.body.clientHeight-this.clientHeight);_left:expression(document.body.scrollLeft + document.body.clientWidth - offsetWidth);}";
}
if (typeof document.compatMode!='undefined'&&document.compatMode!='BackCompat') {
	cot_t1_DOCtp2="_top:expression(document.documentElement.scrollTop-20+document.documentElement.clientHeight-this.clientHeight);}";
} else {
	cot_t1_DOCtp2="_top:expression(document.body.scrollTop-20+document.body.clientHeight-this.clientHeight);}";
}
var cot_bgf0=(window.location.protocol.toLowerCase()=="https:")? "https://secure.comodo.net/trustlogo/images/cot_bgf0.gif" : "http://www.trustlogo.com/images/cot_bgf0.gif";

var cot_tl_bodyCSS='* html {background:url('+cot_bgf0+') fixed;background-repeat: repeat;background-position: right bottom;}';
var cot_tl_fixedCSS='#cot_tl_fixed{position:fixed;';
var cot_tl_fixedCSS=cot_tl_fixedCSS+'_position:absolute;';
var cot_tl_fixedCSS=cot_tl_fixedCSS+'bottom:0px;';
var cot_tl_fixedCSS=cot_tl_fixedCSS+'right:0px;';
var cot_tl_fixedCSS=cot_tl_fixedCSS+'clip:rect(0 100 85 0);';
var cot_tl_fixedCSS=cot_tl_fixedCSS+cot_t1_DOCtp;
var cot_tl_popCSS='#cot_tl_pop {background-color: transparent;';
var cot_tl_popCSS=cot_tl_popCSS+'position:fixed;';
var cot_tl_popCSS=cot_tl_popCSS+'_position:absolute;';
var cot_tl_popCSS=cot_tl_popCSS+'height:194px;';
var cot_tl_popCSS=cot_tl_popCSS+'width: 244px;';
var cot_tl_popCSS=cot_tl_popCSS+'right: 120px;';
var cot_tl_popCSS=cot_tl_popCSS+'bottom: 20px;';
var cot_tl_popCSS=cot_tl_popCSS+'overflow: hidden;';
var cot_tl_popCSS=cot_tl_popCSS+'visibility: hidden;';
var cot_tl_popCSS=cot_tl_popCSS+'z-index: 100;';
var cot_tl_popCSS=cot_tl_popCSS+cot_t1_DOCtp2;document.write('<style type="text/css">'+cot_tl_bodyCSS+cot_tl_fixedCSS+cot_tl_popCSS+'</style>');
function cot_tl_bigPopup(url) {
	newwindow=window.open(url,'name','WIDTH=450,HEIGHT=500,FRAMEBORDER=0,MARGINWIDTH=0,MARGINHEIGHT=0,SCROLLBARS=1,allowtransparency=true');
	if(window.focus) {
		newwindow.focus()
	}
	return false;
}
function cot_tl_toggleMiniPOPUP_hide() {
	var cred_id='cot_tl_pop';
	var NNtype='hidden';
	var IEtype='hidden';
	var WC3type='hidden';
	if(document.getElementById) {
		eval("document.getElementById(cred_id).style.visibility=\""+WC3type+"\"");
	} else {
		if(document.layers) {
			document.layers[cred_id].visibility=NNtype;
		} else {
			if(document.all) {
				eval("document.all."+cred_id+".style.visibility=\""+IEtype+"\"");
			}
		}
	}
	document.getElementById('frame_pop').src =cot_tl_dummyMini;
}
function cot_tl_toggleMiniPOPUP_show() {
	cred_id='cot_tl_pop';
	var NNtype='show';
	var IEtype='visible';
	var WC3type='visible';
	if(document.getElementById) {
		eval("document.getElementById(cred_id).style.visibility=\""+WC3type+"\"");
	} else {
		if(document.layers) {
			document.layers[cred_id].visibility=NNtype;
		} else {
			if(document.all) {
				eval("document.all."+cred_id+".style.visibility=\""+IEtype+"\"");
			}
		}
	}
	document.getElementById('frame_pop').src =cot_tl_miniBaseURL;
}
function COT(cot_tl_theLogo,cot_tl_LogoType,LogoPosition,theAffiliate) {
	if (document.getElementById('comodoTL')) {
		document.getElementById('comodoTL').style.display="none";
	}
	host=location.host;
	if(window.location.protocol.toLowerCase()=="https:") {
		cot_tl_dummyMini='https://secure.comodo.net/trustlogo/images/cot_bgf0.gif';
		cot_tl_miniBaseURL='https://secure.comodo.net/ttb_searcher/trustlogo?v_querytype=C&v_shortname='+cot_tl_LogoType+'&v_search='+host+'&x=6&y=5';
		cot_tl_bigBaseURL='https://secure.comodo.net/ttb_searcher/trustlogo?v_querytype=W&v_shortname='+cot_tl_LogoType+'&v_search='+host+'&x=6&y=5';
	} else {
		cot_tl_dummyMini='http://www.trustlogo.com/images/cot_bgf0.gif';
		cot_tl_miniBaseURL='http://www.trustlogo.com/ttb_searcher/trustlogo?v_querytype=C&v_shortname='+cot_tl_LogoType+'&v_search='+host+'&x=6&y=5';
		cot_tl_bigBaseURL='http://www.trustlogo.com/ttb_searcher/trustlogo?v_querytype=W&v_shortname='+cot_tl_LogoType+'&v_search='+host+'&x=6&y=5';
	}
	document.write('<div id="cot_tl_pop">');
	document.write('<IFRAME id="frame_pop" name="frame_pop" src="'+cot_tl_dummyMini+'" WIDTH=244 HEIGHT=194 FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=no allowtransparency=true></IFRAME>');
	document.write('</div>');
	document.write('<div id="cot_tl_fixed">');
	document.write('<a href="http://www.instantssl.com" onClick="return cot_tl_bigPopup(\''+cot_tl_bigBaseURL+'\')"><img src='+cot_tl_theLogo+' alt="SSL Certificate" border="0" onMouseOver="Ovr=setTimeout(\'cot_tl_toggleMiniPOPUP_show()\',1000);clearTimeout(Ovr2)" onMouseOut="Ovr2=setTimeout(\'cot_tl_toggleMiniPOPUP_hide()\',3000);clearTimeout(Ovr)"></a>');
	document.write('</div>');
}