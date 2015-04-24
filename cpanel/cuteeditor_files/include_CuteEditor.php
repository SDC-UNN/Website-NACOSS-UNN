<?php
error_reporting(E_ALL ^ E_NOTICE);
if(!isset($_SESSION)) session_start();
class CuteEditor
{
  public $AccessKey;
  public $BackColor;
  public $BorderStyle;
  public $BorderWidth;
  public $BorderColor;
  public $RenderRichDropDown;
  public $ContextMenuMode;
  public $URLType;
  public $EmptyAlternateText;
  public $HyperlinkTarget;
  public $ServerName;
  public $BrowserType;
  public $ActiveTab;
  public $AllowEditServerSideCode;
  public $AllowPasteHtml;
  public $AutoConfigure;
  public $AutoParseClasses;
  public $BaseHref;
  public $BreakElement;
  public $ResizeMode;
  public $CodeViewTemplateItemList;
  public $ConfigurationPath;
  public $ConvertHTMLTagstoLowercase;
  public $CustomCulture;
  public $DisableAutoFormatting;
  public $DisableClassList;
  public $DisableItemList="";
  public $DOCTYPE;
  public $DownLevelColumns;
  public $TabSpaces;
  public $ResizeStep;
  public $DownLevelRows;
  public $UseStandardDialog;
  public $EditCompleteDocument;
  public $EditorBodyStyle;
  public $EditorBodyId;
  public $EditorBodyClass;
  public $EditorOnPaste;
  public $EditorWysiwygModeCss;
  public $EnableAntiSpamEmailEncoder;
  public $EnableBrowserContextMenu;
  public $EnableClientScript;
  public $EnableContextMenu;
  public $EnableStripScriptTags;
  public $Focus;
  public $FullPage;
  public $ToggleBorder;
  public $Height;
  public $HelpUrl;
  public $ID;
  public $MaxHTMLLength;
  public $MaxTextLength;
  public $PrintFullWebPage;
  public $ReadOnly;
  public $RemoveTBODYTag;
  public $SecurityPolicyFile;
  public $ShowBottomBar;
  public $ShowCodeViewToolBar;
  public $ShowDecreaseButton;
  public $ShowEnlargeButton;
  public $ShowGroupMenuImage;
  public $ShowHtmlMode;
  public $ShowTagSelector;
  public $ShowWordCount;
  public $ShowPreviewMode;
  public $ShowToolBar;
  public $TabIndex;
  public $TemplateItemList;
  public $TextAreaStyle;
  public $ThemeType;
  public $UseFontTags;
  public $UseHTMLEntities;
  public $UsePhysicalFormattingTags;
  public $UseRelativeLinks;
  public $UseSimpleAmpersand;
  public $Width;
  public $CssClassStyleDropDownMenuNames;
  public $CssClassStyleDropDownMenuList;
  public $ParagraphsListMenuNames;
  public $ParagraphsListMenuList;
  public $FontFacesList;
  public $FontSizesList;
  public $LinksDropDownMenuNames;
  public $LinksDropDownMenuList;
  public $CodeSnippetDropDownMenuNames;
  public $CodeSnippetDropDownMenuList;
  public $ImagesDropDownMenuNames;
  public $ImagesDropDownMenuList;
  public $MaintainAspectRatioWhenDraggingImage;
  public $EnableObjectResizing;
  public $EnableDragDrop;
  public $subsequent;
  public $ZoomsList;
  public $XHTMLOutput;
  public $MaxImageSize;
  public $MaxMediaSize;
  public $MaxFlashSize;
  public $MaxDocumentSize;
  public $MaxTemplateSize;
  public $AllowUpload;
  public $AllowCreateFolder;
  public $AllowRename;
  public $AllowDelete;
  public $ImageGalleryPath;
  public $MediaGalleryPath;
  public $FlashGalleryPath;
  public $TemplateGalleryPath;
  public $FilesGalleryPath;
  public $AbsoluteImageGalleryPath;
  public $AbsoluteMediaGalleryPath;
  public $AbsoluteFlashGalleryPath;
  public $AbsoluteTemplateGalleryPath;
  public $AbsoluteFilesGalleryPath;
  public $ImageFilters;
  public $MediaFilters;
  public $DocumentFilters;
  public $TemplateFilters;

  public $Text;
  public $s_flashpath;
  public $s_mediapath;
  public $s_documentpath;
  public $s_ParagraphsDropDownWidth;
  public $s_SizesDropDownWidth;
  public $s_ZoomsDropDownWidth;
  public $s_StylesDropDownWidth;
  public $s_CodeSnippetsDropDownWidth;
  public $s_ImagesDropDownWidth;
  public $s_FontsDropDownWidth;
  public $s_LinksDropDownWidth;
  
  private $start_time;
  private $d;
  private $l_strings;
  private $D_strings;
 
  public $FilesPath  = "cuteeditor_files";


  function GetText()
  {
    return $_POST[$this->ID];    
  } 
  
  function GetInputText()
  {
    $s_Text;
    $s_Text=$this->Text."";
    if (($this->EnableStripScriptTags))
		$s_Text = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $s_Text);
    return htmlspecialchars($s_Text); 
  } 

  public $CustomAddons;
  
  function ClientID()
  {
    return "CE_".$this->ID."_ID";    
  } 
  function ClientState()
  {
    return $this->ID."ClientState";    
  } 

