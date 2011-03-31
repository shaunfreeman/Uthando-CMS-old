<?php
/* 
 * AllErrors.php
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
 * Description of AllErrors
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * This helper can be used with forms or displaygroups
 * to display all child element errors. Supports PREPEND and
 * APPEND positions.
 *
 */
class Uthando_Form_Decorator_AllErrors extends Zend_Form_Decorator_Abstract
{
	public function render($content)
	{
		$element = $this->getElement();
		$view = $element->getView();
		if($view == null)
		    return $content;

		$errors = array();
		foreach($element->getElements() as $el)
			$errors = array_merge($errors, $el->getMessages());

		if(count($errors) == 0)
			return $content;

		$separator = $this->getSeparator();
		$placement = $this->getPlacement();
		$errors = $view->formErrors($errors, $this->getOptions());

		switch ($placement)
		{
			case self::APPEND:
				return $content . $separator . $errors;
			case self::PREPEND:
				return $errors . $separator . $content;
        }
    }
}

?>
