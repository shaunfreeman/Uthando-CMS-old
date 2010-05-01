<?php

session_start();
ob_start('ob_gzhandler');
//unset($_SESSION['php_path']);
// Set flag that this is a parent file
define( 'PARENT_FILE', 1 );

$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path);

if (isset($_SESSION['php_path']) && is_dir($_SESSION['php_path'])) {
	define ('__PHP_PATH', $_SESSION['php_path']);
} else {
	define ('__PHP_PATH', realpath($_SERVER['DOCUMENT_ROOT'] . '/Common/php'));
}

// Set include paths.
$ini_path = ini_get('include_path') .
	PATH_SEPARATOR . __PHP_PATH .
	PATH_SEPARATOR . __PHP_PATH . '/PEAR' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/Admin' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando/functions' .
	PATH_SEPARATOR . __PHP_PATH . '/Uthando';

ini_set('include_path', $ini_path);

// Include functions.
require_once('functions.php');
require_once('admin_functions.php');

$registry = new UthandoRegistry();

function getError($error, $debug=NULL) {
	if (isset ($debug)) {
		$errors = "<span class=\"smcap\"><p class=\"fail\"><img src=\"/Common/images/actionno.png\" /> " . $error . "<p class=\"debug_message\">" . nl2br($debug) . "</p></p></span>\n";
	} else {
		$errors = "<span class=\"smcap\"><p class=\"fail\"><img src=\"/Common/images/actionno.png\" /> " . $error . "</p></span>";
	}
	return $errors;
}

function getPass($message) {
	return "<span class=\"smcap\"><p class=\"ok\"><img src=\"/Common/images/actionok.png\" />" . $message . "</p></span>\n";
}

$message = FALSE;
$pass = FALSE;

