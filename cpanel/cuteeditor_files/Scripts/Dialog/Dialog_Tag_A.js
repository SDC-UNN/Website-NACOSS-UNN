//ToBoolean.js
function ToBoolean(value)
{
	if(typeof(value)=="string")
	{
		switch(value.toLowerCase())
		{
			case "1":case "true":case "yes":case "on":case "ok":case "-1":return true;
			default:return false;
		}
	}
	return !!value;
}

//Element_IsBlockControl.js
//can be selected as control
function Element_IsBlockControl(element)
{
	var name=element.nodeName;
	if(name=="INPUT")return true;
	if(name=="TEXTAREA")return true;
	if(name=="BUTTON")return true;
	if(name=="IMG")return true;
	if(name=="SELECT")return true;
	if(name=="TABLE")return true;
	var pos=element.style.position;
	if(pos=="absolute"||pos=="relative")
		return true;
	return false;
}



function Element_CUtil_IsBlock(oEl) 
{
	var sBlocks = "|H1|H2|H3|H4|H5|H6|P|PRE|LI|TD|DIV|BLOCKQUOTE|DT|DD|TABLE|HR|IMG|"
	return (oEl!=null) && (sBlocks.indexOf("|"+oEl.nodeName+"|")!=-1)
}

//Window_SelectElement.js
function Window_SelectElement(win,element)
{
	//TODO:check the element's type,
	//if element is not control , select the text instead
	
	if(Browser_UseIESelection())
	{
		if(Element_IsBlockControl(element))
		{
			var coll=win.document.body.createControlRange();
			coll.add(element);
			coll.select();
		}
		else
		{
			var range=win.document.body.createTextRange();
			range.moveToElementText(element);
			range.select();
		}
	}
	else
	{
		var range=win.document.createRange();
		try
		{
			range.selectNode(element);
		}
		catch(x)
		{
			range.selectNodeContents(element);
		}
		var sel=win.getSelection();
		sel.removeAllRanges();
		sel.addRange(range);
	}
}




//----------------------------------------------------------------
//----------------------------------------------------------------



var inp_src=Window_GetElement(window,"inp_src",true);
var btnbrowse=Window_GetElement(window,"btnbrowse",true);
var sel_protocol=Window_GetElement(window,"sel_protocol",true);
var inp_target=Window_GetElement(window,"inp_target",true);
var inp_id=Window_GetElement(window,"inp_id",true);
var inp_class=Window_GetElement(window,"inp_class",true);
var inp_access=Window_GetElement(window,"inp_access",true);
var inp_index=Window_GetElement(window,"inp_index",true);
var inp_color=Window_GetElement(window,"inp_color",true);
var inp_title=Window_GetElement(window,"inp_title",true);
var inp_checked=Window_GetElement(window,"inp_checked",true);
var allanchors=Window_GetElement(window,"allanchors",true);
var Nofollow=Window_GetElement(window,"Nofollow",true);

var originalInnerHTML = "";

var BaseHref=editor.GetBaseHref();

allanchors.style.visibility="hidden"; 


btnbrowse.onclick=function btnbrowse_onclick()
{
	function HandleDialog(res)
	{
		if(res)
		{
			inp_src.value=res;
			SyncTo(element);
		}
	}
	editor.SetNextDialogWindow(window);
	
	if(Browser_IsSafari())
		editor.ShowSelectFileDialog(HandleDialog,inp_src.value,inp_src);	
	else
		editor.ShowSelectFileDialog(HandleDialog,inp_src.value);
}

function ToggleAnchors()
{
	if(allanchors.style.visibility=="hidden")
		allanchors.style.visibility="visible"; 
	else
		allanchors.style.visibility="hidden";
		
}
function updateList()
{		
	while(allanchors.options.length!=0) 
	{
		allanchors.options.remove(allanchors.options(0))
	}
	if(Browser_IsWinIE())
	{
		for(var i=0;i<editdoc.anchors.length;i++)
		{
			var op = document.createElement("OPTION");
			op.text="#"+editdoc.anchors[i].name;
			op.value=editdoc.anchors[i].name;
			allanchors.options.add(op);		
		}
	}
	else
	{
		var imgs = editdoc.images;
		if(imgs)
		{
			for (var j = 0; j < imgs.length; j++)
			{
				var img = imgs[j];
				if(img.className=='cetempAnchor')
				{
					var op = document.createElement("OPTION");
					op.value=img.getAttribute("anchorname")||img.name||img.id;
					op.text="#"+op.value;
					allanchors.options.add(op);	
				}
			}
		}
	}
}

function selectAnchor(sName)
{
	editor.FocusDocument();
	if(Browser_IsWinIE())
	{
		for(var i=0;i<editdoc.anchors.length;i++)
		{
			if(editdoc.anchors[i].name==sName)
			{
				inp_src.value="#"+sName;
				Window_SelectElement(editwin,editdoc.anchors[i]);
			}
		}
	}
	else
	{
		inp_src.value="#"+sName;
	}
}
			
			
function sel_protocol_change()
{
	var src=inp_src.value.replace(/$\s*/,'');
	
	for(var i=0;i<sel_protocol.options.length;i++)
	{
		var val=sel_protocol.options[i].value;
		if(src.substr(0,val.length).toLowerCase()==val)
		{
			src=src.substr(val.length,src.length-val.length);
			break;
		}
	}
	
	var pos1=src.indexOf('://');
	if(pos1!=-1)
		src=src.substr(pos1+3,src.length-3-pos1);
	var pos1=src.indexOf(':');
	if(pos1!=-1)
		src=src.substr(pos1+1,src.length-1-pos1);
	
	var selval=sel_protocol.value;
	
	if(selval=="others")selval="";
	
	inp_src.value=selval+src;
}

