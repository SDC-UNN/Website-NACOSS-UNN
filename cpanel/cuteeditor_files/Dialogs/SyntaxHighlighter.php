<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo GetString("SyntaxHighlighter"); ?></title>		
		
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
	</head>
	<body>
		<div id="ajaxdiv">
			<table>
				<tr>
					<td width="80"><?php echo GetString("CodeLanguage"); ?>:</td>
					<td><select id="sel_lang"></select></td>
				</tr>
				<tr>
					<td colspan="2"><textarea id="ta_code" name="ta_code_name" style="width:400px;height:300px"></textarea></td>
				</tr>
			</table>
			
			<div id="container-bottom">
				<input type="button" value="<?php echo GetString("OK") ; ?>" class="formbutton" onclick="DoHighlight()">
				<input type="button" value="<?php echo GetString("Cancel") ; ?>" class="formbutton" onclick="Close()">
			</div>					
		</div>
	</body>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/_shCore.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushCpp.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushCSharp.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushCss.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushDelphi.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushJava.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushJScript.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushPhp.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushPython.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushRuby.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushSql.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushVb.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shBrushXml.js"></script>
	<script type="text/javascript" src="../Scripts/SyntaxHighlighter/shCore.js"></script>
	<script>
	

//----------------------------------------------------------------
//----------------------------------------------------------------

function SetCookie(name,value,seconds)
{
	var cookie=name+"="+escape(value)+"; path=/;";
	if(seconds)
	{
		var d=new Date();
		d.setSeconds(d.getSeconds()+seconds);
		cookie+=" expires="+d.toUTCString()+";";
	}
	document.cookie=cookie;
}
function GetCookie(name)
{
	var cookies=document.cookie.split(';');
	for(var i=0;i<cookies.length;i++)
	{
		var parts=cookies[i].split('=');
		if(name==parts[0].replace(/\s/g,''))
			return unescape(parts[1])
	}
	//return undefined..
}


var editor=Window_GetDialogArguments(window);
var sel_lang=document.getElementById("sel_lang")
var ta_code=document.getElementById("ta_code")



for(var brush in dp.sh.Brushes)
{
	var aliases = dp.sh.Brushes[brush].Aliases;

	if(aliases == null)
		continue;
	sel_lang.options.add(new Option(aliases,brush));
	
	var b=GetCookie("CESHBRUSH")
	if(b)sel_lang.value=b;
}

//replace with Regular Expression
function DoHighlight() {
	SetCookie("CESHBRUSH",sel_lang.value,3600*24*30);
	var b=dp.sh.Brushes[sel_lang.value];
	ta_code.language=b.Aliases[0]+":nocontrols";
	if(window.opera||!document.all)
	{
		ta_code.innerHTML=ta_code.value;//for firefox..
	}
	dp.sh.HighlightAll(ta_code.name);
	ta_code.style.display="";
	var tag=ta_code.previousSibling
	//alert(tag.innerHTML)
	editor.PasteHTML('<div class="dp-highlighter">'+tag.innerHTML+"</div>");
	tag.parentNode.removeChild(tag);
	Close();
}



	</script>
</html>