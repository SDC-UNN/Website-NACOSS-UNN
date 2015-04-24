<?php 
  error_reporting (E_ALL ^ E_NOTICE);
	require("Include_Security.php") ;
	require("Include_Mimetype.php") ;
	
	$filepath=@$_GET["FP"];
	
	if (substr($filepath,strlen($filepath)-(1))!="/")
	{
		$filepath=$filepath."/";
	} 
	
  if(@$_FILES["file"]["size"] > 0 )
  {
	  $filetype=@$_GET["Type"];
	  $contentType=$_FILES["file"]["type"];
	  $filesize=$_FILES["file"]["size"];
  
	  $filename=$_FILES["file"]["name"];
    
    $filemimetype=FindType(GetExtension($filename));
    $filemimetype2=FindType2(GetExtension($filename));
    // echo $filemimetype;
    
    $C_MaxSize;
    $C_Path;
    $C_AbsolutePath;
    switch (strtolower($filetype))
    {
      case "image":
        $C_MaxSize=$MaxImageSize;
			$Filter_Array=explode(",",strtolower($ImageFilters));			
			$C_Path=$ImageGalleryPath;
			$C_AbsolutePath=$AbsoluteImageGalleryPath;
        break;
      case "flash":
        $C_MaxSize=$MaxFlashSize;
		    $Filter_Array=array(".swf",".flv");		
			$C_Path=$FlashGalleryPath;
			$C_AbsolutePath=$AbsoluteFlashGalleryPath;
        break;
      case "media":
        $C_MaxSize=$MaxMediaSize;
		    $Filter_Array=explode(",",strtolower($MediaFilters));
			$C_Path=$MediaGalleryPath;
			$C_AbsolutePath=$AbsoluteMediaGalleryPath;
        break;
      case "template":
        $C_MaxSize=$MaxTemplateSize;
		    $Filter_Array=explode(",",strtolower($TemplateFilters));
			$C_Path=$TemplateGalleryPath;
			$C_AbsolutePath=$AbsoluteTemplateGalleryPath;
        break;
      case "document":
        $C_MaxSize=$MaxDocumentSize;
		    $Filter_Array=explode(",",strtolower($DocumentFilters));
			$C_Path=$FilesGalleryPath;
			$C_AbsolutePath=$AbsoluteFilesGalleryPath;
        break;
      default:
        break;
    }     
    
	$C_AbsolutePath=ServerMapPath($filepath,$C_AbsolutePath,$C_Path);
	
	if (substr($C_Path,strlen($C_Path)-(1))!="/")
		$C_Path=$C_Path."/";
		
	if(str_contains($filepath, $C_Path))
	{
	}
	else
	{
		print "The area you are attempting to access is forbidden";
		exit();
	}
	
    
    $Is_valid=false;
    $contentType=upload_translate_datatype($contentType);
    if (in_array(strtolower(GetExtension($filename)),$Filter_Array))
    {
        if(strnatcasecmp(trim($contentType),trim($filemimetype))==0)
        {         
          $Is_valid=true;
        }
        else
        {
			echo "&nbsp;<span style='font-family: MS Sans Serif; font-size: 9pt; color:red'><b>File format not allowed! Please contact site administrator. </b></span><br><br>";
			echo "<span><a style=\"font-family: MS Sans Serif; font-size: 9pt; vertical-align: top;\" href=\"upload.php?". $setting ."&FP=". $_GET["FP"] ."&Type=". $_GET["Type"]. "\">Upload a new file</a></span>";
			return;
        }
          
    }
    else
    {
      echo "<span style='font-family: MS Sans Serif; font-size: 9pt; color:red'><b>File format not allowed! Please contact site administrator. </b></span><br><br>";
      echo "<span><a style=\"font-family: MS Sans Serif; font-size: 9pt; vertical-align: top;\" href=\"upload.php?". $setting ."&FP=". $_GET["FP"] ."&Type=". $_GET["Type"]. "\">Upload a new file</a></span>";
      return;    
    }
    
    $C_MaxSize=GetMaxSize($C_MaxSize);
    
    if ($filesize > $C_MaxSize*1024)
    {      
      echo "<span style='font-family: MS Sans Serif; font-size: 9pt; color:red'><b>File size (". FormatSize($filesize).") exceeds the maximum size allowed. </b></span><br><br>";
      echo "<span><a style=\"font-family: MS Sans Serif; font-size: 9pt; vertical-align: top;\" href=\"upload.php?". $setting ."&FP=". $_GET["FP"] ."&Type=". $_GET["Type"]. "\">Upload a new file</a></span>";
      return;
    }
    
    $f_basename = basename( $_FILES['file']['name']);    
    
    $f_basename = preg_replace("/[^a-zA-Z0-9s.]/", "_", $f_basename);
    
    if(move_uploaded_file($_FILES['file']['tmp_name'], $C_AbsolutePath. $f_basename)) 
    {
	  chmod($C_AbsolutePath. $f_basename, 0644);
      echo "The file ". $f_basename . " has been uploaded successfully! <br>";
      echo "File size: ". FormatSize( $filesize) .".";
      echo "<script language=javascript>parent.UploadSaved('" . $filepath . $f_basename . "','". $filepath ."');</script>";		
    } 
    else {
      echo "Sorry, there was a problem uploading your file.";
    }
  }  
  else
  {
    if (@$_FILES["file"]["error"] > 0)
    {        
      switch ($_FILES["file"]["error"])
      {
        case 1:
          echo "Error: " . $_FILES["file"]["error"] . "<br />";
          break;
        case 2:
          echo "Error: " . $_FILES["file"]["error"] . "<br />";
          break;
        case 3:
          echo "Error: " . $_FILES["file"]["error"] . "<br />";
          break;
        case 4:
          echo "No file was uploaded. <br>";
          break;
        default:
          echo "Error: " . $_FILES["file"]["error"] . "<br />";
          break;
      } 
     }
     else
     {      
      $maxsize = ini_get('upload_max_filesize');
      $maxsize=GetMaxSize($maxsize);
      echo "File is not uploaded. Server rejected file. <br>";
      echo "The uploaded file exceeds the server upload file limitation: " . FormatSize($maxsize);
     }
  }
  
  
  function FormatSize ($size) {

    // Setup some common file size measurements.
    $kb = 1024;         // Kilobyte
    $mb = 1024 * $kb;   // Megabyte
    $gb = 1024 * $mb;   // Gigabyte
    $tb = 1024 * $gb;   // Terabyte
    
    /* If it's less than a kb we just return the size, otherwise we keep going until
    the size is in the appropriate measurement range. */
    if($size < $kb) {
        return $size." B";
    }
    else if($size < $mb) {
        return round($size/$kb,2)." KB";
    }
    else if($size < $gb) {
        return round($size/$mb,2)." MB";
    }
    else if($size < $tb) {
        return round($size/$gb,2)." GB";
    }
    else {
        return round($size/$tb,2)." TB";
    }
}	
?> 

<html>
<head>
    <title>Upload</title>
	<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
</head>
<body>
	<div style="vertical-align:top">
		<a href="upload.php?<?php echo $setting; ?>&FP=<?php echo $_GET["FP"]; ?>&Theme=<?php echo $Theme; ?>&Type=<?php echo $_GET["Type"]; ?>">Upload a new file</a>
	</div>
</body>
</html> 