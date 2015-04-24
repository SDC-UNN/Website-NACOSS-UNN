<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
	
	function IsTagPattern($tagname,$pattern)
	{
		$tagname=strtolower($tagname);
		$pattern=strtolower($pattern);
		$ispattern=false;
		if ($tagname==$pattern)
		{
			$ispattern=true;
		}
		else
		{
			$tagArray=explode(",",$pattern);
			for ($j=0; $j<count($tagArray); $j=$j+1)
			{
				$str=trim($tagArray[$j]);
				if ($str=="*")
				{
					$ispattern=true;
				}
				else if ($str==$tagname)
				{
					$ispattern=true;
				}
				else if ($str=="-".$tagname)
				{
					$ispattern=false;
				} 

				if ($ispattern)
				{
					break;
				} 
			}
		} 
		return $ispattern;
	} 
	
	function GetTagDisplayName($tagname)
	{
		$TagDisplayName;
		switch (strtolower($tagname))
		{
			case "img":
				$TagDisplayName=GetString("Image");
				break;
			case "object":
				$TagDisplayName=GetString("ActiveXObject");
				break;
			case "inserttable":
				$TagDisplayName=GetString($tagname);
				break;
			default:
				$TagDisplayName=$tagname;
				break;
		} 
		return $TagDisplayName;
	} 
	
	$nocancel=false;
  $tabcontrol="";
  
	if (@$_GET["NoCancel"]=="True")
	{
		$nocancel=true;
	} 

	$tagName=$_GET["Tag"];
	$tabName=$_GET["Tab"];
	$tabName="".$tabName;

	if ($tabName=="")
	{
		if (strtolower($tagName)=="table")
		{
			$tabName="InsertTable";
		}			
		else
		{
			$tabName=$tagName;
		} 
	} 

	if (strtolower($tabName)=="textarea")
	{
		$tabName="TextBox";
	} 
	
	$doc=simplexml_load_file("Tag.config");
	if ($doc == false) {
		echo "Error while parsing the tag.config file";
		exit;
	}
?>
 
<html>
	<head>
    <title></title>
		<meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
		<meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
		<?php
			if ($nocancel)
			{
				print "<script type='text/javascript'>top.nocancel=true;</script>";
			}
			else
			{
				print "<script type='text/javascript'>top.nocancel=false;</script>";
			}		
		?>
		<script type="text/javascript" src="../Scripts/Dialog/Dialog_TagHead.js"></script>
		<style type="text/css">	 
			html, body,#ajaxdiv,#Form1 {height: 100%;}
		</style>
	</head>
	
	<body>
		
		<div id="ajaxdiv" style="padding:10px;margin:0;text-align:center; background:#eeeeee;height:100%;width:100%">
			<div class="tab-pane-control tab-pane" id="controlparent">
				<div class="tab-row">
						
							<?php							
								$index=0;
								foreach($doc->children() as $child)
								{ 									
									$objText=$child["text"];
									$objPattern=$child["pattern"];
									$objTab=$child["tab"];
									$objControl=$child["control"];
									$isactive=false;
									if (IsTagPattern($tagName,$objPattern))
									{
										if ($index==0 && $_GET["Tab"].""=="")
										{
											$isactive=true;
										} 

										if ($objTab==$tabName)
										{
											$isactive=true;
										} 
										$url=$_SERVER["PHP_SELF"];
										$url=$url."?Tag=".$_GET["Tag"];
										$url=$url."&Tab=".$objTab;
										$url=$url."&UC=".$_GET["UC"];
										$url=$url."&Theme=".$_GET["Theme"];
										$url=$url."&setting=".$_GET["setting"];
										
										if ($isactive)
										{
											$tabcontrol=$objControl;
											$tabtext=$objText;
											print "<h2 class='tab selected'>";
											print "<a tabindex='-1' href='".$url."'>";
											print "<span style='white-space:nowrap;' >";
											print $tabtext;
											print "</span>";
											print "</a>";
											print "</h2>";
										}
										else
										{
											$tabtext=$objText;
											print "<h2 class='tab'>";
											print "<a tabindex='-1' href='".$url."'>";
											print "<span style='white-space:nowrap;' >";
											print $tabtext;
											print "</span>";
											print "</a>";
											print "</h2>";
										}
										$index=$index+1;
									} 
								}
							?>
						</div>
		                <br>
			            <div class="tab-page" style="WIDTH:450px">
			<?php
				if ($tabcontrol!="")
				{
					require "Tag/".strtolower($tabcontrol);
				}
				else
				{
					require "Tag/tag_common.php";
				} 
			?>		
		                </div>
		          </div>
		        <br>
		        <div id="container-bottom">
					<input type="button" id="btn_editinwin" value="<?php echo GetString("EditHtml"); ?>" />				
					&nbsp;&nbsp;&nbsp;
					<input type="button" class="formbutton" id="btnok" value="<?php echo GetString("OK"); ?>" style="width:80px"/>&nbsp;
					<input type="button" class="formbutton" id="btncc" value="<?php echo GetString("Cancel"); ?>" style="width:80px"/>
		        </div>
		</div>
	</body>
	<script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
	<script type="text/javascript" src="../Scripts/Dialog/Dialog_TagFoot.js"></script>
</html>