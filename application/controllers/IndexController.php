<?php
/*
 * IndexController.php
 *
 * Copyright (c) 2011 Shaun Freeman <shaun@shaunfreeman.co.uk>.
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
 * Description of IndexController
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class IndexController extends Uthando_Controller_Action_Abstract
{
    public function init()
    {
        parent::init();
        $this->_authService = new Core_Service_Authentication();
    }

    public function indexAction()
    {
        if (!$this->_request->getParam('isAdmin')) {
            $frontpage = Zend_Registry::get('siteConfig')
                    ->bootstrap
                    ->frontController;

            if ($frontpage) {
                return $this->_forward(
                    $frontpage->defualtAction,
                    $frontpage->defaultControllerName,
                    $frontpage->defaultModule
                 );
            } else {
                return false;
            }
        }
    }
}
?>