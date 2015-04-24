<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
	$Theme="Office2007";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head ID="Head1">
		<title><?php echo GetString("MoreColors") ; ?></title>
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
		<script type="text/javascript" src="../Scripts/Dialog/Dialog_ColorPicker.js"></script>
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<style type="text/css">
			.colorcell
			{
				width:22px;
				height:11px;
				cursor:hand;
			}
			.colordiv
			{
				border:solid 1px #808080;
				width:22px;
				height:11px;
				font-size:1px;
			}
		</style>
		<script>
function DoubleHex(v)
{
	if(v<16)return "0"+v.toString(16);
	return v.toString(16);
}
function ToHexString(r,g,b)
{
	return ("#"+DoubleHex(r*51)+DoubleHex(g*51)+DoubleHex(b*51)).toUpperCase();
}
function MakeHex(z,x,y)
{
	//hor->ver
	var l=z%2
	var t=(z-l)/2
	z=l*3+t

	//left column , l/r mirrow
	if(z<3)x=5-x;
	
	//middle row , t/b mirrow
	if(z==1||z==4)y=5-y;
	
	return ToHexString(5-y,5-x,5-z);
}
var colors=new Array(216);
for(var z=0;z<6;z++)
{
	for(var x=0;x<6;x++)
	{
		for(var y=0;y<6;y++)
		{
			var hex=MakeHex(z,x,y)
			var xx=(z%2)*6+x;
			var yy=Math.floor(z/2)*6+y;
			colors[yy*12+xx]=hex;
		}
	}
}

var arr=[];
for(var i=0;i<colors.length;i++)
{
	if(i%12==0)arr.push("<tr>");
	arr.push("<td class='colorcell'><div class='colordiv' style='background-color:")
	arr.push(colors[i]);
	arr.push("' cvalue='");
	arr.push(colors[i]);
	arr.push("' title='")
	arr.push(colors[i]);
	arr.push("'>&nbsp;</div></td>");
	if(i%12==11)arr.push("</tr>");
}
		</script>
	</head>
	<body>
	<div id="ajaxdiv">
			<div class="tab-pane-control tab-pane" id="tabPane1">
				<div class="tab-row">
					<h2 class="tab selected">
						<a tabindex="-1" href='colorpicker.php?Theme=<?php echo $Theme; ?>&<?php echo $_SERVER["QUERY_STRING"]; ?>'>
							<span style="white-space:nowrap;">
								<?php echo GetString("WebPalette") ; ?>
							</span>
						</a>
					</h2>
					<h2 class="tab">
							<a tabindex="-1" href='colorpicker_basic.php?Theme=<?php echo $Theme; ?>&<?php echo $_SERVER["QUERY_STRING"]; ?>'>
								<span style="white-space:nowrap;">
									<?php echo GetString("NamedColors") ; ?>
								</span>
							</a>
					</h2>
					<h2 class="tab">
							<a tabindex="-1" href='colorpicker_more.php?Theme=<?php echo $Theme; ?>&<?php echo $_SERVER["QUERY_STRING"]; ?>'>
								<span style="white-space:nowrap;">
									<?php echo GetString("CustomColor") ; ?>
								</span>
							</a>
					</h2>
				</div>
				<div class="tab-page">
					<table cellSpacing='2' cellPadding="1" align="center">
						<script>
							document.write(arr.join(""));
						</script>
						<tr>
							<td colspan="12" height="12"><p align="left"></p>
							</td>
						</tr>
						<tr>
							<td colspan="12" valign="middle" height="24">								
					<span style="height:24px;width:50px;vertical-align:middle;"><?php echo GetString("Color") ; ?>: </span>&nbsp;
					<input type="text" id="divpreview" size="7" maxlength="7" style="width:180px;height:24px;border:#a0a0a0 1px solid; Padding:4;"/>
							</td>
						</tr>
					</table>
				</div>
			</div>
		<div id="container-bottom">
			<input type="button" id="buttonok" value="<?php echo GetString("OK") ; ?>" class="formbutton" style="width:70px"	onclick="do_insert();" /> 
			&nbsp;&nbsp;&nbsp;&nbsp; 
			<input type="button" id="buttoncancel" value="<?php echo GetString("Cancel") ; ?>" class="formbutton" style="width:70px"	onclick="do_Close();" />
		</div>
	</div>
	</body>
</html>