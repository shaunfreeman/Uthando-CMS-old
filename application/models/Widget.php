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
 * Description of Core_Model_Widget
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Core_Model_Widget extends Uthando_Model_Abstract
{
    protected $_widgetId;
    protected $_widgetGroupId;
    protected $_name;
    protected $_widget;
    protected $_sortOrder;
    protected $_showTitle;
    protected $_params;
    protected $_html;
    protected $_enabled;

    public function getWidgetId()
    {
        return $this->_widgetId;
    }

    public function setWidgetId($id)
    {
        $this->_widgetId = (int) $id;
        return $this;
    }

    public function getWidgetGroupId()
    {
        return $this->_widgetGroupId;
    }

    public function setWidgetGroupId($id)
    {
        $this->_widgetGroupId = (int) $id;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function getWidget()
    {
        return $this->_widget;
    }

    public function setWidget($widget)
    {
        $this->_widget = (string) $widget;
        return $this;
    }

    public function getSortOrder()
    {
        return $this->_sortOrder;
    }

    public function setSortOrder($sort_order)
    {
        $this->_sortOrder = (int) $sort_order;
        return $this;
    }

    public function getShowTitle()
    {
        return $this->_showTitle;
    }

    public function setShowTitle($show_title)
    {
        $this->_showTitle = (int) $show_title;
        return $this;
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function setParams($params)
    {
        $this->_params = (string) $params;
        return $this;
    }

    public function getHtml()
    {
        return $this->_html;
    }

    public function setHtml($html)
    {
        $this->_html = (string) $html;
        return $this;
    }

    public function getEnabled()
    {
        return $this->_enabled;
    }

    public function setEnabled($enabled)
    {
        $this->_enabled = (int) $enabled;
        return $this;
    }
}
?>
