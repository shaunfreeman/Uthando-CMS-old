<?php
/* 
 * Message.php
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
 * Displays an html message block with links.
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Zend_View_Helper_Message extends Zend_View_Helper_Abstract
{
    private $_text;

    private $_links = array();
    
    /**
     * Constructs the message and adds the links if any.
     * 
     * @param string $text
     * @param array $links
     * @return string
     * @access public
     */
    public function message($text, $links = array())
    {
        $this->_text = (string) $text;
        $this->_links = (array) $links;

        $this->_widget = new Core_Widget_Message($widget);
        
    }

    public function  __toString() {
        return $html;
    }
}
?>
