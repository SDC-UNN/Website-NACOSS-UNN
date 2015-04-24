<?php
error_reporting(E_ALL ^ E_NOTICE);
  require("Include_Security.php") ;
  require("phpuploader/include_phpuploader.php") ;
?>
<html>
	<head>		
		<title>Upload Page</title>		
		<link href="../Themes/Office2007/dialog.css" type="text/css" rel="stylesheet" />
		<!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
	</head>
	<body>
    <?php    
      $FilePath="";
      $file_Type="";
      if (@$_GET["Type"]!="")
      {
        $file_Type=strtolower(trim($_GET["Type"]));
      }
      
      if ($file_Type!="" && @$_GET["Type"]!="FP")
      {
        $FilePath=trim($_GET["FP"]);
      }
    ?>
	<form action="filePost.php?<?php echo $setting; ?>&Theme=<?php echo $Theme; ?>&FP=<?php echo $FilePath; ?>&Type=<?php echo $file_Type; ?>" enctype="multipart/form-data" method="post">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input type="file" name="file" id="file" size="35"/>
					 </td>
					<td
					<td id="uploader">
						<input type="submit" value="upload" id="Submit1" name="Submit1"/>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
