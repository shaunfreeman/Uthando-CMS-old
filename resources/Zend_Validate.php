<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Translate
 * @subpackage Ressource
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id:$
 */

/**
 * EN-Revision: 22668
 */

    // Zend_Validate_Alnum
    _("Invalid type given. String, integer or float expected");
    _("'%value%' contains characters which are non alphabetic and no digits");
    _("'%value%' is an empty string");

    // Zend_Validate_Alpha
    _("Invalid type given. String expected");
    _("'%value%' contains non alphabetic characters");
    _("'%value%' is an empty string");

    // Zend_Validate_Barcode
    _("'%value%' failed checksum validation");
    _("'%value%' contains invalid characters");
    _("'%value%' should have a length of %length% characters");
    _("Invalid type given. String expected");

    // Zend_Validate_Between
    _("'%value%' is not between '%min%' and '%max%', inclusively");
    _("'%value%' is not strictly between '%min%' and '%max%'");

    // Zend_Validate_Callback
    _("'%value%' is not valid");
    _("An exception has been raised within the callback");

    // Zend_Validate_Ccnum
    _("'%value%' must contain between 13 and 19 digits");
    _("Luhn algorithm (mod-10 checksum) failed on '%value%'");

    // Zend_Validate_CreditCard
    _("'%value%' seems to contain an invalid checksum");
    _("'%value%' must contain only digits");
    _("Invalid type given. String expected");
    _("'%value%' contains an invalid amount of digits");
    _("'%value%' is not from an allowed institute");
    _("'%value%' seems to be an invalid creditcard number");
    _("An exception has been raised while validating '%value%'");

    // Zend_Validate_Date
    _("Invalid type given. String, integer, array or Zend_Date expected");
    _("'%value%' does not appear to be a valid date");
    _("'%value%' does not fit the date format '%format%'");

    // Zend_Validate_Db_Abstract
    _("No record matching '%value%' was found");
    _("A record matching '%value%' was found");

    // Zend_Validate_Digits
    _("Invalid type given. String, integer or float expected");
    _("'%value%' must contain only digits");
    _("'%value%' is an empty string");

    // Zend_Validate_EmailAddress
    _("Invalid type given. String expected");
    _("'%value%' is no valid email address in the basic format local-part@hostname");
    _("'%hostname%' is no valid hostname for email address '%value%'");
    _("'%hostname%' does not appear to have a valid MX record for the email address '%value%'");
    _("'%hostname%' is not in a routable network segment. The email address '%value%' should not be resolved from public network");
    _("'%localPart%' can not be matched against dot-atom format");
    _("'%localPart%' can not be matched against quoted-string format");
    _("'%localPart%' is no valid local part for email address '%value%'");
    _("'%value%' exceeds the allowed length");

    // Zend_Validate_File_Count
    _("Too many files, maximum '%max%' are allowed but '%count%' are given");
    _("Too few files, minimum '%min%' are expected but '%count%' are given");

    // Zend_Validate_File_Crc32
    _("File '%value%' does not match the given crc32 hashes");
    _("A crc32 hash could not be evaluated for the given file");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_ExcludeExtension
    _("File '%value%' has a false extension");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_ExcludeMimeType
    _("File '%value%' has a false mimetype of '%type%'");
    _("The mimetype of file '%value%' could not be detected");
    _("File '%value%' is not readable or does not exist");
    // Zend_Validate_File_Exists
    _("File '%value%' does not exist");

    // Zend_Validate_File_Extension
    _("File '%value%' has a false extension");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_FilesSize
    _("All files in sum should have a maximum size of '%max%' but '%size%' were detected");
    _("All files in sum should have a minimum size of '%min%' but '%size%' were detected");
    _("One or more files can not be read");

    // Zend_Validate_File_Hash
    _("File '%value%' does not match the given hashes");
    _("A hash could not be evaluated for the given file");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_ImageSize
    _("Maximum allowed width for image '%value%' should be '%maxwidth%' but '%width%' detected");
    _("Minimum expected width for image '%value%' should be '%minwidth%' but '%width%' detected");
    _("Maximum allowed height for image '%value%' should be '%maxheight%' but '%height%' detected");
    _("Minimum expected height for image '%value%' should be '%minheight%' but '%height%' detected");
    _("The size of image '%value%' could not be detected");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_IsCompressed
    _("File '%value%' is not compressed, '%type%' detected");
    _("The mimetype of file '%value%' could not be detected");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_IsImage
    _("File '%value%' is no image, '%type%' detected");
    _("The mimetype of file '%value%' could not be detected");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_Md5
    _("File '%value%' does not match the given md5 hashes");
    _("A md5 hash could not be evaluated for the given file");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_MimeType
    _("File '%value%' has a false mimetype of '%type%'");
    _("The mimetype of file '%value%' could not be detected");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_NotExists
    _("File '%value%' exists");

    // Zend_Validate_File_Sha1
    _("File '%value%' does not match the given sha1 hashes");
    _("A sha1 hash could not be evaluated for the given file");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_Size
    _("Maximum allowed size for file '%value%' is '%max%' but '%size%' detected");
    _("Minimum expected size for file '%value%' is '%min%' but '%size%' detected");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_File_Upload
    _("File '%value%' exceeds the defined ini size");
    _("File '%value%' exceeds the defined form size");
    _("File '%value%' was only partially uploaded");
    _("File '%value%' was not uploaded");
    _("No temporary directory was found for file '%value%'");
    _("File '%value%' can't be written");
    _("A PHP extension returned an error while uploading the file '%value%'");
    _("File '%value%' was illegally uploaded. This could be a possible attack");
    _("File '%value%' was not found");
    _("Unknown error while uploading file '%value%'");

    // Zend_Validate_File_WordCount
    _("Too much words, maximum '%max%' are allowed but '%count%' were counted");
    _("Too less words, minimum '%min%' are expected but '%count%' were counted");
    _("File '%value%' is not readable or does not exist");

    // Zend_Validate_Float
    _("Invalid type given. String, integer or float expected");
    _("'%value%' does not appear to be a float");

    // Zend_Validate_GreaterThan
    _("'%value%' is not greater than '%min%'");

    // Zend_Validate_Hex
    _("Invalid type given. String expected");
    _("'%value%' has not only hexadecimal digit characters");

    // Zend_Validate_Hostname
    _("Invalid type given. String expected");
    _("'%value%' appears to be an IP address, but IP addresses are not allowed");
    _("'%value%' appears to be a DNS hostname but cannot match TLD against known list");
    _("'%value%' appears to be a DNS hostname but contains a dash in an invalid position");
    _("'%value%' appears to be a DNS hostname but cannot match against hostname schema for TLD '%tld%'");
    _("'%value%' appears to be a DNS hostname but cannot extract TLD part");
    _("'%value%' does not match the expected structure for a DNS hostname");
    _("'%value%' does not appear to be a valid local network name");
    _("'%value%' appears to be a local network name but local network names are not allowed");
    _("'%value%' appears to be a DNS hostname but the given punycode notation cannot be decoded");

    // Zend_Validate_Iban
    _("Unknown country within the IBAN '%value%'");
    _("'%value%' has a false IBAN format");
    _("'%value%' has failed the IBAN check");

    // Zend_Validate_Identical
    _("The two given tokens do not match");
    _("No token was provided to match against");

    // Zend_Validate_InArray
    _("'%value%' was not found in the haystack");

    // Zend_Validate_Int
    _("Invalid type given. String or integer expected");
    _("'%value%' does not appear to be an integer");

    // Zend_Validate_Ip
    _("Invalid type given. String expected");
    _("'%value%' does not appear to be a valid IP address");

    // Zend_Validate_Isbn
    _("Invalid type given. String or integer expected");
    _("'%value%' is no valid ISBN number");

    // Zend_Validate_LessThan
    _("'%value%' is not less than '%max%'");

    // Zend_Validate_NotEmpty
    _("Invalid type given. String, integer, float, boolean or array expected");
    _("Value is required and can't be empty");

    // Zend_Validate_PostCode
    _("Invalid type given. String or integer expected");
    _("'%value%' does not appear to be a postal code");

    // Zend_Validate_Regex
    _("Invalid type given. String, integer or float expected");
    _("'%value%' does not match against pattern '%pattern%'");
    _("There was an internal error while using the pattern '%pattern%'");

    // Zend_Validate_Sitemap_Changefreq
    _("'%value%' is no valid sitemap changefreq");
    _("Invalid type given. String expected");

    // Zend_Validate_Sitemap_Lastmod
    _("'%value%' is no valid sitemap lastmod");
    _("Invalid type given. String expected");

    // Zend_Validate_Sitemap_Loc
    _("'%value%' is no valid sitemap location");
    _("Invalid type given. String expected");

    // Zend_Validate_Sitemap_Priority
    _("'%value%' is no valid sitemap priority");
    _("Invalid type given. Numeric string, integer or float expected");
    // Zend_Validate_StringLength
    _("Invalid type given. String expected");
    _("'%value%' is less than %min% characters long");
    _("'%value%' is more than %max% characters long");

