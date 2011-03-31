<?php
/* 
 * Role.php
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
 * Description of Role
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Model_Mapper_Role extends Uthando_Model_Acl_Abstract
{
    protected $_dbTableClass = 'Core_Model_DbTable_Role';
    protected $_modelClass = 'Core_Model_Role';

    protected function _setVars($row, Core_Model_Role $model) {
        return $model
                ->setRoleId($row->roleId)
                ->setUpid($row->upid)
                ->setRole($row->role);
    }

    public function getRoleIdByRole($role)
    {
        $select = $this->getDbTable()
                ->select('roleId')
                ->where('role = ?', $role);

        return $this->fetchRow($select);
    }

    protected function save($data, Core_Model_Role $model)
    {
        
    }

    public function setAcl($acl) {
        parent::setAcl($acl);

        //$this->_acl->allow('Administrator', $this);

        return $this;
    }
}
?>