if (is_numeric($_GET['stage'])) {
	
	if (isset($_POST)) {
		
		$registry->config = new ConfigMagik($registry);
		
		// clean Post values and assign the to an array.
		foreach ($_POST as $key => $value) {
			$post[$key] = escape_data($value);
		}
		
		switch($_GET['stage']) {
			
			//Check FTP Settings.
			case 2:
				// Check FTP Host.
				if (!empty($post['host'])) {
					
					$registry->ftp = new Net_FTP($post['host'], $post['port']);
					
					if (PEAR::isError($con = $registry->ftp->connect())) {
						$message .= getError($con->getMessage());
					} else {
						if (PEAR::isError($login = $registry->ftp->login($post['username'], $post['password']))) {
							$message .= getError($login->getMessage());
						} else {
							$ftproot = $registry->ftp->pwd();
							
							$ftp_realpath = realpath($_SERVER['DOCUMENT_ROOT'].'/../');
							
							$public_html = end(explode('/',$_SERVER['DOCUMENT_ROOT']));
							
							$diff = implode('/',array_diff(explode('/',$ftp_realpath),explode('/',$ftproot)));
							
							if ($ftproot != '/' && $diff) {
								$ftproot = $ftproot.'/'.$diff.'/';
							}
							
							$tmp = '/Common/tmp';
							$registry->tmp_dir = $_SERVER['DOCUMENT_ROOT'].$tmp;
							
							if (PEAR::isError($dir = $registry->ftp->mkdir($ftproot.$public_html.$tmp))) {
								$message .= getError($dir->getMessage());
								$dir = FALSE;
							} else {
								$dir = TRUE;
								$message .= getPass("created tmp folder");
							}
							
							$index = $registry->ftp->put($_SERVER['DOCUMENT_ROOT'].'/Common/index.html', $ftproot.$public_html.$tmp.'/index.html', true, FTP_ASCII);
							
							if (PEAR::isError($index)) {
								$message .= getError($index->getMessage());
								$index = FALSE;
							} else {
								$index = TRUE;
								$message .= getPass("made index file in tmp folder");
							}
							
							$chmod = $registry->ftp->site("CHMOD 0777 ".$ftproot.$public_html.$tmp);
							
							if (PEAR::isError($chmod)) {
								$message .= getError($chmod->getMessage());
								$chmod = FALSE;
							} else {
								$chmod = TRUE;
								$message .= getPass("tmp folder permissions set");
							}
							
							$uthando_dir = "uthando";
							
							if (PEAR::isError($data_dir = $registry->ftp->mkdir($ftproot.$uthando_dir.'/ini', true))) {
								$message .= getError($data_dir->getMessage());
								$data_dir = FALSE;
							} else {
								
								$registry->ftp->cd($ftproot.$uthando_dir.'/ini');
								
								if ($ftproot != '/') {
									$ini_folder = $registry->ftp->pwd();
								} else {
									$ini_folder = $ftp_realpath.$registry->ftp->pwd();
								}
								
								// move php dir to uthando dir.
								$php_folder = $registry->ftp->putRecursive($_SERVER['DOCUMENT_ROOT'].'/Common/php/', $ftproot.$uthando_dir.'/php/', true, FTP_ASCII);
								
								if (PEAR::isError($php_folder)) {
									$message .= getError($php_folder->getMessage());
									$php_folder = FALSE;
								} else {
									$php_folder = TRUE;
									
									$registry->ftp->cd($ftproot.$uthando_dir.'/php');
									
									
									if ($ftproot != '/') {
										$php_folder = $registry->ftp->pwd();
									} else {
										$php_folder = $ftp_realpath.$registry->ftp->pwd();
									}
									
									$message .= getPass("made php folder");
									
									function redir($registry) {
										global $ftproot;
										global $public_html;
										//return $registry->ftp->rm($ftproot.$public_html.'/Common/php/', true);
									}
									
									$rm_dir = redir($registry);
									
									if (PEAR::isError($rm_dir)) {
										
										$message .= getError($rm_dir->getMessage());
										$rm_dir = redir($registry);
									}
									
									
								}
								
								$files = find_files($_SERVER['DOCUMENT_ROOT'], array('php' => 3));
								
								$dirs = array(
									"/\/\*\{START_INI_DIR\}\*\/(.*?)\/\*\{END_INI_DIR\}\*\//is" => "/*{START_INI_DIR}*/\n\$registry->ini_dir = '".$ini_folder."';\n/*{END_INI_DIR}*/",
									
									"/\/\*\{START_PHP_INI_PATH\}\*\/(.*?)\/\*\{END_PHP_INI_PATH\}\*\//is" => "/*{START_PHP_INI_PATH}*/\ndefine ('__PHP_PATH', '".$php_folder."');\n/*{END_PHP_INI_PATH}*/"
								);
								
								$match_ini = "/\/\*\{START_INI_DIR\}\*\//";
								$match_php = "/\/\*\{START_PHP_INI_PATH\}\*\//";
								
								foreach ($files as $key => $value) {
									$file = file_get_contents($value);
									
									$d = split("/", $value);
									$d = $d[count($d) - 2];
									
									if ((preg_match($match_ini, $file) || preg_match($match_php, $file)) && $d != "setup") {
										$file = preg_replace(array_keys($dirs), array_values($dirs), $file);
										
										$registry->ftp->site("CHMOD 0646 ".$value);
										
										file_put_contents($value, $file);
										
										$registry->ftp->site("CHMOD 0644 ".$value);
										
									}
									
								}
								
								$registry->ini_dir = $ini_folder;
								
								$registry->config->set( 'uthando_dir', $ftproot.$uthando_dir, 'FTP');
								
								$registry->config->load($ini_folder.'/uthando.ini.php');
								
								$data_dir = TRUE;
								$message .= getPass("created ini directory");
								
								foreach ($post as $key => $value) {
									$registry->config->set( $key, $value, 'FTP');
								}
								
								$registry->uthando_dir = $ftproot.$uthando_dir;
								
								//$registry->config->set( 'ftproot', $ftproot, 'FTP');
								$registry->config->set( 'public_html', $ftproot.$public_html, 'FTP');
								
								$registry->config->set( 'uthando_dir', $ftproot.$uthando_dir, 'FTP');
								
								$registry->config->save();
							}
							
							if ($chmod && $dir && $index && $data_dir) {
								$message .= getPass("All Settings are correct");
								$_SESSION['php_path'] = $php_folder;
								$_SESSION['ini_folder'] = $ini_folder;
							}
						}
					}
					
					$registry->ftp->disconnect();
					
				} else {
					$message .= getError("Please Set FTP Host");
				}
				break;
			
			// Check Database Settings.
			case 3:
				
				$registry->config->load($_SESSION['ini_folder'].'/uthando.ini.php');
				
				$ftp = $registry->config->get('FTP');
				
				$mdb2 = MDB2::connect($post);
				if (PEAR::isError($mdb2)) {
					$message .= getError($mdb2->getMessage(), $mdb2->getDebugInfo());
					
				} else {
					$registry->ftp = new Net_FTP($ftp['host'], $ftp['port']);
					
					if (PEAR::isError($con = $registry->ftp->connect())) {
						$message .= getError($con->getMessage());
					} else {
						if (PEAR::isError($login = $registry->ftp->login($ftp['username'], $ftp['password']))) {
							$message .= getError($login->getMessage());
						} else {
					
							foreach ($post as $key => $value) {
								$registry->config->set( $key, $value, 'DATABASE');
							}
								
							$registry->config->save();
					
							$message .= getPass("Database login details are OK");
							$mdb2->disconnect();
							$registry->ftp->disconnect();
						}
					}
				}
				
				$mdb2 = MDB2::factory($post);
				
				if (PEAR::isError($mdb2)) {
					$message .= getError($mdb2->getMessage(), $mdb2->getDebugInfo());
					
				} else {
					// drop any preexisting tables.
					function table_delete () {
						global $mdb2;
						$Complete_delete = true;
						$res = $mdb2->query('SHOW TABLES');
						
						if (PEAR::isError($res)) {
							$message .= getError($res->getMessage(), $res->getDebugInfo());
						} else {

							// Get each row of data on each iteration until
							// there are no more rows
							while ($row = $res->fetchRow()) {
								// Assuming MDB2's default fetchmode is MDB2_FETCHMODE_ORDERED
								print $row[0]."<br />";
								$affected = $mdb2->exec('DROP TABLE ' . $row[0]);
								// Always check that result is not an error
								if (PEAR::isError($affected)) {
									$Complete_delete = false;
								}

							}
							$res->free();
							if (!$Complete_delete) table_delete();
						}
					}
					table_delete();
					// load in tables.
					$file = file_get_contents('./sql/tables.sql');
					$file .= file_get_contents('./sql/data.sql');
					$file .= file_get_contents('./sql/key_constraints.sql');
					
					$file = split("--",$file);
					
					foreach ($file as $sql) {
						$res = $mdb2->exec($sql);
					
						if (PEAR::isError($res)) {
							$message .= getError($res->getMessage(), $res->getDebugInfo());
						}
					}
					
					$message .= getPass("All Database settings are correct");
					
				}
				$mdb2->disconnect();
				
				break;
				
			case 4:
				
				$registry->config->load($_SESSION['ini_folder'].'/uthando.ini.php');
				
				$ftp = $registry->config->get('FTP');
				
				if (!$post['enable_ssl']) $post['enable_ssl'] = 0;
				
				$registry->ftp = new Net_FTP($ftp['host'], $ftp['port']);
					
				if (PEAR::isError($con = $registry->ftp->connect())) {
					$message .= getError($con->getMessage());
				} else {
					if (PEAR::isError($login = $registry->ftp->login($ftp['username'], $ftp['password']))) {
						$message .= getError($login->getMessage());
					} else {
					
						foreach ($post as $key => $value) {
							$registry->config->set( $key, $value, 'SERVER');
						}
								
						$registry->config->save();
						$message .= getPass("All Server settings are correct");
					}
				}
				
				// delete setup dir.
				//$registry->ftp->rm($ftproot.$public_html.'/setup/', true);
				
				$registry->ftp->disconnect();
				break;
			
		}
		
		print $message;
		
	}
	
}

ob_end_flush();

?>