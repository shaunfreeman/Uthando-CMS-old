<?php
/**
 * Version.php
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
 *
 * @category Uthando
 * @package Uthando
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Store and retreives version number
 *
 * @category Uthando
 * @package Uthando
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
final class Uthando_Version
{
	/**
	 * Get current Uthando version
	 *
     * @param none
	 * @return string
     * @access public
	 */
	public static function getVersion()
	{
		return '2.0dev';
	}
}
?>