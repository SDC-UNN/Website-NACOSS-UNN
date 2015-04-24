<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_Security.php") ;
?>
<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>

<script type="text/javascript">	
			var tipbgcolor='lightyellow'  //tooltip bgcolor
			var disappeardelay=250  //tooltip disappear speed onMouseout (in miliseconds)
			var vertical_offset="0px" //horizontal offset of tooltip from anchor link
			var horizontal_offset="-3px" //horizontal offset of tooltip from anchor link

			/////No further editting needed

			var ie4=document.all
			var ns6=document.getElementById&&!document.all

			if (ie4||ns6)
			document.write('<div id="tooltipdiv" style="visibility:hidden;background-color:'+tipbgcolor+'" ></div>')

			function getposOffset(what, offsettype){
			var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
			var parentEl=what.offsetParent;
			while (parentEl!=null){
			totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
			parentEl=parentEl.offsetParent;
			}
			return totaloffset;
			}


			function showhide(obj, e, visible, hidden){
			if (ie4||ns6)
			dropmenuobj.style.left=dropmenuobj.style.top=-500;
			if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
			obj.visibility=visible
			else if (e.type=="click")
			obj.visibility=hidden
			}

			function iecompattest(){
			return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
			}

			function clearbrowseredge(obj, whichedge){
			var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1
			if (whichedge=="rightedge"){
			var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
			dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
			if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
			edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
			}
			else{
			var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
			dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
			if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure)
			edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
			}
			return edgeoffset
			}

			function showTooltip(menucontents, obj, e){
			if (window.event) 
				event.cancelBubble=true
			else 
				if (e.stopPropagation) e.stopPropagation()
					clearhidetip()
			dropmenuobj=document.getElementById? document.getElementById("tooltipdiv") : tooltipdiv
			dropmenuobj.innerHTML=menucontents

			if (ie4||ns6){
				showhide(dropmenuobj.style, e, "visible", "hidden")
				dropmenuobj.x=getposOffset(obj, "left")
				dropmenuobj.y=getposOffset(obj, "top")
				dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
				dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"
				}
			}

			function hidetip(e){
			if (typeof dropmenuobj!="undefined"){
			if (ie4||ns6)
				dropmenuobj.style.visibility="hidden"
			}
			}

			function delayhidetip(){
			if (ie4||ns6)
			delayhide=setTimeout("hidetip()",disappeardelay)
			}

			function clearhidetip(){
				if (typeof delayhide!="undefined")
					clearTimeout(delayhide)
			}	
