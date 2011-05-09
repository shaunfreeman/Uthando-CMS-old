<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category    ZendX
 * @package     ZendX_MooTools
 * @subpackage  View
 * @copyright   Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license     http://framework.zend.com/license/new-bsd     New BSD License
 * @version     $Id: Container.php
 */


/**
 * @see ZendX_MooTools
 */
require_once "ZendX/MooTools.php";


class ZendX_MooTools_View_Helper_MooTools_Container
{
    /**
     * Path to local webserver MooTools library
     *
     * @var String
     */
    protected $_mootolsLibraryPath = null;

    /**
     * Additional javascript files that for MooTools Helper components.
     *
     * @var Array
     */
    protected $_javascriptSources = array();

    /**
     * Indicates wheater the MooTools  View Helper is enabled.
     *
     * @var Boolean
     */
    protected $_enabled = false;

    /**
     * Indicates if a capture start method for javascript or onLoad has been called.
     *
     * @var Boolean
     */
    protected $_captureLock = false;

    /**
     * Additional javascript statements that need to be executed after MooTools lib.
     *
     * @var Array
     */
    protected $_javascriptStatements = array();

    /**
     * Additional stylesheet files for MooTools related components.
     *
     * @var Array
     */
    protected $_stylesheets = array();

    /**
     * MooTools onLoad statements Stack
     *
     * @var Array
     */
    protected $_onLoadActions = array();

    /**
     * Actions to perform on window domready
     * @var array
     */
    protected $_domReadyActions = array();

    /**
     * View is rendered in XHTML or not.
     *
     * @var Boolean
     */
    protected $_isXhtml = false;



    /**
     * Default CDN MooTools Library version
     *
     * @var String
     */
    protected $_version = ZendX_MooTools::DEFAULT_MOOTOOLS_VERSION;


    /**
     * Default Render Mode (all parts)
     *
     * @var Integer
     */
    protected $_renderMode = ZendX_MooTools::RENDER_ALL;

    /**
     * MooTools Moore Library Enabled
     *
     * @var Boolean
     */
    protected $_mooreEnabled = false;


    /**
     * Local MooTools More Library Path
     * variable is null
     *
     * @var String
     */
    protected $_mooreLibraryPath = null;


   /**
     * MooTools Moore Version
     *
     * @var String
     */
    protected $_mooreVersion = ZendX_MooTools::DEFAULT_MOORE_VERSION;

    /**
     * Load CDN Path from SSL or Non-SSL?
     *
     * @var boolean
     */
    protected $_loadSslCdnPath = false;

    /**
     * View Instance
     *
     * @var Zend_View_Interface
     */
    public $view = null;


    /**
     * Set view object
     *
     * @param  Zend_View_Interface $view
     * @return void
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }


    /**
     * Enable MooTools
     *
     * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function enable()
    {

        $this->_enabled = true;
        return $this;
    }

    /**
     * Disable MooTools
     *
     * @return Gnbit_MooTools_View_Helper_MooTools_Container
     */
    public function disable()
    {
        $this->_enabled = false;
        return $this;
    }

    /**
     * Is mootools enabled?
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_enabled;
    }

    /**
     * Set the version of the MooTools library used.
     *
     * @param string $version
     * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function setVersion($version)
    {
        if (is_string($version) && preg_match('/^[1-9]\.[0-9](\.[0-9])?$/', $version)) {
            $this->_version = $version;
        }
        return $this;
    }

    /**
     * Get the version used with the MooTools library
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * Set Use SSL on CDN Flag
     *
     * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function setCdnSsl($flag)
    {
        $this->_loadSslCdnPath = $flag;
        return $this;
    }

    /**
     * Are we using the CDN?
     *
     * @return boolean
     */
    public function useCdn()
    {
        return !$this->useLocalPath();
    }


    /**
     * Set path to local MooTools library
     *
     * @param  string $path
     * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function setLocalPath($path)
    {
        $this->_mootolsLibraryPath  = (string) $path;
        return $this;
    }

    /**
     * Get local path to MooTols
     *
     * @return string
     */
    public function getLocalPath()
    {
        return $this->_mootolsLibraryPath;
    }


    /**
     * Are we using a local path?
     *
     * @return boolean
     */
    public function useLocalPath()
    {
        return (null === $this->_mootolsLibraryPath) ? false : true;
    }

