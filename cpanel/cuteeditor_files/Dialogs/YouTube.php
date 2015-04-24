<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>
			<?php echo GetString("YouTube"); ?>  
		</title>		
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->	
		<style type="text/css">
		#idSource{width: 480px; height: 120px;background-color:#ffffff;padding:0;border:1px solid #a0a0a0;}
		html, body,#ajaxdiv,#Form1 {height: 100%;}
		</style>
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
	</head>
	<body>
		<div id="ajaxdiv">
			<table border="0" cellspacing="2" cellpadding="2" width="100%">
				<tr>
					<td valign="top" style="white-space:nowrap;">
						<p><?php echo GetString("PasteYouTube"); ?>:</p>
						<textarea name="idSource" id="idSource" rows="9" cols="50" onpaste="setTimeout('do_preview()',100)" onchange="do_preview()"></textarea>
						<input type="hidden" id="TargetUrl" size="50" name="TargetUrl" />
					</td>
				</tr>
			</table>
			<div style="padding-top:10px;text-align:center">
<input class="formbutton" type="button" value="   <?php echo GetString("Insert"); ?>   " onclick="do_insert()" />&nbsp;&nbsp;&nbsp;
<input class="formbutton" type="button" value="   <?php echo GetString("Cancel"); ?>   " onclick="do_Close()" />
			</div>
		</div>
	</body>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_YouTube.js"></script>
</html>