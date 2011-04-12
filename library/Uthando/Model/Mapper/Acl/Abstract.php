<?php
/* 
 * Abstract.php
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
 * Description of Uthando_Model_Mapper_Acl_Abstract
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class Uthando_Model_Mapper_Acl_Abstract extends Uthando_Model_Mapper_Abstract
implements Zend_Acl_Resource_Interface
{
    protected $_acl;
    protected $_identity;

    /**
     * Implement the Zend_Acl_Resource_Interface, make this model
     * an acl resource
     *
     * @param none
     * @return string The resource id
     * @access public
     */
    public function  getResourceId() {
        return $this->_modelClass;
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

    public function checkAcl($action)
    {   
        return $this->getAcl()->isAllowed(
                $this->getIdentity(),
                $this,
                $action
        );
    }

    /**
     * Injector for the acl, the acl can be injected either directly
     * via this method or by passing the 'acl' option to the models
     * construct.
     *
     * We add all the access rule for this resource here, so we
     * add $this as the resource, plus its rules.
     *
     * @param Zend_Acl_Resource_Interface $acl
     * @return Uthando_Model_Mapper_Abstract
     */
    public function setAcl($acl)
    {
        if (!$acl->has($this->getResourceId())) {
            $acl->add($this);
        }

        $this->_acl = $acl;

        return $this;
    }

    /**
     * Get the acl and automatically instantiate the default acl if one
     * has not been injected.
     *
     * @return Zend_Acl
     */
    public function getAcl()
    {
        if (null === $this->_acl) {
            $this->setAcl(new Uthando_Acl_Uthando());
        }

        return $this->_acl;
    }
}
?>
