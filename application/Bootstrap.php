<?php
/*
 * Bootstrap.php
 *
 * Copyright (c) 2010 Shaun Freeman <shaun@shaunfreeman.co.uk>.
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
 * Class Bootstrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Holds the logger class
     * 
     * @var $_logger
     * @access protected
     */
    protected $_logger;
    
    /**
     * Sets the logging for the application.
     * 
     * @param none
     * @return none
     * @access private
     */
    protected function _initLogging()
    {
        $this->bootstrap('frontController');
        $logger = new Zend_Log();

        $writer = 'production' == $this->getEnvironment() ?
            new Zend_Log_Writer_Stream(APPLICATION_PATH.'/../data/logs/app.log') :
            new Zend_Log_Writer_Firebug();
        $logger->addWriter($writer);

        if ('production' == $this->getEnvironment()) {
            $filter = new Zend_Log_Filter_Priority(Zend_Log::CRIT);
            $logger->addFilter($filter);
        }

        $this->_logger = $logger;
        Zend_Registry::set('log', $logger);
    }

    /**
     * Sets the Database profiler for the application.
     *
     * @param none
     * @return none
     * @access private
     */
    protected function _initDbProfiler()
    {
        $this->_logger->info(__METHOD__);

        if ('production' !== $this->getEnvironment()) {
            $this->bootstrap('db');
            $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
            $profiler->setEnabled(true);
            $this->getPluginResource('db')
                 ->getDbAdapter()
                 ->setProfiler($profiler);
        }
    }

    /**
     * Set up domain options and merge with main Uthando-CMS options
     *
     * @param none
     * @return none
     * @access none
     */
    protected function _initConfig()
    {
        $this->_logger->info(__METHOD__);
        
        $config = Core_Model_Config::getConfig();
        Zend_Registry::set('siteConfig', $config);
    }

    /**
     * Starts the session.
     *
     * @param none
     * @return none
     * @access none
     */
    protected function _initSession()
    {
        $this->_logger->info(__METHOD__);

        $this->bootstrap('db');
        
        $config = array(
            'name'           => 'core_session',
            'primary'        => 'id',
            'modifiedColumn' => 'modified',
            'dataColumn'     => 'data',
            'lifetimeColumn' => 'lifetime'
        );

        Zend_Session::setSaveHandler(new Zend_Session_SaveHandler_DbTable($config));
        Zend_Session::start();
    }

    protected function _initActionHelpers()
    {
        $this->_logger->info(__METHOD__);
        Zend_Controller_Action_HelperBroker::addHelper(new Uthando_Controller_Helper_Acl());
    }

    /**
     * Sets up the modules.
     *
     * @param none
     * @return none
     * @access protected
     */
    protected function _initModules()
    {
        $this->_logger->info(__METHOD__);
        
        $mapper = new Core_Model_Mapper_Module();
        $modules = $mapper->getEnabledModules();

        $enabled_modules = array(
            'default'   => APPLICATION_PATH . '/controllers'
        );
        
        foreach ($modules as $value) {
            $enabled_modules[$value->getModule()] = APPLICATION_PATH . '/modules/' . $value->getModule() . '/controllers';
        }

        $front = $this->getResource('frontController');
        $front->setControllerDirectory($enabled_modules);
        
    }

    /**
     * Sets up auto loading of widgets.
     *
     * @param none
     * @return none
     * @access public
     */
    public function _initModelWidgetAutoloader()
    {
        $this->_logger->info(__METHOD__);

        $this->getResourceLoader()->addResourceTypes(array(
            'widget' => array(
              'path'      => 'widgets',
              'namespace' => 'Widget',
            )
        ));
    }

    /**
     * Sets up translation
     */
    protected function _initTranslate() {

        $this->_logger->info(__METHOD__);
        
        // Get current registry
        $registry = Zend_Registry::getInstance();
        
        $locale = new Zend_Locale();

        $registry->set('Zend_Locale', $locale);

        $translate = new Zend_Translate(
            array(
                'adapter'           => 'gettext',
                'content'           => APPLICATION_PATH . '/../languages',
                'locale'            => 'auto',
                'scan'              => Zend_Translate::LOCALE_FILENAME,
                'disableNotices'    => true,
                'logUntranslated'   => false
            )
        );
        
        $registry->set('Zend_Translate', $translate);    
    }

    /**
     * Set default view settings
     *
     * @param none
     * @return none
     * @access private
     */
    protected function _initViewSettings()
    {
        $this->_logger->info(__METHOD__);

        $this->bootstrap('view');

        $this->_view = $this->getResource('view');

        $this->_view->addHelperPath(
                APPLICATION_PATH . '/views/helpers', 'Zend_View_Helper'
        );
    }
}

?>
