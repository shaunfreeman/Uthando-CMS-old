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
 * @package     ZendX_MooToolos
 * @subpackage  View
 * @copyright   Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license     http://framework.zend.com/license/new-bsd     New BSD License
 * @version     $Id: MooTools.php
 */

/**
 * @see ZendX_MooTools
 */
require_once "ZendX/MooTools.php";

/**
 * @see Zend_Registry
 */
require_once 'Zend/Registry.php';

/**
 * @see Zend_View_Helper_Abstract
 */
require_once 'Zend/View/Helper/Abstract.php';


/**
 * @see ZendX_MooTools_View_Helper_MooTools_Container
 */
require_once "ZendX/MooTools/View/Helper/MooTools/Container.php";

/**
 * MooTools Helper. Functions as a stack for code and loads all MooTools dependencies.
 *
 * @uses 	   Zend_Json
 * @package    ZendX_MooTools
 * @subpackage View
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class ZendX_MooTools_View_Helper_MooTools extends Zend_View_Helper_Abstract
{
    /**
     * @var Zend_View_Interface
     */
    public $view;
    
    /**
	 * MooTools Safe Mode
	 * Available only in version 1.2.3 or higher of MooTools
	 *
	 * @see	      http://mootools.net/blog/2009/06/22/the-dollar-safe-mode/
	 * @staticvar Boolean Status of safe Mode
	 */
    private static $noSafeMode = false;

	/**
     * Initialize helper
     *
     * Retrieve container from registry or create new container and store in
     * registry.
     *
     * @return void
     */
    public function __construct()
    {
        $registry = Zend_Registry::getInstance();
        if (!isset($registry[__CLASS__])) {
            require_once 'ZendX/MooTools/View/Helper/MooTools/Container.php';
            $container = new ZendX_MooTools_View_Helper_MooTools_Container();
            $registry[__CLASS__] = $container;
        }
        $this->_container = $registry[__CLASS__];
    }

	/**
	 * Return jQuery View Helper class, to execute jQuery library related functions.
	 *
	 * @return ZendX_MooTools_View_Helper_MooTools_Container
	 */
    public function mooTools()
    {
        return $this->_container;
    }

    /**
     * Set view object
     *
     * @param  Zend_View_Interface $view
     * @return void
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
        $this->_container->setView($view);
    }

	/**
	 * Enable the MooTools internal safe Mode to work with
	 * other Javascript libraries. Will setup MooTools in the variable
	 * document.id instead of $ to overcome conflicts.
	 *
	 * @link http://mootools.net/blog/2009/06/22/the-dollar-safe-mode/
	 */
    public static function enableNoSafeMode()
    {
    	self::$noSafeMode = true;
    }

	/**
	 * Disable safe Mode of MooTools if this was previously enabled.
	 *
	 * @return void
	 */
    public static function disableNoSafeMode()
    {
    	self::$noSafeMode = false;
    }

	/**
	 * Return current status of the MooTools no Conflict Mode
	 *
	 * @return Boolean
	 */
    public static function getNoSafeMode()
    {
    	return self::$noSafeMode;
    }

    /**
     * Return current MooTools handler based on safe Mode settings.
     *
     * @return String
     */
    public static function getMooToolsHandler()
    {
        return ((self::getNoSafeMode()==true)?'document.id':'$');
    }
}