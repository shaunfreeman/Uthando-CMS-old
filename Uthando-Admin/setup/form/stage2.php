<?php
/*
 * Uthando CMS - Content management system.
 * Copyright (C) 2010  Shaun Freeman
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

$licence = file_get_contents('./licence.php');

$dom = new HTML_Element();

$wrapper = $dom->createElement('div', null, array('id' => 'stage2'));

$fs = $dom->createElement('fieldset');

$fs->appendChild($dom->createElement('legend', 'Stage 2 | Licence'));
$div = $dom->createDocumentFragment($licence, array('id' => 'licence'));

$fs->appendChild($div);
$wrapper->appendChild($fs);

$fs = $dom->createElement('fieldset', null, array('class' => 'formFooters'));
$fs->appendChild($dom->createElement('fieldset', 'I Accept the Licence', array('id' => 'licence_accept', 'class' => 'next')));
$fs->appendChild($dom->createElement('fieldset', 'Previous', array('id' => 'previous', 'class' => 'previous')));
$wrapper->appendChild($fs);

$dom->appendChild($wrapper);

print $dom->toHtml();

?>