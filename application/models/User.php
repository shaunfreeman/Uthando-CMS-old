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
 * Description of User
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Model_User extends Uthando_Model_Abstract
{
    protected $_userId;
    protected $_roleId;
    protected $_emailTypeId;
    protected $_role;
    protected $_upid;
    protected $_firstName;
    protected $_lastName;
    protected $_username;
    protected $_email;
    protected $_password;
    protected $_iv;
    protected $_cdate;
    protected $_mdate;
    protected $_activation;
    protected $_block;

    public function getUserId()
    {
        return $this->_userId;
    }

    public function setUserId($id)
    {
        $this->_userId = (int) $id;
        return $this;
    }

    public function getRoleId()
    {
        return $this->_roleId;
    }

    public function setRoleId($id)
    {
        $this->_roleId = (int) $id;
        return $this;
    }

    public function getEmailTypeId()
    {
        return $this->_emailTypeId;
    }

    public function setEmailTypeId($id)
    {
        $this->_emailTypeId = (int) $id;
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

    public function getUpid()
    {
        return $this->_upid;
    }

    public function setUpid($id)
    {
        $this->_upid = (int) $id;
        return $this;
    }

    public function getFirstName()
    {
        return $this->_firstName;
    }

    public function setFirstName($name)
    {
        $this->_firstName = (string) $name;
        return $this;
    }

    public function getLastName()
    {
        return $this->_lastName;
    }

    public function setLastName($name)
    {
        $this->_lastName = (string) $name;
        return $this;
    }

    public function getFullname()
    {
        return join(' ', array(
            $this->_firstName,
            $this->_lastName
        ));
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setUsername($username)
    {
        $this->_username = (string) $username;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function setPassword($password)
    {
        $this->_password = (string) $password;
        return $this;
    }

    public function getIv()
    {
        return $this->_iv;
    }

    public function setIv($iv)
    {
        $this->_iv = (string) $iv;
        return $this;
    }

    public function getCdate()
    {
        return $this->_cdate;
    }

    public function setCdate($ts)
    {
        $this->_cdate = $ts;
        return $this;
    }

    public function getMdate()
    {
        return $this->_mdate;
    }

    public function setMdate($ts)
    {
        $this->_mdate = $ts;
        return $this;
    }

    public function getActivaton()
    {
        return $this->_activation;
    }

    public function setActivation($activate)
    {
        $this->_activation = (int) $activate;
        return $this;
    }

    public function getBlock()
    {
        return $this->_block;
    }

    public function setBlock($block)
    {
        $this->_block = (int) $block;
        return $this;
    }
}
?>
