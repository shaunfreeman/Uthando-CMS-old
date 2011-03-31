<?php
/* 
 * Uthando.php
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
 * Description of Uthando
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Uthando_Acl_Uthando extends Zend_Acl
{
    public function __construct()
    {
        /**
         * TODO:
         * add Acl config from database.
         */
        $this->addRole(new Zend_Acl_Role('Guest'));
        $this->addRole(new Zend_Acl_Role('Registered'));
        $this->addRole(new Zend_Acl_Role('Manager'), 'Registered');
        $this->addRole(new Zend_Acl_Role('Administrator'), 'Manager');
        $this->addRole(new Zend_Acl_Role('SuperAdministrator'), 'Administrator');

        $this->addResource(new Zend_Acl_Resource('Guest'));
        $this->addResource(new Zend_Acl_Resource('User'));
        $this->addResource(new Zend_Acl_Resource('Admin'));

        $this->deny();

        $this->allow('Guest', 'Guest');
        $this->allow('Registered', 'User');
        $this->allow('Manager', 'Admin');
    }
}
?>
