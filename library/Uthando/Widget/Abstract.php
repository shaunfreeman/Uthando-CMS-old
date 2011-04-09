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
 * Description of Uthando_Widget_Abstract
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class Uthando_Widget_Abstract
{
    protected $_view;
    protected $_viewTemplate = 'widget.phtml';
    
    public function __construct($widget)
    {
        $this->_view = new Zend_View();
        $this->_view->setScriptPath(APPLICATION_PATH . '/widgets/views');

        if (is_array($widget)) {
            $widget = Uthando_Utility_Array::arrayToObject($widget);
        }

        $this->_view->assign('widget', (object) $widget);
        $this->setParams();
        
        $this->init();
    }

    public function init() {}

    public function setParams($params = null)
    {
        $params = ($params) ? $params : $this->_view->widget->params;
        $this->_view->assign('params', (array) parse_ini_string($params));
    }
    
    public function render()
    {
        return $this->_view->render($this->_viewTemplate);
    }
}
?>
