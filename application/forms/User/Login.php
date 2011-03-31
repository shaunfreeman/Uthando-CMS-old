<?php
/* 
 * Login.php
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
 * Description of Login
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Form_User_Login extends Core_Form_User_Base
{
    public function init()
    {
        parent::init();

        $this->removeElement('firstName');
        $this->removeElement('lastName');
        $this->removeElement('username');
        $this->removeElement('roleId');

        $this->removeElement('passwordVerify');

        $this->removeElement('captcha');

        $this->removeDisplayGroup('UserDetails');
        $this->removeDisplayGroup('SitePassword');
        $this->removeDisplayGroup('SiteCaptcha');
        
        $this->getElement('email')->removeValidator('Db_NoRecordExists');

        $this->addHash('csrf');

        $this->addSubmit(_('Login'));
    }
}
?>
