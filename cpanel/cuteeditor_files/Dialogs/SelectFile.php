<?php
error_reporting(E_ALL ^ E_NOTICE);
require("Include_Security.php") ;
header("Expires: " . gmdate("D, d M Y H:i:s", time() + (-1*60)) . " GMT");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		<style type="text/css">
	    #uploader1 {VISIBILITY: inherit; Z-INDEX: 2;width:350px;height:55px;margin:10px 0 0 10px}
	    #browse_Frame{border:1px solid #a0a0a0;width:520px;height:300px}
	    #divouter{border:1px solid #a0a0a0; vertical-align: top; overflow: auto; width:200px;height:300px; background-color: white; text-align: center}
	    #divpreview{background-color: white; height: 100%; width: 100%;text-align:left;padding:10px}
		html, body,#ajaxdiv,#Form1 {height: 100%;}
	    #inp_color_preview{margin-bottom:-3px;}
		</style>
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
	    <title><?php echo GetString("Browse") ; ?> </title>
    <?php
     
      $Current_FilesGalleryPath=$FilesGalleryPath;
      if (@$_GET["DP"]!="")
      {
        $Current_FilesGalleryPath=$_GET["DP"];
      }
    ?>
    
	</head>
	<body>
		<div id="ajaxdiv">
			<table border="0" cellspacing="2" cellpadding="0" width="100%">
	            <tr>
		            <td style="width:520px;">
		            </td>
		            <td>
			            <?php
							$ButtonStatusClass="cursor dialogButton";
							if($AllowCreateFolder!="true")
							$ButtonStatusClass="CuteEditorButtonDisabled";                           
						?>
<img src='../Images/newfolder.gif' id='btn_CreateDir' onclick='CreateDir_click();' title='<?php echo GetString("Createdirectory") ; ?>' class='<?php echo $ButtonStatusClass; ?>' onmouseover='CuteEditor_ColorPicker_ButtonOver(this);' />
<img src="../Images/zoom_in.gif" id="btn_zoom_in" onclick="Zoom_In();" title="<?php echo GetString("ZoomIn") ; ?>" class="cursor dialogButton" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" /> 
<img src="../Images/zoom_out.gif" id="btn_zoom_out" onclick="Zoom_Out();" title="<?php echo GetString("ZoomOut") ; ?>" class="cursor dialogButton" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" /> 
<img src="../Images/Actualsize.gif" id="btn_Actualsize" onclick="Actualsize();" title="<?php echo GetString("ActualSize") ; ?>" class="cursor dialogButton" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" /> 
		            </td>
	            </tr>
				<tr>
					<td valign="top" style="width:520px; height:300px">
<iframe src="browse_Document.php?<?php echo $setting ; ?>&Theme=<?php echo $Theme; ?>&DP=<?php echo $Current_FilesGalleryPath; ?>" id="browse_Frame" frameborder="0" scrolling="auto"></iframe>
					</td>
					<td>
						<div id="divouter">
							<div id="divpreview">
							</div>
						</div>
					</td>
				</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" style="margin-top:3px;width:100%">
				<tr>
				    <td valign="top">
		              <fieldset>
		                <legend><?php echo GetString("Insert") ; ?></legend>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<tr>
				                    <td valign="middle"><?php echo GetString("Url") ; ?>:</td>
				                    <td>
				                        <input type="text" id="TargetUrl" style="width:360px" name="TargetUrl" />
			                        </td>
			                    </tr>
		                    </table>
	                  </fieldset>
              <?php
                $Style_Display_None="";
	                        if ($AllowUpload!="true")
                {
                  $Style_Display_None="Style='Display:none'";
                } 
	                      ?>
	                        <fieldset id="fieldsetUpload" <?php echo $Style_Display_None ; ?> >
		                    <legend><?php echo GetString("Upload") ; ?> (Max size <?php echo $MaxDocumentSize; ?>K)</legend>