//********************************************************
// Begin Event Handlers
//********************************************************

  function CuteEditor()
  {
    $this->FilesPath=dirname($this->GetWebPath(__FILE__));
    $this->ActiveTab="Edit";
    $this->AllowEditServerSideCode=false;
    $this->UseStandardDialog=false;
    $this->AllowPasteHtml=true;
    $this->AutoConfigure="Default";
    $this->AutoParseClasses=true;
    $this->BaseHref="";
    $this->BreakElement="Div";
	$this->ResizeMode="ResizeCorner";
    $this->CodeViewTemplateItemList="Save,Print,Cut,Copy,Paste,Find,ToFullPage,FromFullPage,SelectAll,SelectNone";
    $this->ConvertHTMLTagstoLowercase=true;
    $this->CustomCulture="en-en";
    $this->DisableAutoFormatting=false;
    $this->DownLevelColumns=50;
    $this->DownLevelRows=13;
    $this->TabSpaces=3;
    $this->ResizeStep=100;
    $this->DOCTYPE="";
    $this->EditCompleteDocument=false;
    $this->EditorBodyStyle="";
    $this->EditorBodyId="";
    $this->EditorBodyClass="";
    $this->EditorOnPaste="ConfirmWord";
    $this->URLType="Default";
    $this->EmptyAlternateText="ForceAdd";
    $this->HyperlinkTarget="Default";
	//ContextMenuMode = "Default"
    $this->EditorWysiwygModeCss="";
    $this->EnableAntiSpamEmailEncoder=true;
    $this->EnableBrowserContextMenu=true;
    $this->EnableClientScript=true;
    $this->EnableContextMenu=true;
    $this->EnableStripScriptTags=false;
    $this->Focus=false;
    $this->FullPage=false;
    $this->ToggleBorder=true;
    $this->Height="320";
    $this->MaxHTMLLength=0;
    $this->MaxTextLength=0;
    $this->PrintFullWebPage=false;
    $this->ReadOnly=false;
    $this->RemoveTBODYTag=false;
    $this->SecurityPolicyFile="Default.config";
    $this->ShowBottomBar=true;
    $this->ShowCodeViewToolBar=true;
    $this->ShowDecreaseButton=true;
    $this->ShowEnlargeButton=true;
    $this->ShowGroupMenuImage=true;
    $this->ShowHtmlMode=true;
    $this->ShowTagSelector=true;
    $this->ShowWordCount=true;
    $this->ShowPreviewMode=true;
    $this->ShowToolBar=true;
    $this->ThemeType="Office2007";
    $this->UseFontTags=false;
    $this->RenderRichDropDown=true;
    $this->UseHTMLEntities=true;
    $this->UsePhysicalFormattingTags=false;
    $this->UseRelativeLinks=true;
    $this->MaintainAspectRatioWhenDraggingImage=true;
    $this->EnableObjectResizing=true;
    $this->EnableDragDrop=true;
    $this->Width="780";
    $this->BackColor="#F4F4F3";
    $this->BorderColor="#dddddd";
    $this->BorderStyle="Solid";
    $this->BorderWidth=1;
    $this->HelpUrl=$this->FilesPath."/Help/default.htm";
    $this->subsequent=false;
    $this->UseSimpleAmpersand=false;
    $this->TabIndex=0;
    $this->XHTMLOutput=false;
    $this->ServerName=$_SERVER["SERVER_NAME"];
	  $this->GetAllIndexMap();   
  } 

  function GetBrowserType()
  {
    $s_BrowserType="false";
    
	global $HTTP_USER_AGENT ;

	if ( isset( $HTTP_USER_AGENT ) )
		$sAgent = $HTTP_USER_AGENT ;
	else
		$sAgent = $_SERVER['HTTP_USER_AGENT'] ;
		
	if ( strpos($sAgent, 'MSIE') !== false && strpos($sAgent, 'mac') == false && strpos($sAgent, 'Opera') == false )
	{
		$iVersion = (float)substr($sAgent, strpos($sAgent, 'MSIE') + 5, 3) ;
		if ($iVersion >= 5.5) 
			$s_BrowserType="winIE";
	}
	else if ( strpos($sAgent, 'Trident/') !== false )
	{
		$iVersion = (int)substr($sAgent, strpos($sAgent, 'Trident/') + 8, 3) ;
		$iVersion=$iVersion+4;
		$s_BrowserType="Gecko";	//IE,but use Gecko for temporary compability
	}
	else if ( strpos($sAgent, 'Gecko/') !== false )
	{
		$iVersion = (int)substr($sAgent, strpos($sAgent, 'Gecko/') + 6, 8) ;
		if ($iVersion >= 20030210) 
			$s_BrowserType="Gecko";
	}
	else if ( strpos($sAgent, 'Opera') !== false )
	{
		$iVersion = (int)substr($sAgent, strpos($sAgent, 'Opera') + 6, 1) ;
		if ($iVersion >= 9) 
          $s_BrowserType="Opera";
    }
	else if ( strpos($sAgent, 'Safari') !== false )
	{
		$iVersion = (int)substr($sAgent, strpos($sAgent, 'AppleWebKit/') + 12, 3) ;
		if ($iVersion >= 312) 
          $s_BrowserType="Safari12";
		if ($iVersion >= 522) 
          $s_BrowserType="Safari";
  }  
	if ( strpos($sAgent, 'Chrome') !== false && strpos($sAgent, 'Safari') !== false)
	{
			$s_BrowserType="Gecko";
	}   
	if ( strpos($sAgent, 'iphone') !== false || strpos($sAgent, 'windows ce') !== false || strpos($sAgent, 'blackberry') !== false || strpos($sAgent, 'opera mini') !== false || strpos($sAgent, 'mobile') !== false || strpos($sAgent, 'palm') !== false || strpos($sAgent, 'portable') !== false || strpos($sAgent, 'iPad') !== false)
	{
			$s_BrowserType="false";
	}     
    $this->BrowserType=$s_BrowserType;    
  } 

  function GetRenderRichDropdown()
  {
    if (strtolower($this->BrowserType)==="safari" || strtolower($this->BrowserType)==="safari12")
    {
      return false;
    }
    else
    {
      return $this->RenderRichDropDown;
    } 
  } 

  function GetFormatBlockCode($block)
  { 
    switch (strtolower($block))
    {
      case "normal":
        return "<P>";
        break;
      case "heading 1":
        return "<H1>";
        break;
      case "heading 2":
        return "<H2>";
        break;
      case "heading 3":
        return "<H3>";
        break;
      case "heading 4":
        return "<H4>";
        break;
      case "heading 5":
        return "<H5>";
        break;
      case "heading 6":
        return "<H6>";
        break;
      case "address":
        return "Address";
        break;
      case "formatted":
        return "Formatted";
        break;
      case "definition term":
        return "Definition Term";
        break;
      default:
        return "<P>";
        break;
    }     
  } 

  function CreateToolBar()
  {
	$s;
    if ($this->TemplateItemList!="")
    {
      $s=$this->GetToolbarFromItemList($this->TemplateItemList,$this->DisableItemList);
    }
    else
    if ($this->ConfigurationPath!="")
    {
      $s=$this->GetToolbarItems($this->ConfigurationPath,$this->DisableItemList);
    }
    else
    {
      $s=$this->GetToolbarItems("/Configuration/AutoConfigure/".$this->AutoConfigure.".config",$this->DisableItemList);
    } 
    return $s;    
  } 

  function BuildBottomBar()
  {
	$s="";
    if (($this->ShowBottomBar))
    {
      $s="<tr><td class='CuteEditorBottomBarContainer'>";
      $s=$s."<table border='0' cellspacing='0' cellpading='0' style='width:100%;'><tr><td class='CuteEditorBottomBarContainer' style='width:150px'>";
      $s=$s."<img alt=\"".$this->G_Str("Normal")."\" Command=\"TabEdit\"  src=\"".$this->ProcessThemeWebPath("design.gif")."\" border=\"0\" />";
      if ($this->ShowHtmlMode==true)
      {
        $s=$s."<img alt=\"".$this->G_Str("HTML")."\" Command=\"TabCode\"  src=\"".$this->ProcessThemeWebPath("htmlview.gif")."\" border=\"0\" />";
      }
	  if ($this->ShowPreviewMode==true)
	  {
		$s=$s."<img alt=\"".$this->G_Str("Preview")."\" Command=\"TabView\"  src=\"".$this->ProcessThemeWebPath("preview.gif")."\" border=\"0\" />";
	  } 
	  $s=$s."</td>";
	  if ($this->ShowTagSelector==true)
	  {
		$s=$s."<td><div id='".$this->ClientID()."_TagListContainer' class='CuteEditorTagListContainer'>&nbsp;</div></td>";
	  } 
	  if ($this->ShowWordCount==true)
	  {
		$s=$s."<td style='text-align:right;' nowrap='nowrap'><span class='WordCount'></span><span class='WordSpliter'>&nbsp;</span><span class='CharCount'></span></td>";
	  } 
      $s=$s."<td style='text-align:right;'>";
	  if (strtolower($this->ResizeMode)=="plusminus")
	  {
		  if ($this->ShowEnlargeButton)
		  {
			$s=$s."<img alt=\"".$this->G_Str("Enlarge")."\" Command=\"sizeplus\" src=\"".$this->ProcessThemeWebPath("plus.gif")."\" border=\"0\"/>";
		  } 

		  if ($this->ShowDecreaseButton)
		  {
			$s=$s."<img alt=\"".$this->G_Str("Decrease")."\" Command=\"sizeminus\" src=\"".$this->ProcessThemeWebPath("minus.gif")."\" border=\"0\"/>";
		  } 
	  }
	  else
	  {
		if (strtolower($this->ResizeMode)=="resizecorner")
		{
			$s=$s."<img alt=\"".$this->G_Str("Resize")."\" ondragstart=\"return false\" onmouseover=\"(CuteEditor_GetEditor(this).RegisterResizeCornor||function(){})(this.parentNode)\" src=\"".$this->GetURL("Images/ResizeCorner.gif")."\" border=\"0\"/>";
		}	  
	  }


      $s=$s."</td>";
      $s=$s."</tr></table>";
      $s=$s."</td></tr>";
    } 
    return $s;    
  } 


  function EditorInitialise()
  {    	
    switch (strtolower($this->BrowserType))
    {
      case "safari12":
        $loaderFolder="Safari12_Loader";
        break;
      case "safari":
        $loaderFolder="Gecko_Loader";
        break;
      case "opera":
        $loaderFolder="Opera_Loader";
        break;
      case "gecko":
        $loaderFolder="Gecko_Loader";
        break;
      case "winie":
        $loaderFolder="IE_Loader";
        break;
    } 
    if ($this->subsequent==false)
    {
		$t="<script language=\"JavaScript\">";
		$t=$t."var CE_Editor1_IDSettingClass_Strings={";
		$t=$t.$this->GetClientStrings();
		$t=$t."'':''};";
		$t=$t."</script>";
    }
    $t=$t."<script language=\"JavaScript\" src=\"".$this->FilesPath."/Scripts/".$loaderFolder."/Loader.js\"></script>";
    mt_srand((double)microtime()*1000000);
    $t=$t."<img src=\"".$this->FilesPath."/Images/1x1.gif?".(mt_rand(0,10000000)/10000000)."\"";
    $t=$t." onload=\"CuteEditorInitialize('".$this->ClientID()."',{";
    $t=$t."'_ClientID':'".$this->ClientID()."',";
    $t=$t."'_UniqueID':'".$this->ID."',";
    $t=$t."'_FrameID':'".$this->ClientID()."_Frame',";
    $t=$t."'_ToolBarID':'".$this->ClientID()."_ToolBar',";
    $t=$t."'_CodeViewToolBarID':'".$this->ClientID()."_CodeViewToolBar',";
    $t=$t."'_HiddenID':'".$this->ID."',";
    $t=$t."'_StateID':'".$this->ClientState()."',";
    $t=$t."'Culture':'".$this->CustomCulture."',";
    $t=$t."'Theme':'".$this->ThemeType."',";
    $t=$t."'ResourceDir':'".$this->FilesPath."',";
    $t=$t."'ActiveTab':'".$this->ActiveTab."',";
    $t=$t."'ToggleBorder':'".$this->ToggleBorder."',";
    $t=$t."'FullPage':'".$this->booleanToString($this->FullPage)."',";
    if ($this->ContextMenuMode!="")
    {
      $t=$t."'ContextMenuMode':'".$this->ContextMenuMode."',";
    }
    else
    {
      $t=$t."'ContextMenuMode':'".$this->AutoConfigure."',";
    } 

    $t=$t."'EnableBrowserContextMenu':'".$this->booleanToString($this->EnableBrowserContextMenu)."',";
    $t=$t."'EnableContextMenu':'".$this->booleanToString($this->EnableContextMenu)."',";
    $t=$t."'FocusOnLoad':'".$this->booleanToString($this->Focus)."',";
    $t=$t."'ConvertHTMLTagstoLowercase':'".$this->booleanToString($this->ConvertHTMLTagstoLowercase)."',";
    $t=$t."'RemoveTBODYTag':'".$this->booleanToString($this->RemoveTBODYTag)."',";
    $t=$t."'AllowEditServerSideCode':'".$this->booleanToString($this->AllowEditServerSideCode)."',";
    $t=$t."'UseStandardDialog':'".$this->booleanToString($this->UseStandardDialog )."',";   
    $t=$t."'EnableAntiSpamEmailEncoder':'".$this->booleanToString($this->EnableAntiSpamEmailEncoder)."',";
    $t=$t."'EnableStripScriptTags':'".$this->booleanToString($this->EnableStripScriptTags)."',";
    $t=$t."'MaxHTMLLength':'".$this->MaxHTMLLength."',";
    $t=$t."'MaxTextLength':'".$this->MaxTextLength."',";
    $t=$t."'TabSpaces':'".$this->TabSpaces."',";
    $t=$t."'ResizeStep':'".$this->ResizeStep."',";
    $t=$t."'BreakElement':'".$this->BreakElement."',";
    $t=$t."'ResizeMode':'".$this->ResizeMode."',";
    $t=$t."'URLType':'".$this->URLType."',";
    $t=$t."'EmptyAlternateText':'".$this->EmptyAlternateText."',";
    $t=$t."'HyperlinkTarget':'".$this->HyperlinkTarget."',";
    $t=$t."'ServerName':'".$this->ServerName."',";
    $t=$t."'AllowPasteHtml':'".$this->booleanToString($this->AllowPasteHtml)."',";
    $t=$t."'EncodeHiddenValue':'False',";
    $t=$t."'UseSimpleAmpersand':'".$this->booleanToString($this->UseSimpleAmpersand)."',";
    $t=$t."'UsePhysicalFormattingTags':'".$this->booleanToString($this->UsePhysicalFormattingTags)."',";
    $t=$t."'EnableObjectResizing':'".$this->booleanToString($this->EnableObjectResizing)."',";
    $t=$t."'EnableDragDrop':'".$this->booleanToString($this->EnableDragDrop)."',";
    $t=$t."'MaintainAspectRatioWhenDraggingImage':'".$this->booleanToString($this->MaintainAspectRatioWhenDraggingImage)."',";
    $t=$t."'UseFontTags':'".$this->booleanToString($this->UseFontTags)."',";
    $t=$t."'RenderRichDropDown':'".$this->GetRenderRichDropdown()."',";
    $t=$t."'UseHTMLEntities':'".$this->UseHTMLEntities."',";
    $t=$t."'EditorOnPaste':'".$this->EditorOnPaste."',";
    $t=$t."'EditorWysiwygModeCss':'".$this->EditorWysiwygModeCss."',";
    $t=$t."'HelpPath':'".$this->HelpUrl."',";
    $t=$t."'PrintFullWebPage':'".$this->booleanToString($this->PrintFullWebPage)."',";
    $t=$t."'ReadOnly':'".$this->booleanToString($this->ReadOnly)."',";
    $t=$t."'EditCompleteDocument':'".$this->booleanToString($this->EditCompleteDocument)."',";
    $t=$t."'DOCTYPE':'".htmlspecialchars($this->DOCTYPE)."',";
    $t=$t."'BaseHref':'".$this->BaseHref."',";
    $t=$t."'EditorBodyStyle':'".$this->EditorBodyStyle."',";
    $t=$t."'EditorBodyId':'".$this->EditorBodyId."',";
    $t=$t."'EditorBodyClass':'".$this->EditorBodyClass."',";
    $t=$t."'Theme':'".$this->ThemeType."',";
    $t=$t."'XHTMLOutput':'".$this->booleanToString($this->XHTMLOutput)."',";
    $t=$t."'EditorSetting':'".$this->EditorSetting()."'})\"";
    if (strtolower($this->BrowserType)!="opera")
    {
      $t=$t." style=\"display:none;\"";
    } 
    $t=$t."/>";
    return $t;    
  } 

  function editorClientScript()
  { 
	$s = "";
    if ($this->subsequent==false)
    {
      $s="<script language=\"JavaScript\" SRC=\"".$this->FilesPath."/Scripts/Constant.js\"></script>";
    } 
    return $s;    
  } 

  function editorStylesheet()
  {
    return "<link href='".$this->FilesPath."/Themes/".$this->ThemeType."/style.php?EditorID=".$this->ClientID()."' type='text/css' rel='stylesheet'/>";
  } 

  function Draw()
  {
    echo $this->GetString();    
  } 

  function GetString()
  {
	$this->GetBrowserType(); 
	$this->GetAllStringByCulture($this->CustomCulture);
	$s = "";
	$t = "";
    if (!$this->EnableClientScript || $this->BrowserType=="false")
    {
      if ($this->AccessKey!="")
      {
        $t=$t." AccessKey=\"".$this->AccessKey."\"";
      } 
      $s="<textarea name=\"".$this->ID."\" id='".$this->ID."' ".$t." rows=\"".$this->DownLevelRows."\" cols=\"".$this->DownLevelColumns."\" style=\"width: ".$this->Width."; height: ".$this->Height."\" ID=\"".$this->ID."\">".$this->GetInputText()."</textarea>";
    }
    else
    {
      $s=$s." <!-- CuteEditor Version 6.6 ".$this->ID." Begin --> "."\r\n";
      if (strtolower($this->BrowserType)=="safari12")
      {
        $s="<input name=\"".$this->ID."\" id='".$this->ID."' type=hidden value='".$this->GetInputText()."'>";
      }
       else
      {
        $s=$s."<textarea name='".$this->ID."' id='".$this->ID."' rows='".$this->DownLevelRows."' cols='".$this->DownLevelColumns."' class='CuteEditorTextArea' style='DISPLAY: none; WIDTH: 100%; HEIGHT: 100%'>".$this->GetInputText()."</textarea>";
      } 
      $s=$s.$this->editorClientScript();
      $s=$s.$this->editorStylesheet();
      $s=$s."";
      if ($this->TabIndex!=0)
      {
        $t="TabIndex=".$this->TabIndex;
      } 

      if ($this->AccessKey!="")
      {
        $t=$t." AccessKey=\"".$this->AccessKey."\"";
      } 

      $this->start_time=$this->getmicrotime();
      $s=$s."<input type=hidden name=\"".$this->ClientState()."\" value=''/>";
      $s=$s."<table ".$t." id=\"".$this->ClientID()."\" _IsCuteEditor=\"True\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color:".$this->BackColor.";border-color:".$this->BorderColor.";border-width:".$this->BorderWidth."px;border-style:".$this->BorderStyle.";table-layout:auto;height:".$this->Height."px;width:".$this->Width."px;\">";
      $s=$s."<tr><td class=\"CuteEditorToolBarContainer\" unselectable='on' valign='top'>";
      $s=$s."<div id=\"".$this->ClientID()."_ToolBar\" style=\"display:none;\">";
      if (strtolower($this->ShowToolBar)==true)
      {
        $s=$s.$this->CreateToolBar();
        if ($this->CustomAddons!="")
        {
         // $s=$s.$this->CustomAddons;
         $s = str_replace("##HOLDER##", $this->CustomAddons, $s);
        } 
        else
        {
         $s = str_replace("##HOLDER##", "", $s);
        }
      } 
      $s=$s."</div>";
      $s=$s."<div id=\"".$this->ClientID()."_CodeViewToolBar\" style=\"display:none;\">";

      if (strtolower($this->ShowCodeViewToolBar)==true)
      {

        $s=$s.$this->GetToolbarFromItemList($this->CodeViewTemplateItemList,$this->DisableItemList);
      } 
      $s=$s."</div>";
      $s=$s."</td></tr>";
      $s=$s."<tr><td class=\"CuteEditorFrameContainer\">";
      $s=$s."<iframe id=\"".$this->ClientID()."_Frame\" src=\"".$this->GetURL("template.php")."\" FrameBorder=\"0\" class=\"CuteEditorFrame\" spellcheck=\"false\" style=\"background-color:White;border-color:#dddddd;border-width:1px;border-style:Solid;height:100%;width:100%;\"></iframe>";
      $s=$s."</td></tr>";
      $s=$s.$this->BuildBottomBar();
      $s=$s."</table>";
      $s=$s.$this->EditorInitialise();
      $s=$s."\r\n<!-- CuteEditor ".$this->ID." End ".round(($this->getmicrotime() - $this->start_time), 3)."s--> "."\r\n";
    } 
    return $s;    
  } 

