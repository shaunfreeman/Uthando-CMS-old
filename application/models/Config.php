<?php
/* 
 * Config.php
 * 
 * Copyright (c) 2010 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 * 
 * This file is part of Uthando-CMS.
 * 
 * Uthando-CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Uthando-CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Uthando-CMS.  If not, see <http ://www.gnu.org/licenses/>.
 */

/**
 * Description of Core_Model_Config
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Model_Config
{
    const KEY = 'Core_Config_';

	/**
	 * Get application config object
	 *
     * @param none
	 * @return Zend_Config
     * @access public
	 */
	public static function getConfig()
	{
		$host = $_SERVER['SERVER_NAME'];
		$host = (substr($host, 0, 3) == 'www') ? substr($host, 4) : $host;

		$key = self::KEY.$host;
		if (!Zend_Registry::isRegistered($key)) {
			$hostConfig = APPLICATION_PATH . '/configs/sites/' . $host . '.ini';

			$hostConfig = new Zend_Config_Ini($hostConfig);
            
			Zend_Registry::set($key, $hostConfig);
		}

		return Zend_Registry::get($key);
	}
}
?>
