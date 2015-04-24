<?php
error_reporting(E_ALL ^ E_NOTICE);

	$Culture;
	$Culture=trim(@$_GET["UC"]);
	$Theme;
	$Domain;
	$Theme=trim(@$_GET["Theme"]);
	
	function GetString($instring)
	{	
		$Culture=trim(@$_GET["UC"]);
		$t=GetStringByCulture($instring,$Culture);
		if ($t=="")
		{
			$t=GetStringByCulture($instring,"default");
		} 
		if ($t=="")
		{
			$t="{".$instring."}";
		} 
		return $t;
	}
    function GetStringByCulture($instring,$input_culture)
	{
		$xml;	
		$item;
    if($input_culture=="")
    {
      $input_culture="en-en";
    }
		$xml=simplexml_load_file( "../Languages/".$input_culture.".xml" );
		if ($xml == false) {
			echo "Failed to load the language text from the XML file: ../Languages/".$input_culture.".xml";
			exit;
		}
		$item=$xml->xpath('//resources/resource[@name="'.$instring.'"]');
		return $item[0];   
	
	} 
	
	function CuteEditor_Decode($input_str)
	{
		$input_str=str_replace("#1","<",$input_str);
		$input_str=str_replace("#2",">",$input_str);
		$input_str=str_replace("#3","&",$input_str);
		$input_str=str_replace("#4","*",$input_str);
		$input_str=str_replace("#5","o",$input_str);
		$input_str=str_replace("#6","O",$input_str);
		$input_str=str_replace("#7","s",$input_str);
		$input_str=str_replace("#8","S",$input_str);
		$input_str=str_replace("#9","e",$input_str);
		$input_str=str_replace("#a","E",$input_str);
		$input_str=str_replace("#0","#",$input_str);
		return $input_str;
	}   
	$ResourceDir = getcwd();
?>