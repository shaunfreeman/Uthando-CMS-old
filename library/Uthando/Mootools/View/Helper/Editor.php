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
 * Description of Uthando_Mootools_View_Helper_Editor
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Uthando_Mootools_View_Helper_Editor extends Zend_View_Helper_Abstract
{
    public function editor($config)
    {
        $log = Zend_Registry::get('log');
        $log->info(__METHOD__);

        $editorScript = "
        window.addEvent('domready', function(){
            $('comment').mooEditable({
                actions: 'bold italic underline strikethrough | formatBlock justifyleft justifyright justifycenter justifyfull | insertunorderedlist insertorderedlist indent outdent | undo redo | createlink unlink | toggleview',
                dimensions: {
                    x:600,
                    y:300
                }
            });
        });
        " . PHP_EOL;

        $this->view->headLink()
                ->appendStylesheet('/uthando-js/MooTools/mooeditable/Assets/MooEditable/MooEditable.css');

        $this->view->headScript()
                ->appendFile('/uthando-js/MooTools/mooeditable/Source/MooEditable/MooEditable.js')
                ->appendScript($editorScript);
    }
}

?>
