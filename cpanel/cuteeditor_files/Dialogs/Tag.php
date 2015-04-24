<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_Security.php") ;

	$FrameSrc="Tag.Frame.php";
	if ($_SERVER["QUERY_STRING"]!="")
	{
		$FrameSrc=$FrameSrc."?".$_SERVER["QUERY_STRING"];
	} 

?>
<html>
	<head>
		<title><?php echo GetString("Properties") ; ?></title>		
	</head>
	<script>
	window.changed=false;
	top.returnValue=false;
	</script>
	<body style="margin:0px;padding:0px;border-width:0px;overflow:hidden;" scroll="no">
		<iframe id='frame' frameborder='0' style='width:100%;height:100%;' src='<?php echo $FrameSrc; ?>'></iframe>
	</body>
</html>