<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo GetString("Preview") ; ?></title>
		
		<meta name="content-type" content="text/html ;charset=Unicode" />
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<style type="text/css">	
		html, body {height: 100%;}
		#idSource{WIDTH: 100%; HEIGHT: 100%;background-color:#ffffff;}
		#divouter{border-top:1px solid #a0a0a0;border-left:1px solid #a0a0a0;border-bottom:1px solid #ffffff;border-right:1px solid #ffffff;vertical-align: top;width:100%;height:100%; background-color:white;}
		</style>
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
	</head>
	<body>
		<div id="ajaxdiv" style="padding:3px;">
			<table style="height:100%" cellspacing="0" cellpadding="0" width="99%">
				<tbody>
					<tr>
						<td style="HEIGHT: 100%" colspan="3">
							<div id="divouter">
							<iframe id="idSource" src="../template.php" scrolling="auto" frameborder="0">
							</iframe>
							</div>
						</td>
					</tr>
					<tr>
						<td>
<img src="../Images/print.gif" onclick="window.print();" title="<?php echo GetString("Print") ; ?>" class="cursor dialogButton" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" />
						</td>
						<td style="PADDING-LEFT: 30px;">
							<?php echo GetString("Width") ; ?>: <input type="text" name="inc_width" id="inc_width" size="5" />&nbsp;&nbsp; 
							<?php echo GetString("Height") ; ?>: <input type="text" name="inc_height" id="inc_height" size="5" />
						</td>
						<td class="dialogFooter" align="right" style="padding:15px">
							<input class="formbutton" type="button" value="<?php echo GetString("Cancel") ; ?>" onclick="do_Close()" />&nbsp;
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_Preview.js"></script>
</html>
