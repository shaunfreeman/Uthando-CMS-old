<?php

/*
 * Tidy.php
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
 * Description of Tidy
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Uthando_Controller_Plugin_TidyOutput extends Zend_Controller_Plugin_Abstract
{
    /**
     * @var tidy|null
     */
     protected $_tidy;

    /**
     * @var array
     */
    protected static $_tidyConfig = array(
        'indent'                        => true,
        //'indent-attributes'             => true,
        'output-xhtml'                  => true,
        'doctype'                       => 'strict',
        'drop-proprietary-attributes'   => true,
        'wrap'                          => 600,
    );
    /**
     * @var string
     */
    protected static $_tidyEncoding = 'UTF8';

    public static function setConfig(array $config)
    {
        self::$_tidyConfig = $config;
    }

    public static function setEncoding($encoding)
    {
         if (!is_string($encoding)) {
             throw new InvalidArgumentException('Encoding must be a string');
         }
         self::$_tidyEncoding = $encoding;
    }

    protected function getTidy($string = null)
    {
        if (null === $this->_tidy) {
            if (null === $string) {
                $this->_tidy = new tidy();
            } else {
                $this->_tidy = tidy_parse_string($string,
                                                 self::$_tidyConfig,
                                                 self::$_tidyEncoding);
            }
        }
        return $this->_tidy;
    }

    public function dispatchLoopShutdown()
    {
        $response = $this->getResponse();
        $tidy     = $this->getTidy($response->getBody());
        $tidy->cleanRepair();
        $response->setBody((string) $tidy);
    }
}

?>
