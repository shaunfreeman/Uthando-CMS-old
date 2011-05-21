<?php
/**
 * Abstract.php
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
 *
 * @category Uthando
 * @package Uthando_Form
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of Abstract
 *
 * @category Uthando
 * @package Uthando_Form
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class Uthando_Form_Abstract extends Zend_Form
{
    /**
     * @var model object
     * @access protected
     */
    protected $_model;

    /**
     * An array that set the global decorators for all elements.
     *
     * @var array
     * @access protected
     */
    protected $_elementDecorators = array(
        'ViewHelper',
        'Errors',
        'Description',
        array(
            array('data' => 'HtmlTag'),
            array(
                'tag' => 'p',
                'class' => 'element'
            )
        ),
        array(
            'Label',
            array('tag' => 'p')
        ),
        array(
            array('row' => 'HtmlTag'),
            array('tag' => 'div')
        )
    );

    /**
     * Loads the default form decorators.
     *
     * @param none
     * @return void
     * @access public
     */
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'Description',
            'FormElements',
            array(
                'HtmlTag',
                array(
                    'tag' => 'div',
                    'class' => 'zend_form'
                )
            ),
            'Form'
        ));
    }

    /**
     * Constructs a submit button.
     *
     * @param string $label
     * @return Uthando_Form_Abstract
     * @access public
     */
    public function addSubmit($label)
    {
        $this->addElement('submit', 'submit', array(
            'ignore'        => true,
            'decorators'    => array(
                'ViewHelper',
                array(
                    'HtmlTag',
                    array(
                        'tag'   => 'div'
                    )
                )
            ),
            'label'         => $label,
            'attribs'       => array ('class' => 'button')
        ));

       return $this;
    }

    /**
     * Adds a hidden element to the form.
     *
     * @param string $id id or name of element.
     * @param string $value value to be inserted into the hidden element.
     * @return Uthando_Form_Abstract
     * @access public
     */
    public function addHiddenElement($id, $value)
    {
        $this->addElement('hidden', $id, array(
            'value' => $value,
            'decorators'    => array(
                'ViewHelper',
                array(
                    'HtmlTag',
                    array(
                        'tag'   => 'div'
                    )
                )
            )
        ));

        return $this;
    }

    /**
     * Injects a hash input element into the form to protect against CSRF attacks.
     *
     * @param string $id id or name of element.
     * @return Uthando_Form_Abstract
     * @access public
     */
    public function addHash($id)
    {
        $this->addElement('hash', $id, array(
            'ignore'    => true,
            'salt'      => 'unique',
            'decorators'    => array(
                'ViewHelper',
                array(
                    'HtmlTag',
                    array(
                        'tag'   => 'div'
                    )
                )
            )
        ));

        return $this;
    }

    /**
     * Adds the Captcha element to the form.
     *
     * @param array $data array of options to apply for the captcha
     * @return void
     * @access public
     */
    public function addCaptcha($data)
    {
        $this->addElement('captcha', 'captcha', array(
            'captcha'    => $data,
            'required'   => true,
            'label'      => _('Please enter the letters displayed below:'),
            'attribs'       => array ('class' => 'inputbox'),
            'decorators'    => array(
                'Errors',
                array(
                    array('data' => 'HtmlTag'),
                    array(
                        'tag' => 'p',
                        'class' => 'element'
                    )
                ),
                array(
                    'Label',
                    array('tag' => 'p')
                ),
                array(
                    array('row' => 'HtmlTag'),
                    array(
                        'tag' => 'div',
                        'id' => 'captcha'
                    )
                )
            )
        ));
    }

    /**
     * Model setter
     *
     * @param object $model
     * @return none
     * @access public
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }

    /**
     * Model Getter
     *
     * @return object model
     * @access public
     */
    public function getModel()
    {
        return $this->_model;
    }
}
?>
