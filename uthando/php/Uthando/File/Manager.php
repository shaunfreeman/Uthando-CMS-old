<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class File_Manager
{
	protected $path = null;
	protected $length = null;
	protected $basedir = null;
	protected $basename = null;
	protected $options;
	protected $post;
	protected $get;
	
	public function __construct($registry, $options) {
		$path = File_Utility::getPath();
		
		$this->registry = $registry;
		
		$this->options = array_merge(array(
			'directory' => '../Demos/Files',
			'baseURL' => '',
			'assetBasePath' => '../Assets',
			'id3Path' => $path . '/getid3/getid3.php',
			'mimeTypesPath' => $path . '/MimeTypes.ini',
			'dateFormat' => 'j M Y - H:i',
			'maxUploadSize' => 1024 * 1024 * 3,
			'move' => false,
			'create' => false,
			'upload' => false,
			'destroy' => false,
			'safe' => true,
			'filter' => null
		), $options);
		
		$this->basedir = realpath($this->options['directory']);
		$this->basename = pathinfo($this->basedir, PATHINFO_BASENAME) . '/';
		$this->path = realpath($this->options['directory'] . '/../');
		$this->length = strlen($this->path);
		
		header('Expires: Fri, 01 Jan 1990 00:00:00 GMT');
		header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		
		$this->get = $_GET;
		$this->post = $_POST;
	}
	
	public function fireEvent($event) {
		$event = $event ? 'on' . ucfirst($event) : null;
		if (!$event || !method_exists($this, $event)) $event = 'onView';
		
		$this->{$event}();
	}
	
	protected function onView() {
		$dir = $this->getDir(!empty($this->post['directory']) ? $this->post['directory'] : null);
		$files = ($files = glob($dir . '/*')) ? $files : array();
		
		if ($dir != $this->basedir) array_unshift($files, $dir . '/..');
		natcasesort($files);
		foreach ($files as $file):
			$mime = $this->getMimeType($file);
			if ($this->options['filter'] && $mime != 'text/directory' && !File_Utility::startsWith($mime, $this->options['filter']))
				continue;
			
			$out[is_dir($file) ? 0 : 1][] = array(
				'name' => pathinfo($file, PATHINFO_BASENAME),
				'date' => date($this->options['dateFormat'], filemtime($file)),
				'mime' => $this->getMimeType($file),
				'icon' => $this->getIcon($this->normalize($file)),
				'size' => filesize($file)
			);
		endforeach;
		
		echo json_encode(array(
			'path' => $this->getPath($dir),
			'dir' => array(
				'name' => pathinfo($dir, PATHINFO_BASENAME),
				'date' => date($this->options['dateFormat'], filemtime($dir)),
				'mime' => 'text/directory',
				'icon' => 'dir'
			),
			'files' => array_merge(!empty($out[0]) ? $out[0] : array(), !empty($out[1]) ? $out[1] : array())
		));
	}
	
	protected function onDetail() {
		if (empty($this->post['directory']) || empty($this->post['file'])) return;
		
		$file = realpath($this->path . '/' . $this->post['directory'] . '/' . $this->post['file']);
		if (!$this->checkFile($file)) return;
		
		require_once($this->options['id3Path']);
		
		$url = $this->options['baseURL'] . $this->normalize(substr($file, strlen($this->path)+1));
		$mime = $this->getMimeType($file);
		$content = null;
		
		if (File_Utility::startsWith($mime, 'image/')){
			$size = getimagesize($file);
			$content = '<img src="' . $url . '" class="preview" alt="" />
				<h2>${more}</h2>
				<dl>
					<dt>${width}</dt><dd>' . $size[0] . 'px</dd>
					<dt>${height}</dt><dd>' . $size[1] . 'px</dd>
				</dl>';
		}elseif (File_Utility::startsWith($mime, 'text/') || $mime == 'application/x-javascript'){
			$filecontent = file_get_contents($file, null, null, 0, 300);
			if (!File_Utility::isBinary($filecontent)) $content = '<div class="textpreview">' . nl2br(str_replace(array('$', "\t"), array('&#36;', '&nbsp;&nbsp;'), htmlentities($filecontent))) . '</div>';
		}elseif ($mime == 'application/zip'){
			$out = array(array(), array());
			$getid3 = new getID3();
			$getid3->Analyze($file);
			foreach ($getid3->info['zip']['files'] as $name => $size):
				$icon = is_array($size) ? 'dir' : $this->getIcon($name);
				$out[($icon == 'dir') ? 0 : 1][$name] = '<li><a><img src="' . $this->options['assetBasePath'] . '/Icons/' . $icon . '.png" alt="" /> ' . $name . '</a></li>';
			endforeach;
			natcasesort($out[0]);
			natcasesort($out[1]);
			$content = '<ul>' . implode(array_merge($out[0], $out[1])) . '</ul>';
		}elseif (File_Utility::startsWith($mime, 'audio/')){
			$getid3 = new getID3();
			$getid3->Analyze($file);
			
			$content = '<div class="object">
					<object type="application/x-shockwave-flash" data="' . $this->options['assetBasePath'] . '/dewplayer.swf?mp3=' . rawurlencode($url) . '&volume=30" width="200" height="20">
						<param name="movie" value="' . $this->options['assetBasePath'] . '/dewplayer.swf?mp3=' . rawurlencode($url) . '&volume=30" />
					</object>
				</div>
				<h2>${more}</h2>
				<dl>
					<dt>${title}</dt><dd>' . $getid3->info['comments']['title'][0] . '</dd>
					<dt>${artist}</dt><dd>' . $getid3->info['comments']['artist'][0] . '</dd>
					<dt>${album}</dt><dd>' . $getid3->info['comments']['album'][0] . '</dd>
					<dt>${length}</dt><dd>' . $getid3->info['playtime_string'] . '</dd>
					<dt>${bitrate}</dt><dd>' . round($getid3->info['bitrate']/1000) . 'kbps</dd>
				</dl>';
		}
		
		echo json_encode(array(
			'content' => $content ? $content : '<div class="margin">
				${nopreview}<br/><button value="' . $url . '">${download}</button>
			</div>'
		));
	}
	
	protected function onDestroy(){
		if (!$this->options['destroy'] || empty($this->post['directory']) || empty($this->post['file'])) return;
		
		$file = realpath($this->path . '/' . $this->post['directory'] . '/' . $this->post['file']);
		if (!$this->checkFile($file)) return;
		
		$this->unlink($file);
		
		echo json_encode(array(
			'content' => 'destroyed'
		));
	}
	
	protected function onCreate(){
		if (!$this->options['create'] || empty($this->post['directory']) || empty($this->post['file'])):
			echo json_encode(array(
				'content' => 'nocreate'
			));
		else:
			$ftp = new File_FTP($this->registry);
			
			$file = $this->getName($this->post['file'], $this->getDir($this->post['directory'], $ftp->public_html));
			if (!$file) return;
			
			$matches = explode($ftp->public_html, $file);
			
			$ftp->mkdir($ftp->public_html.$matches[1]);
			
			$this->onView();
		endif;
	}
	
	protected function unlink($file){
		$file = realpath($file);
		if ($this->basedir==$file || strlen($this->basedir)>=strlen($file))
			return;
			
		$ftp = new File_FTP($this->registry);
		
		$matches = explode($ftp->public_html, $file);
		$file_to_delete = $ftp->public_html.$matches[1];
		
		if (is_dir($file)) $file_to_delete .= '/';
		
		try{ if ($this->checkFile($file)) $ftp->rm($file_to_delete,true); }catch(Exception $e){}
	}
	
	protected function getName($file, $dir){
		$files = array();
		foreach ((array)glob($dir . '/*') as $f):
			$files[] = pathinfo($f, PATHINFO_FILENAME);
		endforeach;
		$pathinfo = pathinfo($file);
		$file = $dir . '/' . File_Utility::pagetitle($pathinfo['filename'], $files).(!empty($pathinfo['extension']) ? '.' . $pathinfo['extension'] : null);
		
		return !$file || !File_Utility::startsWith($file, $this->basedir) || file_exists($file) ? null : $file;
	}
	
	protected function getIcon($file) {
		if (File_Utility::endsWith($file, '/..')):
			return 'dir_up';
		elseif (is_dir($file)):
			return 'dir';
		endif;
		
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		return ($ext && file_exists(realpath($this->options['assetBasePath'] . '/Icons/' . $ext . '.png'))) ? $ext : 'default';
	}

	protected function getMimeType($file) {
		return is_dir($file) ? 'text/directory' : File_Upload::mime($file);
	}
	
	protected function getDir($dir, $ftp_path=null) {
		$path = ($ftp_path) ? $ftp_path : $this->path;
		$dir = realpath($path . '/' . (File_Utility::startsWith($dir, $this->basename) ? $dir : $this->basename));
		return $this->checkFile($dir) ? $dir : $this->basedir;
	}
	
	protected function getPath($file) {
		$file = $this->normalize(substr($file, $this->length));
		return substr($file, File_Utility::startsWith($file, '/') ? 1 : 0);
	}
	
	protected function checkFile($file) {
		$mimes = $this->getAllowedMimeTypes();
		$hasFilter = $this->options['filter'] && count($mimes);
		if ($hasFilter) array_push($mimes, 'text/directory');
		return !(!$file || !File_Utility::startsWith($file, $this->basedir) || !file_exists($file) || ($hasFilter && !in_array($this->getMimeType($file), $mimes)));
	}
	
	protected function normalize($file) {
		return preg_replace('/\\\|\/{2,}/', '/', $file);
	}
	
	protected function getAllowedMimeTypes() {
		$filter = $this->options['filter'];
		
		if (!$filter) return null;
		if (!File_Utility::endsWith($filter, '/')) return array($filter);
		
		static $mimes;
		if (!$mimes) $mimes = parse_ini_file($this->options['mimeTypesPath']);
		
		foreach ($mimes as $mime):
			if (File_Utility::startsWith($mime, $filter)) $mimeTypes[] = strtolower($mime);
		endforeach;
		
		return $mimeTypes;
	}
}

class FileManagerException extends Uthando_Exception {}

?>