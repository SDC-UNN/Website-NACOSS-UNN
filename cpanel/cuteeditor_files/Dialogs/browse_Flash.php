<?php
error_reporting(E_ALL ^ E_NOTICE);
	require("Include_Security.php") ;
	header("Expires: " . gmdate("D, d M Y H:i:s", time() + (-1*60)) . " GMT"); 
	$folpath=@$_GET["loc"];
	$goingup=@$_GET["u"];
	$current_Path=@$_GET["FP"];
	
	if (substr($current_Path,strlen($current_Path)-(1))!="/")
		$current_Path=$current_Path."/";
		
	if (substr($FlashGalleryPath,strlen($FlashGalleryPath)-(1))!="/")
		$FlashGalleryPath=$FlashGalleryPath."/";	
	
	if($AbsoluteFlashGalleryPath!="")	
	{
		if (substr($AbsoluteFlashGalleryPath,strlen($AbsoluteFlashGalleryPath)-(1))!="/")
			$AbsoluteFlashGalleryPath=$AbsoluteFlashGalleryPath."/";
	}
		
	if(str_contains($current_Path, $FlashGalleryPath))
	{
	}
	else
	{
			print "The area you are attempting to access is forbidden";
			exit();
	}
	
	if ($folpath!="" && $goingup!="y" && substr($folpath,strlen($folpath)-(1))!="/")
	{
		$folpath=$folpath."/";
	} 
	
	$action=@$_GET["action"];
	
	if ($DemoMode=="true")
	{
		if($action=="deletefile" || $action=="renamefile" ||$action=="renamefolder" ||$action=="deletefolder" ||$action=="createfolder")
		{
			print "<script language=\"javascript\">alert('This function is disabled in the demo mode.');</script>";
			print "<script language=\"javascript\">parent.ResetFields();</script>";
		}
	}
	else
	{
		switch ($action)
		{
			case "deletefile":			
				unlink(ServerMapPath($_GET["filename"],$AbsoluteFlashGalleryPath,$FlashGalleryPath));
				print "<script language=\"javascript\">parent.ResetFields();</script>";
				break;
			case "renamefile":
				rename(ServerMapPath($_GET["filename"],$AbsoluteFlashGalleryPath,$FlashGalleryPath),ServerMapPath($_GET["newname"],$AbsoluteFlashGalleryPath,$FlashGalleryPath));
				print "<script language=\"javascript\">parent.row_click('".$_GET["newname"]."');</script>";
				break;
			case "renamefolder":
				rename(ServerMapPath($_GET["filename"],$AbsoluteFlashGalleryPath,$FlashGalleryPath),ServerMapPath($_GET["newname"],$AbsoluteFlashGalleryPath,$FlashGalleryPath));
				break;
			case "deletefolder":
				rmdir(ServerMapPath($_GET["foldername"],$AbsoluteFlashGalleryPath,$FlashGalleryPath)); 
				break;
			case "createfolder":
				$folderPath=$_GET["foldername"];
				$folderPath=$current_Path.$folpath.$folderPath;
				$folderPath=ServerMapPath($folderPath,$AbsoluteFlashGalleryPath,$FlashGalleryPath);
				if (file_exists($folderPath))
				{
					$exMessage="Unable to create the folder \"".$folderPath."\", there exists a file or a folder with the same name...";
				}
				else
				{
					$result= mkdir($folderPath,0777);
					if(!$result) {
               			$exMessage="Unable to create the folder \"".$folderPath."\", make sure the name you entered is a valid folder name";
					}
					else
					{
						$exMessage="Created the folder \"".$folderPath."\"...";
					} 
				} 
				break;
		} 
	}
	function Showbrowse_Img($spec)
	{
	  extract($GLOBALS);
	  $s="";
    $directory=ServerMapPath($spec,$AbsoluteFlashGalleryPath,$FlashGalleryPath);
    // if the path has a slash at the end we remove it here
    if(substr($directory,-1) == '/')
    {
      $directory = substr($directory,0,-1);
    }

	  $s=$s."<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" valign=\"top\" id=\"FoldersAndFiles\" style=\"width:100%\" class=sortable>";
	  $s=$s."<tr onMouseOver=\"row_over(this)\" onMouseOut=\"row_out(this)\" class='cursor' bgcolor=\"#f0f0f0\">";
$s=$s."<th width=21><img src=\"../Images/refresh.gif\" title=\"refresh\" onclick=\"parent.Refresh('".$folpath."');\" onMouseOver=\"parent.CuteEditor_ColorPicker_ButtonOver(this);\" class=dialogButton></th>";
	  $s=$s."<th width=136 Class=\"filelistHeadCol\"><b>Name</b></th>";
	  $s=$s."<th width=50 Class=\"filelistHeadCol\"><b>Size</b></th>";
	  if ($AllowDelete=="true")
	  {
      $s=$s."<th width=16></th>";
	  } 

	  if ($AllowRename=="true")
	  {
		  $s=$s."<th width=14></th>";
	  }

	  $s=$s."</tr>";
	  $s=$s."<tr onMouseOver=\"row_over(this)\" onMouseOut=\"row_out(this)\" onclick=\"Editor_upfolder();\">";
	  $s=$s."<td><img src=\"../Images/parentfolder.gif\" title=\"Go up one level\" class='cursor'></td>";
	  $s=$s."<td class='cursor'>...</td>";
	  $s=$s."<td></td>";
	  if ($AllowDelete=="true")
	  {
		  $s=$s."<td nowrap></td>";
	  } 
	  if ($AllowRename=="true")
	  {
		  $s=$s."<td nowrap></td>";
	  } 
	  $s=$s."</tr>";
    
    $dirlist = array();
    $filelist = array();
    
    // we open the directory
    if($f = opendir($directory))
    {
		  while (($file = readdir($f)) !== false)
		  {
         if ($file != "." && $file != "..") 
         {
            $path = $directory.'/'.$file;        
            if(is_file($path))            
            {
               $filelist[] = $file;  
            }
            elseif(is_dir($path))
            {
               $dirlist[] = $file;            
            }
          }
		   }
       closedir($f);
    }
    
    if($dirlist)
		{
			asort($dirlist);
			while (list ($key, $file) = each ($dirlist))
			{
        //add the html for the folders
		    $str_openfolderEvent="onclick=\"parent.SetUpload_FolderPath('".$current_Path.$folpath.$file."');location.href='browse_Flash.php?".$setting."&loc=".$folpath.$file."&Theme=".$Theme."&FP=".$current_Path."';\"";
		    $s=$s."<tr onMouseOver=\"row_over(this)\" onMouseOut=\"row_out(this)\" class='cursor'>";
		    $s=$s."<td ".$str_openfolderEvent."><img src=\"../Images/closedfolder.gif\"></td>"."\r\n";
		    $s=$s."<td ".$str_openfolderEvent.">"."\r\n";
		    $s=$s.$file."&nbsp;</td>"."\r\n";
		    $s=$s."<td nowrap ".$str_openfolderEvent."></td>";		  
	      if ($AllowDelete=="true")
		    {
		      $s=$s."<td><img src=\"../Images/delete.gif\" onclick=\"deletefolder('".$current_Path.$folpath.$file."')\" title=\"Delete\"></td>";
		    } 

	      if ($AllowRename=="true")
		    {
		      $s=$s."<td><img src=\"../Images/edit.gif\" title=\"Rename\" onclick=\"renamefolder('".$current_Path.$folpath.$file."')\"></td>";
		    } 
		    $s=$s."</tr>"."\r\n";      
      }
    }    
    if($filelist)
		{
			asort($filelist);
			while (list ($key, $file) = each ($filelist))
			{
			if(ValidImage($file))
			{
            //add the html for the folders
		    $s=$s."<tr onclick=\"parent.row_click('".$current_Path.$folpath.$file."'); \" onMouseOver=\"row_over(this)\" onMouseOut=\"row_out(this)\" class='cursor'>";
		    $s=$s."<td><img src=\"../Images/".GetExtension($file).".gif\" class='cursor'></td>"."\r\n";
		    $s=$s."<td>"."\r\n";
		    $s=$s.$file."&nbsp;</td>"."\r\n";
		    $s=$s."<td nowrap>".FormatSize(filesize($directory.'/'.$file))."</td>";		  
	      	if ($AllowDelete=="true")
		    {
		      $s=$s."<td><img src=\"../Images/delete.gif\" onclick=\"deletefile('".$current_Path.$folpath.$file."')\" title=\"Delete\"></td>";
		    } 

	        if ($AllowRename=="true")
		    {
		      $s=$s."<td><img src=\"../Images/edit.gif\" title=\"Rename\" onclick=\"renamefile('".$current_Path.$folpath.$file."','$file')\"></td>";
		    } 
		    $s=$s."</tr>"."\r\n";      
			}
      }
    }  
  $s=$s."</table>";
  return $s;
} 