</script>
<?php
	define('TABLE_COLS', 5);		# number or images displayed per row
	define('TABLE_ROWS', 4);		# maximum number of rows to display
	$folpath=@$_GET["loc"];
	$goingup=@$_GET["u"];
	$current_Path=@$_GET["GP"];
	
	if (substr($current_Path,strlen($current_Path)-(1))!="/")
		$current_Path=$current_Path."/"; 
	if (substr($ImageGalleryPath,strlen($ImageGalleryPath)-(1))!="/")
		$ImageGalleryPath=$ImageGalleryPath."/";
	
	if($AbsoluteImageGalleryPath!="")	
	{
		if (substr($AbsoluteImageGalleryPath,strlen($AbsoluteImageGalleryPath)-(1))!="/")
			$AbsoluteImageGalleryPath=$AbsoluteImageGalleryPath."/";
	}
		
	if(str_contains($current_Path, $ImageGalleryPath))
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
	switch ($action)
	{
		case "deletefile":
			unlink(ServerMapPath($_GET["filename"],$AbsoluteImageGalleryPath,$ImageGalleryPath));
			print "<script language=\"javascript\">parent.ResetFields();</script>";
			break;
		case "renamefile":
			rename(ServerMapPath($_GET["filename"],$AbsoluteImageGalleryPath,$ImageGalleryPath),ServerMapPath($_GET["newname"],$AbsoluteImageGalleryPath,$ImageGalleryPath));
			print "<script language=\"javascript\">parent.row_click('".$_GET["newname"]."');</script>";
			break;
		case "renamefolder":
			rename(ServerMapPath($_GET["filename"],$AbsoluteImageGalleryPath,$ImageGalleryPath),ServerMapPath($_GET["newname"],$AbsoluteImageGalleryPath,$ImageGalleryPath));
			break;
		case "deletefolder":
			rmdir(ServerMapPath($_GET["foldername"],$AbsoluteImageGalleryPath,$ImageGalleryPath)); 
			break;
		case "createfolder":
			$folderPath=$_GET["foldername"];
			$folderPath=$current_Path.$folpath.$folderPath;
			$folderPath=ServerMapPath($folderPath,$AbsoluteImageGalleryPath,$ImageGalleryPath);
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
	function Showbrowse_Img($spec)
	{
	  extract($GLOBALS);
	  $s="";
	  $directory=ServerMapPath($spec,$AbsoluteImageGalleryPath,$ImageGalleryPath);	  
		// if the path has a slash at the end we remove it here
		if(substr($directory,-1) == '/')
		{
		  $directory = substr($directory,0,-1);
		}

    $dirlist = array();
    $imglist = array();
    
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
              if(ValidImage($file))
                $imglist[] = $file;  
            }
            elseif(is_dir($path))
            {
                $dirlist[] = $file;            
            }
          }
		   }
       closedir($f);
    }
    
	$s=$s."<div style='overflow: auto; height: 120px;'>";		
	$s=$s."<table border='0' cellspacing='0' cellpadding='1' width='100%' align='center' style='vertical-align:middle'>";
	$s=$s."<tr onMouseOver='row_over(this)' onMouseOut='row_out(this)' onclick='Editor_upfolder();'>";
	$s=$s."<td style='text-align:right;padding-right:10px;'><img src='../Images/parentfolder.gif' title='Go up one level' class='cursor'></td>";
	$s=$s."</tr>";
	   
    if($dirlist)
	  {
		  asort($dirlist);
		  while (list ($key, $file) = each ($dirlist))
		  {
			  //add the html for the folders
		    $str_openfolderEvent="onclick=\"parent.SetUpload_imagePath('".$current_Path.$folpath.$file."');location.href='browse_Img_gallery.php?".$setting."&loc=".$folpath.$file."&Theme=".$Theme."&GP=".$current_Path."';\"";
		    $s=$s."<tr class='cursor'>";
		    $s=$s."<td ".$str_openfolderEvent."><img src=\"../Images/closedfolder.gif\">&nbsp;"."\r\n";
		    $s=$s.$file."&nbsp;</td>"."\r\n";
		    $s=$s."<td nowrap ".$str_openfolderEvent."></td>";	
		    $s=$s."</tr>"."\r\n";      
		  }
    }
	
	$s=$s."</table></div>";
    
    $imgcnt = sizeof($imglist);
    $max_per_page = TABLE_COLS * TABLE_ROWS;
      
    $currpage   = (isset($_GET['page']))     
	  ? (int) $_GET['page'] 
	  : 1;
    
    // set index of page's first image in image list array
	  $first_image_index = ($currpage - 1) * $max_per_page;

	  // set index of page's last image in image list array 
	  $last_image_index = ($imgcnt < $currpage * $max_per_page)
		  ? $last_image_index = $imgcnt
		  : $currpage * $max_per_page;  	
	  
	  $s=$s."<div style='HEIGHT: 280px;'><table width='100%' CellSpacing='0' valign='top'>";   

	  // loop control var
	  $column_cnt  = 1;
  	
	  // loop through current page images
	  for ($i = $first_image_index; $i < $last_image_index; $i++) {
		  # build path to thumb
		  $thumburl  = $current_Path.$folpath.$imglist[$i];
          
     
      $absoluteThumburl=ServerMapPath($thumburl,$AbsoluteImageGalleryPath,$ImageGalleryPath);
      
  //    echo $absoluteThumburl . "<br><br>";
   //   echo $AbsoluteImageGalleryPath . "<br><br>";
   //   echo $ImageGalleryPath . "<br><br>";
      
      $size = getimagesize($absoluteThumburl);

     if ($size !== false) {
       $height = $size[1];
       $width = $size[0];
       
       if ($width > 80)
       {
           $width = 80;
           $percent = ($size[0] / $width);
           $height = (int)($size[1] / $percent);
       }
       
	     if ($height > 64)
       {
            $height = 64;
            $percent = ($size[1] / $height);
            $width = (int)($size[0] / $percent);
       }
     }
     else
     {
      $height = 64;
      $width = 80;
     }
     
     $p;
      
      if (!(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')){
        $p = show_perms(fileperms($absoluteThumburl));
      }
      else 
      {
        $p = base_convert(fileperms($absoluteThumburl),10,8);
        $p = substr($p,strlen($p)-3);
      }
      
      $file_stat = stat($absoluteThumburl);
      $filesize = FormatSize($file_stat[7]);
      $lastmod = date("m/d/Y",$file_stat[10]);
        
      $f_Tooltip="";
      $f_Tooltip=$f_Tooltip."<nobr>Name: ".$imglist[$i]."</nobr><br>";
      $f_Tooltip=$f_Tooltip."<nobr>Size: ".$filesize."</nobr><br>";
      $f_Tooltip=$f_Tooltip."<nobr>Width: ".$size[0]."</nobr><br>";
      $f_Tooltip=$f_Tooltip."<nobr>Height: ".$size[1]."</nobr><br>";
      $f_Tooltip=$f_Tooltip."<nobr>Date modified: ".$lastmod."</nobr><br>";
      $f_Tooltip=$f_Tooltip."<nobr>Attributes: ".$p."</nobr><br>";
        
		  // insert row tag if this is the first column
		  if ($column_cnt == 1) { $s .= "<tr>\n"; }
  		
		  // insert thumbnail, and surrounding html
		  $s .= "<td>";
		  $s .= "<img src=\"$thumburl\" border=\"0\" width=\"".$width."\" height=\"".$height."\" onclick=\"parent.insert(this.src)\"";
      $s .= " onMouseover=\"Check(this,1); showTooltip('".$f_Tooltip."', this, event);\"";
      $s .= " onMouseout=\"Check(this,0); delayhidetip()\" ";
      $s .= " style=\"BORDER: white 1px solid;cursor:hand;cursor:pointer;\" align=\"center\"/>";
		  $s .= "</td>\n";
  		
		  if ($column_cnt == TABLE_COLS) {
			  $s .= "</tr>\n\n";
			  $column_cnt = 1;
		  } else {
			  $column_cnt++;
		  }
	  }    
	  $s=$s."</table></div>";
    
    $pagecnt  = (int) (($imgcnt - 1) / (TABLE_COLS * TABLE_ROWS)) + 1; 
	  $self     = $_SERVER['PHP_SELF'];

    $s=$s."<p style='text-align:center;overflow: auto;word-wrap:break-word'>";
    // Show paging indicator if multiple pages:
    $s=$s."Pages:&nbsp;";
    if ($currpage>1)
    {
      $s=$s."<a href=\"".$self."?".$setting."&Theme=".$Theme."&GP=".$current_Path.$folpath."&page=".($currpage-1)."\">&lt;&lt; Prev</a>&nbsp;";
    } 

    // You can also show page numbers:
    for ($I=1; $I<=$pagecnt; $I=$I+1)
    {
      if ($I==$currpage)
      {
        $s=$s.$I."&nbsp;";
      }
      else
      {
        $s=$s."<a href=\"".$self."?".$setting."&Theme=".$Theme."&GP=".$current_Path.$folpath."&page=".$I."\">".$I."</a>&nbsp;";
      } 
  }

  if ($currpage<$pagecnt)
  {
    $s=$s."<a href=\"?".$setting."&Theme=".$Theme."&GP=".$current_Path.$folpath."&page=".($currpage+1)."\">Next &gt;&gt;</a>";
  } 
    
  $s=$s."</p>";
    
  return $s;
} 

