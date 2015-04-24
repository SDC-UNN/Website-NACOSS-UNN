<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("Include_GetString.php") ;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo GetString("DocumentPropertyPage") ; ?></title>		
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
		<style type="text/css">
		html, body,#ajaxdiv,#Form1 {height: 100%;}
		</style>
	</head>
	<body>
		<div id="ajaxdiv">
		<table border="0" cellspacing="0" cellpadding="2" style="width:100%;" id="Table1">
			<tr>
				<td valign="top">
					<fieldset>
						<legend>
							<?php echo GetString("DocumentPropertyPage") ; ?></legend>
						<div style="height:12px"></div>
						<table border="0" cellpadding="3" cellspacing="0" style="border-collapse:collapse;" class="normal"
							id="Table2">
							<tr>
								<td><?php echo GetString("Title") ; ?>:</td>
								<td colspan="4">
									<input type="text" id="inp_title" style="width:320px" name="inp_title" />
								</td>
							</tr>
							<tr>
								<td>DOCTYPE:</td>
								<td colspan="4">
									<input type="text" id="inp_doctype" style="width:320px" name="inp_doctype" />
								</td>
							</tr>
							<tr>
								<td><?php echo GetString("Description") ; ?>:</td>
								<td colspan="4">
									<textarea id="inp_description" rows="3" cols="20" style="width:320px" name="inp_description"></textarea>
								</td>
							</tr>
							<tr>
								<td><?php echo GetString("Keywords") ; ?>:</td>
								<td colspan="4">
									<textarea id="inp_keywords" rows="3" cols="20" style="width:320px" name="inp_keywords"></textarea>
								</td>
							</tr>
							<tr>
								<td><?php echo GetString("PageLanguage") ; ?>:</td>
								<td colspan="4">
									<input type="text" id="PageLanguage" name="PageLanguage" size="15" style="WIDTH:320px" />
								</td>
							</tr>
							<tr>
								<td><?php echo GetString("HTMLEncoding") ; ?>:</td>
								<td colspan="4">
									<input type="text" id="HTMLEncoding" name="HTMLEncoding" size="15" style="WIDTH:320px" />
								</td>
							</tr>
							<tr>
								<td><?php echo GetString("Backgroundcolor") ; ?>:</td>
								<td>
								    <input autocomplete="off" type="text" id="bgcolor" name="bgcolor" size="7" style="width:57px;behavior:url('../Scripts/ColorPicker.php?UC=<?php echo $Culture ; ?>');" />
								    <img alt="" src="../Images/colorpicker.gif" id="bgcolor_Preview" style=";vertical-align:inherit;behavior:url('../Scripts/ColorPicker.php?UC=<?php echo $Culture ; ?>');" />
							    </td>
								<td style="width:5px"></td>
								<td><?php echo GetString("ForeColor") ; ?>:</td>
								<td>
									<input autocomplete="off" type="text" id="fontcolor" name="fontcolor" size="7" style="width:57px;behavior:url('../Scripts/ColorPicker.php?UC=<?php echo $Culture ; ?>');" />
								    <img alt="" src="../Images/colorpicker.gif" id="fontcolor_Preview" style=";vertical-align:inherit;behavior:url('../Scripts/ColorPicker.php?UC=<?php echo $Culture ; ?>');" />
								</td>
							</tr>
							<tr>
								<td><?php echo GetString("Backgroundimage") ; ?>:</td>
								<td colspan="4">
									<input type="text" id="Backgroundimage" style="width:250px" name="Backgroundimage" />
									<input type="button"  id="btnbrowse" value="<?php echo GetString("Browse") ; ?>"/>
								</td>
							</tr>
							<tr>
								<td><?php echo GetString("TopMargin") ; ?>:</td>
								<td>
									<input type="text" id="TopMargin" name="TopMargin" size="7" style="width:57px" /> 
									Pixels
								</td>
								<td style="width:5px"></td>
								<td><?php echo GetString("BottomMargin") ; ?>:</td>
								<td>
									<input type="text" id="BottomMargin" name="BottomMargin" size="7" style="width:57px" />
									Pixels
								</td>
							</tr>
							<tr>
								<td><?php echo GetString("LeftMargin") ; ?>:</td>
								<td>
									<input type="text" id="LeftMargin" name="LeftMargin" size="7" style="width:57px" />
									Pixels
								</td>
								<td style="width:5px"></td>
								<td><?php echo GetString("RightMargin") ; ?>:</td>
								<td>
									<input type="text" id="RightMargin" name="RightMargin" size="7" style="width:57px" />
									Pixels
								</td>
							</tr>
							<tr>
								<td><?php echo GetString("MarginWidth") ; ?>:</td>
								<td>
									<input type="text" id="MarginWidth" name="RightMargin" size="7" style="width:57px" />
									Pixels
								</td>
								<td style="width:5px"></td>
								<td><?php echo GetString("MarginHeight") ; ?>:</td>
								<td>
									<input type="text" id="MarginHeight" name="MarginHeight" size="7" style="width:57px" />
									Pixels
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
		</table>
			<br>
			<div id="container-bottom">
					<input type="button" id="btnok" class="formbutton"  value="<?php echo GetString("OK") ; ?>"/>
					&nbsp; 
					<input type="button" id="btncc" class="formbutton" value="<?php echo GetString("Cancel") ; ?>"/>
				</div>					
		</div>
	</body>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_Page.js"></script>
</html>