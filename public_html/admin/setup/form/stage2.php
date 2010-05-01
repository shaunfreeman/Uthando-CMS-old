<?php
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