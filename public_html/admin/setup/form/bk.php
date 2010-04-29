// stage 2 - FTP settings
$form->addElement('html', '<div id="stage2" class="table-cell"><fieldset>');

$form->addElement('header',null,'Stage 2 | FTP Settings');
	
$form->addElement('text', 'port', 'Port:', array('size' => 4, 'value' => '21'));
$form->addElement('text', 'host', 'Host:', array('size' => 30, 'value' => 'localhost'));
$form->addElement('text', 'username', 'Username:', array('size' => 30, 'maxlength' => 100));

$form->addElement('password', 'password', 'Password:', array('size' => 30, 'maxlength' => 20));
		
$form->addElement('html', '</fieldset>');
	
$form->addElement('html', '<fieldset class="formFooters"><p class="next">Next</p><p class="previous">Previous</p></fieldset></div>');
	
//stage 3 - Database Settings
$form->addElement('html', '<div id="stage3" class="table-cell"><fieldset>');

$form->addElement('header',null,'Stage 3 | Database Settings');
	
$s = $form->createElement('select', 'phptype', 'PHP Type:');
$opts = array('mysql' => 'MySQL', 'mysqli' => 'MySQLi');
$s->loadArray($opts,'mysqli');
$form->addElement($s);
	
$form->addElement('text', 'hostspec', 'Host:', array('size' => 30, 'value' => 'localhost'));
	
$form->addElement('text', 'database', 'Database:', array('size' => 30));
	
$form->addElement('text', 'username', 'Username:', array('size' => 30, 'maxlength' => 100));

$form->addElement('password', 'password', 'Password:', array('size' => 30, 'maxlength' => 20));
		
$form->addElement('html', '</fieldset>');
	
$form->addElement('html', '<fieldset class="formFooters"><p class="next">Next</p><p class="previous">Previous</p></fieldset></div>');
	
//stage 4 - Server Settings
$form->addElement('html', '<div id="stage4" class="table-cell"><fieldset>');

$form->addElement('header',null,'Stage 4 | Site Settings');
	
$form->addElement('text', 'site_name', 'Site Name:', array('size' => 30));
	
$form->addElement('text', 'web_url', 'Url:', array('size' => 30, 'value' => 'http://'.$_SERVER['HTTP_HOST']));
	
// time zones
$handle = fopen(__PHP_PATH . '/Uthando/csv/time_zone.csv', "r");
	
while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
	$time_zones[$data[0].'/'.$data[1]] = $data[1];
}
	
fclose($handle);
	
$t = $form->createElement('select', 'timezone', 'Time Zone');
$t->loadArray($time_zones,'Europe/London');
$form->addElement($t);
	
$form->addElement('checkbox', 'enable_ssl', 'Enable SSL:');
	
$form->addElement('text', 'ssl_url', 'SSL Url:', array('size' => 30));
	
$p = $form->createElement('select', 'site_template', 'Template');
	
if ($dir = $_SERVER['DOCUMENT_ROOT'].'/templates') {
	$templates = scandir($dir);
	foreach ($templates as $template) {
		// Skip pointers 
		if ($template == '.' || $template == '..' || !is_dir($_SERVER['DOCUMENT_ROOT'].'/templates/'.$template)) {
			continue;
		}
			
		$template_opts[$template] = str_replace("_", " ", ucwords($template));
			
	}
		
}
$p->loadArray($template_opts);
$form->addElement($p);

$form->addElement('checkbox', 'dbug', 'Dbug Mode On:');
	
$form->addElement('html','<input type="hidden" name="admin_template" value="admin" />');
		
$form->addElement('html', '</fieldset>');
	
$form->addElement('html', '<fieldset class="formFooters"><p class="next">Next</p><p class="previous">Previous</p></fieldset></div>');