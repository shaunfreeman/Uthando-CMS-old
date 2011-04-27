<?php
/*
 * Bootstrap.php
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
 * Description of Ublog_Bootstrap
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Ublog_Bootstrap extends Zend_Application_Module_Bootstrap
{
    /**
     * @var Zend_Log
     */
    protected $_logger;

    protected function _initLogging()
    {
        $this->_logger = Zend_Registry::get('log');
    }

    protected function _initModuleResourceAutoloader()
    {
        $this->_logger->info(__METHOD__);

        $this->getResourceLoader()->addResourceTypes(array(
            'widget' => array(
              'path'      => 'widgets',
              'namespace' => 'Widget',
            )
        ));
    }

    protected function _initRoutes()
    {
        $this->_logger->info(__METHOD__);

        $router = Zend_Controller_Front::getInstance()->getRouter();

        $config = new Zend_Config_Ini(APPLICATION_PATH . '/modules/ublog/configs/routes/blog.ini', 'routes');

        $router->addConfig($config, 'routes');

    }

    /**
     * Set blog view settings
     */
    protected function _initViewSettings()
    {
        $this->_logger->info(__METHOD__);

        //$this->_view = $this->getApplication()->getResource('view');

       // $this->_view->addHelperPath(
            //APPLICATION_PATH . '/modules/ublog/views/helpers', 'Zend_View_Helper'
        //);
    }
}
?>
