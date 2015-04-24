<?php
require("Include_Security.php") ;
error_reporting(E_ALL ^ E_NOTICE);
header("Expires: " . gmdate("D, d M Y H:i:s", time() + (-1*60)) . " GMT"); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>		
	    <title><?php echo GetString("InsertImage") ; ?> </title>
    
		<?php
		
		$Current_ImageGalleryPath=$ImageGalleryPath;
		if (@$_GET["GP"]!="")
		{
			$Current_ImageGalleryPath=$_GET["GP"];
		}
		?>
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
		<style type="text/css">
			html, body,#ajaxdiv,#Form1 {height: 100%;}
	        #browse_Img_gallery {border:0;height:500px;width:100%;vertical-align: top;overflow: auto;}
			A:link { COLOR: #000099 }	
			A:visited { COLOR: #000099 }	
			A:active { COLOR: #000099 }	
			A:hover { COLOR: darkred }
			#tooltipdiv { border: black 1px solid; padding: 2px; z-index: 100; font: menu; position: absolute }	
			#ThumbList1_MyList IMG { border:solid 2px #cccccc;}	
			</style>
	</head>
	<body>
		<div id="ajaxdiv">  
		 	<table border="0" cellspacing="0" cellpadding="2" width="100%" align="center">
				<tr>
					<td valign="top"> 
				        <iframe src="browse_Img_gallery.php?<?php echo $setting ; ?>&GP=<?php echo $Current_ImageGalleryPath; ?>&Theme=<?php echo $Theme ; ?>" id="browse_Img_gallery" frameborder="0" scrolling="auto"></iframe>
				        <input type="hidden" id="TargetUrl" onpropertychange="do_preview()" name="TargetUrl" style="width:300px;"/>
			    	</td>
				</tr>
				<tr>
					<td align="right" style="padding-top:10px; text-align:center">
<input type="button" value="<?php echo GetString("Cancel") ; ?>" class="formbutton" onclick="cancel();" />
					</td>
				</tr>
			</table>
		</div>
	</body>
	<script type="text/javascript">
	    var currentfolder = "browse_Img_gallery.php?<?php echo $setting ; ?>&GP=<?php echo $Current_ImageGalleryPath ; ?>&Theme=<?php echo $Theme ; ?>";	
	    var setting = "<?php echo $setting ; ?>";	
	</script>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_InsertGallery.js"></script>
</html>