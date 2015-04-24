<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("Include_GetString.php") ;
?>
<script runat="server">
override protected void OnInit(EventArgs args)
{
	if(Context.Request.QueryString["IsFrame"]==null)
	{
		string FrameSrc="Thumbnail.php?IsFrame=1&"+Request.ServerVariables["QUERY_STRING"];
		CuteEditor.CEU.WriteDialogOuterFrame(Context,"<?php echo GetString("AutoThumbnail") ; ?>",FrameSrc);
		Context.Response.End();
	}
	base.OnInit(args);
}
</script>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo GetString("AutoThumbnail") ; ?> 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</title>
		
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
	</head>
	<body style="margin:0px;border-width:0px;padding:4px;">
		<form id="Form1">
			<input type="hidden" id="hiddenDirectory" name="hiddenDirectory" /> 
			<input type="hidden" id="hiddenFile" name="hiddenFile" />
			<input type="hidden" enableviewstate="false" id="hiddenAlert" name="hiddenAlert" /> 
			<input type="hidden" enableviewstate="false" id="hiddenAction" name="hiddenAction" />
		<table border="0" cellpadding="4" cellspacing="0" width="100%">
			<tr>
				<td>
					<table border="0" cellpadding="1" cellspacing="4" class="normal">
					<tr>
						<td style="white-space:nowrap"  valign="top">
							<fieldset style="height:80px;">
								<table border="0" cellpadding="1" cellspacing="0" class="normal">
									<tr>
										<td style="white-space:nowrap; width:60" ><?php echo GetString("Width") ; ?>:</td>
										<td>
											<input id="inp_width" value="80" maxlength="3" onkeyup="checkConstrains('width');"  onkeypress="return CancelEventIfNotDigit()" style="WIDTH : 70px" name="inp_width" />
										</td>
										<td rowspan="2" align="right" valign="middle"><img src="../Images/locked.gif" id="imgLock" width="25" height="32" title="<?php echo GetString("ConstrainProportions") ; ?>" /></td>
									</tr>
									<tr>
										<td><?php echo GetString("Height") ; ?>:</td>
										<td>
											<input id="inp_height" value="80" maxlength="3" onkeyup="checkConstrains('height');"  onkeypress="return CancelEventIfNotDigit()" style="WIDTH : 70px" name="inp_height" />
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="checkbox" id="constrain_prop" checked="checked" onclick="javascript:toggleConstrains();" />
											Constrain Proportions</td>
									</tr>
								</table>
							</fieldset>		
						</td>
						<td valign="top" style="white-space:nowrap" >
							<div style="width:100px; height:80px; vertical-align:top;overflow:hidden;BACKGROUND-COLOR: #ffffff;BORDER-RIGHT: buttonhighlight 1px solid;BORDER-TOP: buttonshadow 1px solid;BORDER-LEFT: buttonshadow 1px solid;BORDER-BOTTOM: buttonhighlight 1px solid;">
								<img alt="" id="img_demo" src="../Images/1x1.gif" />
							</div>
						</td>
					</tr>	
					<tr>
						<td>
							<div style="margin-top:8px;text-align:center">
								<asp:Button id="okButton" Text="  <?php echo GetString("OK") ; ?>  " OnClick="thumbnailButton_Click" />
								&nbsp;&nbsp;
								<input type="button" value="<?php echo GetString("Cancel") ?>" onclick="top.returnValue=false;top.close()" />
							</div>
						</td>
					</tr>				
				</table>
			</td>
		</tr>
		</table>
	</form>			
	</body>
