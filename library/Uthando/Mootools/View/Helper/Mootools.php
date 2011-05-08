<?php

/*
 * MooTools.php
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
 * Description of Uthando_Mootools_View_Helper_Mootools
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Uthando_Mootools_View_Helper_Mootools extends Zend_View_Helper_Abstract
{
    /**
     * Base CDN url to utilize
     * @var string
     */
    protected $_cdnBase = Uthando_Mootools::CDN_BASE_GOOGLE;

    /**
     * Path segment following version string of CDN path
     * @var string
     */
    protected $_cdnPath = Uthando_Mootools::CDN_MOOTOOLS_PATH_GOOGLE;

    /**
     * Mootools version to use from CDN
     * @var string
     */
    protected $_cdnVersion = '1.3.2';

    public function mootools()
    {
        $log = Zend_Registry::get('log');
        $log->info(__METHOD__);

        $this->view->headScript()
             ->appendFile($this->_cdnBase . $this->_cdnVersion . $this->_cdnPath);

        return $this;
    }
}

?>
