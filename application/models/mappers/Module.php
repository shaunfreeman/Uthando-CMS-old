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
 * Description of Core_Model_Mapper_Modules
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Model_Mapper_Module extends Uthando_Model_Mapper_Acl_Abstract
{
    protected $_dbTableClass = 'Core_Model_DbTable_Module';
    protected $_modelClass = 'Core_Model_Module';
    
    /**
     * Sets all values for the module table row.
     * 
     * @param object $row
     * @param Core_Model_Module $module
     * @return Core_Model_Module
     * @access protected
     */
    protected function _setVars($row, $module)
    {
        return $module
            ->setId($row->moduleId)
            ->setModule($row->module)
            ->setEnabled($row->enabled);
    }

    public function getModules()
    {
        $select = $this->getDbTable()
                ->select()
                ->order('module');

        return $this->fetchAll($select);
    }

    /**
     * Saves sata to database if row exists then updates row else
     * inserts new row.
     * 
     * @param object $module
     */
    protected function save($data, Core_Model_Module $model)
    {   
        $data = array(
            'module'    => $module->getModule(),
            'enabled'   => $module->getEnabled()
        );

        if (null === ($id = $module->id())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    /**
     * Gets all enabled modules.
     *
     * @param none
     * @return object
     * @access public
     */
    public function getEnabledModules()
    {   
        $select = $this->getDbTable()
                ->select()
                ->where('enabled = 1')
                ->order('module');

        return $this->fetchAll($select);
    }

    public function setAcl($acl) {
        parent::setAcl($acl);

        $this->_acl->allow('Administrator', $this, array('save'))
                ->allow('SuperAdministrator', $this);

        return $this;
    }
}
?>
