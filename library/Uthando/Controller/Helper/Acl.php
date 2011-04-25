<?php
/*
 * Acl.php
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
 * Description of Uthando_Controller_Helper_Acl
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Uthando_Controller_Helper_Acl extends Zend_Controller_Action_Helper_Abstract
{
    protected $_acl;
    protected $_identity;

    public function init()
    {
        $this->_acl = new Uthando_Acl_Uthando();
    }

    public function getAcl()
    {
        return $this->_acl;
    }

    public function isAllowed($resource = null, $privilege = null)
    {
        if (null === $this->_acl) {
            return null;
        }

        return $this->_acl->isAllowed($this->getIdentity(), $resource, $privilege);
    }

    public function setIdentity($identity)
    {
        if (is_array($identity)) {
            if (!isset($identity['role'])) {
                $identity['role'] = 'Guest';
            }

            $identity = new Zend_Acl_Role($identity['role']);
        } elseif (is_object($identity) && is_string($identity->role)) {
            $identity = new Zend_Acl_Role($identity->role);
        } elseif (is_scalar($identity) && !is_bool($identity)) {
            $identity = new Zend_Acl_Role($identity);
        } elseif (null === $identity) {
            $identity = new Zend_Acl_Role('Guest');
        } elseif (!$identity instanceof Zend_Acl_Role_Interface) {
            throw new Exception('Invalid identity provided');
        }

        $this->_identity = $identity;

        return $this;
    }

    public function getIdentity()
    {
        if (null === $this->_identity) {
            $auth = Zend_Auth::getInstance();

            if (!$auth->hasIdentity()) {
                return 'Guest';
            }

            $this->setIdentity($auth->getIdentity());
        }

        return $this->_identity;
    }

    public function direct($resource = null, $privilege = null)
    {
        return $this->isAllowed($resource, $privilege);
    }
}
?>
