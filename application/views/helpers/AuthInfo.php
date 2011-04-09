<?php
/* 
 * AuthInfo.php
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
 * Access authentication data saved in the session.
 *
 * @uses viewHelper Zend_View_Helper
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Zend_View_Helper_AuthInfo extends Zend_View_Helper_Abstract
{
    /**
     * @var Core_Service_Authentication
     */
    protected $_authService;

    /**
     * Get user info from the auth session
     *
     * @param string|null $info The data to fetch, null to chain
     * @return string|Zend_View_Helper_AuthInfo
     * @access public
     */
    public function authInfo($info = null)
    {
        if (null === $this->_authService) {
            $this->_authService = new Core_Service_Authentication();
        }

        if (null === $info) {
            return $this;
        }

        if (false === $this->isLoggedIn()) {
            return null;
        }
        
        return $this->_authService->getIdentity()->$info;
    }

    /**
     * Returns wheather user is logged in.
     *
     * @param none
     * @return bool true|false
     * @access public
     */
    public function isLoggedIn()
    {
        return $this->_authService->getAuth()->hasIdentity();
    }
}
?>
