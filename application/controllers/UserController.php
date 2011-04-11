<?php
/* 
 * userController.php
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
 * Description of userController
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class UserController extends Uthando_Controller_Action_Abstract
{
    public function init()
    {
        parent::init();
        
        $this->_authService = new Core_Service_Authentication();
        $this->_model = new Core_Model_Mapper_User();

        $this->setForm('userLogin', array(
            'controller' => 'user',
            'action'     => 'authenticate'
        ));

        $this->setForm('userRegister', array(
            'controller' => 'user' ,
            'action' => 'complete-registration'
        ));

        $this->setForm('userEdit', array(
            'controller' => 'user' ,
            'action' => 'save'
        ));

        $this->setForm('userAdminEdit', array(
            'controller' => 'user' ,
            'action' => 'save'
        ), 'admin');

        $this->setForm('userAdminNew', array(
            'controller'    => 'user',
            'action'        => 'save-new'
        ), 'admin');
    }

    public function indexAction()
    {
        if (!$this->_helper->acl('User')) {
            return $this->_helper->redirector('login');
        }

        if ($this->_request->getParam('isAdmin') && $this->_helper->acl('Admin')) {
            return $this->_helper->redirector->gotoRoute(
                        array(
                            'module' => 'core',
                            'controller' => 'user',
                            'action' => 'list'
                        ),
                        'admin', true
                    );
        }
    }

    public function editAction()
    {   
        if (!$this->_helper->acl('User')) {
            return $this->_helper->redirector('login');
        }

        if ($this->_request->getParam('isAdmin') && $this->_helper->acl('Admin')) {
            if ($this->_request->getParam('id')) {
                $this->view->user = $this->_model->find($this->_request->getParam('id'));
                $this->getForm('userAdminEdit')->populate($this->view->user->toArray());

                if ($this->view->user->getUpid() < $this->_authService->getIdentity()->getUpid()) {
                    return $this->_helper->redirector->gotoRoute(
                        array(
                            'module' => 'core',
                            'controller' => 'user',
                            'action' => 'list'
                        ),
                        'admin', true
                    );
                }

                if ($this->_authService->getIdentity()->getUserId() == $this->_request->getParam('id')) {
                    $this->getForm('userAdminEdit')
                            ->getElement('roleId')
                            ->setName('RoleIdDisabled')
                            ->setAttribs(array('disabled' => 'disabled'));
                    $this->getForm('userAdminEdit')
                          ->addHiddenElement('roleId', $this->_authService->getIdentity()->getRoleId());
                }
            } else {
                throw new Exception('No user id was requested.');
            }
        } else {
            $this->view->user = $this->_authService->getIdentity();
            $this->getForm('userEdit')->populate($this->view->user->toArray());
        }
    }

    public function listAction()
    {
        if (!$this->_helper->acl('Admin')) {
            return $this->_helper->redirector('login');
        }

        if (!$this->_request->getParam('isAdmin')) {
            return $this->_helper->redirector('index');
        }

        $this->view->users = $this->_model->getUsers();
    }
    
    public function loginAction()
    {
        if ($this->_helper->acl('User')) {
            return $this->_helper->redirector('index');
        }
    }

    public function authenticateAction()
    {
        if ($this->_helper->acl('User')) {
            return $this->_helper->redirector('login');
        }

        if (!$this->_request->isPost()) {
            return $this->_helper->redirector('login');
        }

        if (!$this->getForm('userLogin')->isValid($this->_request->getPost())) {
            return $this->render('login'); // re-render the login form
        }
        
        if (false === $this->_authService->authenticate($this->getForm('userLogin')->getValues())) {
            $this->getForm('userLogin')->setDescription(_('Login failed, Please try again.'));
            return $this->render('login'); // re-render the login form
        }
        
        return $this->_helper->redirector('index');
    }

    public function logoutAction()
    {
        if (!$this->_helper->acl('User')) {
            return $this->_helper->redirector('index');
        }

        $this->_authService->clear();
        return $this->_helper->redirector('index');
    }

    public function registerAction()
    {
        if ($this->_helper->acl('User')) {
            return $this->_helper->redirector('index');
        }
    }

    public function newAction()
    {
        if (!$this->_helper->acl('Admin')) {
            return $this->_helper->redirector('login');
        }

        if (!$this->_request->getParam('isAdmin')) {
            return $this->_helper->redirector('index');
        }
    }

    public function saveNewAction()
    {
        if (!$this->_helper->acl('Admin')) {
            return $this->_helper->redirector('login');
        }

        if (!$this->_request->getParam('isAdmin')) {
            return $this->_helper->redirector('index');
        }

        if (!$this->_request->isPost()) {
            return $this->_helper->redirector->gotoRoute(
                array(
                    'module' => 'core',
                    'controller' => 'user',
                    'action' => 'list'
                ),
                'admin', true
            );
        }

        if (!$this->getForm('userAdminNew')->isValid($this->_request->getPost())) {
            return $this->render('new'); // re-render the login form
        }

        if (false === $this->_model->saveUser($this->getForm('userAdminNew')->getValues())) {
            return $this->render('new');
        }
    }

    public function saveAction()
    {
        if (!$this->_helper->acl('User')) {
            return $this->_helper->redirector('login');
        }

        if (!$this->_request->isPost()) {
            return $this->_helper->redirector('register');
        }

        if ($this->_request->getParam('isAdmin') && $this->_helper->acl('Admin')) {
            if ($this->_request->getParam('id')) {
                
                $this->view->user = $this->_model->find($this->_request->getParam('id'));
                $this->getForm('userAdminEdit')->excludeUserEmailFromValidation($this->view->user->getEmail());

                if (!$this->getForm('userAdminEdit')->isValid($this->_request->getPost())) {
                    return $this->render('edit'); // re-render the edit form
                }

                $data = $this->_request->getPost();
                $data['userId'] = $this->view->user->getUserId();
            } else {
                throw new Uthando_Exception('No user id was requested.');
            }
        } else {
            $this->view->user = $this->_authService->getIdentity();
            
            $this->getForm('userEdit')->excludeUserEmailFromValidation($this->view->user->getEmail());
            
            if (!$this->getForm('userEdit')->isValid($this->_request->getPost())) {
                return $this->render('edit'); // re-render the edit form
            }

            $data = $this->_request->getPost();
            $data['userId'] = $this->view->user->getUserId();
        }

        $this->_model->saveUser($data);
    }
    
    public function deleteAction()
    {
        if (!$this->_helper->acl('Admin') && !$this->_request->getParam('isAdmin')) {
            return $this->_helper->redirector('login');
        }

        if (!$this->_request->getParam('userDelete')) {
            $this->view->userId = $this->_request->getParam('id');
            return $this->render('comfirmDelete');
        }

        if ($this->_request->getParam('id')) {
            if ($this->_authService->getIdentity()->getUserId() != $this->_request->getParam('id')) {
                $this->_model->deleteUser($this->_request->getParam('id'));
            } else {
                throw new Uthando_Exception('You cannot delete yourself.');
            }
        } else {
            throw new Uthando_Exception('No user id was requested.');
        }
    }

    public function completeRegistrationAction()
    {
        if ($this->_helper->acl('User')) {
            return $this->_helper->redirector('login');
        }

        if (!$this->_request->isPost()) {
            return $this->_helper->redirector('register');
        }

        if (!$this->getForm('userRegister')->isValid($this->_request->getPost())) {
            return $this->render('register'); // re-render the login form
        }

        if (false === $this->_model->registerUser($this->getForm('userRegister')->getValues())) {
            return $this->render('register');
        }
	}
}
?>
