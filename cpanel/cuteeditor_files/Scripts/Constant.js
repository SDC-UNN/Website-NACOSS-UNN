if(!window.editorconstant)window.editorconstant={};

editorconstant.KEYDOWN_NOTIFYCHANGEDELAY=2000

// When creating a table using the Wizard, the following default attributes apply.
editorconstant._CreateEditingTableStyle = "<table border='0' cellspacing='2' cellpadding='2' width='500'>";
// Default window ornaments for the SyntaxHighlighter dialog
editorconstant._syntaxHighlighterDialogFeature = "dialogWidth:525px;dialogHeight:370px";
// When creating a new div box, the following default attributes apply.
editorconstant._BoxFormattingStyle = "border: solid 1px #666666;";
// Default window ornaments for the ColorPicker dialog
editorconstant._colorpickerDialogFeature = "dialogWidth:500px;dialogHeight:420px";
// Default window ornaments for the Clean dialog
editorconstant._cleanDialogFeature = "dialogWidth:260px;dialogHeight:240px";
// Default window ornaments for the Preview dialog
editorconstant._previewDialogFeature = "dialogWidth:640px;dialogHeight:480px;resizable:1";
// Default window ornaments for the Anchor dialog
editorconstant._anchorDialogFeature = "resizable:0;dialogWidth:320px;dialogHeight:230px;";
// Default window ornaments for the Link dialog
editorconstant._linkDialogFeature = "resizable:0;dialogWidth:460px;dialogHeight:214px;";
// Default window ornaments for the Char dialog
editorconstant._charDialogFeature = "resizable:0;dialogWidth:520px;dialogHeight:360px;";
// Default window ornaments for the find dialog
editorconstant._findDialogFeature = "resizable:1;dialogWidth:385px;dialogHeight:150px;";
// Default window ornaments for the Emotion dialog
editorconstant._emotionDialogFeature = "resizable:0;dialogWidth:280px;dialogHeight:300px;";
// Default window ornaments for the Template dialog
editorconstant._templateDialogFeature = "dialogWidth:660px;dialogHeight:410px;";
// Default window ornaments for the Create Template dialog
editorconstant._createtemplateDialogFeature = "dialogWidth:760px;dialogHeight:385px;help:no;scroll:no;status:no;resizable:0;";
// Default window ornaments for the youtube dialog
editorconstant._youtubeDialogFeature = "dialogWidth:540px;dialogHeight:220px;";
// Default window ornaments for the Document dialog
editorconstant._documentDialogFeature = "dialogWidth:750px;dialogHeight:530px;";
// Default window ornaments for the gallery dialog
editorconstant._galleryDialogFeature = "dialogWidth:564px;dialogHeight:540px;";
// Default window ornaments for the image dialog
editorconstant._imageDialogFeature = "dialogWidth:620px;dialogHeight:530px;";
// Default window ornaments for the image map dialog
editorconstant._imagemapDialogFeature = "dialogWidth:610px;dialogHeight:370px;";
// Default window ornaments for the media dialog
editorconstant._mediaDialogFeature = "dialogWidth:580px;dialogHeight:460px;";
// Default window ornaments for the flash dialog
editorconstant._flashDialogFeature = "dialogWidth:600px;dialogHeight:515px;";
// Default window ornaments for the page properties dialog
editorconstant._pageDialogFeature = "dialogWidth:490px;dialogHeight:440px;";
// Default window ornaments for the Tag dialog
editorconstant._tagDialogFeature = "resizable:0;dialogWidth:470px;dialogHeight:500px;";
// Default window ornaments for the help 
editorconstant._helpDialogFeature = "dialogWidth:820px;dialogHeight:450px;";
// Default window ornaments for the Rule dialog
editorconstant._RuleDialogFeature = "resizable:1;dialogWidth:340px;dialogHeight:210px;";
// Default style in the source view 
editorconstant._editorSourceStyle = "background:#ffffff;margin:0;padding:0;color:black";
// Default window ornaments for the paste dialog
editorconstant._pastetextDialogFeature = "resizable:0;dialogWidth:450px;dialogHeight:400px;";
// Default window ornaments for the universal keyboard dialog
editorconstant._keyboardDialogFeature = "resizable:0;dialogWidth:415px;dialogHeight:310px;";
// Default editorconstant ornaments for the select image, select file dialog
editorconstant._selectImageDialogFeature = "status:0;dialogWidth:610px;dialogHeight:500px; scroll: 0; resizable: 0; help:0";
// Default editorconstant ornaments for the select image, select file dialog
editorconstant._selectFileDialogFeature = "status:0;dialogWidth:760px;dialogHeight:500px; scroll: 0; resizable: 0; help:0";
editorconstant.layerdefaultstyle = "position:absolute;width:104px; height: 104px";
editorconstant.ToggleBorderStyle='1px dotted #000000';
editorconstant.DisableCtrlZ = false;
//By default, when users double click a control, a tag property dialog will open. Set it to true if you want to disable this feature.
editorconstant.DisableDoubleClickEvent = false; 
editorconstant.AbsolutePositionValue='absolute'; //'relative';
// Default editorconstant ornaments for the spell checker dialog
editorconstant._spellcheckDialogFeature = "help:0;status:0;resizable:0;dialogWidth:450px;dialogHeight:400px;";
//Default dialog's z-index
editorconstant.DialogZIndex=8888; 

editorconstant.AlwaysShowFontName=false;

editorconstant.DisableHotkeyF12=false;

editorconstant.UseXhtmlFormat=true;
editorconstant.DropDownBGColor="white";

//set to window for compatible
for(var p in editorconstant)window[p]=editorconstant[p];