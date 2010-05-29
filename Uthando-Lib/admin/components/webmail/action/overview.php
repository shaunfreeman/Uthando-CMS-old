<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

if ($this->authorize()):

function getAttributesFlagArray($p_attributes){
    $attrs[LATT_HASNOCHILDREN]='false';
    $attrs[LATT_HASCHILDREN]='false';
    $attrs[LATT_REFERRAL]='false';
    $attrs[LATT_UNMARKED]='false';
    $attrs[LATT_MARKED]='false';
    $attrs[LATT_NOSELECT]='false';
    $attrs[LATT_NOINFERIORS]='false';
    $attrsX=$attrs;
    foreach($attrs as $attrkey=>$attrval){
        if ($p_attributes & $attrkey){
            $attrsX[$attrkey]='true';
            $p_attributes-=$attrkey;
        }
    }
    return $attrsX;
}

function decodeMimeStr($string, $charset="UTF-8" )
{
      $newString = '';
      $elements=imap_mime_header_decode($string);
      for($i=0;$i<count($elements);$i++)
      {
        if ($elements[$i]->charset == 'default')
          $elements[$i]->charset = 'iso-8859-1';
        $newString .= iconv($elements[$i]->charset, $charset, $elements[$i]->text);
      }
      return $newString;
} 

/* connect to gmail */
$mboxconnstr = '{localhost:143/imap/notls}';
$username = 'shaunfre';
$password = 'lusatacr';

$this->addContent(file_get_contents('webmail/browser.html',true));

/* try to connect */
/*
$mbox = imap_open($mboxconnstr,$username,$password) or die('Cannot connect to IMAP: ' . imap_last_error());

$list = imap_getmailboxes($mbox, $mboxconnstr, "*");

 if(is_array($list)){
        foreach($list as $fkey=>$folder){
            $mapname = str_replace($mboxconnstr, "", imap_utf7_decode($folder->name));
            if($mapname[0] != ".") {
                //$attrs[LATT_]=': NO';
                $list_folders[$fkey]['name'] = $folder->name;
                $list_folders[$fkey]['nameX'] = $mapname;
                $list_folders[$fkey]['delimiter'] = $folder->delimiter;
                $list_folders[$fkey]['attributes'] = $folder->attributes;
                $list_folders[$fkey]['attr_values'] = getAttributesFlagArray($folder->attributes);
            }
        }
    }else echo "Call failed<br />\n";
    
    foreach ($list_folders as $key => $value):
		$mbox_dir = imap_open($value['name'],$username,$password);
		$emails = imap_search($mbox_dir,'ALL');
		$output = null;
		if ($emails):
			foreach($emails as $email_number):
				$overview = imap_fetch_overview($mbox_dir,$email_number,0);
				$message = imap_fetchbody($mbox_dir,$email_number, 2);
				$subject = imap_mime_header_decode($overview[0]->subject);
				$from = imap_mime_header_decode($overview[0]->from);
				
				if ($from[0]->charset == 'default'):
					$from = $from[0]->text;
				else:
					$from = utf8_decode($from[0]->text);
				endif;
				
				if ($subject[0]->charset == 'default'):
					$subject = $subject[0]->text;
				else:
					$subject = utf8_decode($subject[0]->text);
				endif;
				
				//print_rr($subject);
				//print_rr($from);
				
				$output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
				$output.= '<span class="subject">'.HTML_Element::makeXmlSafe($subject).'</span> ';
				$output.= '<span class="from">'.HTML_Element::makeXmlSafe($from).'</span>';
				$output.= '<span class="date">on '.$overview[0]->date.'</span>';
				$output.= '</div>';
		
				// output the email body
				//$output.= '<div class="body">'.HTML_Element::makeXmlSafe($message).'</div>';
				
			endforeach;
			$tab_array[$value['nameX']] = $output;
		endif;
    endforeach;
    
    $tabs = new HTML_Tabs($tab_array);
*/
/* grab emails */
//$emails = imap_search($inbox,'ALL');

/* if emails are returned, cycle through each... */
//if($emails) {
	
	/* begin output var */
	//$output = '<div id="content">';
	
	/* put the newest emails on top */
	//rsort($emails);
	
	
	// for every email...
	/*
	foreach($emails as $email_number) {
		
		// get information specific to this email
		$overview = imap_fetch_overview($inbox,$email_number,0);
		//$message = imap_fetchbody($inbox,$email_number,2);
		
		// output the email header information
		$output.= '<div class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
		$output.= '<span class="subject">'.HTML_Element::makeXmlSafe($overview[0]->subject).'</span> ';
		$output.= '<span class="from">'.HTML_Element::makeXmlSafe($overview[0]->from).'</span>';
		$output.= '<span class="date">on '.$overview[0]->date.'</span>';
		$output.= '</div>';
		
		// output the email body
		//$output.= '<div class="body">'.HTML_Element::makeXmlSafe($message).'</div>';
	}
	*/
	//$output.= '</div>';
	//$this->addContent( $tabs->toHTML() );
	
	$this->registry->component_js = array(
		'/components/webmail/js/webmail.js'
	);
//} 

/* close the connection */
//imap_close($mbox);

endif;
?>