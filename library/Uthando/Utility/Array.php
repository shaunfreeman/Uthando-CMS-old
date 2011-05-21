<?php
/**
 * Array.php
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
 * @package Uthando_Utility
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Utility calss to preform certain array operations.
 *
 * @category Uthando
 * @package Uthando_Utility
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Uthando_Utility_Array
{
    /**
     * Merges arrays together into one. If input array in an Zend_Config object
     * then it converts it to an array and then merges it.
     *
     * @param mixed $array
     * @param mixed $return_array
     * @return array
     * @access public
     * @static
     */
    public static function mergeMultiArray($array, &$return_array = null)
    {
        if (!is_array($return_array)) {
            $return_array = array();
        }

        if ($array instanceof Zend_Config) {
            $array = $array->toArray();
        }

        foreach ($array as $value) {
            if (is_array($value)) {
                self::mergeMultiArray($value, $return_array);
            } else {
                $return_array[] = $value;
            }
        }

        return $return_array;
    }

    /**
     * Turns an array into an object.
     *
     * @param array $array
     * @return stdClass
     * @static
     */
    public static function arrayToObject($array)
    {
        $object = new stdClass();
		if (is_array($array) && count($array) > 0):
			foreach ($array as $name=>$value):
				$name = lcfirst(trim($name));
				if (!empty($name)) $object->$name = $value;
			endforeach;
		endif;
		return $object;
    }

    /**
     * Turns an object into an array.
     *
     * @param object $obj
     * @return array
     * @static
     */
    public static function objectToArray($obj)
    {
        $array = array();
		if (is_object($object)) $array = get_object_vars($object);
		return $array;
    }
}
?>