function Update_sel_protocol	(src)
{
	var found=false;
	for(var i=0;i<sel_protocol.options.length;i++)
	{
		var val=sel_protocol.options[i].value;
		if(src.substr(0,val.length).toLowerCase()==val)
		{
			if(sel_protocol.selectedIndex!=i)
				sel_protocol.selectedIndex=i;
			found=true;
			break;
		}
	}
	//set others
	if(!found)
		sel_protocol.selectedIndex=sel_protocol.options.length-1;
}

UpdateState=function UpdateState_A()
{
	
}

SyncToView=function SyncToView_A()
{	
	var src = "";
		
	if(element.getAttribute("href"))
		src = element.getAttribute("href");
	if(element.getAttribute("href_cetemp"))
		src = element.getAttribute("href_cetemp");
		
//	src = element.getAttribute( 'href_cetemp' ) ;
//	if ( !src || src.length == 0 )
//		src = element.getAttribute( 'href' , 2 ) + '' ;
	if(src)
	{	
		if(ToBoolean(editor.GetScriptProperty("EnableAntiSpamEmailEncoder"))
			&&(element.href).indexOf("&#")!=-1)
		{
			src=decode(src);
		}
		else		
		{	
			if(BaseHref!=null&&BaseHref!="")
			{
				if(src.toLowerCase().substr(0,BaseHref.length+1)==BaseHref+"#")
				{
					src=src.substring(BaseHref.length);
				}
			}					
		}
	}
	try
	{
		Update_sel_protocol(src);	
	}
	catch(x)
	{}
	
//	if(UseRelativeLinks&&BaseHref)
//		src= RemoveServerNamesFromUrl(src,BaseHref);		
	if(element.id)
		inp_id.value=element.id;	
	if(src)			
		inp_src.value=src;
	
	if(element.style.color)
	{
		inp_color.value=revertColor(element.style.color);
		inp_color.style.backgroundColor = inp_color.value;
	}
	if(element.title)
		inp_title.value=element.title;
	if(element.target)
		inp_target.value=element.target;
	if(element.tabIndex)
		inp_index.value=element.tabIndex;
	if(element.accessKey)
		inp_access.value=element.accessKey;
	if(element.getAttribute("rel")=="nofollow")
		Nofollow.checked=true;
		
	inp_class.value=element.className;
	
	originalInnerHTML = element.innerHTML;
}

SyncTo=function SyncTo_A(element)
{
	// This will cause problem when UrlType is not default.
	//if(sel_protocol.value=="mailto:"&&ToBoolean(editor.GetScriptProperty("EnableAntiSpamEmailEncoder")))
	//{
	//	element.href=obfuscate(inp_src.value);
	//	element.setAttribute("href_cetemp",inp_src.value);
	//	Update_sel_protocol(decode(element.href.replace(/$\s*/,'')));
	//}
	//else
	//{
		if(inp_src.value)
		{
			element.href=inp_src.value;
			element.setAttribute("href_cetemp",inp_src.value);
			try{
				Update_sel_protocol(element.href.replace(/$\s*/,''));
			}
			catch(x)
			{}
		}
	//}
	try
	{
		element.style.color=inp_color.value||'';
	}
	catch(x)
	{
		element.style.color='';
	}
	element.className = inp_class.value;
	element.target = inp_target.value;
	element.title = inp_title.value;
	element.tabIndex = inp_index.value;
	element.accessKey = inp_access.value;
	element.id=inp_id.value;
	
	if(element.id=="")
		element.removeAttribute("id");	
	if(element.title=="")
		element.removeAttribute("title");	
	if(element.target=="")
		element.removeAttribute("target");	
	if(element.className=="")
		element.removeAttribute("className");
	if(element.className=="")
		element.removeAttribute("class");		
	if(element.tabIndex=="")
		element.removeAttribute("tabIndex");
	if(element.accessKey=="")
		element.removeAttribute("accessKey");	
	
	if(Nofollow.checked)
		element.setAttribute("rel","nofollow");
	else
	{
		try
		{
			element.removeAttribute("rel");	
		}
		catch(x)
		{}
	}
	var invalidCharactersRegExp = /[^a-z\d]/i;				
	if(invalidCharactersRegExp.test(inp_id.value))
	{
		alert(CE_GetStr("ValidID"));
		return;
	}	
		
	var html = element.innerHTML;
				
	switch(html.toLowerCase())
	{
		case "<div></div>":
		case "<div>&nbsp;</div>":
		case "<div>&#160;</div>":
		case "<p></p>":
		case "<p>&#160;</p>":
		case "<p>&nbsp;</p>":
			element.innerHTML="";
		break;
		default:
			break;
	}	
				
	if(originalInnerHTML=='')
	{
		element.innerHTML=element.title||inp_src.value||element.name;
	}		
	
}

function obfuscate (address) {
    var obfuscated = "";
    if(address.length > 0)
    {
		for (var i = 0; i < address.length; i++) {
			obfuscated += "&#" + address.charCodeAt(i) + ";";
		};
	}
    return (obfuscated);
   }
   
  function decode (etxt) {
	var dtxt = "";
    var arr=etxt.split(";");
    for (var i = 0; i < arr.length; i++) {
		var t = arr[i].substr(2,arr[i].length-2); 
		t = String.fromCharCode(t); 
		dtxt += t; 
	} 
    return (dtxt);
 }


updateList();

inp_color.onclick=inp_color_Preview.onclick=function inp_color_onclick()
	{
		SelectColor(inp_color,inp_color_Preview);
	}