    /**
     * Enable MooTools Moore Library Rendering
     *
     * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function mooreEnable()
    {
        $this->enable();
        $this->_mooreEnabled = true;
        return $this;
    }

    /**
     * Disable MooTools moore Library Rendering
     *
     * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function mooreDisable()
    {
        $this->_mooreEnabled = false;
        return $this;
    }


    /**
     * Check wheater currently the MooTools moore library is enabled.
     *
     * @return boolean
     */
    public function mooreIsEnabled()
    {
         return $this->_mooreEnabled;
    }

    /**
     * Set local path to MooTools Moore library
     * And Enable
     *
     * @param String $path
     * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function setMooreLocalPath($path)
    {
    	$this->_mooreLibraryPath = (string) $path;
    	$this->mooreEnable();
    	return $this;
    }

    /**
     * Return the local MooTools Moore Path if set.
     *
     * @return string
     */
    public function getMooreLocalPath()
    {
    	return $this->_mooreLibraryPath;
    }



     /**
     * Start capturing routines to run onLoad
     *
     * @return boolean
     */
    public function onLoadCaptureStart()
    {
        if ($this->_captureLock) {
            require_once 'Zend/Exception.php';
            throw new Zend_Exception('Cannot nest onLoad captures');
        }

        $this->_captureLock = true;
        return ob_start();
    }

    /**
     * Stop capturing routines to run onLoad
     *
     * @return boolean
     */
    public function onLoadCaptureEnd()
    {
        $data               = ob_get_clean();
        $this->_captureLock = false;

        $this->addOnLoad($data);
        return true;
    }


     /**
     * Start capturing routines to run onLoad
     *
     * @return boolean
     */
    public function domReadyCaptureStart()
    {
        if ($this->_captureLock) {
            require_once 'Zend/Exception.php';
            throw new Zend_Exception('Cannot nest onLoad captures');
        }

        $this->_captureLock = true;
        return ob_start();
    }

    /**
     * Stop capturing routines to run domReady
     *
     * @return boolean
     */
    public function domReadyCaptureEnd()
    {
        $data               = ob_get_clean();
        $this->_captureLock = false;

        $this->addDomReady($data);
        return true;
    }

	/**
     * Capture arbitrary javascript to include in MooTools script
     *
     * @return boolean
     */
    public function javascriptCaptureStart()
    {
        if ($this->_captureLock) {
            require_once 'Zend/Exception.php';
            throw new Zend_Exception('Cannot nest captures');
        }

        $this->_captureLock = true;
        return ob_start();
    }

    /**
     * Finish capturing arbitrary javascript to include in MooTools script
     *
     * @return boolean
     */
    public function javascriptCaptureEnd()
    {
        $data               = ob_get_clean();
        $this->_captureLock = false;

        $this->addJavascript($data);
        return true;
    }


	/**
	 * Add a Javascript File to the include stack.
	 *
	 * @return ZendX_MooTools_View_Helper_MooTools_Container
	 */
    public function addJavascriptFile($path)
    {
        $path = (string) $path;
        if (!in_array($path, $this->_javascriptSources)) {
            $this->_javascriptSources[] = (string) $path;
        }
        return $this;
    }

	/**
	 * Return all currently registered Javascript files.
	 *
	 * This does not include the MooTools library, which is handled by another retrieval
	 * strategy.
	 *
	 * @return Array
	 */
    public function getJavascriptFiles()
    {
        return $this->_javascriptSources;
    }


	/**
	 * Clear all currently registered Javascript files.
	 *
	 * @return ZendX_MooTools_View_Helper_MooTools_Container
	 */
    public function clearJavascriptFiles()
    {
        $this->_javascriptSources = array();
        return $this;
    }


    /**
     * Add arbitrary javascript to execute in MooTools JS container
     *
     * @param  string $js
	 * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function addJavascript($js)
    {
        $js = preg_replace('/^\s*(.*?)\s*$/s', '$1', $js);
        if (!in_array(substr($js, -1), array(';', '}'))) {
            $js .= ';';
        }

        if (in_array($js, $this->_javascriptStatements)) {
            return $this;
        }

        $this->_javascriptStatements[] = $js;
        return $this;
    }

	/**
     * Return all registered javascript statements
     *
     * @return array
     */
    public function getJavascript()
    {
        return $this->_javascriptStatements;
    }

