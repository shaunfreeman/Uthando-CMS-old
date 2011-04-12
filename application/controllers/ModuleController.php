<?php
/* 
 * ModuleController.php
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
 * Description of ModuleController
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ModuleController extends Uthando_Controller_Action_Abstract
{
    public function init()
    {
        if (!$this->_request->getParam('isAdmin') || !$this->_helper->acl('Admin')) {
            return $this->_helper->redirector('login', 'user', 'default');
        }

        parent::init();
        
        $this->_authService = new Core_Service_Authentication();
        $this->_model = new Core_Model_Mapper_Module();
        
    }

    public function indexAction()
    {
       return $this->_forward('list');
    }

    public function listAction()
    {
        $this->view->modules = $this->_model->getModules();
    }

    public function enableAction()
    {

    }

    public function deleteAction()
    {
        
    }
}
?>