<iframe src="upload.php?<?php echo $setting ; ?>&Theme=<?php echo $Theme; ?>&FP=<?php echo $Current_FilesGalleryPath; ?>&Type=document" id="uploader1" frameborder="0" scrolling="auto"></iframe>
				        </fieldset> 
	                    </td>
				    <td>&nbsp;&nbsp;&nbsp; 
				    </td>
				    <td width="250">	
			<div style="padding-top:10px; text-align:center">
<input class="formbutton" type="button" value="<?php echo GetString("OK") ; ?>" onclick="do_insert()" id="Button1" name="Button1" /> &nbsp;&nbsp;&nbsp;                    							
<input class="formbutton" type="button" value="<?php echo GetString("Cancel") ; ?>" onclick="do_Close()" id="Button2" name="Button2" />
            </div>
				    </td>
			    </tr>
			</table>	
		</div>
			<script type="text/javascript">	
	            var OK = "<?php echo GetString("OK"); ?>";
	            var Cancel = "<?php echo GetString("Cancel"); ?>";
	            var InputRequired = "<?php echo GetString("InputRequired"); ?>";
	            var ValidID = "<?php echo GetString("ValidID"); ?>";
	            var ValidColor = "<?php echo GetString("ValidColor"); ?>";
	            var SelectImagetoInsert = "<?php echo GetString("SelectImagetoInsert"); ?>";
	            
	            function UploadSaved(sFileName,path){
		            ResetFields();
		  try{
		    browse_Frame.location.reload();
		    }
		    catch(x)
		    {}
		            TargetUrl.value = sFileName;
		            var ext=sFileName.substring(sFileName.lastIndexOf('.')).toLowerCase();
	                switch(ext)
	                {
		                case ".jpeg":case ".jpg":case ".gif":case ".png":case ".bmp":
		                    setTimeout(function(){do_preview();}, 100); 
			                break;
		                case ".swf":
		                    setTimeout(function(){do_preview();}, 100); 
			                break;
		                case ".avi":case ".mpg":case ".mp3":case ".mpeg":case ".wav":
		                    setTimeout(function(){do_preview();}, 100); 
			                break;
			            default:
		                    setTimeout(function(){do_preview(sFileName);}, 100); 
			                break;
			            
	                }
		            row_click(sFileName,"");
	            }
            	
	            function Refresh(path)
	            {
		            browse_Frame.location="browse_Document.php?<?php echo $setting ; ?>&Theme=<?php echo $Theme; ?>&DP=<?php echo $FilesGalleryPath; ?>&loc="+path+"";
				}
				function CreateDir_click()
				{
					<?php
						$Style_Display_None;
						if ($AllowCreateFolder!="true")
						{
							echo "alert(\"".GetString("NoPermission")."\");";
							echo "return;";
						}
					?>		    
	                if(Browser_IsIE7())
	                {
		                IEprompt(promptCallback,'<?php echo GetString("SpecifyNewFolderName"); ?>', "");		
		                function promptCallback(dir)
		                {
			                var tempPath = browse_Frame.location;	
			                tempPath = tempPath + "&action=createfolder&foldername="+dir;
			                browse_Frame.location = tempPath;		
		                }
	                }
	                else
	                {
		                var dir=prompt("<?php echo GetString("SpecifyNewFolderName"); ?>","")
		                if(dir)
		                {
			                var tempPath = browse_Frame.location;	
			                tempPath = tempPath + "&action=createfolder&foldername="+dir;
			                browse_Frame.location = tempPath;			
		                }
	                }
	            }
	            function row_click(path,html)
	            {	
		            ResetFields();
		            TargetUrl.value=path;
		            do_preview(html);
	            }	    
        		
	            function SetUpload_FolderPath(path)
	            {	if(path.substring(path.length-1, path.length)=='/')
		            {
			            path=path.substring(0, path.length-1);
		            }
		            uploader1.src="upload.php?<?php echo $setting ; ?>&Theme=<?php echo $Theme; ?>&FP="+path+"&Type=document";
	            }	
	        </script>
		<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
		<script type="text/javascript" src="../Scripts/Dialog/Dialog_SelectFile.js"></script>
	</body>
</html>
