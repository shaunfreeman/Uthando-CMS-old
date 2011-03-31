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
 * Description of Abstract
 *
 * @abstract
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class Uthando_Model_Abstract
{
    protected $_classMethods;
    
    /**
     * Constructor
     *
     * @param array|Zend_Config|null $options
     * @return void
     */
    public function __construct($options = null)
    {
        $this->_classMethods = get_class_methods($this);
        
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        }

        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Sets the value for a property.
     *
     * @param var $name
     * @param mixed $value
     * @return none
     * @access public
     */
    public function  __set($name, $value) {
       $method = 'set' . ucfirst($name);

        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid ' . $name . ' property');
        }

        $this->$method($value);
    }

    /**
     * Gets the property in this class.
     *
     * @param var $name
     * @return method
     * @access public
     */
    public function  __get($name) {
        $method = 'get' . ucfirst($name);

        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid ' . $name . ' property');
        }

        return $this->$method();
    }

    /**
     * Sets the options for this class.
     * 
     * @param array $options
     * @return Uthando_Model_Abstract
     * @access public
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $this->_classMethods)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    /**
     * Turns class values into an array.
     * 
     * @param none
     * @return array
     * @access public
     */
    public function toArray()
    {
        $array = array();

        foreach ($this->_classMethods as $method) {
            if (substr($method, 0, 3) == 'get') {
                $array[lcfirst(substr($method,3))] = $this->$method();
            }
        }

        return $array;
    }
}
?>
