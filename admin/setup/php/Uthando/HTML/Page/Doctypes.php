<?php
$default['default'][0] = 'XHTML 1.0 Transitional';

$default['xhtml'][0] = 'XHTML 1.0 Strict';
$default['xhtml']['1.0'][0] = 'XHTML 1.0 Strict';
$default['xhtml']['basic'][0] = 'XHTML Basic 1.0';

$default['html'][0] = 'HTML 4.01 Strict';
$default['html']['4.01'][0] = 'HTML 4.01 Strict';

// Array of doctype declarations:

// XHTML 1.0 Strict
$doctype['xhtml']['1.0']['strict'][] = 'html';
$doctype['xhtml']['1.0']['strict'][] = '-//W3C//DTD XHTML 1.0 Strict//EN';
$doctype['xhtml']['1.0']['strict'][] = 'http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd';

// XHTML 1.0 Transitional
$doctype['xhtml']['1.0']['transitional'][] = 'html';
$doctype['xhtml']['1.0']['transitional'][] = '-//W3C//DTD XHTML 1.0 Transitional//EN';
$doctype['xhtml']['1.0']['transitional'][] = 'http://www.w3c.org/TR/xhtml1/DTD/xhtml1-transitional.dtd';

// XHTML 1.0 Frameset
$doctype['xhtml']['1.0']['frameset'][] = 'html';
$doctype['xhtml']['1.0']['frameset'][] = '-//W3C//DTD XHTML 1.0 Frameset//EN';
$doctype['xhtml']['1.0']['frameset'][] = 'http://www.w3c.org/TR/xhtml1/DTD/xhtml1-frameset.dtd';

// all ready for this :)
// XHTML 1.1
$doctype['xhtml']['1.1'][] = 'html';
$doctype['xhtml']['1.1'][] = '-//W3C//DTD XHTML 1.1//EN';
$doctype['xhtml']['1.1'][] = 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd';

// XHTML Basic 1.0
$doctype['xhtml']['basic']['1.0'][] = 'html';
$doctype['xhtml']['basic']['1.0'][] = '-//W3C//DTD XHTML Basic 1.0//EN';
$doctype['xhtml']['basic']['1.0'][] = 'http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd';

// XHTML Print 1.0
// from the W3C Candidate Recommendation 20 January 2004
// http://www.w3.org/TR/2004/CR-xhtml-print-20040120 
$doctype['xhtml']['print']['1.0'][] = 'html"';
$doctype['xhtml']['print']['1.0'][] = '-//W3C//DTD XHTML-Print 1.0//EN';
$doctype['xhtml']['print']['1.0'][] = 'http://www.w3.org/MarkUp/DTD/xhtml-print10.dtd';

// XHTML 2.0
// from the W3C Working Draft 6 May 2003
// http://www.w3.org/TR/2003/WD-xhtml2-20030506
$doctype['xhtml']['2.0'][] = 'html';
$doctype['xhtml']['2.0'][] = '-//W3C//DTD XHTML 2.0//EN';
$doctype['xhtml']['2.0'][] = 'TBD';

// HTML 4.01 Strict
$doctype['html']['4.01']['strict'][] = 'HTML';
$doctype['html']['4.01']['strict'][] = '-//W3C//DTD HTML 4.01//EN';
$doctype['html']['4.01']['strict'][] = 'http://www.w3.org/TR/html4/strict.dtd';

// HTML 4.01 Transitional
$doctype['html']['4.01']['transitional'][] = 'HTML';
$doctype['html']['4.01']['transitional'][] = '-//W3C//DTD HTML 4.01 Transitional//EN';
$doctype['html']['4.01']['transitional'][] = 'http://www.w3.org/TR/html4/loose.dtd';

// HTML 4.01 Frameset
$doctype['html']['4.01']['frameset'][] = 'HTML';
$doctype['html']['4.01']['frameset'][] = '-//W3C//DTD HTML 4.01 Frameset//EN';
$doctype['html']['4.01']['frameset'][] = 'http://www.w3.org/TR/html4/frameset.dtd';

// HTML 4.0 Strict
$doctype['html']['4.0']['strict'][] = 'HTML';
$doctype['html']['4.0']['strict'][] = '-//W3C//DTD HTML 4.0//EN';
$doctype['html']['4.0']['strict'][] = 'http://www.w3.org/TR/REC-html40/strict.dtd';

// HTML 4.0 Transitional
$doctype['html']['4.0']['transitional'][] = 'HTML';
$doctype['html']['4.0']['transitional'][] = '-//W3C//DTD HTML 4.0 Transitional//EN';
$doctype['html']['4.0']['transitional'][] = 'http://www.w3.org/TR/REC-html40/loose.dtd';

// HTML 4.0 Frameset
$doctype['html']['4.0']['frameset'][] = 'HTML';
$doctype['html']['4.0']['frameset'][] = '-//W3C//DTD HTML 4.0 Frameset//EN';
$doctype['html']['4.0']['frameset'][] = 'http://www.w3.org/TR/REC-html40/frameset.dtd';
?>