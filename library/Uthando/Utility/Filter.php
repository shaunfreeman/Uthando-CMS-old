<?php
/**
 * Filter.php
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
 *
 * @category Uthando
 * @package Uthando_Filter
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of Filter
 *
 * @category Uthando
 * @package Uthando_Filter
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Uthando_Utility_Filter
{
    public static function filter($value)
    {
        $find    = array( '`', '&',   ' ', '"', "'" );
        $replace = array( '',  'and', '-', '',  '', );
        $new = str_replace( $find, $replace,$value);

        $noalpha = 'ÁÉÍÓÚÝáéíóúýÂÊÎÔÛâêîôûÀÈÌÒÙàèìòùÄËÏÖÜäëïöüÿÃãÕõÅåÑñÇç@°ºª';
        $alpha   = 'AEIOUYaeiouyAEIOUaeiouAEIOUaeiouAEIOUaeiouyAaOoAaNnCcaooa';

        $new = substr( $new, 0, 255 );
        $new = strtr( $new, $noalpha, $alpha );

        // not permitted chars are replaced with "-"
        $new = preg_replace( '/[^a-zA-Z0-9_\+]/', '-', $new );

        //remove -----'s
        $new = preg_replace( '/(-+)/', '-', $new );

        return rtrim( $new, '-' );
    }
}

?>
