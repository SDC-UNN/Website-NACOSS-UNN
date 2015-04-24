<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>
			<?php echo GetString("InsertEmotion"); ?>  
		</title>		
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<style>
		html, body,#ajaxdiv {height: 100%;}
		#ImageTable img {cursor:pointer;width:19px;height:19px;}
		</style>
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
	</head>
	<body>
		<div id="ajaxdiv">
			<div style="background-color:#ffffff;border:1px solid #cccccc; padding:10px; width:250px; ">
						<table width="100%" cellspacing="0" cellpadding="1" border="0" id="ImageTable" align="center">
							<tr>
								<td><img alt="" src="../Images/emsmile.gif" /></td>
								<td><img alt="" src="../Images/emteeth.gif" /></td>
								<td><img alt="" src="../Images/emwink.gif" /></td>
								<td><img alt="" src="../Images/emsmileo.gif" /></td>
								<td><img alt="" src="../Images/emsmilep.gif" /></td>
								<td><img alt="" src="../Images/emsmiled.gif" /></td>
								<td><img alt="" src="../Images/emangry.gif" /></td>
								<td><img alt="" src="../Images/emembarrassed.gif" /></td>
							</tr>
							<tr>
								<td><img alt="" src="../Images/emcrook.gif" /></td>
								<td><img alt="" src="../Images/emsad.gif" /></td>
								<td><img alt="" src="../Images/emcry.gif" /></td>
								<td><img alt="" src="../Images/emdgust.gif" /></td>
								<td><img alt="" src="../Images/emangel.gif" /></td>
								<td><img alt="" src="../Images/emlove.gif" /></td>
								<td><img alt="" src="../Images/emunlove.gif" /></td>
								<td><img alt="" src="../Images/emmessag.gif" /></td>
							</tr>
							<tr>
								<td><img alt="" src="../Images/emcat.gif" /></td>
								<td><img alt="" src="../Images/emdog.gif" /></td>
								<td><img alt="" src="../Images/emmoon.gif" /></td>
								<td><img alt="" src="../Images/emstar.gif" /></td>
								<td><img alt="" src="../Images/emfilm.gif" /></td>
								<td><img alt="" src="../Images/emnote.gif" /></td>
								<td><img alt="" src="../Images/emrose.gif" /></td>
								<td><img alt="" src="../Images/emrosesad.gif" /></td>
							</tr>
							<tr>
								<td><img alt="" src="../Images/emclock.gif" /></td>
								<td><img alt="" src="../Images/emlips.gif" /></td>
								<td><img alt="" src="../Images/emgift.gif" /></td>
								<td><img alt="" src="../Images/emcake.gif" /></td>
								<td><img alt="" src="../Images/emphoto.gif" /></td>
								<td><img alt="" src="../Images/emidea.gif" /></td>
								<td><img alt="" src="../Images/emtea.gif" /></td>
								<td><img alt="" src="../Images/emphone.gif" /></td>
							</tr>
							<tr>
								<td><img alt="" src="../Images/emhug.gif" /></td>
								<td><img alt="" src="../Images/emhug2.gif" /></td>
								<td><img alt="" src="../Images/embeer.gif" /></td>
								<td><img alt="" src="../Images/emcocktl.gif" /></td>
								<td><img alt="" src="../Images/emmale.gif" /></td>
								<td><img alt="" src="../Images/emfemale.gif" /></td>
								<td><img alt="" src="../Images/emthup.gif" /></td>
								<td><img alt="" src="../Images/emthdown.gif" /></td>
							</tr>
							<tr>
								<td><img alt="" src="../Images/emvamp.gif" /></td>
								<td><img alt="" src="../Images/emhot.gif" /></td>
								<td><img alt="" src="../Images/emrainbow.gif" /></td>
								<td><img alt="" src="../Images/ememail.gif" /></td>
								<td><img alt="" src="../Images/face1.gif" /></td>
								<td><img alt="" src="../Images/face2.gif" /></td>
								<td><img alt="" src="../Images/face3.gif" /></td>
								<td><img alt="" src="../Images/face4.gif" /></td>
							</tr>
							<tr>
								<td><img alt="" src="../Images/face5.gif" /></td>
								<td><img alt="" src="../Images/face6.gif" /></td>
								<td><img alt="" src="../Images/face7.gif" /></td>
								<td><img alt="" src="../Images/face8.gif" /></td>
								<td><img alt="" src="../Images/face9.gif" /></td>
								<td><img alt="" src="../Images/face10.gif" /></td>
								<td><img alt="" src="../Images/face11.gif" /></td>
								<td><img alt="" src="../Images/face12.gif" /></td>
							</tr>
							<tr>
								<td><img alt="" src="../Images/face13.gif" /></td>
								<td><img alt="" src="../Images/face14.gif" /></td>
								<td><img alt="" src="../Images/face15.gif" /></td>
								<td><img alt="" src="../Images/face16.gif" /></td>
								<td><img alt="" src="../Images/face17.gif" /></td>
								<td><img alt="" src="../Images/face18.gif" /></td>
								<td><img alt="" src="../Images/face19.gif" /></td>
								<td><img alt="" src="../Images/face20.gif" /></td>
							</tr>
							<tr>
								<td><img alt="" src="../Images/face21.gif" /></td>
								<td><img alt="" src="../Images/face22.gif" /></td>
								<td><img alt="" src="../Images/face23.gif" /></td>
								<td><img alt="" src="../Images/face24.gif" /></td>
								<td><img alt="" src="../Images/emkulou.gif" /></td>
								<td><img alt="" src="../Images/emfist.gif" /></td>
								<td><img alt="" src="../Images/emquestion.gif" /></td>
								<td></td>
							</tr>
						</table>
				</div>
			<br>
			<div id="container-bottom">
				<input type="button" value="<?php echo GetString("Cancel") ; ?>" class="formbutton" onclick="do_Close()">
			</div>					
		</div>
	</body>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_InsertEmotion.js"></script>
</html>
