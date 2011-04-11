<?php
/* 
 * User.php
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
 * Description of Core_Model_Mapper_User
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @property Core_Model_User $user
 */
class Core_Model_Mapper_User extends Uthando_Model_Acl_Abstract
{
    protected $_dbTableClass = 'Core_Model_DbTable_User';
    protected $_modelClass = 'Core_Model_User';

    protected function _setVars($row, Core_Model_User $class)
    {
        $role = $this->_getRole($row);
        
        return $class
            ->setUserId($row->userId)
            ->setRoleId($row->roleId)
            ->setEmailTypeId($row->emailTypeId)
            ->setRole($role->role)
            ->setUpid($role->upid)
            ->setFirstName($row->firstName)
            ->setLastName($row->lastName)
            ->setUsername($row->username)
            ->setEmail($row->email)
            ->setPassword($row->password)
            ->setIv($row->iv)
            ->setCdate($row->cdate)
            ->setMdate($row->mdate)
            ->setActivation($row->activation)
            ->setBlock($row->block);
    }

    public function registerUser($values)
    {
        if (!$this->checkAcl('registerUser')) {
            throw new Uthando_Acl_Exception("Insufficient rights");
        }

        $user = new Core_Model_User($values);
        
        $password = $this->_passwordTreatment($user->getPassword());

        $roleTable = new Core_Model_Mapper_Role();
        $role = $roleTable->getRoleIdByRole('Registered');

        $data = array(
            'roleId'    => $role->getRoleId(),
            'firstName' => $user->getFirstName(),
            'lastName'  => $user->getLastName(),
            'email'     => $user->getEmail(),
            'password'  => $password,
            'iv'        => $user->getIv(),
            'cdate'     => date('Y-m-d H:i:s')
        );

       return $this->_save($data, $user);
    }

    public function saveUser($values)
    {
        if (!$this->checkAcl('saveUser')) {
            throw new Uthando_Acl_Exception("Insufficient rights");
        }

        $user = new Core_Model_User($values);
        $data = $user->toArray();

        foreach($data as $key => $value) {
            if (!isset($value) || $value == '') {
                unset($data[$key]);
            }
        }

        if(isset($data['password'])){
            $data['password'] = $this->_passwordTreatment($data['password']);
        }

        unset($data['fullname']);

        return $this->_save($data, $user);
    }

    public function deleteUser($id)
    {
        if (!$this->checkAcl('deleteUser')) {
            throw new Uthando_Acl_Exception("Insufficient rights");
        }

        $where = $this->getDbTable()
                ->getAdapter()
                ->quoteInto('userId = ?', $id);

        return $this->_delete($where);
    }

    protected function _save($data, $model)
    {
        if (null === ($id = $model->getUserId())) {
            unset($data[$id]);
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array('userId = ?' => $id));
        }
    }

    public function getUserByEmail($email)
    {
        $select = $this->getDbTable()
                ->select()
                ->where('email = ?', $email);

        return $this->fetchRow($select);
    }

    public function getUsers()
    {
        if (!$this->checkAcl('getUsers')) {
            throw new Uthando_Acl_Exception("Insufficient rights");
        }

        return $this->fetchAll();
    }

    public function setAcl($acl) {
        parent::setAcl($acl);

        $this->_acl->allow('Guest', $this, array('registerUser'))
                   ->allow('Registered', $this, array('saveUser'))
                   ->allow('Manager', $this);
        
        return $this;
    }

    private function _getRole($row = null)
    {
        if (null === $row) {
            return null;
        }
        
        return $row->findParentRow(
            'Core_Model_DbTable_Role',
            'Role'
        );
    }

    private function _passwordTreatment($password)
    {
        $passwordTreatment = Zend_Registry::get('siteConfig')->user
                ->auth
                ->credentialTreatment;

        $filter = new Zend_Filter_PregReplace(
            array(
                'match' => '/\?/',
                'replace' => "'".$password."'"
            )
        );

        return new Zend_Db_Expr($filter->filter($passwordTreatment));
    }
}
?>
