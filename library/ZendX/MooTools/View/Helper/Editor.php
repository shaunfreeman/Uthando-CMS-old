<?php

/*
 * Editor.php
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
 * Description of ZendX_MooTools_View_Helper_Editor
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendX_MooTools_View_Helper_Editor extends ZendX_MooTools_View_Helper_MooTools
{
    protected $_plugins = array(
        'Charmap' => null,
        'CleanPaste' => array('More/Class.Refactor'),
        'Extras' => array('MooEditable.UI.MenuList'),
        'Flash' => null,
        'Forecolor' => array('MooEditable.UI.ButtonOverlay'),
        'Group' => null,
        'Image' => null,
        'Pagebreak' => null,
        'Smiley' => array('MooEditable.UI.ButtonOverlay'),
        'Table' => null,
        'UI.ButtonOverlay' => null,
        'UI.ExtendedLinksDialog' => array('More/URI'),
        'UI.MenuList' => null
    );

    public function editor($name, $plugins = null, $domReady = array())
    {
        if (!is_array($plugins)) {
            $plugins = array();
        }

        $this->mooTools()->addJavascriptFile(
                $this->mooTools()
                ->getPluginsPath()
                . '/' . $name
                . '/' . $name . '.js'
        );

        $this->mooTools()->addStylesheet(
                $this->mooTools()
                ->getPluginsPath()
                . '/Styles/' . $name
                . '/' . $name . '.css'
        );

        foreach ($plugins as $plugin) {

            $depentants = $this->_plugins[$plugin];

            foreach ($depentants as $dep) {
                $this->mooTools()->addJavascriptFile(
                    $this->mooTools()
                    ->getPluginsPath()
                    . '/' . $name
                    . '/' . $dep . '.js'
                );
            }

            $this->mooTools()->addJavascriptFile(
                $this->mooTools()
                ->getPluginsPath()
                . '/' . $name
                . '/' . $name . '.' . $plugin . '.js'
            );

            $this->mooTools()->addStylesheet(
                    $this->mooTools()
                    ->getPluginsPath()
                    . '/Styles/' . $name
                    . '/' . $name . '.' . $plugin . '.css'
            );
        }

        $this->mooTools()->addDomReady($this->build($domReady));
    }

    public function build($js)
    {
        $returnJs = "\t";

        $returnJs .= "$('".$js['element']."')";
        $returnJs .= ".mooEditable({".PHP_EOL;

        foreach ($js['options'] as $key => $option) {
            $returnJs .= "\t\t".$key.":".$option.",".PHP_EOL;
        }

        $returnJs = substr($returnJs, 0, -2).PHP_EOL;

        $returnJs .= "\t});".PHP_EOL;

        return $returnJs;
    }
}

?>
