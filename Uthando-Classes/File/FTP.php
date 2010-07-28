<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

define('FILE_FTP_FILES_ONLY', 0, true);
define('FILE_FTP_DIRS_ONLY', 1, true);
define('FILE_FTP_DIRS_FILES', 2, true);
define('FILE_FTP_RAWLIST', 3, true);
define('FILE_FTP_BLOCKING', 1, true);
define('FILE_FTP_NONBLOCKING', 2, true);

class File_FTP
{
	protected $registry;
	public $vars;
	private $timeout = 90;
	private $mode = FTP_BINARY;
	private $file_extensions = array(
		FTP_ASCII => array(),
		FTP_BINARY => array()
	);
	private $handle;
	private $matcher;
	private $ls_match = array(
		'unix' => array(
			'pattern' => '/(?:(d)|.)([rwxts-]{9})\s+(\w+)\s+([\w\d-()?.]+)\s+([\w\d-()?.]+)\s+(\w+)\s+(\S+\s+\S+\s+\S+)\s+(.+)/',
			'map' => array(
				'is_dir' => 1,
				'rights' => 2,
				'files_inside' => 3,
				'user' => 4,
				'group' => 5,
				'size' => 6,
				'date' => 7,
				'name' => 8,
			)
		)
	);
	
	public function __construct($registry, $auto=true)
	{
		$this->registry = $registry;
		if ($auto):
			$config = new Config($this->registry, array('path' => $this->registry->ini_dir . '/ftp.ini.php'));
		
			foreach ($config->get('ftp') as $key => $value):
				$this->$key = $value;
			endforeach;
			
			$this->login();
		endif;
	}
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		return $this->vars[$index];
	}
	
	private function connect()
	{
		$this->matcher = null;
		if (!$this->host) throw new FTPException('ftp host is not set.');
		if (!$this->port) throw new FTPException('ftp port is not set');
		
		$handle = @ftp_connect($this->host, $this->port, $this->timeout);
		if (!$handle) {
			$this->handle = false;
			throw new FTPException('Connection to host failed');
		} else {
			$this->handle =& $handle;
			return true;
		}
	}
	
	public function disconnect()
    {
		$res = @ftp_close($this->handle);
		if (!$res) throw new FTPException('Disconnect failed.');
		$this->handle = null;
		return true;
	}
	
	public function login()
	{
		if ($this->handle === null):
			$res = $this->connect();
			if (!$res) return $res;
		endif;
		
		
		if (!$this->username) throw new FTPException(' ftp username is not set');

		if (!$this->password) throw new FTPException('ftp password is not set');

		$res = @ftp_login($this->handle, $this->username, $this->password);

		if (!$res) throw new FTPException('Unable to login');
		
		return true;
	}
	
	public function cd($dir, $report_error=true)
	{
		$erg = @ftp_chdir($this->handle, $dir);
		if (!$erg):
			if ($report_error) throw new FTPException('Directory change failed');
			return false;
		endif;
		return true;
	}
	
	public function pwd()
	{
		$res = @ftp_pwd($this->handle);
		if (!$res) throw new FTPException('Could not determine the actual path.');
		return $res;
	}
	
	public function mkdir($dir, $recursive = false)
    {
		$dir = $this->constructPath($dir);
		$savedir = $this->pwd();
		
		$e = $this->cd($dir, false);
		if ($e === true):
			$this->cd($savedir);
			return true;
		endif;
		$this->cd($savedir);
		
		if ($recursive === false):
			$res = ftp_mkdir($this->handle, $dir);
			if (!$res) throw new FTPException("Creation of '$dir' failed");
			return true;
		else:
			 // do not look at the first character, as $dir is absolute,
			// it will always be a /
			if (strpos(substr($dir, 1), '/') === false) return $this->mkdir($dir, false);
			if (substr($dir, -1) == '/') $dir = substr($dir, 0, -1);
			$parent = substr($dir, 0, strrpos($dir, '/'));
			$res = $this->mkdir($parent, true);
			if ($res === true) $res = $this->mkdir($dir, false);
			if ($res !== true) return $res;
			return true;
		endif;
    }
	
	public function chmod($target, $permissions)
	{
		//$permissions = octdec( str_pad($permissions,4,'0',STR_PAD_LEFT) );
		// If $target is an array: Loop through it.
		if (is_array($target)):
			for ($i = 0; $i < count($target); $i++):
				$res = $this->chmod($target[$i], $permissions);
				if (!$res) return $res;
				 // end if isError
			endfor; // end for i < count($target)
		else:
			$res = @ftp_chmod($this->handle, $permissions, $target);
			if (!$res) throw new FTPException("CHMOD " . $permissions . " " . $target . " failed");
			return $res;
		endif; // end if is_array
	} // end method chmod
	
	public function rename($remote_from, $remote_to)
	{
		$res = @ftp_rename($this->handle, $remote_from, $remote_to);
		if (!$res) throw new FTPException("Could not rename ".$remote_from." to ". $remote_to." !");
		return true;
	}
	
	public function ls($dir = null, $mode = FILE_FTP_DIRS_FILES)
	{
		if (!isset($dir)):
			$dir = $this->pwd();
			if (!$dir) throw new FTPException("Could not retrieve current directory");
		endif;
		
		if (($mode != FILE_FTP_FILES_ONLY) && ($mode != FILE_FTP_DIRS_ONLY) && ($mode != FILE_FTP_RAWLIST)) $mode = FILE_FTP_DIRS_FILES;
		
		switch ($mode):
			case FILE_FTP_DIRS_FILES:
				$res = $this->lsBoth($dir);
				break;
			case FILE_FTP_DIRS_ONLY:
				$res = $this->lsDirs($dir);
				break;
			case FILE_FTP_FILES_ONLY:
				$res = $this->lsFiles($dir);
				break;
			case FILE_FTP_RAWLIST:
				$res = @ftp_rawlist($this->handle, $dir);
				break;
		endswitch;

		return $res;
	}
	
	public function put($local_file, $remote_file, $overwrite = false, $mode = null, $options = 0)
	{
		if ($options & (FILE_FTP_BLOCKING | FILE_FTP_NONBLOCKING) === (FILE_FTP_BLOCKING | FILE_FTP_NONBLOCKING)) throw new FTPException("Bad options given: FILE_FTP_NONBLOCKING and '. 'FILE_FTP_BLOCKING can't both be set");
		
		$usenb = ! ($options & (FILE_FTP_BLOCKING == FILE_FTP_BLOCKING));
		if (!isset($mode)) $mode = $this->checkFileExtension($local_file);
		$remote_file = $this->constructPath($remote_file);
		
		if (!file_exists($local_file)) throw new FTPException("Local file '$local_file' does not exist.");
		
		if ((ftp_size($this->handle, $remote_file) != -1) && !$overwrite) throw new FTPException("Remote file '".$remote_file. "' exists and may not be overwriten.");
		
		if (function_exists('ftp_alloc')) ftp_alloc($this->handle, filesize($local_file));
		
		if ($usenb && function_exists('ftp_nb_put')):
			$res = ftp_nb_put($this->handle, $remote_file, $local_file, $mode);
			while ($res == FTP_MOREDATA):
				$res = ftp_nb_continue($this->handle);
			endwhile;
		else:
			$res = ftp_put($this->handle, $remote_file, $local_file, $mode);
		endif;
		
		if (!$res) throw new FTPException("File '$local_file' could not be uploaded to '" .$remote_file."'.");
			
		return true;
	}
	
	public function rm($path, $recursive = false, $filesonly = false)
	{
		$path = $this->constructPath($path);
		if ($this->checkRemoteDir($path) == true):
			if ($recursive):
				return $this->rmDirRecursive($path, $filesonly);
			else:
				return $this->rmDir($path);
			endif;
		else:
			return $this->rmFile($path);
		endif;
	}
	
	private function checkRemoteDir($path)
	{
		$pwd = $this->pwd();
		if (!$pwd) return $pwd;
		$res = $this->cd($path,false);
		$this->cd($pwd);
		return $res;
	}
	
	private function rmFile($file)
	{
		if (substr($file, 0, 1) != "/"):
			$actual_dir = $this->pwd();
			if (substr($actual_dir, (strlen($actual_dir) - 2), 1) != "/") $actual_dir .= "/";
			$file = $actual_dir.$file;
		endif;
		$res = @ftp_delete($this->handle, $file);
		if (!$res) throw new FTPException("Could not delete file '$file'.");
		return true;
	}
	
	private function rmDir($dir)
	{
		if (substr($dir, (strlen($dir) - 1), 1) != "/") throw new FTPException("Directory name '$dir' is invalid, has to end with '/'");
		
		$res = @ftp_rmdir($this->handle, $dir);
		if (!$res) throw new FTPException("Could not delete directory '$dir'.");
		return true;
	}
	
	private function rmDirRecursive($dir, $filesonly = false)
	{
		if (substr($dir, (strlen($dir) - 1), 1) != "/")  throw new FTPException("Directory name '$dir' is invalid, has to end with '/'");
		
		
		$file_list = $this->lsFiles($dir);
		foreach ($file_list as $file):
			$file = $dir.$file["name"];
			$res  = $this->rm($file);
			if (!$res) return $res;
		endforeach;
		
		$dir_list = $this->lsDirs($dir);
		foreach ($dir_list as $new_dir):
			if ($new_dir["name"] == '.' || $new_dir["name"] == '..') continue;
			$new_dir = $dir.$new_dir["name"]."/";
			$res = $this->rmDirRecursive($new_dir, $filesonly);
			if (!$res) return $res;
		endforeach;
		
		if (!$filesonly) $res = $this->rmDir($dir);
		
		if (!$res):
			return $res;
		else:
			return true;
		endif;
	}
	
	private function lsBoth($dir)
	{
		$list_splitted = $this->listAndParse($dir);
		if (!$list_splitted) return $list_splitted;
		
		if (!is_array($list_splitted["files"])) $list_splitted["files"] = array();
		
		if (!is_array($list_splitted["dirs"])) $list_splitted["dirs"] = array();
		
		$res = array();
		@array_splice($res, 0, 0, $list_splitted["files"]);
		@array_splice($res, 0, 0, $list_splitted["dirs"]);
		return $res;
	}
	
	private function lsDirs($dir)
	{
		$list = $this->listAndParse($dir);
		if (!$list) return $list;
		return $list["dirs"];
	}
	
	private function lsFiles($dir)
	{
		$list = $this->listAndParse($dir);
		if (!$list) return $list;
		return $list["files"];
	}
	
	private function listAndParse($dir)
	{
		$dirs_list  = array();
		$files_list = array();
		
		$dir_list = $this->ls($dir, FILE_FTP_RAWLIST);
		if (!is_array($dir_list)) throw new FTPException('Could not get raw directory listing.');
		
		foreach ($dir_list AS $key => $value):
			if (strncmp($value, 'total: ', 7) == 0 && preg_match('/total: \d+/', $value)):
				unset($dir_list[$key]);
				break; // usually there is just one line like this
			endif;
		endforeach;
		
        // Handle empty directories
		if (count($dir_list) == 0) return array('dirs' => $dirs_list, 'files' => $files_list);
		
		// Exception for some FTP servers seem to return this wiered result instead
		// of an empty list
		if (count($dirs_list) == 1 && $dirs_list[0] == 'total 0') return array('dirs' => array(), 'files' => $files_list);
		
		if (!isset($this->matcher) || !$this->_matcher):
			$this->matcher = $this->determineOSMatch($dir_list);
			if (!$this->matcher) return $this->matcher;
		endif;
		
		foreach ($dir_list as $entry):
			if (!preg_match($this->matcher['pattern'], $entry, $m)) continue;
			
			$entry = array();
			foreach ($this->matcher['map'] as $key => $value) $entry[$key] = $m[$value];
			$entry['stamp'] = $this->parseDate($entry['date']);

			if ($entry['is_dir']):
				$dirs_list[] = $entry;
			else:
				$files_list[] = $entry;
			endif;
		endforeach;
		usort($dirs_list, array("File_FTP", "natSort"));
		usort($files_list, array("File_FTP", "natSort"));
		$res["dirs"]  = (is_array($dirs_list)) ? $dirs_list : array();
		$res["files"] = (is_array($files_list)) ? $files_list : array();
		return $res;
	}
	
	private function checkFileExtension($filename)
	{
		if (($pos = strrpos($filename, '.')) === false):
			return $this->mode;
		else:
			$ext = substr($filename, $pos + 1);
		endif;
		
		if (isset($this->file_extensions[$ext])) return $this->file_extensions[$ext];
		
		return $this->mode;
	}
	
	private function constructPath($path)
	{
		if ((substr($path, 0, 1) != '/') && (substr($path, 0, 2) != './')):
			$actual_dir = $this->pwd();
			if (substr($actual_dir, -1) != '/') $actual_dir .= '/';
			$path = $actual_dir.$path;
		endif;
		return $path;
	}
	
	private function determineOSMatch(&$dir_list)
	{
		foreach ($dir_list as $entry):
			foreach ($this->ls_match as $os => $match):
				if (preg_match($match['pattern'], $entry)) return $match;
			endforeach;
		endforeach;
		throw new FTPException( 'The list style of your server seems not to be supported. Please email a "$ftp->ls(NET_FTP_RAWLIST);" output plus info on the server to the maintainer of this package to get it supported! Thanks for your help!');
	}
	
	private function natSort($item_1, $item_2)
	{
		return strnatcmp($item_1['name'], $item_2['name']);
	}
	
	private function parseDate($date)
	{
        // Sep 10 22:06 => Sep 10, <year> 22:06
		if (preg_match('/([A-Za-z]+)[ ]+([0-9]+)[ ]+([0-9]+):([0-9]+)/', $date, $res)):
			$year = date('Y');
			$month = $res[1];
			$day = $res[2];
			$hour = $res[3];
			$minute = $res[4];
			$date = "$month $day, $year $hour:$minute";
			$tmpDate = strtotime($date);
			if ($tmpDate > time()):
				$year--;
				$date = "$month $day, $year $hour:$minute";
			endif;
		elseif (preg_match('/^\d\d-\d\d-\d\d/', $date)):
            // 09-10-04 => 09/10/04
			$date = str_replace('-', '/', $date);
		endif;
		
		$res = strtotime($date);
		if (!$res) throw new FTPException('Dateconversion failed.');
		return $res;
	}
}

class FTPException extends UthandoException {}

?>