function GetExtension($str_FileName)
{
	return strtolower(substr(strrchr($str_FileName, '.'), 1));
}
function ValidImage($str_FileName)
{
	$valid = false;
	$ext = ".".GetExtension($str_FileName);
	if(strcasecmp($ext,".swf")==0||strcasecmp($ext,".flv")==0)
	{
			$valid = true;
	}
	return $valid;
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Browse</title>
	<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
    <script type="text/javascript">
      var folderpath = "browse_Flash.php?<?php echo $setting ; ?>&FP=<?php echo $current_Path ; ?>&Theme=<?php echo $Theme; ?>";

      function Editor_upfolder(path) {
      var arrloc = curloc.split("/");
      str = "";
      for (i=0;i<arrloc.length-2;i++) {
				str += arrloc[i] + "/";
			}
			
			str="browse_Flash.php?<?php echo $setting ; ?>&FP=<?php echo $current_Path ; ?>&Theme=<?php echo $Theme; ?>&loc=" + str + "&u=y";
			location.href = str;
			parent.SetUpload_FolderPath('<?php echo $current_Path ; ?>');
		}
		
		
		function deletefile(path)
		{ 
			if (confirm("Delete File " + path + "?")) {
				self.location.replace(folderpath+"&loc=<?php echo $folpath; ?>&action=deletefile&filename=" + path + "");
			}	
		}
		
		function deletefolder(path)
		{
			if (confirm("Delete Folder " + path + "?")) {
				self.location.replace(folderpath+"&loc=<?php echo $folpath; ?>&action=deletefolder&foldername=" + path + "");
			}	
		}
		function renamefile(path,oldname)
		{	
			var i=oldname.lastIndexOf('.'); 
			var ext=oldname.substr(i);
			var t= oldname.substr(0,oldname.lastIndexOf('.'));
			
			if(parent.Browser_IsIE7())
	        {
		        parent.IEprompt(promptCallback,'Type the new name for this file:', "");		
		        function promptCallback(newName)
		        {				 
	               if ((newName) && (newName!=""))
	               {
	               newName=newName + ext;    		
		                self.location.replace(folderpath+"&loc=<?php echo $folpath; ?>&action=renamefile&filename=" + path + "&newname=<?php echo $current_Path; ?><?php echo $folpath; ?>" + newName + "");
	               }	
		        }
	        }
	        else
	        {
			    var newName=prompt("Type the new name for this file:",t);
    						 
			    if ((newName) && (newName!=""))
			    {
				    newName=newName + ext;
				    self.location.replace(folderpath+"&loc=<?php echo $folpath; ?>&action=renamefile&filename=" + path + "&newname=<?php echo $current_Path; ?><?php echo $folpath; ?>" + newName + "");
			    }
	        }	
		}
		
		
		function renamefolder(path)
		{
		    if(parent.Browser_IsIE7())
	        {
		        parent.IEprompt(promptCallback,'Type the new name for this folder:', "");		
		        function promptCallback(newName)
		        {
			        if ((newName) && (newName!=""))
			        {
				        self.location.replace(folderpath+"&loc=<?php echo $folpath; ?>&action=renamefolder&filename=" + path + "&newname=<?php echo $current_Path; ?><?php echo $folpath; ?>" + newName + "");
			        }	
		        }
	        }
	        else
	        {
			    var newName = prompt('Type the new name for this folder:','');
			    if ((newName) && (newName!=""))
			    {
				    self.location.replace(folderpath+"&loc=<?php echo $folpath; ?>&action=renamefolder&filename=" + path + "&newname=<?php echo $current_Path; ?><?php echo $folpath; ?>" + newName + "");
			    }	
	        }	
		}
		function row_over(row)
		{
			row.style.backgroundColor='#eeeeee';
		}
		function row_out(row)
		{
			row.style.backgroundColor='';
		}
	</script>
	<script type="text/javascript">var curloc = "<?php echo $folpath; ?>";</script>
	<script type="text/javascript" src="sorttable.js"></script>
    <link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
</head>
<body style="overflow:auto;background-color:white">
    <?php 
      echo Showbrowse_Img($current_Path.$folpath);
	  ?>
</body>
</html>