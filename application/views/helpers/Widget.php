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
 * Description of Widget
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Zend_View_Helper_Widget extends Zend_View_Helper_Abstract
{
    private $_widget;
    private $_DbTable;
    
    public function widget()
    {
        $this->_widget = null;
        $this->_DbTable = new Core_Model_Mapper_Widget();
        return $this;
    }

    public function get($name)
    {
        $widget = $this->_DbTable->getWidgetByName($name);

        if ($widget instanceof Uthando_Model_Abstract) {
            $widgetClass = $this->_getInflected($widget->widget);
            $this->_widget = new $widgetClass($widget);
        } else {
            $this->_widget = '';
        }

        return $this;
    }

    public function getWidgetsByGroup($group)
    {
        $this->_widget = array();
        $widgets = $this->_DbTable->getWidgetsByGroup($group, true);

        foreach ($widgets as $widget) {
           $widgetClass = $this->_getInflected($widget->widget);
           $this->_widget[] = new $widgetClass($widget);
        }
        
        return $this;
    }

    public function __toString()
    {
        try {
            return $this->render();
        } catch (Exception $e) {
            $msg = get_class($e) . ': ' . $e->getMessage();
            trigger_error($msg, E_USER_ERROR);
            return '';
        }
    }

    public function render()
    {   
        if ($this->_widget instanceof Uthando_Widget_Abstract) {
            return $this->_widget->render();
        } elseif (is_array($this->_widget)) {
            $widgetGroup = '';

            foreach ($this->_widget as $widget) {
                $widgetGroup .= $widget->render();
            }
            
            return $widgetGroup;
        } else {
            return '';
        }
    }

    /**
     * Inflect the name using the inflector filter
     *
     * Changes camelCaseWord to Camel_Case_Word
     *
     * @param string $name The name to inflect
     * @return string The inflected string
     */
    private function _getInflected($name)
    {
        $inflector = new Zend_Filter_Inflector(':class');
        $inflector->setRules(array(
            ':class'  => array('Word_CamelCaseToUnderscore')
        ));
        return ucfirst($inflector->filter(array('class' => $name)));
    }
}
?>
