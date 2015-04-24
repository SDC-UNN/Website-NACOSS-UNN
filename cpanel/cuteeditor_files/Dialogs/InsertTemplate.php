<?php
error_reporting(E_ALL ^ E_NOTICE);
require("Include_Security.php") ;
header("Expires: " . gmdate("D, d M Y H:i:s", time() + (-1*60)) . " GMT"); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>		
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
		<style type="text/css">
		#framepreview {
			width: 100%;
			height: 100%;
			overflow:auto;
			text-align: left;
			vertical-align: top;
			padding: 0;
			margin: 0;
			background-color: white;
		}
		
	    #uploader1 {VISIBILITY: inherit; Z-INDEX: 2;width:500px;height:65px;margin:10px 0 0 10px}
	    #browse_Frame{border:1px solid #a0a0a0;width:270px;height:246px}
	    #divouter{border:1px solid #a0a0a0;padding:0;vertical-align: top; overflow: auto; width:357px;height:250px; background-color:white;}
		#divpreview{background-color: white; height: 100%; width: 100%}
			html, body,#ajaxdiv,#Form1 {height: 100%;}
		</style>
		
	<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
	<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
	<title><?php echo GetString("InsertTemplate") ; ?></title>
    <?php
    
      $Current_TemplateGalleryPath=$TemplateGalleryPath;
      if (@$_GET["MP"]!="")
      {
        $Current_TemplateGalleryPath=$_GET["MP"];
      }
    ?>
    
	</head>
	<body>
		<div id="ajaxdiv">
			<table border="0" cellspacing="0" cellpadding="2" width="100%">
	            <tr>
		            <td style="white-space:nowrap; width:250px">
		            </td>
		            <td valign="bottom" style="width:200px">
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
					<td valign="top" style="width:260px;height:240px;">
<iframe src="browse_Template.php?<?php echo $setting ; ?>&Theme=<?php echo $Theme; ?>&MP=<?php echo $Current_TemplateGalleryPath; ?>" id="browse_Frame" frameborder="0" scrolling="auto"></iframe>
					</td>
					<td>
						<div id="divouter">
<iframe id="framepreview" src="../template.php" scrolling="auto" frameborder="0"></iframe>
						</div>
					</td>
				</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:2px 0 2px 0">
				<tr>
					<td style="width:10px">
					</td>
					<td valign="top">
						<input type="hidden" id="TargetUrl" size="40" name="TargetUrl" />

            <?php
              $Style_Display_None="";
						  if ($AllowUpload!="true")
              {
                $Style_Display_None="Style='Display:none'";
              } 
						?>
						<fieldset id="fieldsetUpload" <?php echo $Style_Display_None ; ?> >
							<legend><?php echo GetString("Upload") ; ?> (Max size <?php echo $MaxTemplateSize; ?>K)</legend>
<iframe src="upload.php?<?php echo $setting ; ?>&Theme=<?php echo $Theme; ?>&FP=<?php echo $Current_TemplateGalleryPath; ?>&Type=template" id="uploader1" frameborder="0" scrolling="auto"></iframe>						</fieldset>
						<div style="padding-top:10px; text-align:center">
<input class="formbutton" type="button" value="<?php echo GetString("Insert") ; ?>" onclick="do_insert()" id="Button1" />
&nbsp;&nbsp;&nbsp; 
<input class="formbutton" type="button" value="<?php echo GetString("Cancel") ; ?>" onclick="do_Close()" id="Button2" />
						</div>
					</td>
				</tr>
			</table>
		</div>
	    <script type="text/javascript">	
	        var OK = "<?php echo GetString("OK"); ?>"
	        var Cancel = "<?php echo GetString("Cancel"); ?>"
	        var InputRequired = "<?php echo GetString("InputRequired"); ?>"
	        var ValidID = "<?php echo GetString("ValidID"); ?>"
	        var ValidColor = "<?php echo GetString("ValidColor"); ?>"
	        var SelectImagetoInsert = "<?php echo GetString("SelectImagetoInsert"); ?>";
	        
	        function UploadSaved(sFileName,path){
		        ResetFields();
		  try{
		    browse_Frame.location.reload();
		    }
		    catch(x)
		    {}
		        TargetUrl.value = sFileName;
		        setTimeout(function(){do_preview(sFileName);}, 100); 
		       row_click(sFileName);
	        }
        	
	        function Refresh(path)
	        {
		        browse_Frame.location="browse_Template.php?<?php echo $setting ; ?>&Theme=<?php echo $Theme; ?>&MP=<?php echo $TemplateGalleryPath; ?>&loc="+path+"";
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
	        function row_click(path)
	        {
		        framepreview.location=path;
		        setTimeout(do_preview,500);
	        }	    
    		
	        function SetUpload_FolderPath(path)
	        {	if(path.substring(path.length-1, path.length)=='/')
		        {
			        path=path.substring(0, path.length-1);
		        }
		        uploader1.src="upload.php?<?php echo $setting ; ?>&Theme=<?php echo $Theme; ?>&FP="+path+"&Type=template";
	        }	
	    </script>	
		<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
		<script type="text/javascript" src="../Scripts/Dialog/Dialog_InsertTemplate.js"></script>
	</body>
</html>
