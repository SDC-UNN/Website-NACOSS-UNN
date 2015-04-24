<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo GetString("PasteAsHTML") ; ?> </title>		
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
		<style type="text/css">	
		html, body,#ajaxdiv {height: 100%;}
		#idSource{width: 430px; height: 300px;background-color:#ffffff;padding:0;}
		#divouter{border:1px solid #a0a0a0;vertical-align: top;width: 430px; height: 300px;background-color:white;}
		</style>
</head>
<body>
    <div id="ajaxdiv">
        <table border="0" cellpadding="0" cellspacing="2" width="100%" id="Table1">
					<tr>
						<td style="padding:4px;">
                <?php echo GetString("UseCtrl_VtoPaste") ; ?></td>
					</tr>
					<tr>
						<td>
							<div id="divouter">
<iframe id="idSource" name="idSource" src="../template.php" scrolling="auto" frameborder="0"></iframe>
							</div>
						</td>
					</tr>
				</table>
        <br />
        <div align="center">
				<input type="button" id="Button2" name="insert" class="formbutton" value="<?php echo GetString("Insert") ; ?>" onclick="insertContent();" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" value="<?php echo GetString("Cancel") ; ?>" class="formbutton" onclick="cancel();" id="Button1" name="Button1" />
			</div>
    </div>
	</body>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_gecko_pasteword.js"></script>
</html>