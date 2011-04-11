<?php
/* 
 * Widget.php
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
 * Description of Core_Model_Mapper_Widget
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Model_Mapper_Widget extends Uthando_Model_Acl_Abstract
{
    protected $_dbTableClass = 'Core_Model_DbTable_Widget';
    protected $_modelClass = 'Core_Model_Widget';

    protected function _setVars($row, $module)
    {
        return $module
            ->setWidgetId($row->widgetId)
            ->setName($row->name)
            ->setWidget($row->widget)
            ->setSortOrder($row->sortOrder)
            ->setShowTitle($row->showTitle)
            ->setParams($row->params)
            ->setHtml($row->html)
            ->setEnabled($row->enabled);
    }

    public function save()
    {
        parent::save();
    }

    public function getWidgetByName($widget)
    {
        $select = $this->getDbTable()
                ->select()
                ->where('name = ?', $widget)
                ->where('enabled = 1');

        return $this->fetchRow($select);
    }

    public function getWidgetsByGroup($group, $raw = false)
    {
        $widgetGroupTable = new Core_Model_Mapper_Widget_Group();
        $group = $widgetGroupTable->getWidgetGroupId($group, $raw);
        
        $widgets = $group->findDependentRowset(
                'Core_Model_DbTable_Widget',
                'Group'
        );

        $entries = array();

        foreach ($widgets as $row) {
			if ($row->enabled) {
            	$entries[] = $this->_setVars($row, new $this->_modelClass());
			}
        }

        return $entries;
    }

    public function setAcl($acl) {
        parent::setAcl($acl);

        $this->_acl->allow('Administrator', $this, array('save'))
                ->allow('SuperAdministrator', $this);

        return $this;
    }
}
?>