</html>
	
		<script type="text/javascript">
			var obj=Window_GetDialogArguments(window);
			var src=obj.src;
			var img_demo = document.getElementById("img_demo");
			var inp_width = document.getElementById("inp_width");
			var inp_height = document.getElementById("inp_height");
			var hiddenFile=Window_GetElement(window,"hiddenFile",true);
			var hiddenAlert=Window_GetElement(window,"hiddenAlert",true);
			var hiddenDirectory=Window_GetElement(window,"hiddenDirectory",true);
			var hiddenAction=Window_GetElement(window,"hiddenAction",true);
			var defaultwidth = <?php echo secset.ThumbnailWidth ?>;
			var defaultheight = <?php echo secset.ThumbnailHeight ?>;
			
			window.onload=reset_hiddens;
			function reset_hiddens()
			{					
				if(hiddenAction.value!="")
				{					
					//clear the commands..
					if(hiddenAlert.value)
						alert(hiddenAlert.value);
					
					Window_SetDialogReturnValue(window,hiddenAction.value);
					Window_CloseDialog(window);
				}
				else
				{
					hiddenAlert.value="";
					hiddenAction.value="";
				}
				
			}
			
			SyncToView();
			
			function SyncToView()
			{
				if(src)
				{
					var img=new Image();
					img.src = src;
					img_demo.src = src;
					
					var p1 = parseInt(img.width/defaultwidth);
					var p2 = parseInt(img.height/defaultheight);
					
					if(p1>p2)
					{	
						if(img.width < defaultwidth)
						{
							alert("<?php echo GetString("ImagetooSmall") ?>");
							inp_width.value = img.width;
							inp_height.value = img.height;
						}
						else
						{
							inp_width.value = defaultwidth;
							var height = parseInt(defaultwidth*img.height/img.width);
							inp_height.value = height;
						}
					}
					else
					{
						if(img.height < defaultheight)
						{
							alert("<?php echo GetString("ImagetooSmall") ; ?>");
							inp_width.value = img.width;
							inp_height.value = img.height;
						}
						else
						{
							inp_height.value = defaultheight;
							var width = parseInt(defaultwidth*img.width/img.height);
							inp_width.value = width;
						}
					}
					hiddenFile.value=src;
					hiddenDirectory.value=obj.dir;
					do_preview();
				}
			}			
			
			
			function toggleConstrains() 
			{
				var lockImage = document.getElementById('imgLock');
				var constrains = document.getElementById('constrain_prop');

				if(constrains.checked) 
				{
					lockImage.src = "../Images/locked.gif";
					checkConstrains('width') 
				}
				else
				{
					lockImage.src = "../Images/1x1.gif";
				}
			}

			var checkingConstrains=false;

			function checkConstrains(changed) 
			{
				//if onpropertychange fired by this function..
				if(checkingConstrains)return;
	
				checkingConstrains=true;
				try
				{
					var constrains = document.getElementById('constrain_prop');

					if(constrains.checked) 
					{
						var preview_image=document.getElementById("preview_image");
						if(preview_image)
						{
							//change the size ok , because do_preview() agian
				
							//move to no-zoomed element
				
							var div=document.createElement("DIV");
							div.style.cssText='position:absolute';
							document.body.appendChild(div);
				
							div.appendChild(preview_image);
				
							preview_image.removeAttribute('width');
							preview_image.removeAttribute('height');
							preview_image.style.width=''
							preview_image.style.height=''
				
							original_width=preview_image.offsetWidth;
							original_height=preview_image.offsetHeight;
				
							div.removeNode(true);
						}
						else
						{
							var original = new Image();
							original.src = src;
							original_width= original.width;
							original_height = original.height;
						}

						if((original_width > 0) && (original_height > 0)) 
						{
							width = inp_width.value;
							height = inp_height.value;
			
							if(changed == 'width')
							{
								if ( width.length == 0 || isNaN( width ) )
								{
									inp_width.value='';
									inp_height.value='';
								}
								else
								{
									height = parseInt(width*original_height/original_width);
									inp_height.value = height;
								}
							}

							if(changed == 'height')
							{
								if ( height.length == 0 || isNaN( height ) )
								{	
									inp_width.value='';
									inp_height.value='';
								}
								else
								{
									width = parseInt(height*original_width/original_height);
									inp_width.value = width;
								}
							}
						}
					}
		
					do_preview();
				}
				finally
				{
					checkingConstrains=false;
				}
			}
			
			function do_preview()
			{				
				img_demo.width = inp_width.value;
				img_demo.height = inp_height.value;
			}	
			
		</script>
