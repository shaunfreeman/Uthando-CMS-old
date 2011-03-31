<?php
/* 
 * Base.php
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
 * Description of Base
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Form_User_Base extends Uthando_Form_Abstract
{
    public function init()
    {
        $this->addElement('text', 'firstName', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                'Alpha',
                array('StringLength', true, array(3, 128))
            ),
            'required'      => true,
            'label'         => _('First Name'),
            'attribs'       => array ('class' => 'inputbox')
        ));

        $this->addElement('text', 'lastName', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                'Alpha',
                array('StringLength', true, array(3, 128))
            ),
            'required'      => true,
            'label'         => _('Last Name'),
            'attribs'       => array ('class' => 'inputbox')
        ));

        $this->addElement('text', 'email', array(
            'filters'       => array('StringTrim', 'StringToLower'),
            'validators'    => array(
                array('StringLength', true, array(3, 128)),
                array('EmailAddress', true, array(
                    'mx'    => true
                )),
                array('Db_NoRecordExists', false, array(
                    'table' => 'core_user',
                    'field' => 'email'
                ))
            ),
            'required'      => true,
            'label'         => _('Email'),
            'attribs'       => array ('class' => 'inputbox')
        ));

        $this->addElement('text', 'username', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('StringLength', true, array(3, 128))
            ),
            'label'         => _('Username'),
            'attribs'       => array ('class' => 'inputbox')
        ));

        $this->addElement('password', 'password', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('StringLength', true, array(6, 128))
            ),
            'required'      => true,
            'label'         => _('Password'),
            'attribs'       => array ('class' => 'inputbox')
        ));

        $this->addElement('password', 'passwordVerify', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('identical', false, array('token' => 'password'))
            ),
            'required'      => true,
            'label'         => _('Confirm Password'),
            'attribs'       => array ('class' => 'inputbox')
        ));

        $model = new Core_Model_Mapper_Role();
        $roles = $model->fetchAll();

        $multiOptions = array(
            0 => 'Select Role'
        );
        
        $identity = Zend_Auth::getInstance();

        if ($identity->hasIdentity()) {
            $upid = $identity->getIdentity()->getUpid();
        } else {
            $upid = 0;
        }
        
        foreach ($roles as $role) {
            if ($role->getRole() == 'Guest') continue;
            if ($upid == 0 || $role->getUpid() < $upid) continue;
            $multiOptions[$role->getRoleId()] = $role->getRole();
        }

        $displayGroup = $this->getDisplayGroup('UserDetails');

        $this->addElement('select', 'roleId', array(
            'validators'    => array(
                array('GreaterThan', true, array('min' => 0))
            ),
            'errorMessages'  => array(_('Please select a role for this user.')),
            'label'         => _('Role'),
            'MultiOptions'  => $multiOptions,
            'required'      => true
        ));

         // Setup Groups.
        $this->addDisplayGroup(array(
            'firstName',
            'lastName',
            'email',
            'username',
            'roleId'
        ), 'UserDetails', array(
            'legend'        => _('User Details'),
            'decorators'    => array(
                'FormElements',
                'Fieldset',
                new Zend_Form_Decorator_HtmlTag(array(
                    'tag' => 'div',
                    'id' => 'userDetailsGroup'
                ))
            )
        ));

        $this->addDisplayGroup(array(
            'password',
            'passwordVerify'
        ), 'SitePassword', array(
            'legend' => _('Site Password'),
            'decorators'    => array(
                'FormElements',
                'Fieldset',
                new Zend_Form_Decorator_HtmlTag(array(
                    'tag' => 'div',
                    'id' => 'sitePasswordGroup'
                ))
            )
        ));

        $captcha = Zend_Registry::get('siteConfig')
            ->user
            ->captcha;

        if ($captcha->enabled) {

            $this->addElement('captcha', 'captcha', array(
                'captcha'    => $captcha->options->toArray(),
                'required'   => true,
                'label'      => _('Please enter the letters displayed below:'),
                'attribs'       => array ('class' => 'inputbox')
            ));

            $this->addDisplayGroup(array(
                'captcha'
            ), 'SiteCaptcha', array('legend' => _('Captcha Image')));

        }

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }

    /**
     * Excludes the current user's email from validating against the database.
     * 
     * @param string $email
     * @return Core_Form_User_Base
     * @access public
     */
    public function excludeUserEmailFromValidation($email)
    {
        $this->getElement('email')
                ->addValidator(
            'Db_NoRecordExists',
            false,
            array(
                'table'     => 'core_user',
                'field'     => 'email',
                'exclude'   => array(
                    'field' => 'email',
                    'value' => $email
                )
            )
        );

        return $this;
    }
}
?>
