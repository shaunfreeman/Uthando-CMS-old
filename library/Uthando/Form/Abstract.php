<?php
/* 
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
 */

/**
 * Description of Abstract
 *
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
     * Constructs a submit button.
     *
     * @param string $label
     * @return Uthando_Form_Abstract
     * @access public
     */
    public function addSubmit($label)
    {
       $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => $label,
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
            'value' => $value
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
            'salt'      => 'unique'
        ));

        return $this;
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
