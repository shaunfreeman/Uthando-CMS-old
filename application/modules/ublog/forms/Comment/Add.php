<?php

/*
 * Add.php
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
 * Description of Ublog_Form_Comment_Add
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Ublog_Form_Comment_Add extends Uthando_Form_Abstract
{
    public function init()
    {
        $this->addElementPrefixPath(
            'Uthando_Filter',
            APPLICATION_PATH . '/../library/Uthando/Filter/',
            'filter'
        );

        $this->addElement('text', 'Name', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('Alpha', true, array('allowWhiteSpace' => true)),
                array('StringLength', true, array(3, 128))
            ),
            'required'      => true,
            'label'         => _('Name'),
            'attribs'       => array ('class' => 'inputbox')
        ));

        $this->addElement('text', 'email', array(
            'filters'       => array('StringTrim', 'StringToLower'),
            'validators'    => array(
                array('StringLength', true, array(3, 128)),
                array('EmailAddress', true, array(
                    'mx'    => true
                ))
            ),
            'required'      => true,
            'label'         => _('Email'),
            'attribs'       => array ('class' => 'inputbox')
        ));

        $this->addElement('text', 'website', array(
            'filters'       => array('StringTrim', 'StringToLower'),
            'validators'    => array(
                array('StringLength', true, array(3, 128))
            ),
            'label'         => _('Website'),
            'attribs'       => array ('class' => 'inputbox')
        ));

        $this->addElement('textarea', 'comment', array(
            'filters'       => array('HtmlPurifier'),
            'label'         => _('Comment'),
            'required'      => true,
            'attribs'       => array ('class' => 'inputbox', 'rows' => '15', 'cols' => '40')
        ));

        $this->addElement('hidden', 'blogId');

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
        }

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));

        $this->addSubmit('Comment');
        $this->addHash('csrf');
    }
}

?>
