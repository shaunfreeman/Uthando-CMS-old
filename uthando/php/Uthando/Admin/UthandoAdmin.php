
<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class UthandoAdmin extends Uthando {
	
	private $authorized = FALSE;
	public $lang = 'en';
	
	public function __construct($registry) {
		
		parent::__construct($registry);
		
		if (substr($this->registry->admin_config->get('admin_url', 'SERVER'), 7) != $_SERVER["SERVER_NAME"]) {
			header("Location: ".$this->registry->config->get('web_url', 'SERVER'));
			exit();
		}
		
		$this->loadLang();
	}
	
	public function getPath() {
		return $this->registry->path;
	}
	
	public function authorize() {
		if (!$this->authorized) $this->getAuthorize();
		return $this->authorized;
	}
	
	private function getAuthorize() {
	
		if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['user_group']) && UthandoUser::checkUser()) {
		
			// Query the database.
			$row = $this->getResult(
				'user_id, username, user_group',
				$this->registry->user.'users',
				$this->registry->user.'user_groups',
				array(
					'where' =>'user_id='.$_SESSION['user_id'],
					'and' => "user_group != 'registered'"
				),
				false
			);
	
			if ($row) {
				
				if ($row->username == $_SESSION['username'] && $row->user_id == $_SESSION['user_id'] && $row->user_group == $_SESSION['user_group']) {
					$this->upid = $this->setUserPermissions($_SESSION['user_group']);
					if ($this->upid > 0 && $this->upid < 4) {
						$this->authorized = TRUE;
					}
				}
			}
		}
	}
	
	private function setUserPermissions($group) {
		switch ($group) {
			case 'super administrator':
				return 1;
				break;
			case 'administrator':
				return 2;
				break;
			case 'manager':
				return 3;
				break;
			default:
				return false;
				break;
		}
	}
	
	public function getLangMessage($key) {
		return $this->messages[$this->registry->component][$key];
	}
	
	private function loadLang() {
		$js = file_get_contents(__SITE_PATH.'/Common/langs/'.$this->lang.'.json');
		
		$this->messages = json_decode($js, true);
	}
	
	// seperate this out to it's own HTML class.
	public function makeMessageBar($items, $icon_size) {
		if (is_array($items)) {
			$menuBar = '<div id="messageBar" class="center">';
			foreach ($items as $key => $value) {
				
				if ($key == 'seperator') {
					$menuBar .= '<div class="seperator"></div>';
				} else {
					$menuBar .= '<a id="'.$key.'-'.$icon_size.'" class="Tips button" href="'.$value.'" title="'.ucwords(str_replace('_', ' ', $key)).'" rel="'.$this->getLangMessage($key).'"><span>'.ucwords(str_replace('_', ' ', $key)).'</span></a>';
				}
			}
			$menuBar .= '<div class="both"><!-- --></div>';
			$menuBar .= '</div>';
			return $menuBar;
		} else {
			return false;
		}
	}
	
	// seperate this out to it's own HTML class.
	public function makeToolbar($items, $icon_size) {
		if (is_array($items)) {
			$menuBar = '<div id="menuToolbarWrap">';
			$menuBar .= '<img width="8" height="53" id="scrollLeft" alt="scroll left" src="/templates/'.$this->registry->template.'/images/left_scroll.png"/>';
			$menuBar .= '<div id="menuToolbar">';
			$menuBar .= '<ul id="iconMenuStrip">';
			foreach ($items as $key => $value) {
				
				if ($key == 'seperator') {
					//$menuBar .= '<div class="seperator"></div>';
				} else {
					$menuBar .= '<li><a id="'.$key.'-'.$icon_size.'" class="Tips button iconImgs" href="'.$value.'" title="'.ucwords(str_replace('_', ' ', $key)).'" rel="'.$this->getLangMessage($key).'"><span class="iconCaptions">'.ucwords(str_replace('_', ' ', $key)).'</span></a></li>';
				}
			}
			$menuBar .= '</ul>';
			$menuBar .= '<div class="both"><!-- --></div>';
			$menuBar .= '</div>';
			$menuBar .= '<img width="8" height="53" id="scrollRight" alt="scroll right" src="/templates/'.$this->registry->template.'/images/right_scroll.png"/>';
			$menuBar .= '</div>';
			return $menuBar;
		} else {
			return false;
		}
	}
	
	public function array_search_recursive($needle, $haystack, $strict=false, $path=array()) {
		if( !is_array($haystack) ) {
			return false;
		}
 
		foreach( $haystack as $key => $val ) {
			if( is_array($val) && $subPath = UthandoAdmin::array_search_recursive($needle, $val, $strict, $path) ) {
				$path = array_merge($path, array($key), $subPath);
				return $path;
			} elseif( (!$strict && $val == $needle) || ($strict && $val === $needle) ) {
				$path[] = $key;
				return $path;
			}
		}
		return false;
	}
	
}
?>