<?php
if(!isset($_SESSION)) session_start();
error_reporting(E_ALL ^ E_NOTICE);
	$Culture;
	$Culture=trim(@$_GET["UC"]);
	$Theme;
	$ResourceDir;
	$Theme=trim(@$_GET["Theme"]);
  $CESecurity=trim(@$_GET["setting"]);
 	if ($CESecurity=="")
	{
		print "The area you are attempting to access is forbidden";
		exit();
	}    
  if ($CESecurity!=$_SESSION['CESecurity'])
	{
		print "The area you are attempting to access is forbidden";
		exit();
	} 
	  $CESecurity=base64_decode($CESecurity);
      $CESecurityArray=explode("|",$CESecurity);
		$MaxImageSize=$CESecurityArray[0];
		$MaxMediaSize=$CESecurityArray[1];
		$MaxFlashSize=$CESecurityArray[2];
		$MaxDocumentSize=$CESecurityArray[3];
		$MaxTemplateSize=$CESecurityArray[4];
		$ImageGalleryPath=$CESecurityArray[5];
		$MediaGalleryPath=$CESecurityArray[6];
		$FlashGalleryPath=$CESecurityArray[7];
		$TemplateGalleryPath=$CESecurityArray[8];
		$FilesGalleryPath=$CESecurityArray[9];
		$AllowUpload=$CESecurityArray[10];
		$AllowCreateFolder=$CESecurityArray[11];
		$AllowRename=$CESecurityArray[12];
		$AllowDelete=$CESecurityArray[13];
		$ImageFilters=$CESecurityArray[14];
		$MediaFilters=$CESecurityArray[15];
		$DocumentFilters=$CESecurityArray[16];
		$TemplateFilters=$CESecurityArray[17];
		$Culture=$CESecurityArray[18];
		$AbsoluteImageGalleryPath=$CESecurityArray[19];
		$AbsoluteMediaGalleryPath=$CESecurityArray[20];
		$AbsoluteFlashGalleryPath=$CESecurityArray[21];
		$AbsoluteTemplateGalleryPath=$CESecurityArray[22];
		$AbsoluteFilesGalleryPath=$CESecurityArray[23];
		$DemoMode=strtolower($CESecurityArray[24]);

	function GetString($instring)
	{	
		$Culture;
		$Culture=trim($_GET["UC"]);
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
     
	$setting="setting=".trim(@$_GET["setting"]);  
	
	
	function ServerMapPath($input_path,$absolute_path,$virtual_path)
	{
	  if($absolute_path!="")
	  {
		return $absolute_path.str_ireplace($virtual_path,"",$input_path);
	  }
	  else
	  {
		if(strtoupper(substr(PHP_OS, 0, 3) === 'WIN'))
		{    
if(empty($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['SCRIPT_FILENAME'])) { 
	$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
} 
if(empty($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['PATH_TRANSLATED'])) { 
  $_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
}
				return $_SERVER["DOCUMENT_ROOT"].$input_path;
		}
		else
		{
			return ucfirst($_SERVER["DOCUMENT_ROOT"]).$input_path; 
		}
	  }
	}
	
	function GetWebPath($pfile)
	{
		$scriptfile=@$_SERVER['SCRIPT_FILENAME'];
		if(!$scriptfile)$scriptfile=$_SERVER['ORIG_SCRIPT_FILENAME'];


		$ppath=$scriptfile;
		$vpath=$_SERVER['SCRIPT_NAME'];
		
		$ppath=str_replace("\\","/",$ppath);
		$vpath=str_replace("\\","/",$vpath);
		$pfile=str_replace("\\","/",$pfile);
		
		$lfile=strtolower($pfile);
		$lpath=strtolower($ppath);
		
		$l=min(strlen($pfile),strlen($ppath));
		for($i=0;$i<strlen($pfile);$i++)
		{
			if(substr($lfile,$i,1)!=substr($lpath,$i,1))
			{
				$vroot=substr($vpath,0,strlen($vpath)-(strlen($ppath)-$i));
				return $vroot . substr($pfile,$i);
			}
		}
	}
	function str_contains($haystack, $needle, $ignoreCase = false) {
    if ($ignoreCase) {
        $haystack = strtolower($haystack);
        $needle   = strtolower($needle);
    }
    $needlePos = strpos($haystack, $needle);
    return ($needlePos === false ? false : ($needlePos+1));
}

function show_perms( $in_Perms ) {
   $sP = "<b>";
   if($in_Perms & 0x1000) $sP .= 'p';            // FIFO pipe
   elseif($in_Perms & 0x2000) $sP .= 'c';        // Character special
   elseif($in_Perms & 0x4000) $sP .= 'd';        // Directory
   elseif($in_Perms & 0x6000) $sP .= 'b';        // Block special
   elseif($in_Perms & 0x8000) $sP .= '&minus;';    // Regular
   elseif($in_Perms & 0xA000) $sP .= 'l';        // Symbolic Link
   elseif($in_Perms & 0xC000) $sP .= 's';        // Socket
   else $sP .= 'u';                              // UNKNOWN
   $sP .= "</b>";
   // owner - group - others
   $sP .= (($in_Perms & 0x0100) ? 'r' : '&minus;') . (($in_Perms & 0x0080) ? 'w' : '&minus;') . (($in_Perms & 0x0040) ? (($in_Perms & 0x0800) ? 's' : 'x' ) : (($in_Perms & 0x0800) ? 'S' : '&minus;'));
   $sP .= (($in_Perms & 0x0020) ? 'r' : '&minus;') . (($in_Perms & 0x0010) ? 'w' : '&minus;') . (($in_Perms & 0x0008) ? (($in_Perms & 0x0400) ? 's' : 'x' ) : (($in_Perms & 0x0400) ? 'S' : '&minus;'));
   $sP .= (($in_Perms & 0x0004) ? 'r' : '&minus;') . (($in_Perms & 0x0002) ? 'w' : '&minus;') . (($in_Perms & 0x0001) ? (($in_Perms & 0x0200) ? 't' : 'x' ) : (($in_Perms & 0x0200) ? 'T' : '&minus;'));
   return $sP;
}
	// $ResourceDir = getcwd();
   
   $ResourceDir=$_SERVER['PHP_SELF'];
   $ResourceDir=str_replace("Dialogs/InsertFlash.php","",$ResourceDir);
?>