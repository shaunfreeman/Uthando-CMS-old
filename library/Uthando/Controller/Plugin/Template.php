<?php
/*
 * Template.php
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
 * Description of Template
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Uthando_Controller_Plugin_Template extends Zend_Controller_Plugin_Abstract
{
    /**
     * Dispatches site template.
     *
     * @param $request Zend_Controller_Requset object
     * @return none
     * @access public
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $config = Zend_Registry::get('siteConfig');
        $layout = Zend_Layout::getMvcInstance();

        $log = Zend_Registry::get('log');
        $log->info(__METHOD__);

        if ($request->getParam('isAdmin')) {
            if (isset($config->admin->name)) {
                $layout->setLayout('layout')
                       ->setLayoutPath(APPLICATION_PATH . '/../templates/' . $config->admin->name . '/');
                $layoutSet = true;
                $templateName = $config->admin->name;
            }
        } else {
            if (isset($config->template->name)) {
                $layout->setLayout('layout')
                       ->setLayoutPath(APPLICATION_PATH . '/../templates/' . $config->template->name . '/');
                $layoutSet = true;
                $templateName = $config->template->name;
            }
        }

        if ($layoutSet) {
            $template = new Uthando_View_Template($request, $config, $templateName);

            Zend_Registry::set('template', $template);
        }
    }
}
?>