    /**
     * Clear arbitrary javascript stack
     *
	 * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function clearJavascript()
    {
        $this->_javascriptStatements = array();
        return $this;
    }

/**
     * Add a stylesheet
     *
     * @param  string $path
	 * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function addStylesheet($path)
    {
        $path = (string) $path;
        if (!in_array($path, $this->_stylesheets)) {
            $this->_stylesheets[] = (string) $path;
        }
        return $this;
    }

    /**
     * Retrieve registered stylesheets
     *
     * @return array
     */
    public function getStylesheets()
    {
        return $this->_stylesheets;
    }

   /**
     * Add a script to execute onLoad
     *
     * @param  string $callback Lambda
	 * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function addOnLoad($callback)
    {
        if (!in_array($callback, $this->_onLoadActions, true)) {
            $this->_onLoadActions[] = $callback;
        }
        return $this;
    }

    /**
     * Retrieve all registered onLoad actions
     *
     * @return array
     */
    public function getOnLoadActions()
    {
        return $this->_onLoadActions;
    }


    /**
     * Clear the onLoadActions stack.
     *
     * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function clearOnLoadActions()
    {
        $this->_onLoadActions = array();
        return $this;
    }

   /**
     * Add a script to execute domready
     *
     * @param  string $callback Lambda
	 * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function addDomReady($callback)
    {
        if (!in_array($callback, $this->_domReadyActions, true)) {
            $this->_domReadyActions[] = $callback;
        }
        return $this;
    }

    /**
     * Retrieve all registered domready actions
     *
     * @return array
     */
    public function getDomReadyActions()
    {
        return $this->_domReadyActions;
    }

    /**
     * Clear the domreadyActions stack.
     *
     * @return ZendX_MooTools_View_Helper_MooTools_Container
     */
    public function clearDomReadyActions()
    {
        $this->_domReadyActions = array();
        return $this;
    }


	/**
	 * Set which parts of the MooTools enviroment should be rendered.
	 *
	 * This function allows for a gradual refactoring of the MooTools code
	 * rendered by calling __toString(). Use ZendX_MooTools::RENDER_*
	 * constants. By default all parts of the enviroment are rendered.
	 *
	 * @see    ZendX_MooTools::RENDER_ALL
	 * @param  integer $mask
	 * @return ZendX_MooTools_View_Helper_MooTools_Container
	 */
    public function setRenderMode($mask)
    {
        $this->_renderMode = $mask;
        return $this;
    }

	/**
	 * Return bitmask of the current Render Mode
	 * @return integer
	 */
    public function getRenderMode()
    {
        return $this->_renderMode;
    }

    /**
     * String representation of MooTools environment
     *
     * @return string
     */
    public function __toString()
    {
        if (!$this->isEnabled()) {
            return '';
        }

        $this->_isXhtml = $this->view->doctype()->isXhtml();

        $html  = $this->_renderStylesheets() . PHP_EOL
               . $this->_renderScriptTags() . PHP_EOL
               . $this->_renderExtras();
        return $html;
    }


     /**
     * Render MooTools stylesheets
     *
     * @return string
     */
    protected function _renderStylesheets()
    {
    	if( ($this->getRenderMode() & ZendX_MooTools::RENDER_STYLESHEETS) == 0) {
    		return '';
    	}

        foreach ($this->getStylesheets() as $stylesheet) {
            $stylesheets[] = $stylesheet;
        }

        if (empty($stylesheets)) {
            return '';
        }

        array_reverse($stylesheets);
        $style = "";
        foreach($stylesheets AS $stylesheet) {
            if ($this->view instanceof Zend_View_Abstract) {
                $closingBracket = ($this->view->doctype()->isXhtml()) ? ' />' : '>';
            } else {
                $closingBracket = ' />';
            }

            $style .= '<link rel="stylesheet" href="'.$stylesheet.'" '.
                      'type="text/css" media="screen"' . $closingBracket . PHP_EOL;
        }

        return $style;
    }

