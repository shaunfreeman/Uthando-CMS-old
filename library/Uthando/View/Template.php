<?php
/*
 * Template.php
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
 * Description of Template
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Uthando_View_Template
{
    private $_view;
    private $_options;
    private $_templateName;
    private $_navigation;
    private $_request;


    public function __construct($request, $options, $name)
    {
        $this->_request = $request;
        $this->_view = Zend_Controller_Front::getInstance()
                ->getParam('bootstrap')
                ->getResource('view');

        $this->setTemplateName($name);

        $this->_options = $options;

        $this->_setupHeadSection();

        $this->addLogos($this->_options->template->logos);

        $this->initMenus();
    }

    private function _setupHeadSection()
    {
        $this->_view->headTitle($this->_options->site->name);
        $this->_view->headTitle()->setSeparator(' - ');

        $this->_view->headMeta()
            ->appendName('keywords', $this->_options->template->keywords);
        $this->_view->headMeta()
            ->appendName('description', $this->_options->template->description);

        $controllerCss = '/templates/' . $this->getTemplateName() .
                '/css/' . $this->_request->getControllerName() . '.css';

        if (file_exists(APPLICATION_PATH . '/../' . $controllerCss)) {
            $this->_view
                ->headLink()
                ->appendStylesheet($controllerCss);
        }


        foreach (Uthando_Utility_Array::mergeMultiArray($this->_options->template->css) as $value) {
            $this->_view
                 ->headLink()
                 ->appendStylesheet($value);
        }

        /*
        foreach (Uthando_Utility_Array::mergeMultiArray($options->template->js) as $value) {
            $this->_view
                 ->headScript()
                 ->appendFile($value);
        }
        */
    }

    public function addLogos($logos)
    {
        foreach ($logos as $key => $value) {
            $this->_view->$key = $value;
        }
    }

    public function getView()
    {
        return $this->_view;
    }

    public function initMenus()
    {
        $this->setNavigation(new Zend_Config_Xml(APPLICATION_PATH . '/../templates/'
                . $this->getTemplateName()
                . '/menu.xml'));
        return $this;
    }

    public function getNavigation($menu)
    {
        return $this->_navigation[$menu];
    }

    public function setNavigation(Zend_Config $navi)
    {
        foreach ($navi as $menu => $menuItems) {
            $this->_navigation[$menu] = $container = new Zend_Navigation($menuItems);
        }

        return $this;
    }

    public function getTemplateName()
    {
        return $this->_templateName;
    }

    public function setTemplateName($name)
    {
        $this->_templateName = (string) $name;
        return $this;
    }
}
?>
