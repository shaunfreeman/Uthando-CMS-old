<?php
// no direct access
defined( 'PARENT_FILE' ) or die( 'Restricted access' );

class UShop_Utility
{
	public static function removeSection($message, $type)
	{
		return preg_replace("/<!--".$type."_start-->(.*?)<!--".$type."_end-->/s", "", $message);
	}
	
	public static function returnLink()
	{
		return '<a class="button" href="'.urldecode($_SESSION['http_referer']).'">Continue Shopping</a>';
	}
}

?>