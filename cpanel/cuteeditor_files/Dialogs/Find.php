<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo GetString("Find") ; ?> </title>		
		<meta name="content-type" content="text/html ;charset=Unicode" />
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
		<style type="text/css">	
		html, body,#ajaxdiv {height: 100%;}
		</style>
	</head>
	<body>
		<div id="ajaxdiv">
			<table cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<td class="normal" width="260">
						<table cellspacing="2" cellpadding="5" width="100%" class="normal">
							<tr>
								<td valign="top" ><?php echo GetString("Find what") ; ?>:
								</td>
								<td valign="top" style="white-space:nowrap"><input type="text" size="30" name="stringSearch" id="stringSearch" style="width : 150px;" /></td>
							</tr>
							<tr>
								<td width="100"><?php echo GetString("Replace with") ; ?>:
								</td>
								<td valign="top"><input type="text" size="30" name="stringReplace" id="stringReplace" style="width : 150px;" /></td>
							</tr>
						</table>
						<input type="Checkbox" size="40" name="MatchWholeWord" id="MatchWholeWord" /><?php echo GetString("Match whole word") ; ?><br />
						<input type="Checkbox" size="40" name="MatchCase" id="MatchCase" /><?php echo GetString("Match case") ; ?>
					</td>
					<td class="normal" width="100">
					    <input type="button" style="width:75px; height:22px; margin-top:10px" class="formbutton" onclick="FindTxt();" value="<?php echo GetString("Find Next") ; ?>" />
					    <input type="button" style="width:75px; height:22px; margin-top:7px" class="formbutton" onclick="ReplaceTxt();" value="<?php echo GetString("Replace") ; ?>" />
					    <input type="button" style="width:75px; height:22px; margin-top:7px" class="formbutton" onclick="ReplaceAllTxt();" value="<?php echo GetString("Replace All") ; ?>"/>
					    <input type="button" style="width:75px; height:22px; margin-top:7px" class="formbutton" onclick="(top.closeeditordialog || top.close)();" value="<?php echo GetString("Cancel") ; ?>"/>
					</td>
				</tr>
			</table>
		</div>
	</body>
	<script>
	    var WordNotFound = "<?php echo GetString("WordNotFound") ; ?>";
	    var WordReplaced = "<?php echo GetString("WordReplaced") ; ?>";
	</script>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_Find.js"></script>
</html>
