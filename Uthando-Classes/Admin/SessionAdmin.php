<?php

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class SessionAdmin extends Session {
	
	function set_db() {
		$this->db_name = $this->registry->admin_config->get('uthando_admin','DATABASE');
	}
	
}

?>