 	/**
     * Renders all javascript file related stuff of the MooTools enviroment.
     *
     * @return string
     */
    protected function _renderScriptTags()
    {
    	$scriptTags = '';
    	if( ($this->getRenderMode() & ZendX_MooTools::RENDER_LIBRARY) > 0) {
	        $source = $this->_getMooToolsLibraryPath();

	        $scriptTags .= '<script type="text/javascript" src="' . $source . '"></script>'.PHP_EOL;

	        if($this->mooreIsEnabled()) {
                $moorePath = $this->_getMooToolsMooreLibraryPath();
	        	$scriptTags .= '<script type="text/javascript" src="'.$moorePath.'"></script>'.PHP_EOL;
	        }

	        if(ZendX_MooTools_View_Helper_MooTools::getNoSafeMode() == true) {
	        	$scriptTags .= '<script type="text/javascript">var $ = document.id;</script>'.PHP_EOL;
	        }
    	}

		if( ($this->getRenderMode() & ZendX_MooTools::RENDER_SOURCES) > 0) {
	        foreach($this->getJavascriptFiles() AS $javascriptFile) {
	            $scriptTags .= '<script type="text/javascript" src="' . $javascriptFile . '"></script>'.PHP_EOL;
	        }
		}
        return $scriptTags;
    }


    /**
     * Renders all javascript code related stuff of the MooTools enviroment.
     *
     * @return string
     */
    protected function _renderExtras()
    {
        $onLoadActions = array();
        if( ($this->getRenderMode() & ZendX_MooTools::RENDER_MOOTOOLS_ON_LOAD) > 0) {
	        foreach ($this->getOnLoadActions() as $callbackOnLoad) {
	            $onLoadActions[] = $callbackOnLoad;
	        }
        }


        $domReadyActions = array();
        if( ($this->getRenderMode() & ZendX_MooTools::RENDER_MOOTOOLS_DOM_READY) > 0) {
	        foreach ($this->getDomReadyActions() as $callbackDomReady) {
	            $domReadyActions[] = $callbackDomReady;
	        }
        }


		$javascript = '';
		if( ($this->getRenderMode() & ZendX_MooTools::RENDER_JAVASCRIPT) > 0) {
        	$javascript = implode("\n    ", $this->getJavascript());
		}

        $content = '';

        if (!empty($onLoadActions)) {
            $content .=  'window.addEvent(\'load\', function() {'."\n    ";
            $content .= implode("\n    ", $onLoadActions) . "\n";
            $content .= '});'."\n";
        }


        if (!empty($domReadyActions)) {
            $content .=  'window.addEvent(\'domready\', function() {'."\n    ";
            $content .= implode("\n    ", $domReadyActions) . "\n";
            $content .= '});'."\n";
        }


        if (!empty($javascript)) {
            $content .= $javascript . "\n";
        }

        if (preg_match('/^\s*$/s', $content)) {
            return '';
        }

        $html = '<script type="text/javascript">' . PHP_EOL
              . (($this->_isXhtml) ? '//<![CDATA[' : '//<!--') . PHP_EOL
              . $content
              . (($this->_isXhtml) ? '//]]>' : '//-->') . PHP_EOL
              . PHP_EOL . '</script>';
        return $html;
    }


    /**
     * @return string
     */
    protected function _getMooToolsLibraryBaseCdnUri()
    {
        if($this->_loadSslCdnPath == true) {
            $baseUri = ZendX_MooTools::CDN_BASE_GOOGLE_SSL;
        } else {
            $baseUri = ZendX_MooTools::CDN_BASE_GOOGLE;
        }
        return $baseUri;
    }


    /**
	 * Internal function that constructs the include path of the MooTools library.
	 *
	 * @return string
	 */
    protected function _getMooToolsLibraryPath()
    {
        if($this->_mootolsLibraryPath != null) {
            $source = $this->_mootolsLibraryPath;
        } else {
            $baseUri = $this->_getMooToolsLibraryBaseCdnUri();
            $source = $baseUri .
                ZendX_MooTools::CDN_SUBFOLDER_MOOTOOLS .
                $this->getVersion() .
            	ZendX_MooTools::CDN_MOOTOOLS_PATH_GOOGLE;
        }
        $log = Zend_Registry::get('log');
        $log->info(__METHOD__);

        return $source;
    }

    /**
     * Include path of the MooTools Moore library
     *
     * @return string
     */
    protected function _getMooToolsMooreLibraryPath ()
    {
        if ($this->_mooreLibraryPath != null) {
            $source = $this->_mooreLibraryPath;
        } else {
            trigger_error("Mootools Moore Library Path is no defined", E_USER_NOTICE);
        }

        return $source;
    }

}