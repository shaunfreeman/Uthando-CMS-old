<?php
/* 
 * Authentication.php
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
 * Description of Authentication
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Service_Authentication
{
    protected $_authAdapter;
    protected $_userModel;
    protected $_auth;

    public function __construct(Core_Model_Mapper_User $userModel = null)
    {
        $this->_userModel = (null === $userModel) ?
                new Core_Model_Mapper_User() : $userModel;
    }

    public function authenticate($credentials)
    {
        $adapter    = $this->getAuthAdapter($credentials);
        $auth       = $this->getAuth();
        $result     = $auth->authenticate($adapter);

        if (!$result->isValid()) {
            return false;
        }

        $user = $this->_userModel
                ->getUserByEmail($credentials['email']);
        $auth->getStorage()->write($user);

        return true;
    }

    public function getAuth()
    {
        if (null === $this->_auth) {
            $this->_auth = Zend_Auth::getInstance();
        }

        return $this->_auth;
    }

    public function getIdentity()
    {
        $auth = $this->getAuth();

        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }

        return false;
    }

    public function clear()
    {
        $this->getAuth()->clearIdentity();
    }

    public function setAuthAdapter(Zend_Auth_Adapter_Interface $adapter)
    {
        $this->_authAdapter = $adapter;
    }

    public function getAuthAdapter($values)
    {
        if (null === $this->_authAdapter) {
            $authAdapter = new Zend_Auth_Adapter_DbTable(
                    Zend_Db_Table_Abstract::getDefaultAdapter(),
                    'core_user',
                    'email',
                    'password'
            );

            $this->setAuthAdapter($authAdapter);
            $this->_authAdapter->setIdentity($values['email']);
            $this->_authAdapter->setCredential($values['password']);

            $auth = Zend_Registry::get('siteConfig')->user->auth;
            
            if ($auth->credentialTreatment === 'MCrypt') {
                // MCrypt stuff here.
                // get IV then encrypt $values['password']
                // and then setCredential with encrypted password
                // to check against.
            } elseif (is_string($auth->credentialTreatment)) {
                $this->_authAdapter->setCredentialTreatment($auth->credentialTreatment);
            } else {
                throw new Exception(_('Password credential treatment needs to to set.'));
            }
        }

        return $this->_authAdapter;
    }
}
?>
