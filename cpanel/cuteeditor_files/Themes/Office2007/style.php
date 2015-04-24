<?php
header('Content-type: text/css');
$editorid="#".$_GET["EditorID"]." ";
?>
<?php   echo $editorid; ?> {background-color:#D7E3F2!important; border: #7E9DB9 1px solid!important;}
<?php   echo $editorid; ?> IMG { border:0px;display:inline;}

<?php   echo $editorid; ?> .CuteEditorSelect { font:normal 11px Tahoma; margin-left:1px; margin-top:1px; height:20px; vertical-align:middle;}
<?php   echo $editorid; ?> .CuteEditorDropDown { float: left; border: #7E9DB9 1px solid; margin:1px 1px 1px 1px;padding:0;}
<?php   echo $editorid; ?> .CuteEditorDropDown Span {font:normal 11px Tahoma;}
<?php   echo $editorid; ?> .CuteEditorToolbar {}
<?php   echo $editorid; ?> .CuteEditorToolBarContainer {padding:3px 2px 3px 3px;height:1px;overflow-y:visible;}
<?php   echo $editorid; ?> .CuteEditorFrameContainer {width:100%;height:100%;}
<?php   echo $editorid; ?> .CuteEditorBottomBarContainer {padding:2px;height:1px;overflow-y:visible;}
<?php   echo $editorid; ?> .CuteEditorGroupMenu {margin:1px;float: left;background-image: url(Images/horizontal.background.gif); background-repeat: repeat-x; height:27px; vertical-align:middle;border-top:1px solid #A6B6C5;border:1px solid #A6B6C5;padding:1px;}
<?php   echo $editorid; ?> .CuteEditorGroupMenu span td{ vertical-align:middle}
<?php   echo $editorid; ?> .CuteEditorGroupMenuCell{ float:left;padding-left:3px;}
<?php   echo $editorid; ?> .CuteEditorGroupImage { margin:0; vertical-align:middle;float:left;}

<?php   echo $editorid; ?> .CuteEditorLineBreak {padding:0; height:0; margin:0}
<?php   echo $editorid; ?> .CuteEditorFrame {width:100%;height:100%;padding:0;margin:0;border-top: #7E9DB9 1px solid!important;border-bottom: #7E9DB9 1px solid!important;border-left: #ffffff 0 solid!important;border-right: #ffffff 0 solid!important;}
<?php   echo $editorid; ?> .CuteEditorButton { margin:1px; vertical-align:middle;}
<?php   echo $editorid; ?> .CuteEditorButtonActive { margin:0; vertical-align:middle; border:#0a246a 1px solid!important; background-color:#FFDBA3;background-image: url(Images/toolbarbutton.over.gif)}
<?php   echo $editorid; ?> .CuteEditorButtonOver { margin:0;vertical-align:middle;border:#0a246a 1px solid!important; background-color:#FFDBA3;background-image: url(Images/toolbarbutton.over.gif);}
<?php   echo $editorid; ?> .CuteEditorButtonDown { border-right: buttonhighlight 1px solid!important; border-TOP: buttonshadow 1px solid!important; border-left: buttonshadow 1px solid!important; border-bottom: buttonhighlight 1px solid!important; margin:0;vertical-align:middle; }
<?php   echo $editorid; ?> .CuteEditorButtonDisabled { filter:alpha(opacity=50);	-moz-opacity:0.5; opacity:0.5;margin:1px; vertical-align:middle;}

<?php   echo $editorid; ?> .ToolControl{}
<?php   echo $editorid; ?> .ToolControlOver{}
<?php   echo $editorid; ?> .ToolControlDown{}
<?php   echo $editorid; ?> .separator {height:24px;background-image: url(Images/Separator.gif); background-repeat: no-repeat; vertical-align:middle; width:2px;margin-left:2px; margin-right:2px;	}
<?php   echo $editorid; ?> .tagselector {font:normal 11px Tahoma;margin:0 2px 0 2px;padding:2px;cursor:hand;border: #7E9DB9 1px solid;}
<?php   echo $editorid; ?> .tagselectorOver {font:normal 11px Tahoma;margin:0 2px 0 2px;padding:2px;cursor:hand;border: #7E9DB9 1px solid;background-image: url(Images/toolbarbutton.over.gif);background-repeat: repeat-x; }
<?php   echo $editorid; ?> .WordCount {font:normal 11px Tahoma;}
<?php   echo $editorid; ?> .WordSpliter {font:normal 11px Tahoma;}
<?php   echo $editorid; ?> .CharCount {font:normal 11px Tahoma; padding-right:10px;}


/*case sensive for CSS1*/
<?php   echo $editorid; ?> #cmd_tofullpage.CuteEditorButtonActive { display:none }
<?php   echo $editorid; ?> #cmd_fromfullpage.CuteEditorButton { display:none }

.ceifdialogshadow
{
	background-color:#336699;
	position:absolute;
	left:0;
	top:0;
	width:100%;
	height:100%;
	z-index:10;
	cursor:not-allowed;
	filter:alpha(opacity=20);
	-moz-opacity:0.2;
	opacity:0.2;
}
.ceifdialog
{
	 border:0;	 
}

.ceifdialogtl{
	margin:0 auto;
	width:15px;
	height:35px;	
	background:transparent url(Images/t1.png) no-repeat;
}
.ie5ceifdialogtl{
	margin:0 auto;
	width:15px;
	height:35px;	
	background:transparent url(Images/t1.gif) no-repeat;
}
.ceifdialogtop{
	height:35px;
	overflow:hidden;
	padding:2px 5px 2px 6px;
	color:#15428b;
	cursor:move;
	font:bold 11px tahoma,arial,verdana,sans-serif;
	background:transparent url(Images/t2.png) repeat-x;
	vertical-align:bottom;
}
.ie5ceifdialogtop{
	height:35px;
	overflow:hidden;
	padding:2px 5px 2px 6px;
	color:#15428b;
	cursor:move;
	font:bold 11px tahoma,arial,verdana,sans-serif;
	background:transparent url(Images/t2.gif) repeat-x;
	vertical-align:bottom;
}
.ceifdialogtr{
	margin:0 auto;
	background:transparent url(Images/t3.png) no-repeat;
}
.ie5ceifdialogtr{
	margin:0 auto;
	background:transparent url(Images/t3.gif) no-repeat;
}
.ceifdialogtitletext
{
	float:left;
	margin-top:6px;
}
.btnClose {
	float:right;
	width:28px;
	height:15px;
	text-align:right;
	margin-top:8px;
	background:transparent url(Images/Close2.gif) no-repeat;
}
.ceifdialogleftbar{
	width:15px;
	font-size:1px;
	background:transparent url(Images/l1.png) repeat-y;
}
.ie5ceifdialogleftbar{
	width:15px;
	font-size:1px;
	background:transparent url(Images/l1.gif) repeat-y;
}
.ceifdialogrightbar{
	width:15px;
	font-size:1px;
	background:transparent url(Images/r1.png) repeat-y;
}
.ie5ceifdialogrightbar{
	width:15px;
	font-size:1px;
	background:transparent url(Images/r1.gif) repeat-y;
}
.ceifdialogcenter{
	border:1px solid #84A0C4; 
	background-color:#DFE8F6;
	color:#15428b;
}
.ceifdialogbottom{
	height:15px;
	width:100%;
	margin:0 auto;
	background:transparent url(Images/b1.png) repeat-x;
}
.ie5ceifdialogbottom{
	height:15px;
	width:100%;
	margin:0 auto;
	background:transparent url(Images/b1.gif) repeat-x;
}
.ceifdialogbottomleft{
	width:15px;
	height:15px;
	background:transparent url(Images/l2.png) no-repeat;
}
.ie5ceifdialogbottomleft{
	width:15px;
	height:15px;
	background:transparent url(Images/l2.gif) no-repeat;
}
.ceifdialogbottomright{
	width:15px;
	height:15px;
	background:transparent url(Images/r2.png) no-repeat;
}
.ie5ceifdialogbottomright{
	width:15px;
	height:15px;
	background:transparent url(Images/r2.gif) no-repeat;
}