function GetExtension($str_FileName)
{
	return strtolower(substr(strrchr($str_FileName, '.'), 1));
}
function ValidImage($str_FileName)
{
	extract($GLOBALS);
	$valid = false;
	$ext = ".".GetExtension($str_FileName);
	$filter_Array;
	$filter_Array=explode(",",strtolower($ImageFilters));
	foreach ($filter_Array as $v) {
   		if(strcasecmp($ext,$v)==0)
		{
			$valid = true;
			break;
		}
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

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Browse</title>
<script type="text/javascript">

	function highlightcell(c) {
		var allcells = document.getElementsByTagName("TD");
		for (i=0;i<allcells.length;i++) {
			allcells[i].style.backgroundColor = "white"; allcells[i].style.color = "black";
		}
		c.style.backgroundColor = "#0a246a"; c.style.color = "white";
	}
	
	var folderpath = "browse_Img_gallery.php?<?php echo $setting; ?>&Theme=<?php echo $Theme; ?>&GP=<?php echo $current_Path ; ?>";
	
	function Editor_upfolder() {
		arrloc = curloc.split("/"); 
		str = "";
		for (i=0;i<arrloc.length-2;i++) {
			str += arrloc[i] + "/";
		}
		location.href = folderpath+"&loc=" + str + "&u=y";
		parent.currentfolder = folderpath+"&loc=" + str + "&u=y";
	}	
	
	function Check(t,n)	
	{
		if(n==1) {
			t.style.border = "1px solid #00107B";
			t.style.background = "#F1EEE7";
		}
		else  {
			t.style.border = "1px solid #d7d3cc";
			t.style.background = "#d7d3cc";
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
	function UploadSaved(sFileName,path){
		document.getElementById("TargetUrl").value = sFileName;
		self.location=self.location;
	}
	
	
</script>
<script language="JavaScript">var curloc = "<?php echo $folpath; ?>";</script> 
		
	<style type="text/css">
		INPUT { BORDER-RIGHT: black 1px solid; BORDER-TOP: black 1px solid; FONT-SIZE: 8pt; VERTICAL-ALIGN: middle; BORDER-LEFT: black 1px solid; CURSOR: pointer; BORDER-BOTTOM: black 1px solid; FONT-FAMILY: MS Sans Serif }
		A:link { COLOR: #000099 }
		A:visited { COLOR: #000099 }
		A:active { COLOR: #000099 }
		A:hover { COLOR: darkred }
		#tooltipdiv{
		position:absolute;
		padding: 2px;
		border:1px solid black;
		font:menu;
		z-index:100;
		}
		body
		{
		background-color:#eeeeee;
		overflow:hidden;margin:0px; border:0px;
		}
	</style>
  <link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
</head>
<body>
	<?php 
	//	echo $current_Path.$folpath;
		echo Showbrowse_Img($current_Path.$folpath);
		$Style_Display_None="";
		if ($AllowUpload!="true")
		{
			$Style_Display_None="Display:none";
		} 
	?>
  <br />
  <iframe src="upload.php?<?php echo $setting ; ?>&Theme=<?php echo $Theme; ?>&FP=<?php echo $current_Path . $folpath; ?>&Type=Image" id="uploader1" frameborder="0" scrolling="auto" style="width:100%;<?php echo $Style_Display_None ; ?>"></iframe>
	<input type="hidden" id="TargetUrl" name="TargetUrl" />		
</body>
</html>


<script type="text/javascript">
			function SetUpload_imagePath(path)
	        {
				if(document.getElementById("uploader1")!=null)
					document.getElementById("uploader1").src="upload.php?<?php echo $setting ; ?>&FP="+path+"&Type=Image"
	        }				

</script>