//--------------------------------------	

  function EditorSetting()
  {
	$s="";
    if (($this->MaxImageSize)!="")
    {
      $s=$s.$this->MaxImageSize."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("MaxImageSize")."|";
    } 
    if (($this->MaxMediaSize)!="")
    {
      $s=$s.$this->MaxMediaSize."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("MaxMediaSize")."|";
    } 
    if (($this->MaxFlashSize)!="")
    {
      $s=$s.$this->MaxFlashSize."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("MaxFlashSize")."|";
    } 

    if (($this->MaxDocumentSize)!="")
    {
      $s=$s.$this->MaxDocumentSize."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("MaxDocumentSize")."|";
    } 
    
    if (($this->MaxTemplateSize)!="")
    {
      $s=$s.$this->MaxTemplateSize."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("MaxTemplateSize")."|";
    } 

    if (($this->ImageGalleryPath)!="")
    {
      $s=$s.$this->ImageGalleryPath."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("ImageGalleryPath")."|";
    } 

    if (($this->MediaGalleryPath)!="")
    {
      $s=$s.$this->MediaGalleryPath."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("MediaGalleryPath")."|";
    } 

    if (($this->FlashGalleryPath)!="")
    {
      $s=$s.$this->FlashGalleryPath."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("FlashGalleryPath")."|";
    } 

    if (($this->TemplateGalleryPath)!="")
    {
      $s=$s.$this->TemplateGalleryPath."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("TemplateGalleryPath")."|";
    } 

    if (($this->FilesGalleryPath)!="")
    {
      $s=$s.$this->FilesGalleryPath."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("FilesGalleryPath")."|";
    } 

    if ($this->AllowUpload!="")
    {
      $s=$s.$this->AllowUpload."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("AllowUpload")."|";
    } 

    if (($this->AllowCreateFolder)!="")
    {
      $s=$s.$this->AllowCreateFolder."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("AllowCreateFolder")."|";
    } 

    if (($this->AllowRename)!="")
    {
      $s=$s.$this->AllowRename."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("AllowRename")."|";
    } 
    if (($this->AllowDelete)!="")
    {
      $s=$s.$this->AllowDelete."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("AllowDelete")."|";
    } 

    if (($this->ImageFilters)!="")
    {
      $s=$s.$this->ImageFilters."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("ImageFilters")."|";
    } 

    if (($this->MediaFilters)!="")
    {
      $s=$s.$this->MediaFilters."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("MediaFilters")."|";
    } 

    if (($this->DocumentFilters)!="")
    {
      $s=$s.$this->DocumentFilters."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("DocumentFilters")."|";
    } 

    if (($this->TemplateFilters)!="")
    {
      $s=$s.$this->TemplateFilters."|";
    }
    else
    {
      $s=$s.$this->G_SettingFromSecurityPolicyFile("TemplateFilters")."|";
    } 
      
    $s=$s.$this->CustomCulture."|";
    $s=$s.$this->AbsoluteImageGalleryPath."|";
    $s=$s.$this->AbsoluteMediaGalleryPath."|";
    $s=$s.$this->AbsoluteFlashGalleryPath."|";
    $s=$s.$this->AbsoluteTemplateGalleryPath."|";
    $s=$s.$this->AbsoluteFilesGalleryPath."|";
    $s=$s.$this->G_SettingFromSecurityPolicyFile("DemoMode")."|";
	  $this->initCodecs();
	  $s=$this->base64Encode($s);
	  $_SESSION['CESecurity']=$s;
    return $s;
  }
  function G_SettingFromSecurityPolicyFile($instring)
  {		
	$xml;	
	$item;
	$xml=simplexml_load_file( $this->fixURL("/Configuration/Security/".$this->SecurityPolicyFile));
	if ($xml == false) {
		echo "Error while parsing the Security Policy File: Configuration/Security/".$this->SecurityPolicyFile;
		exit;
	}
	
	if(strpos($instring,"Filters")==false)
	{
		$item=$xml->xpath('//security[@name="'.$instring.'"]');		
		return $item[0];     
    }
    else
    {
		$items=$xml->xpath('//security[@name="'.$instring.'"]/item');
		$s="";
		foreach ($items as $v) {
   			$s=$s.$v.",";
		}	
		
		if (substr($s,strlen($s)-(1))==",")
		{
			$s=substr($s,0,strlen($s)-1);
		}			
		return $s;      
    }
  }
  
  function last_index_of($sub_str,$instr) { 
	if(strstr($instr,$sub_str)!="") { 
		return(strlen($instr)-strpos(strrev($instr),$sub_str)); 
	} 
	return(-1); 
  }

  function LoadFile($FilePath)
  {
	$this-LoadHTML($FilePath);
  }	
  function LoadHTML($FilePath)
  {
	$FilePath=$this->ServerMapPath($FilePath);
    if (file_exists($FilePath) && is_readable ($FilePath)) 
    {
		$s="";
		$file_handle = fopen($FilePath, "r");
		while (!feof($file_handle)) {
			$s .=fgets($file_handle);
		}
		fclose($file_handle);
		$this->Text=$s;
    }
    else
    {    
		if (!file_exists($FilePath))
		{
		  $this->Text="File ".$FilePath." doesn't exist";
		}
		elseif (!is_readable($FilePath))
		{
		  $this->Text="File ".$FilePath." is not readable.";
		}      
    }    
  } 
  
	function GetAllStringByCulture($culture)
    { 
		$xml = simplexml_load_file($this->fixURL("/Languages/".$culture.".xml"));    
		if ($xml == false) {
			echo "Error while parsing the Languages file" . "Languages/".$culture.".xml";
			exit;
		}
		$this->l_strings = array();
		foreach($xml->children() as $child)
		{ 
			if($child["name"]!=null && $child!=null)
			{
				$this->l_strings[strtolower((string)$child["name"])]=$child;
			}
		}
		
		$xml = simplexml_load_file($this->fixURL("/Languages/en-en.xml"));     
		
		if ($xml == false) {
			echo "Error while parsing the Languages file: " . "Languages/en-en.xml";
			exit;
		}
		
		$this->D_strings = array();
		foreach($xml->children() as $child)
		{ 
			if($child["name"]!=null && $child!=null)
			{
				$this->D_strings[strtolower((string)$child["name"])]=$child;
			}
		}
    }
      
    function GetAllIndexMap()
    {       
		$this->d["save"]="0";
		$this->d["newdoc"]="1";
		$this->d["print"]="2";
		$this->d["bspreview"]="3";
		$this->d["find"]="4";
		$this->d["fit"]="5";
		$this->d["restore"]="6";
		$this->d["cleanup"]="7";
		$this->d["spell"]="8";
		$this->d["cut"]="9";
		$this->d["copy"]="10";
		$this->d["paste"]="11";
		$this->d["pastetext"]="12";
		$this->d["pasteword"]="13";
		$this->d["pasteashtml"]="14";
		$this->d["delete"]="15";
		$this->d["undo"]="16";
		$this->d["redo"]="17";
		$this->d["insertpagebreak"]="18";
		$this->d["insertdate"]="19";
		$this->d["timer"]="20";
		$this->d["specialchar"]="21";
		$this->d["emotion"]="22";
		$this->d["keyboard"]="23";
		$this->d["box"]="24";
		$this->d["layer"]="25";
		$this->d["groupbox"]="26";
		$this->d["image"]="27";
		$this->d["eximage"]="28";
		$this->d["flash"]="29";
		$this->d["media"]="30";
		$this->d["document"]="31";
		$this->d["template"]="32";
		$this->d["youtube"]="33";
		$this->d["insrow_t"]="34";
		$this->d["insrow_b"]="35";
		$this->d["delrow"]="36";
		$this->d["inscol_l"]="37";
		$this->d["inscol_r"]="38";
		$this->d["delcol"]="39";
		$this->d["inscell"]="40";
		$this->d["delcell"]="41";
		$this->d["row"]="42";
		$this->d["cell"]="43";
		$this->d["mrgcell_r"]="44";
		$this->d["mrgcell_b"]="45";
		$this->d["spltcell_r"]="46";
		$this->d["spltcell_b"]="47";
		$this->d["break"]="48";
		$this->d["paragraph"]="49";
		$this->d["left_to_right"]="50";
		$this->d["right_to_left"]="51";
		$this->d["form"]="52";
		$this->d["textarea"]="53";
		$this->d["textbox"]="54";
		$this->d["passwordfield"]="55";
		$this->d["hiddenfield"]="56";
		$this->d["listbox"]="57";
		$this->d["dropdownbox"]="58";
		$this->d["optionbutton"]="59";
		$this->d["checkbox"]="60";
		$this->d["imagebutton"]="61";
		$this->d["submit"]="62";
		$this->d["reset"]="63";
		$this->d["pushbutton"]="64";
		$this->d["page"]="65";
		$this->d["bold"]="66";
		$this->d["italic"]="67";
		$this->d["under"]="68";
		$this->d["left"]="69";
		$this->d["center"]="70";
		$this->d["right"]="71";
		$this->d["justifyfull"]="72";
		$this->d["justifynone"]="73";
		$this->d["unformat"]="74";
		$this->d["numlist"]="75";
		$this->d["bullist"]="76";
		$this->d["indent"]="77";
		$this->d["outdent"]="78";
		$this->d["superscript"]="79";
		$this->d["subscript"]="80";
		$this->d["strike"]="81";
		$this->d["ucase"]="82";
		$this->d["lcase"]="83";
		$this->d["rule"]="84";
		$this->d["link"]="85";
		$this->d["unlink"]="86";
		$this->d["anchor"]="87";
		$this->d["imagemap"]="88";
		$this->d["abspos"]="89";
		$this->d["forward"]="90";
		$this->d["backward"]="91";
		$this->d["borders"]="92";
		$this->d["selectall"]="93";
		$this->d["selectnone"]="94";
		$this->d["help"]="95";           
    } 
            
	function GetImageThemeIndex($cmdname)
	{
	  return $this->d[strtolower($cmdname)]; // unknown dictionary method;              
	} 

  
	// encode base 64 encoded string
	function base64Encode($plain)
	{
		return base64_encode($plain);    
	} 
	
	function initCodecs()
	{
	} 
	function IsArrayEmpty($varArray)
	{
		return false;
	} 	

	function SaveFile($File)
	{			
		$File=$this->ServerMapPath($File);
		$s=stripslashes($this->GetText());
		if (strlen($s)==0)
		{
		  echo "";
		}
		else
		{	  
			$Handle = fopen($File, 'w');
			fwrite($Handle, $s); 
			fclose($Handle); 
			$this->Text=$s;
		}     
	} 

	function SaveButton()
	{
	return "<INPUT type=\"image\" src=\"".$this->ProcessThemeWebPath("save.gif")."\" name=\"Save\" title=\"".$this->G_Str("Save")."\" class=\"CuteEditorButton\">";
	} 

	function GetURL($path)
	{ 	
		if (substr($path,strlen($path)-(1))=="/")
		{
			$path=substr($path,0,strlen($path)-1);
		}
		
		return "".$this->FilesPath."/".$path;    
	} 
	
	function fixURL($path)
	{ 	
		return dirname(__FILE__).$path;    
	} 

	function ProcessThemeWebPath($imageURL)
	{
		switch (strtolower($this->ThemeType))
		{
		  case "office2003blue":
			return $this->GetURL("Themes/Office2003Blue/Images/".$imageURL);
			break;
		  case "office2007":
			return $this->GetURL("Themes/Office2007/Images/".$imageURL);
			break;
		  case "office2003":
			return $this->GetURL("Themes/Office2003/Images/".$imageURL);
			break;
		  case "officexp":
			return $this->GetURL("Themes/OfficeXp/Images/".$imageURL);
			break;
		}     
	} 

	function G_Str($instring)
	{
		$t="";
		$instring=(string)$instring;
		$instring=strtolower($instring);
		if (array_key_exists($instring,$this->l_strings))
		{
			$t=$this->l_strings[$instring];
		}		
		
		if ($t=="")
		{			
			if (array_key_exists($instring,$this->D_strings))
			{
				$t=$this->D_strings[$instring];
			}		
		} 
		if ($t=="")
		{
		  $t="{".$instring."}";
		} 
		return $t;    
	} 

	function GetClientStrings()
	{     
		$s="";
		while (list($key, $val) = each($this->l_strings)) {
			$s = $s ."\"".strtolower($key)."\":\"". $val . "\",";
		}
	    return $s;
	}
  

	function GetToolbarFromItemList($templatelist,$d_list)
	{
		if (strtolower($this->BrowserType)!="winie")
		{
		  $d_list=$d_list.",zoom";
		} 
		
		if ($this->BrowserType=="Safari12")
		{
			$d_list=$d_list.",zoom,find,insertorderedlist,insertunorderedlist,indent,outdent,imagemap,strikethrough";
		} 
		    
		$s="";
		$xml = simplexml_load_file($this->fixURL("/Configuration/AutoConfigure/Full.config"));
		if ($xml == false) {
			echo "Error while parsing the toolbar configuration file" . $cfgfilename."";
			exit;
		}
		$d_Array;
		$d_Array=explode(",",strtolower($d_list));
		$Toolbar_Array;
		$Toolbar_Array=explode(",",strtolower($templatelist));
		
		foreach ($Toolbar_Array as $item) {
			$item=trim($item);
			$is_disabled;
			$is_disabled=false;
			if ($item!=null&&$item!="")
			{
				if (in_array(strtolower($item),$d_Array))
					$is_disabled=true;
			}
			if(!$is_disabled)
			{
				switch (strtolower($item))
				{
				  case "g_start":
					$s=$s.$this->AddToolbarGroupStart();
					break;
				  case "g_end":
					$s=$s.$this->AddToolbarGroupEnd();
					break;
				  case "separator":
					$s=$s.$this->AddToolbarSeparator();
					break;
				  case "holder":
					$s=$s."##HOLDER##";
					break;
				  case "linebreak":
					$s=$s.$this->AddToolbarLineBreak();
					break;
				  case "table":
					$s=$s.$this->AddToolbarTable();
					break;
				  case "forecolor":
					$s=$s.$this->AddToolbarForeColor();
					break;
				  case "backcolor":
					$s=$s.$this->AddToolbarBackColor();
					break;
				  default:
					foreach ($xml->toolbars[0]->item as $item2) 
					{
						if($item2['name']!=null && $item2['name']!="" && strtolower($item2['visible'])!="false")
						{
							if(strtolower($item2['name'])==strtolower($item))
							{
								switch (strtolower($item2['type']))
								{
									case "dropdown":
										if ($item2['name']!=null)
										{
										$n=$item2['name'];
										$c="PasteHTML";
										if ($item2['command']!=null)
										{
											$c=$item2['command'];
										} 
										$w="40";
										if ($item2['width']!=null)
										{
											$w=$item2['width'];
										} 
										$s=$s.$this->AddToolbarDropDown($n,$c,$w);
										} 
										break;
									case "image":
										if ($item2['name']!=null)
										{
										$n=$item2['name'];
										$c=$n;
										$t=$n;
										if ($item2['command']!=null)
										{
											$c=$item2['command'];
										} 
										if ($item2['imagename']!=null)
										{
											$t=$item2['imagename'];
										} 
										$s=$s.$this->AddToolbarItem($n,$c,$t,20,20);
										} 
										break;
								} 
								
							}
						}	
					}		
					break;
				} 
			}
				
		}		
		return $s;       
	}
	       
	function GetToolbarItems($cfgfilename,$d_list)
	{
		if (strtolower($this->BrowserType)!="winie")
		{
		  $d_list=$d_list.",zoom";
		} 

		if ($this->BrowserType=="Safari12")
		{
			$d_list=$d_list.",zoom,find,insertorderedlist,insertunorderedlist,indent,outdent,imagemap,strikethrough";
		} 
		    
		$s="";
		$xml = simplexml_load_file($this->fixURL($cfgfilename));
		if ($xml == false) {
			echo "Error while parsing the toolbar configuration file" . $cfgfilename."";
			exit;
		}
		$d_Array;
		$d_Array=explode(",",strtolower($d_list));
		
		foreach ($xml->toolbars[0]->item as $item) 
		{
			$is_disabled;
			$is_disabled=false;
			if ($item['type']!=null&&$item['type']!="")
			{
				if (in_array(strtolower($item['type']),$d_Array))
					$is_disabled=true;
			}
			if ($item['name']!=null&&$item['name']!="")
			{
				if (in_array(strtolower($item['name']),$d_Array))
					$is_disabled=true;
			}
			if(!$is_disabled)
			{
				switch (strtolower($item['type']))
				{
				  case "g_start":
					$s=$s.$this->AddToolbarGroupStart();
					break;
				  case "g_end":
					$s=$s.$this->AddToolbarGroupEnd();
					break;
				  case "separator":
					$s=$s.$this->AddToolbarSeparator();
					break;
				  case "linebreak":
					$s=$s.$this->AddToolbarLineBreak();
					break;
				  case "table":
					$s=$s.$this->AddToolbarTable();
					break;
				  case "forecolor":
					$s=$s.$this->AddToolbarForeColor();
					break;
				  case "backcolor":
					$s=$s.$this->AddToolbarBackColor();
					break;
				  case "dropdown":
					if ($item['name']!=null)
					{
					  $n=$item['name'];
					  $c="PasteHTML";
					  if ($item['command']!=null)
					  {
						$c=$item['command'];
					  } 
					  $w="40";
					  if ($item['width']!=null)
					  {
						$w=$item['width'];
					  } 
					  $s=$s.$this->AddToolbarDropDown($n,$c,$w);
					} 
					break;
				  case "holder":
					$s=$s."##HOLDER##";
					break;
				  case "image":
					if ($item['name']!=null)
					{
					  $n=$item['name'];
					  $c=$n;
					  $t=$n;
					  if ($item['command']!=null)
					  {
						$c=$item['command'];
					  } 
					  if ($item['imagename']!=null)
					  {
						$t=$item['imagename'];
					  } 
					  $s=$s.$this->AddToolbarItem($n,$c,$t,20,20);
					} 
					break;
				  default:
					$s=$s.$this->AddToolbarSeparator();
					break;
				} 
			}
				
		}		
		return $s;       
	}     

	function AddToolbarDropDownfromConfig($name,$command,$width)
	{
		$s="";	
		$xml="";	
		$xml=simplexml_load_file( $this->fixURL("/Configuration/Shared/Common.config"));

		if ($xml == false) {
			echo "Error while parsing the Configuration file" . "Configuration/Shared/Common.config";
			exit;
		}
				 
		if (strtolower($this->GetRenderRichDropdown())!=true || $this->BrowserType=="safari12" || $this->BrowserType=="safari")
		{	
			$s="<select class='CuteEditorSelect' id='".$this->ClientID().strtolower($name)."' Command='".$command."' ";
			$s=$s."onchange=\"CuteEditor_DropDownCommand(this,'".$command."')\" >";
			$s=$s."<option value=\"\" >".$this->G_Str($name)."</option>";
					   
			$items;
			$t;
			$v;
			$h;
			$o;
			$items= $xml->xpath("/configuration/dropdowns/".$name."/item");
			while(list( , $item) = each($items)) 
			{		
				$t=$item["text"];
				if($t!="" && $t != null)
				{
					$v=$t;
					$h=$t;
					$o=$t;
					if (substr($t,0,2)=="[[")
					{
					  $t=substr($t,2,strlen($t)-4);
					  $t=$this->G_Str($t);
					} 

					if($item["value"]!="" && $item["value"] != null)
					{
						$v=$item["value"];
					}					

					if($item->value!="" && $item->value!= null)
					{
						$v=$item->value;
					}	
					
					$v=htmlspecialchars($v);		
					
					$s=$s."<option value='".$v."'>".$t."</option>";
				} 
			}
			$s=$s."</select>";
		}
		else
		{
			$s="<span class='CuteEditorDropDown' id='".$this->ClientID().strtolower($name)."' Command='".$command."' ";
			$s=$s."onchange=\"CuteEditor_DropDownCommand(this,'".$command."')\" RichHideFirstItem='true' _IsRichDropDown='True' style='display:inline-block;width:".$width."px;height:20px;'>";
			$s=$s."<span val=\"\" selected='True' html='".$this->G_Str($name)."' txt=\"".$this->G_Str($name)."\"></span>";
			$items;
			$t;
			$v;
			$h;
			$o;
			$items= $xml->xpath("/configuration/dropdowns/".$name."/item");
			while(list( , $item) = each($items)) 
			{		
				$t=$item["text"];
				if($t!="" && $t != null)
				{
					$v=$t;
					$h=$t;
					$o=$t;
					if (substr($t,0,2)=="[[")
					{
					  $t=substr($t,2,strlen($t)-4);
					  $t=$this->G_Str($t);
					} 

					if($item["value"]!="" && $item["value"] != null)
					{
						$v=$item["value"];
					}					

					if($item->value!="" && $item->value!= null)
					{
						$v=$item->value;
					}	
					
					$v=htmlspecialchars($v);					
					
					if($item["html"]!="" && $item["html"] != null)
					{
						$h=$item["html"];
					}		
					
					if($item->html!="" && $item->html!= null)
					{
						$h=$item->html;
					}		
					$h=str_replace("'","\"",$h);
					
					$h=str_replace($o,$t,$h);	
										        		                		    
					$s=$s."<span val=\"".$v."\" html='".$h."' txt='".$t."'></span>";
				} 
			}
			$s=$s."</span>";
		}
		return $s; 
	}

	function AddToolbarGroupStart()
	{
		return "<table class='CuteEditorGroupMenu' cellSpacing='0' cellPadding='0' border='0'><tr><td class='CuteEditorGroupMenuCell'><nobr>";
	} 
	function AddToolbarGroupEnd()
	{ 
		return "</nobr></td></tr></table>";              
	} 
	function AddToolbarSeparator()
	{
		return "<img src='".$this->ProcessThemeWebPath("Separator.gif")."' unselectable='on' class='separator'/>";              
	} 
	function AddToolbarLineBreak()
	{
	  return "<br clear='both'/>";              
	} 
            
	function AddToolbarItem($name,$command,$img,$l_width,$l_height)
	{
	  if (strtolower($command)=="save")
	  {
		return $this->SaveButton();
	  }
	  else
	  {
		if (is_numeric($l_width) && is_numeric($l_height))
		{
		  $t="<img";
		  if (strtolower($name)=="tofullpage")
		  {
			  $t="<img id='cmd_tofullpage'";
		  } 
		  if (strtolower($name)=="fromfullpage")
		  {
			  $t="<img id='cmd_fromfullpage'";
		  } 
		  if (strtolower($this->BrowserType)=="winie")
		  {
			  $alt="alt=\"".$this->G_Str($name)."\"";
		  }
		  else
		  {
			  $alt="alt=\"".$this->G_Str($name)."\"";
		  }
      
      if($this->GetImageThemeIndex($img)<>"")
		    return $t." ".$alt." Command=\"".$command."\" ThemeIndex=\"".$this->GetImageThemeIndex($img)."\" />";
      else
		    return $t." ".$alt." Command=\"".$command."\" src=\"".$this->ProcessThemeWebPath($img).".gif\" />";
		}
		else
		{
		    return $t." ".$alt." Command=\"".$command."\" ThemeIndex=\"".$this->GetImageThemeIndex($img)."\" />";
		} 
	  }               
	} 

	function AddToolbarDropDown($name,$command,$width)
	{
	  $s="";
	  $name_s="";
	  $list_s="";
	  switch (strtolower($name))
	  {
		case "cssclass":
		  $name_s=$this->CssClassStyleDropDownMenuNames;
		  $list_s=$this->CssClassStyleDropDownMenuList;
		  break;
		case "formatblock":
		  $name_s=$this->ParagraphsListMenuNames;
		  $list_s=$this->ParagraphsListMenuList;
		  break;
		case "fontname":
		  $name_s=$this->FontFacesList;
		  $list_s=$this->FontFacesList;
		  break;
		case "fontsize":
		  $name_s=$this->FontSizesList;
		  $list_s=$this->FontSizesList;
		  break;
		case "links":
		  $name_s=$this->LinksDropDownMenuNames;
		  $list_s=$this->LinksDropDownMenuList;
		  break;
		case "codes":
		  $name_s=$this->CodeSnippetDropDownMenuNames;
		  $list_s=$this->CodeSnippetDropDownMenuList;
		  break;
		case "images":
		  $name_s=$this->ImagesDropDownMenuNames;
		  $list_s=$this->ImagesDropDownMenuList;
		  break;
		case "zoom":
		  $name_s=$this->ZoomsList;
		  $list_s=$this->ZoomsList;
		  break;
		default:
		  break;
	  } 
	  
	  if ($name_s!="" && $list_s!="" && $name_s!=null && $list_s!=null)
	  {
		$name_array=explode(",",$name_s);
		$list_array=explode(",",$list_s);
		if (strtolower($this->GetRenderRichDropdown())!=true || $this->BrowserType=="safari12" || $this->BrowserType=="safari")
		{

		  $s="<select id=\"".$this->ClientID().strtolower($name)."\"  OnChange=\"CuteEditor_DropDownCommand(this,'".$command."')\" class=\"CuteEditorSelect\">";
		  $s=$s."<option value=''>".$this->G_Str($name)."</option>";
		  if (is_array($name_array) && is_array($list_array))
		  {
			if (!$this->IsArrayEmpty($list_array))
			{

			  for ($i=0; $i<count($list_array); $i=$i+1)
			  {
				$l_value=trim($list_array[$i]);
				if (strtolower($name)=="images")
				{

				  $l_value="<img src=\""+$l_value+"\" border=\"0\" />";
				} 

				$s=$s."<option value='".htmlspecialchars($l_value)."'>".htmlspecialchars(trim($name_array[$i]))."</option>";

			  }

			} 

		  } 

		  $s=$s."</select>";
		}
		  else
		{

		  $s="<span class='CuteEditorDropDown' id='".$this->ClientID().strtolower($name)."' Command='".$command."' ";
		  $s=$s."onchange=\"CuteEditor_DropDownCommand(this,'".$command."')\" RichHideFirstItem='true' _IsRichDropDown='True' style='display:inline-block;width:".$width."px;height:20px;'>";
		  $s=$s."<span val=\"\" selected='True' html='".$this->G_Str($name)."' txt=\"".$this->G_Str($name)."\"></span>";
		  if (is_array($name_array) && is_array($list_array))
		  {

			if (!$this->IsArrayEmpty($list_array))
			{

			  for ($i=0; $i<count($list_array); $i=$i+1)
			  {
				$l_value=trim($list_array[$i]);
				if (strtolower($name)=="images")
				{
				  $l_value="<img src=\"".$l_value."\" border=\"0\" />";
				} 
				
				if(strtolower($name)=="cssclass")
					$s=$s."<span class='".$l_value."' val='".htmlspecialchars($l_value)."' html='".trim($name_array[$i])."' txt='".trim($name_array[$i])."'></span>";
				else if(strtolower($name)=="fontname")
					$s=$s."<span style='font-family:".$l_value."' val='".htmlspecialchars($l_value)."' html='".trim($name_array[$i])."' txt='".trim($name_array[$i])."'></span>";
				else if(strtolower($name)=="fontsize")
				{
					$html;
					$html="<font size=".trim($name_array[$i]).">".$this->G_Str("Size")." ".$l_value."</font>";
					$s=$s."<span val='".htmlspecialchars($l_value)."' html='".$html."' txt='".trim($name_array[$i])."'></span>";
				}
				else
					$s=$s."<span val='".htmlspecialchars($l_value)."' html='".trim($name_array[$i])."' txt='".trim($name_array[$i])."'></span>";
			  }
			} 
		  } 

		  $s=$s."</span>";
		} 

		return $s;
	  }
	 else
	  {
		return $this->AddToolbarDropDownfromConfig($name,$command,$width);
	  } 	  
	} 
            
	function AddToolbarForeColor()
	{	  
	  $str_temp="";
	  $t="";
	  $c="".$this->ClientID()."_forecolorimg";
	  if ($this->ReadOnly!=true)
	  {

		if (strtolower($this->BrowserType)=="safari12")
		{

		  $t="onmousedown=\"CuteEditor_GetEditor(this).ExecCommand('ForeColor',false, document.getElementById('".$c."').style.backgroundColor)\"";
		}
		  else
		{

		  $t="onclick=\"CuteEditor_GetEditor(this).ExecCommand('ForeColor',false, ".$c.".style.backgroundColor)\"";
		} 

	  } 

	  $str_temp="<img id='".$c."' Command=\"ForeColor\" alt=\"".$this->G_Str("ForeColor")."\" src='".$this->ProcessThemeWebPath("fontcolor.gif")."' width='17' height='20' border=0 style='background-color: red;' ".$t."/>";
	  $t="";
	  if ($this->ReadOnly!=true)
	  {

		if (strtolower($this->BrowserType)=="safari12")
		{

		  $t="onmousedown=\"CuteEditor_GetEditor(this).ExecCommand('SetForeColor',false,".$c.");\"";
		}
		  else
		{

		  $t="onclick=\"CuteEditor_GetEditor(this).ExecImageCommand('SetForeColor',false,null,this);\" oncolorchange=\"CuteEditor_GetEditor(this).ExecImageCommand('ForeColor',false,this.selectedColor,this); document.getElementById('".$c."').style.backgroundColor = this.selectedColor\"";
		} 

	  } 

	  return $str_temp."<img Command=\"SetForeColor\" alt=\"".$this->G_Str("SetForeColor")."\" src='".$this->ProcessThemeWebPath("tbdown.gif")."' width='9' height='20' border='0' ".$t."/>";
	  
	} 
	function AddToolbarBackColor()
	{ 
	  $t="";
	  $c="".$this->ClientID()."_bkcolorimg";
	  $str_temp="";
	  if ($this->ReadOnly!=true)
	  {

		if (strtolower($this->BrowserType)=="safari12")
		{

		  $t="onmousedown=\"CuteEditor_GetEditor(this).ExecCommand('BackColor',false, document.getElementById('".$c."').style.backgroundColor)\"";
		}
		  else
		{

		  $t="onclick=\"CuteEditor_GetEditor(this).ExecCommand('BackColor',false, document.getElementById('".$c."').style.backgroundColor)\"";
		} 

	  } 

	  $str_temp="<img id='".$c."' Command=\"BackColor\" alt=\"".$this->G_Str("BackColor")."\" src='".$this->ProcessThemeWebPath("colorpen.gif")."' width='17' height='20' border=0 style='background-color: yellow;' ".$t."/>";
	  $t="";
	  if ($this->ReadOnly!=true)
	  {

		if (strtolower($this->BrowserType)=="safari12")
		{

		  $t="onmousedown=\"CuteEditor_GetEditor(this).ExecCommand('SetBackColor',false,".$c.");\"";
		}
		  else
		{

		  $t="onclick=\"CuteEditor_GetEditor(this).ExecImageCommand('SetBackColor',false,null,this);\" oncolorchange=\"CuteEditor_GetEditor(this).ExecImageCommand('BackColor',false,this.selectedColor,this); document.getElementById('".$c."').style.backgroundColor = this.selectedColor\"";
		} 

	  } 

	  return $str_temp."<img Command=\"SetBackColor\" alt=\"".$this->G_Str("SetBackColor")."\" src='".$this->ProcessThemeWebPath("tbdown.gif")."' width='9' height='20' border='0' ".$t."/>";
	  
	} 
            
            
    function AddToolbarTable()
    {    
      $t="";
      if ($this->ReadOnly!=true)
      {
        if (strtolower($this->BrowserType)=="safari12")
        {
          $t="onmousedown=\"var editor=CuteEditor_GetEditor(this);editor.TableDropDown(this)\"";
        }
        else
        {
          $t="onclick=\"var editor=CuteEditor_GetEditor(this);editor.TableDropDown(this)\"";
        } 
      } 
      return "<img Command=\"TableDropDown\" alt=\"".$this->G_Str("TableDropDown")."\" src='".$this->ProcessThemeWebPath("instable.gif")."' ".$t."/>";      
    } 

  
    function getmicrotime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    } 
    function booleanToString($s) {
		if($s==1)
			return "true";
		else
			return "false";
    }
    
    
	function GetWebPath($pfile)
	{
		$scriptfile=@$_SERVER['SCRIPT_FILENAME'];
		if(!$scriptfile)$scriptfile=$_SERVER['ORIG_SCRIPT_FILENAME'];


		$ppath=$scriptfile;
		$vpath=$_SERVER['SCRIPT_NAME'];
		
		$ppath=str_replace("\\","/",$ppath);
		$vpath=str_replace("\\","/",$vpath);
		$pfile=str_replace("\\","/",$pfile);
		
		$lfile=strtolower($pfile);
		$lpath=strtolower($ppath);
		
		$l=min(strlen($pfile),strlen($ppath));
		for($i=0;$i<strlen($pfile);$i++)
		{
			if(substr($lfile,$i,1)!=substr($lpath,$i,1))
			{
				$vroot=substr($vpath,0,strlen($vpath)-(strlen($ppath)-$i));
				return $vroot . substr($pfile,$i);
			}
		}
	}
  
	function ServerMapPath($input_path)
	{
		if(substr($input_path, 0, 1)!="/")
		{
			$ThisFileName = basename($_SERVER['PHP_SELF']); // get the file name
			$abspath = str_replace($ThisFileName,"",$_SERVER['PHP_SELF']);   // get the directory path
		//	echo $abspath;
			$input_path=$abspath.$input_path;
		}
	//	echo $input_path;
		if(!(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'))
		{    
		  return $_SERVER["DOCUMENT_ROOT"].$input_path; 
		}
		else
		{
		  return ucfirst($_SERVER["DOCUMENT_ROOT"]).$input_path; 
		}
	}
 }
?>