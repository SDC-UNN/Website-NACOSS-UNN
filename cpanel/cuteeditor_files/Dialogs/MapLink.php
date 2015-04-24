<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("Include_GetString.php") ;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo GetString("Hyperlink_Information") ; ?> </title>
		
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
		<table border="0" cellspacing="2" cellpadding="5" width="100%" style="text-align:center">
			<tr>
				<td>
					<div>
					<fieldset>
						<table class="normal">
							<tr>
								<td style="width:60px"><?php echo GetString("Url") ; ?>:</td>
								<td><input type="text" id="inp_src" style="width:200px" /></td>
								<td>
								    <input id="btnbrowse" type="button" value="<?php echo GetString("Browse") ; ?>" />
								</td>
							</tr>
							<tr>
								<td style="width:60px"><?php echo GetString("Title") ; ?>:</td>
								<td colspan="2"><input type="text" id="inp_title" style="width:200px" /></td>
							</tr>
							<tr>
								<td style="width:60px"><?php echo GetString("Type") ; ?>:</td>
								<td colspan="2">
									<select id="sel_protocol" onchange="sel_protocol_change()">
										<option value="http://">http://</option>
										<option value="https://">https://</option>
										<option value="ftp://">ftp://</option>
										<option value="news://">news://</option>
										<option value="mailto:">mailto:</option>
										<!-- last one : if move this to front , change the script too -->
										<option value="others"><?php echo GetString("Other") ; ?></option>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width:60px"><?php echo GetString("Target") ; ?></td>
								<td colspan="2">
									<select id="inp_target" name="inp_target">
										<option value=""><?php echo GetString("NotSet") ; ?></option>
										<option value="_blank"><?php echo GetString("Newwindow") ; ?></option>
										<option value="_self"><?php echo GetString("Samewindow") ; ?></option>
										<option value="_top"><?php echo GetString("Topmostwindow") ; ?></option>
										<option value="_parent"><?php echo GetString("Parentwindow") ; ?></option>
									</select>
								</td>
							</tr>		
						</table>
					</fieldset>
					</div>
					<div style="margin-top:8px;width:60%; text-align:center">
						<input class="formbutton" type="button" value="<?php echo GetString("Insert") ; ?>" style="width:80px" onclick="insert_link()" />&nbsp;&nbsp;
						<input class="formbutton" type="button" value="<?php echo GetString("Cancel") ; ?>" style="width:80px" onclick="top.returnValue=false;top.close()" />
					</div>
				</td>
			</tr>
		</table>
		</div>
	</body>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_MapLink.js"></script>
</html>