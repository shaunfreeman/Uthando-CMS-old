<?php

/*
 * HtmlPurifier.php
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
 * Description of HtmlPurifier
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Zend_View_Helper_HtmlPurifier extends Zend_View_Helper_Abstract
{
    /**
     * Returns the string $ value, purified by HTMLPurifier
     * @ param string $ value
     * @ param mixed $ config
     * @ return string
     */
    public function HtmlPurifier($value , $config = null)
    {
        $filter  =  new Uthando_Filter_HtmlPurifier($config);
        return  $filter->filter($value);
    }
}

?>
