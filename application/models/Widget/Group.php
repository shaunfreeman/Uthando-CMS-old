<?php
/* 
 * WidgetGroup.php
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
 * Description of WidgetGroup
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Model_Widget_Group extends Uthando_Model_Abstract
{
    protected $_widgetGroupId;
    protected $_widgetGroup;

    public function getWidgetGroupId()
    {
        return $_widgetGroupId;
    }

    public function setWidgetGroupId($id)
    {
        $this->_widgetGroupId = (int) $id;
        return $this;
    }

    public function getWidgetGroup()
    {
        return $this->_widgetGroup;
    }

    public function setWidgetGroup($group)
    {
        $this->_widgetGroup = (string) $group;
        return $this;
    }
}
?>
