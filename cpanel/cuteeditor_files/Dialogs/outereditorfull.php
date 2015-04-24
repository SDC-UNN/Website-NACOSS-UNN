<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("Include_GetString.php") ;
?>
<script runat="server">
override protected void OnInit(EventArgs args)
{
	if(Context.Request.QueryString["IsFrame"]==null)
	{
		string FrameSrc="OuterEditorFull.php?IsFrame=1&"+Request.ServerVariables["QUERY_STRING"];
		CuteEditor.CEU.WriteDialogOuterFrame(Context,"<?php echo GetString("NewTemplate") ; ?>",FrameSrc);
		Context.Response.End();
	}
	base.OnInit(args);
	this.Load += new System.EventHandler(this.Page_Load); 
}
</script>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		<title><?php echo GetString("NewTemplate") ; ?></title>
	</head>
	<body bgcolor="white">
		<form id="Form1">
			<CE:EDITOR 
					id="OuterEditor" 
					AutoConfigure="Full"
					ShowDecreaseButton="false" 
					ShowEnlargeButton="false" 
					runat="server"
					DisableItemList="print,DocumentPropertyPage,ToFullPage,FromFullPage,CssStyle,InsertTemplate"
				>
			</CE:EDITOR>
		</form>
	</body>
</html>

<script runat="server">
	void Page_Load(object sender, System.EventArgs e)
	{
		CuteEditor.ToolControl tc = OuterEditor.ToolControls["insertcustombutonhere"];
		if(tc!=null)
		{				
			System.Web.UI.WebControls.Image Image1 = new System.Web.UI.WebControls.Image ();
			Image1.ToolTip				= "Close";
			Image1.ImageUrl				= "../Themes/Office2007/Images/close.gif";
			Image1.CssClass				= "CuteEditorButton";
			SetMouseEvents(Image1);
			Image1.Attributes["onclick"]="top.returnValue=null; top.close();";
			
			System.Web.UI.WebControls.Image Image2 = new System.Web.UI.WebControls.Image ();
			Image2.ToolTip				= "Add uneditable regions";
			Image2.ImageUrl				= "../Themes/Office2007/Images/noneditable.gif";
			Image2.CssClass				= "CuteEditorButton";
			SetMouseEvents(Image2);
			Image2.Attributes["onclick"]="CuteEditor_GetEditor(this).ExecCommand('noneditable');";
			
			tc.Control.Controls.Add(Image2);
			tc.Control.Controls.Add(Image1);
		}
		
		bool isnew = true;
		
		string filename = Request.QueryString["f"];
		
		if(System.IO.File.Exists(HttpContext.Current.Server.MapPath(filename)))
		{
			isnew = false;
		}
		else
		{
			if(!filename.EndsWith(".htm")&& !filename.EndsWith(".html"))
				 filename=filename+".htm";
		}
		
		if (!IsPostBack) 
		{
			if(!isnew)
			{
				OuterEditor.LoadHtml(filename);
			}
		}
		else
		{ 
			OuterEditor.SaveFile(filename); 
			HttpContext.Current.Response.Write("<script language='javascript'>top.returnValue=true;top.close();</scr" + "ipt>");
	    } 
	    if(OuterEditor.BrowserType==BrowserType.CompatibleIE)
	    {
			OuterEditor.FullPage=true;
	    }
	}
	
	void SetMouseEvents(WebControl control)
	{
		control.Attributes["onmouseover"]="CuteEditor_ButtonCommandOver(this)";
		control.Attributes["onmouseout"]="CuteEditor_ButtonCommandOut(this)";
		control.Attributes["onmousedown"]="CuteEditor_ButtonCommandDown(this)";
		control.Attributes["onmouseup"]="CuteEditor_ButtonCommandUp(this)";
		control.Attributes["ondragstart"]="CuteEditor_CancelEvent()";
	}
</script>
