<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo GetString("PasteText") ; ?></title>		
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
		<style type="text/css">	
		html, body,#ajaxdiv {height: 100%;}
		#idSource{width: 430px; height: 300px;background-color:#ffffff;padding:0;border:1px solid #a0a0a0;}
		#divouter{border:1px solid #a0a0a0;vertical-align: top;width: 430px; height: 300px;background-color:white;}
		</style>
	</head>
	<body>
		<div id="ajaxdiv">
			<table border="0" cellpadding="0" cellspacing="2" width="100%" ID="Table1">
				<tr>
					<td><?php echo GetString("UseCtrl_VtoPaste") ; ?></td>
					<td style="white-space:nowrap" >
						<input type="checkbox" name="linebreaks" id="linebreaks" checked="checked" /><?php echo GetString("KeepLinebreaks") ; ?>
					</td> 
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="2" width="95%" ID="Table2">
				<tr>
					<td>
						<textarea name="idSource" id="idSource" rows="20" cols="58"></textarea>
          			</td>
				</tr>
			</table>
			<br>
			<table border="0" cellpadding="0" cellspacing="2" width="100%" ID="Table3">
				<tr>
					<td align="left"><input type="button" value="<?php echo GetString("CleanUpBox") ; ?>" class="formbutton" onclick="document.getElementById('idSource').value='';" id="Button2" />
					</td>
					<td align="right" style="padding-right:100px">
						<input type="button" id="insert" name="insert" value="<?php echo GetString("Insert") ; ?>" class="formbutton" onclick="insertContent();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" value="<?php echo GetString("Cancel") ; ?>" onclick="cancel();" class="formbutton" id="Button1" />
					</td>
				</tr>
			</table>	
    </div>
	</body>
	<script type="text/javascript">		
			if(!Browser_IsSafari())
			{
				document.getElementById("idSource").style.width="100%";				
				document.getElementById("idSource").style.height="100%";
			}
	</script>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_gecko_pastetext.js"></script>
</html>