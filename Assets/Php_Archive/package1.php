<?php
/**
* package.php
* Create an application PHAR file.
*
* @author Cal Evans <cal@calevans.com>
* @author John Douglass <john.douglass@oit.gatech.edu>
* @author Benjamin Eberlei <kontakt@beberlei.de>
*/

$pharName = "whitewashing.phar";
$buildDirectory = "/home/whitewashing/whitewashing/build";
$sourceLocation = "/home/whitewashing/whitewashing/trunk";
$stubFile = "/home/whitewashing/whitewashing/trunk/stub.php";

$pharFile = $buildDirectory."/".$pharName;
 
/*
* Let the user know what is going on
*/
echo "Creating PHAR\n";
echo "Source : {$sourceLocation}\n";
echo "Stub File : {$stubFile}\n";
echo "Build-Directory : {$buildDirectory}\n\n";
echo "PHAR-File: : {$pharName}\n\n";
 
/*
* Clean up from previous runs
*/
if (file_exists($pharFile)) {
    Phar::unlinkArchive($pharFile);
}

class PharBuildIterator extends FilterIterator
{
    private $_sourceLocation = null;
    private $_ignorePaths = array();

    public function __construct($sourceLocation)
    {
        $this->_sourceLocation = $sourceLocation;
        parent::__construct(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sourceLocation)));
    }

    public function addIgnorePath($path)
    {
        $this->_ignorePaths[] = $path;
        return $this;
    }

    public function accept()
    {
        $file = $this->getInnerIterator()->current();
        $fileName = $file->getPath().DIRECTORY_SEPARATOR.$file->getFilename();

        if ($this->getInnerIterator()->isDot()) {
            return false;
        }
        foreach ($this->_ignorePaths AS $ignorePath) {
            if (strpos($fileName, $ignorePath) !== false) {
                return false;
            }
        }

        return true;
    }
}
 
/*
* Setup the phar
*/
$p = new Phar($pharFile, 0, basename($pharFile));
$p->compressFiles(Phar::GZ);
$p->setSignatureAlgorithm (Phar::SHA1);
 
/*
* Now build the array of files to be in the phar.
* The first file is the stub file. The rest of the files are built from the directory.
*/
$files = array();
$stubFilename = basename($stubFile);
$files["stub.php"] = $stubFile;
 
echo "Building the array of files to include.\n";
 
 
$rd = new PharBuildIterator($sourceLocation);
$rd->addIgnorePath("/tests/");
$rd->addIgnorePath(".svn");

foreach($rd as $file) {
        $fileName = $file->getPath().DIRECTORY_SEPARATOR.$file->getFilename();
        $fileIndex = substr($fileName, strlen($sourceLocation));
        $files[$fileIndex] = $fileName;
} // foreach($rd as $file)
echo "Now building the phar.\n";
 
/*
* Now build the archive.
*/
$p->startBuffering();
$p->buildFromIterator(new ArrayIterator($files));
$p->stopBuffering();
 
/*
* finish up.
*/
$p->setDefaultStub(basename($stubFile));
$p = null;
 
echo count($files)." files addded to ".$pharFile."\n";
echo "Done.\n";
exit;
