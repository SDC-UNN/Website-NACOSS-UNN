<?php
if(@$_GET["loadlic"]=="1")
{
	$scriptfile=@$_SERVER['SCRIPT_FILENAME'];
	if(!$scriptfile)$scriptfile=$_SERVER['ORIG_SCRIPT_FILENAME'];

	header("Content-Type: application/oct-stream"); 
	$licensefile=dirname($scriptfile)."/../license/phphtmledit.lic";
	$size=filesize($licensefile);
	$handle=fopen($licensefile,"r");
	$data=fread($handle,$size);
	fclose($handle);
	echo(bin2hex($data));
	exit(200);
}
require("phpuploader/include_phpuploader.php") ;
error_reporting(E_ALL ^ E_NOTICE);
require("Include_Security.php") ;
require("Include_Mimetype.php") ;
?>
<html>
	<head>		
		<title>Upload Page</title>		
		<link href="../Themes/Office2007/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
	</head>
	<body>
    <?php    
      $FilePath="";
      $file_Type="";
      if (@$_GET["Type"]!="")
      {
        $file_Type=strtolower(trim($_GET["Type"]));
      }
      
      if ($file_Type!="" && @$_GET["Type"]!="FP")
      {
        $FilePath=trim($_GET["FP"]);
      }
      
      
	      
		$C_MaxSize;
		$C_Path;
		$C_AbsolutePath;
		switch (strtolower($file_Type))
		{
			case "image":
				$C_MaxSize=$MaxImageSize;
				$Filter_Array=explode(",",strtolower($ImageFilters));			
				$C_Path=$ImageGalleryPath;
				$C_AbsolutePath=$AbsoluteImageGalleryPath;
				$Filter=$ImageFilters;
				break;
			case "flash":
				$C_MaxSize=$MaxFlashSize;
				$Filter_Array=array(".swf",".flv");		
				$C_Path=$FlashGalleryPath;
				$C_AbsolutePath=$AbsoluteFlashGalleryPath;
				$Filter=".swf,.flv";
				break;
			case "media":
				$C_MaxSize=$MaxMediaSize;
				$Filter_Array=explode(",",strtolower($MediaFilters));
				$C_Path=$MediaGalleryPath;
				$C_AbsolutePath=$AbsoluteMediaGalleryPath;
				$Filter=$MediaFilters;
				break;
			case "template":
				$C_MaxSize=$MaxTemplateSize;
				$Filter_Array=explode(",",strtolower($TemplateFilters));
				$C_Path=$TemplateGalleryPath;
				$C_AbsolutePath=$AbsoluteTemplateGalleryPath;
				$Filter=$TemplateFilters;
				break;
			case "document":
				$C_MaxSize=$MaxDocumentSize;
				$Filter_Array=explode(",",strtolower($DocumentFilters));
				$C_Path=$FilesGalleryPath;
				$C_AbsolutePath=$AbsoluteFilesGalleryPath;
				$Filter=$DocumentFilters;
				break;
			default:
				break;
		}
	    
		$C_AbsolutePath=ServerMapPath($filepath,$C_AbsolutePath,$C_Path);
		
		if (substr($C_Path,strlen($C_Path)-(1))!="/")
			$C_Path=$C_Path."/";

		$C_MaxSize=GetMaxSize($C_MaxSize);
    ?>
    
	<form action="upload_handler.php?<?php echo $setting; ?>&Theme=<?php echo $Theme; ?>&FP=<?php echo $FilePath; ?>&Type=<?php echo $file_Type; ?>" enctype="multipart/form-data" method="post">
			<?php
			$uploader=new PhpUploader();
			$uploader->Name="UploadControl";
			$uploader->MultipleFilesUpload=true;
			$uploader->LicenseUrl="upload.php?loadlic=1";
			if($Filter)
				$uploader->AllowedFileExtensions=str_replace(".","",$Filter);
			if($C_MaxSize)
				$uploader->MaxSizeKB=$C_MaxSize;
			$uploader->Render();
			?>
		</form>
	</body>
</html>
