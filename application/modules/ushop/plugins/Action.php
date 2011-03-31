<?php
/* 
 * Action.php
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
 * Description of Action
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Ushop_Plugin_Action extends Zend_Controller_Plugin_Abstract
{
    protected $_stack;

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $stack = $this->getStack();

        // category menu.
        $categoryRequest = new Zend_Controller_Request_Simple();
        $categoryRequest->setControllerName('category')
                        ->setActionName('index')
                        ->setParam('responseSegment', 'CategoryMain');

        // Push requests into the stack.
        $stack->pushStack($categoryRequest);
    }

    public function getStack()
    {
        if (null === $this->_stack) {
            $front = Zend_Controller_Front::getInstance();

            if (!$front->hasPlugin('Zend_Controller_Plugin_ActionStack')) {
                $stack = new Zend_Controller_Plugin_ActionStack();
                $front->registerPlugin('ActionStack');
            } else {
                $stack = $front->getPlugin('ActionStack');
            }

            $this->_stack = $stack;
        }

        return $this->_stack;
    }
}
?>
