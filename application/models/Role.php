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
class Core_Model_Role extends Uthando_Model_Abstract
{
    protected $_roleId;
    protected $_upid;
    protected $_role;

    public function getRoleId()
    {
        return $this->_roleId;
    }

    public function setRoleId($id)
    {
        $this->_roleId = (int) $id;
        return $this;
    }

    public function getUpid()
    {
        return $this->_upid;
    }

    public function setUpid($id)
    {
        $this->_upid = (int) $id;
        return $this;
    }

    public function getRole()
    {
        return $this->_role;
    }

    public function setRole($role)
    {
        $this->_role = (string) $role;
        return $this;
    }
}
?>
