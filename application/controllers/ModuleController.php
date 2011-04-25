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
        if ($this->_request->getParam('id')) {
            $module = $this->_model->find($this->_request->getParam('id'));
        } else {
            throw new Uthando_Exception('No module id was requested.');
        }

        $enabled = ($module->getEnabled() == 1) ? 0 : 1;
        $module->setEnabled($enabled);

        if ($this->_model->save($module)) {
            $this->_helper->redirector->gotoRoute(
                array(
                    'module' => 'core',
                    'controller' => 'module',
                    'action' => 'list'
                ),
                'admin', true
            );
        } else {
            throw new Uthando_Exception('Could not update database due to an error.');
        }
    }

    public function deleteAction()
    {

    }
}
?>
