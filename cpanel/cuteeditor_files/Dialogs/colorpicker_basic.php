<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
	$Theme="Office2007";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head runat="server">
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
		<script type="text/javascript" src="../Scripts/Dialog/Dialog_ColorPicker.js"></script>
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<style type="text/css">
			.colorcell
			{
				width:16px;
				height:17px;
				cursor:hand;
			}
			.colordiv,.customdiv
			{
				border:solid 1px #808080;
				width:16px;
				height:17px;
				font-size:1px;
			}
		</style>
		<title><?php echo GetString("NamedColors") ; ?></title>
		<script>
								
		var colorlist=[{n:'Green',h:'#008000'},{n:'Lime',h:'#00FF00'},{n:'Teal',h:'#008080'}, {n:'Aqua',h:'#00FFFF'}, {n:'Navy',h:'#000080'}, {n:'Blue',h:'#0000FF'}, {n:'Purple',h:'#800080'}, {n:'Fuchsia',h:'#FF00FF'},{n:'Maroon',h:'#800000'},{n:'Red',h:'#FF0000'},{n:'Olive',h:'#808000'},{n:'Yellow',h:'#FFFF00'},{n:'White',h:'#FFFFFF'},{n:'Silver',h:'#C0C0C0'},{n:'Gray',h:'#808080'},{n:'Black',h:'#000000'}]
		var colormore=[{n:'DarkOliveGreen',h:'#556B2F'},{n:'DarkGreen',h:'#006400'},{n:'DarkSlateGray',h:'#2F4F4F'},{n:'SlateGray',h:'#708090'},{n:'DarkBlue',h:'#00008B'},{n:'MidnightBlue',h:'#191970'},{n:'Indigo',h:'#4B0082'},{n:'DarkMagenta',h:'#8B008B'},{n:'Brown',h:'#A52A2A'},{n:'DarkRed',h:'#8B0000'},{n:'Sienna',h:'#A0522D'},{n:'SaddleBrown',h:'#8B4513'},{n:'DarkGoldenrod',h:'#B8860B'},{n:'Beige',h:'#F5F5DC'},{n:'HoneyDew',h:'#F0FFF0'},{n:'DimGray',h:'#696969'},{n:'OliveDrab',h:'#6B8E23'},{n:'ForestGreen',h:'#228B22'},{n:'DarkCyan',h:'#008B8B'},{n:'LightSlateGray',h:'#778899'},{n:'MediumBlue',h:'#0000CD'},{n:'DarkSlateBlue',h:'#483D8B'},{n:'DarkViolet',h:'#9400D3'},{n:'MediumVioletRed',h:'#C71585'},{n:'IndianRed',h:'#CD5C5C'},{n:'Firebrick',h:'#B22222'},{n:'Chocolate',h:'#D2691E'},{n:'Peru',h:'#CD853F'},{n:'Goldenrod',h:'#DAA520'},{n:'LightGoldenrodYellow',h:'#FAFAD2'},{n:'MintCream',h:'#F5FFFA'},{n:'DarkGray',h:'#A9A9A9'},{n:'YellowGreen',h:'#9ACD32'},{n:'SeaGreen',h:'#2E8B57'},{n:'CadetBlue',h:'#5F9EA0'},{n:'SteelBlue',h:'#4682B4'},{n:'RoyalBlue',h:'#4169E1'},{n:'BlueViolet',h:'#8A2BE2'},{n:'DarkOrchid',h:'#9932CC'},{n:'DeepPink',h:'#FF1493'},{n:'RosyBrown',h:'#BC8F8F'},{n:'Crimson',h:'#DC143C'},{n:'DarkOrange',h:'#FF8C00'},{n:'BurlyWood',h:'#DEB887'},{n:'DarkKhaki',h:'#BDB76B'},{n:'LightYellow',h:'#FFFFE0'},{n:'Azure',h:'#F0FFFF'},{n:'LightGray',h:'#D3D3D3'},{n:'LawnGreen',h:'#7CFC00'},{n:'MediumSeaGreen',h:'#3CB371'},{n:'LightSeaGreen',h:'#20B2AA'},{n:'DeepSkyBlue',h:'#00BFFF'},{n:'DodgerBlue',h:'#1E90FF'},{n:'SlateBlue',h:'#6A5ACD'},{n:'MediumOrchid',h:'#BA55D3'},{n:'PaleVioletRed',h:'#DB7093'},{n:'Salmon',h:'#FA8072'},{n:'OrangeRed',h:'#FF4500'},{n:'SandyBrown',h:'#F4A460'},{n:'Tan',h:'#D2B48C'},{n:'Gold',h:'#FFD700'},{n:'Ivory',h:'#FFFFF0'},{n:'GhostWhite',h:'#F8F8FF'},{n:'Gainsboro',h:'#DCDCDC'},{n:'Chartreuse',h:'#7FFF00'},{n:'LimeGreen',h:'#32CD32'},{n:'MediumAquamarine',h:'#66CDAA'},{n:'DarkTurquoise',h:'#00CED1'}
			,{n:'CornflowerBlue',h:'#6495ED'}//cornflowerblue?
			,{n:'MediumSlateBlue',h:'#7B68EE'},{n:'Orchid',h:'#DA70D6'},{n:'HotPink',h:'#FF69B4'},{n:'LightCoral',h:'#F08080'},{n:'Tomato',h:'#FF6347'},{n:'Orange',h:'#FFA500'},{n:'Bisque',h:'#FFE4C4'},{n:'Khaki',h:'#F0E68C'},{n:'Cornsilk',h:'#FFF8DC'},{n:'Linen',h:'#FAF0E6'},{n:'WhiteSmoke',h:'#F5F5F5'},{n:'GreenYellow',h:'#ADFF2F'},{n:'DarkSeaGreen',h:'#8FBC8B'},{n:'Turquoise',h:'#40E0D0'},{n:'MediumTurquoise',h:'#48D1CC'},{n:'SkyBlue',h:'#87CEEB'},{n:'MediumPurple',h:'#9370DB'},{n:'Violet',h:'#EE82EE'},{n:'LightPink',h:'#FFB6C1'},{n:'DarkSalmon',h:'#E9967A'},{n:'Coral',h:'#FF7F50'},{n:'NavajoWhite',h:'#FFDEAD'},{n:'BlanchedAlmond',h:'#FFEBCD'},{n:'PaleGoldenrod',h:'#EEE8AA'},{n:'Oldlace',h:'#FDF5E6'},{n:'Seashell',h:'#FFF5EE'},{n:'GhostWhite',h:'#F8F8FF'},{n:'PaleGreen',h:'#98FB98'},{n:'SpringGreen',h:'#00FF7F'},{n:'Aquamarine',h:'#7FFFD4'},{n:'PowderBlue',h:'#B0E0E6'},{n:'LightSkyBlue',h:'#87CEFA'},{n:'LightSteelBlue',h:'#B0C4DE'},{n:'Plum',h:'#DDA0DD'},{n:'Pink',h:'#FFC0CB'},{n:'LightSalmon',h:'#FFA07A'},{n:'Wheat',h:'#F5DEB3'},{n:'Moccasin',h:'#FFE4B5'},{n:'AntiqueWhite',h:'#FAEBD7'},{n:'LemonChiffon',h:'#FFFACD'},{n:'FloralWhite',h:'#FFFAF0'},{n:'Snow',h:'#FFFAFA'},{n:'AliceBlue',h:'#F0F8FF'},{n:'LightGreen',h:'#90EE90'},{n:'MediumSpringGreen',h:'#00FA9A'},{n:'PaleTurquoise',h:'#AFEEEE'},{n:'LightCyan',h:'#E0FFFF'},{n:'LightBlue',h:'#ADD8E6'},{n:'Lavender',h:'#E6E6FA'},{n:'Thistle',h:'#D8BFD8'},{n:'MistyRose',h:'#FFE4E1'},{n:'Peachpuff',h:'#FFDAB9'},{n:'PapayaWhip',h:'#FFEFD5'}]
		
		</script>
	</head>
	<body>
		<div id="ajaxdiv">
			<div class="tab-pane-control tab-pane" id="tabPane1">
				<div class="tab-row">
					<h2 class="tab">
						<a tabindex="-1" href='colorpicker.php?Theme=<?php echo $Theme; ?>&<?php echo $_SERVER["QUERY_STRING"]; ?>'>
							<span style="white-space:nowrap;">
								<?php echo GetString("WebPalette") ; ?>
							</span>
						</a>
					</h2>
					<h2 class="tab selected">
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
					<table class="colortable" align="center">
						<tr>
							<td colspan="16" height="16"><p align="left">Basic:
								</p>
							</td>
						</tr>
						<tr>
							<script>
								var arr=[];
								for(var i=0;i<colorlist.length;i++)
								{
			
									arr.push("<td class='colorcell'><div class='colordiv' style='background-color:")
									arr.push(colorlist[i].n);
									arr.push("' title='")
									arr.push(colorlist[i].n);
									arr.push(' ');
									arr.push(colorlist[i].h);
									arr.push("' cname='");
									arr.push(colorlist[i].n);
									arr.push("' cvalue='")
									arr.push(colorlist[i].h);
									arr.push("'></div></td>");
								}
								document.write(arr.join(""));
							</script>
						</tr>
						<tr>
							<td colspan="16" height="12"><p align="left"></p>
							</td>
						</tr>
						<tr>
							<td colspan="16"><p align="left">Additional:
								</p>
							</td>
						</tr>
						<script>
							var arr=[];
							for(var i=0;i<colormore.length;i++)
							{
								if(i%16==0)arr.push("<tr>");
								arr.push("<td class='colorcell'><div class='colordiv' style='background-color:")
								arr.push(colormore[i].n);
								arr.push("' title='")
								arr.push(colormore[i].n);
								arr.push(' ');
								arr.push(colormore[i].h);
								arr.push("' cname='");
								arr.push(colormore[i].n);
								arr.push("' cvalue='")
								arr.push(colormore[i].h);
								arr.push("'></div></td>");
								if(i%16==15)arr.push("</tr>");
							}
							if(colormore%16>0)arr.push("</tr>");
							document.write(arr.join(""));
						</script>
						<tr>
							<td colspan="16" height="8">
							</td>
						</tr>
						<tr>
							<td colspan="16" height="12">
								<input checked id="CheckboxColorNames" style="width: 16px; height: 20px" type="checkbox">
								<span style="width: 118px;">Use color names</span>
							</td>
						</tr>
						<tr>
							<td colspan="16" height="12">
							</td>
						</tr>
						<tr>
							<td colspan="16" valign="middle" height="24">
							<span style="height:24px;width:50px;vertical-align:middle;">Color : </span>&nbsp;
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

