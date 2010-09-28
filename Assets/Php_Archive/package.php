#!/usr/bin/php
<?php
//@unlink('phpmyadmin.phar.tar.php');
//copy('phpmyadmin.tar.gz', 'phpmyadmin.phar.tar.php');
try{

$directory = dirname(__FILE__) . '/phpmyadmin';
$pharFile = 'phpMyAdmin.phar';

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

while($it->valid()):
    if (!$it->isDot()):
        $files['phpmyadmin/'.$it->getSubPathName()] = $it->key();
    endif;
    $it->next();
endwhile;

$phar = new Phar($pharFile, 0, basename($pharFile));

$phar->startBuffering();
//$phar->buildFromDirectory(dirname(__FILE__) . '/phpmyadmin');
$phar->buildFromIterator(new ArrayIterator($files));

$phar["phpmyadmin/config.inc.php"] = '<?php
/* Servers configuration */
$i = 0;

/* Server localhost (config:root) [1] */
$i++;
$cfg[\'Servers\'][$i][\'auth_type\']     = \'http\';
/* Server parameters */
$cfg[\'Servers\'][$i][\'host\'] = \'localhost\';
$cfg[\'Servers\'][$i][\'connect_type\'] = \'tcp\';
$cfg[\'Servers\'][$i][\'compress\'] = false;
/* Select mysqli if your server has it */
$cfg[\'Servers\'][$i][\'extension\'] = \'mysqli\';
$cfg[\'Servers\'][$i][\'AllowNoPassword\'] = false;

/* rajk - for blobstreaming */
$cfg[\'Servers\'][$i][\'bs_garbage_threshold\'] = 50;
$cfg[\'Servers\'][$i][\'bs_repository_threshold\'] = \'32M\';
$cfg[\'Servers\'][$i][\'bs_temp_blob_timeout\'] = 600;
$cfg[\'Servers\'][$i][\'bs_temp_log_threshold\'] = \'32M\';

/* User for advanced features */
$cfg[\'Servers\'][$i][\'controluser\'] = \'pma\';
$cfg[\'Servers\'][$i][\'controlpass\'] = \'pmapass\';
/* Advanced phpMyAdmin features */
$cfg[\'Servers\'][$i][\'pmadb\'] = \'phpmyadmin\';
$cfg[\'Servers\'][$i][\'bookmarktable\'] = \'pma_bookmark\';
$cfg[\'Servers\'][$i][\'relation\'] = \'pma_relation\';
$cfg[\'Servers\'][$i][\'table_info\'] = \'pma_table_info\';
$cfg[\'Servers\'][$i][\'table_coords\'] = \'pma_table_coords\';
$cfg[\'Servers\'][$i][\'pdf_pages\'] = \'pma_pdf_pages\';
$cfg[\'Servers\'][$i][\'column_info\'] = \'pma_column_info\';
$cfg[\'Servers\'][$i][\'history\'] = \'pma_history\';
$cfg[\'Servers\'][$i][\'tracking\'] = \'pma_tracking\';
$cfg[\'Servers\'][$i][\'designer_coords\'] = \'pma_designer_coords\';


/* End of servers configuration */
if (strpos(PHP_OS, \'WIN\') !== false) {
    $cfg[\'UploadDir\'] = getcwd();
} else {
    $cfg[\'UploadDir\'] = \'/tmp/pharphpmyadmin\';
    @mkdir(\'/tmp/pharphpmyadmin\');
    @chmod(\'/tmp/pharphpmyadmin\', 0777);
}';

$phar->setStub('<?php
Phar::interceptFileFuncs();
Phar::webPhar("phpMyAdmin.phar", "phpmyadmin/index.php");
echo "phpmyadmin is intended to be executed from a web browser\n";
exit -1;
__HALT_COMPILER();
');

$phar->stopBuffering();
echo count($files)." files addded to ".$pharFile."\n";
echo "Done.\n";
} catch (Exception $e) {
    echo 'Write operations failed on phpmyadmin.phar: ', $e;
}

?>
