<?php
/* 
 * Modules.php
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
 * Description of Core_Model_Modules
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Model_Module extends Uthando_Model_Abstract
{
    /**
     * Holds the module id.
     *
     * @var int
     * @access protected
     */
    protected $_id;
    
    /**
     * Holds the module name.
     *
     * @var string
     * @access protected
     */
    protected $_module;

    /**
     * Holds whether module is enabled.
     * 
     * @var int
     * @access protected
     */
    protected $_enabled;

    /**
     * Gets the module id.
     *
     * @return int
     * @access public
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets the module id.
     *
     * @param int $id
     * @return Core_Model_Modules
     * @access public
     */
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    /**
     * Gets the module name.
     *
     * @return string
     * @access public
     */
    public function getModule()
    {
        return $this->_module;
    }

    /**
     * Sets the module name.
     *
     * @param string $module
     * @return Core_Model_Module
     * @access public
     */
    public function setModule($module)
    {
        $this->_module = (string) $module;
        return $this;
    }

    /**
     * Gets whether the module is enabled.
     *
     * @return int
     * @access public
     */
    public function getEnabled()
    {
        return $this->_enabled;
    }

    /**
     * Sets the module enabled mode.
     *
     * @param int $enabled
     * @return Core_Model_Module
     * @access public
     */
    public function setEnabled($enabled)
    {
        $this->_enabled = (int) $enabled;
        return $this;
    }

}
?>
