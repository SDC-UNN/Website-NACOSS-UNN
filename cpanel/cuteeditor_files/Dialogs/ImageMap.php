<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("Include_GetString.php") ;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo GetString("ImageMap") ; ?></title>		
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
		<style type="text/css">
		html, body,#ajaxdiv {height: 100%;}
		#iframe{width: 550px; height: 300px;background-color:#ffffff;padding:0;}
		#divouter{border:1px solid #a0a0a0;vertical-align: top;width: 550px; height: 300px;background-color:white;}
		</style>
	</head>
	<body>
		<div id="ajaxdiv">
			<table border="0" cellspacing="0" cellpadding="2" width="100%">
			<tr>
				<td style="padding:4px 0 1px 4px">
&nbsp;&nbsp;&nbsp; <img src="../Images/ImageMap.gif" onclick="newMap();" title="<?php echo GetString("AddHotSpot") ; ?>"
	class="cursor dialogButton" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" />
<img src="../Images/link.gif" onclick="Addlink(this);" title="<?php echo GetString("InsertLink") ; ?>"
	class="cursor dialogButton" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" />
<img id="img_zoom_in" src="../Images/zoom_in.gif" onclick="Zoom_In();" title="<?php echo GetString("ZoomIn") ; ?>"
	class="cursor dialogButton" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" />
<img id="img_zoom_out" src="../Images/zoom_out.gif" onclick="Zoom_Out();" title="<?php echo GetString("ZoomOut") ; ?>"
	class="cursor dialogButton" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" />
<img id="img_bestfit" src="../Images/bestfit.gif" onclick="BestFit();" title="<?php echo GetString("BestFit") ; ?>"
	class="cursor dialogButton" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" />
<img id="img_actualsize" src="../Images/Actualsize.gif" onclick="Actualsize();" title="<?php echo GetString("ActualSize") ; ?>"
	class="cursor dialogButton" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" />
				</td>
			</tr>
				<tr>
					<td style="height:280px">
						<div id="divouter">		
					        <iframe id="iframe" src="../template.php" frameborder="0"></iframe>
						</div>
					</td>
				</tr>
			</table>
			<div style="padding-top:10px; text-align:center">
<input class="formbutton" type="button" value="   <?php echo GetString("Insert") ; ?>   " onclick="do_insert()" id="Button1" /> 
&nbsp;&nbsp;&nbsp; 
<input class="formbutton" type="button" value="   <?php echo GetString("Cancel") ; ?>  " onclick="do_Close()" id="Button2" />
			</div>
		</div>
	</body>
	<script type="text/javascript">
	    var query_string = "?<?php echo $_SERVER["QUERY_STRING"]; ?>";
	    var AddLinktoImageMap = "<?php echo GetString("AddLinktoImageMap"); ?>";
	</script>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_ImageMap.js"></script>
</html>