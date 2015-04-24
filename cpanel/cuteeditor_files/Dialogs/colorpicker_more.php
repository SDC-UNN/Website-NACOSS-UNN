<?php
	error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
	$Theme="Office2007";
	
	$HTTP_USER_AGENT ;

	if ( isset( $HTTP_USER_AGENT ) )
		$sAgent = $HTTP_USER_AGENT ;
	else
		$sAgent = $_SERVER['HTTP_USER_AGENT'] ;
		
	if ( strpos($sAgent, 'MSIE') !== false && strpos($sAgent, 'mac') == false && strpos($sAgent, 'Opera') == false )
	{
		require "colorpicker_more_ie.php";
	}
	else
	{
		require "colorpicker_more_ns.php";	
	}
?>