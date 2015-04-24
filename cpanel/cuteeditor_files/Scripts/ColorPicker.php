<%  
   Response.ContentType = "text/x-component"
   dim Culture
   Culture = Trim(Request.QueryString("UC"))  
   dim FilePath
   FilePath = Trim(Request.QueryString("F"))  
   Public Function GetString(instring)
	    dim t
    	
	    t = GetStringByCulture(instring,Culture)
    	
	    If t = ""  then
		    t= GetStringByCulture(instring,"_default")
	    End If
    	
	    If t = ""  then
		    t= "{"&instring&"}"	
	    End If
	    GetString= t	
    End Function
    
    
   FilePath = Left(request.ServerVariables("PATH_INFO"),InStr(request.ServerVariables("PATH_INFO"),FilePath)+len(FilePath)-1)

    Public Function GetStringByCulture(instring,input_culture)
	    dim scriptname,xmlfilename,doc,temp
	    dim node,selectednode,optionnodelist,errobj
	    dim selectednodes

	    xmlfilename= Server.MapPath(FilePath&"/languages/"&input_culture&".xml")

	    ' Create an object to hold the XML
	    set doc = server.CreateObject("Microsoft.XMLDOM")

	    ' For ASP, wait until the XML is all ready before continuing
	    doc.async = False

	    ' Load the XML file or return an error message and stop the script
	    if not Doc.Load(xmlfilename) then
		    Response.Write "Failed to load the language text from the XML file.<br>"
		    Response.End
	    end if

	    ' Make sure that the interpreter knows that we are using XPath as our selection language
	    doc.setProperty "SelectionLanguage", "XPath"

	    set selectednode= doc.selectSingleNode("/resources/resource[@name='"&instring&"']")
	    if IsObject(selectednode) and not selectednode is nothing  then
		    GetStringByCulture=CuteEditor_Decode(selectednode.text)
	    else
		    GetStringByCulture=""		
	    end if
    End Function    
    
     PUBLIC FUNCTION CuteEditor_Decode(input_str)        
	    input_str=Replace(input_str,"#1","<")
	    input_str=Replace(input_str,"#2",">")
	    input_str=Replace(input_str,"#3","&")
	    input_str=Replace(input_str,"#4","*")
	    input_str=Replace(input_str,"#5","o")
	    input_str=Replace(input_str,"#6","O")
	    input_str=Replace(input_str,"#7","s")
	    input_str=Replace(input_str,"#8","S")
	    input_str=Replace(input_str,"#9","e")
	    input_str=Replace(input_str,"#a","E")
	    input_str=Replace(input_str,"#0","#")
	    CuteEditor_Decode = input_str
     END FUNCTION
%>
<PUBLIC:COMPONENT>
	<PUBLIC:EVENT ID="event_oncolorchange" name="oncolorchange" />
	<PUBLIC:EVENT ID="event_oncolorpopup" name="oncolorpopup" />
	<PUBLIC:PROPERTY name="selectedColor" GET="_get_selectedColor" PUT="_set_selectedColor"/>
	<PUBLIC:METHOD name="popupColor" INTERNALNAME="_mtd_popupColor" />
	<PUBLIC:ATTACH EVENT="onclick" ONEVENT="_mtd_onclick()" />
</PUBLIC:COMPONENT>

<script type="text/javascript">
// All colors in the following color array will be used in the editor color picker
var colorsArray = new Array("#000000","#993300","#333300","#003300","#003366","#000080","#333399","#333333",
			"#800000","#FF6600","#808000","#008000","#008080","#0000FF","#666699","#808080",
			"#FF0000","#FF9900","#99CC00","#339966","#33CCCC","#3366FF","#800080","#999999",
			"#FF00FF","#FFCC00","#FFFF00","#00FF00","#00FFFF","#00CCFF","#993366","#C0C0C0",
			"#FF99CC","#FFCC99","#FFFF99","#CCFFCC","#CCFFFF","#99CCFF","#CC99FF","#FFFFFF");
			
var ShowMoreColors = true;
var dlgurl='<%=FilePath%>/Dialogs/ColorPicker.php?<%=Request.ServerVariables("QUERY_STRING") %>&setting=<%= Request.Cookies("CESecurity") %>';
function element._cphtc_sel(color)
{
	_color=color;
	event_oncolorchange.fire();
}
function element._cphtc_dlg()
{
	CloseDiv();

	event_oncolorpopup.fire();
	var option='dialogWidth:500px;dialogHeight:330px;help:0;status:0;resizable:1'
	if(element.disableVisual)
	{
		var res=showModalDialog(dlgurl
			,{color:oldvalue}
			,option);
		if(res!=null&&res!=false)
		{
			_color=res;
			event_oncolorchange.fire();
			
		}
	}
	else
	{
		//FEATURE:change the color in ColorPicker.php would fire the event so the changing would affect immediately , and it could be auto rollback
		
		var oldvalue=_color;
		
		var res=showModalDialog(dlgurl
			,{color:oldvalue,onchange:SetColor}
			,option);

		if(res!=null&&res!=false)
		{
			_color=res;
		}
		else
		{
			_color=oldvalue;
		}
		
		event_oncolorchange.fire();
		
		function SetColor(val)
		{
			_color=val;
			event_oncolorchange.fire();
		}
	}
}

var _color="";

function _get_selectedColor()
{
	return _color;
}
function _set_selectedColor(val)
{
	_color=val;
}

var div;
var selects;
var isopen=false;

function _mtd_onclick()
{
	_mtd_popupColor();
}

function _mtd_popupColor()
{
	if(div==null)
	{
		div = document.createElement("<DIV style='width=140;cursor:default;position:absolute;z-index:88888888;background-color:white;border:0px;overflow:visible;'>");
		
		var temp_html = '';				
		var total = colorsArray.length;
		var width = 8;

		temp_html += "<table cellpadding=0 cellspacing=5 style='width:100%;font-family: Verdana; font-size: 6px; BORDER: #666666 1px solid;' bgcolor=#f9f8f7><tr><td>";
		temp_html += "<table cellpadding=0 cellspacing=2 style='font-size: 3px;'>";
		
		temp_html += '<tr>';
		temp_html += '<td colspan=10 align=center style="padding:1px;border:solid 1px #f9f8f7;margin:1px" onmouseup="document.all.'+element.uniqueID+'._cphtc_sel(this.ColorValue)"  ColorValue="" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);">';
		temp_html += '<table cellspacing=0 cellpadding=0 border=0 width=90% style="font-size:3px">';
		temp_html += '<tr><td width=18><div style="background-color:#000000; border:solid 1px #808080; width:12px; height:12px; font-size: 3px;">&nbsp;</div></td><td align=center style="font:normal 11px verdana;">&nbsp;<%= GetString("Automatic") %></td></tr>';
		temp_html += '</table>';
		temp_html += '</td>';
		temp_html += '</tr>';
		
		temp_html += '<tr><td>&nbsp;</td></tr>';

		for (var i=0; i<total; i++) {
			if ((i % width) == 0) 
			{
				temp_html += "<tr>"; 
			}
			
			temp_html += '<td title='+colorsArray[i]+' align=center style="padding:1px;border:solid 1px #f9f8f7;" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" ColorValue="'+colorsArray[i]+'" onmouseup="document.all.'+element.uniqueID+'._cphtc_sel(this.ColorValue);">';
			temp_html += '<div style="background-color:'+colorsArray[i]+'; border:solid 1px #808080; width:12px; height:12px; font-size: 3px;">&nbsp;</div>';
			temp_html += '</td>';
			
			if ( ((i+1)>=total) || (((i+1) % width) == 0))
			{ 
				temp_html += "</tr>";
			}
		}		
		temp_html += '<tr><td>&nbsp;</td></tr>';
		//temp_html += '<tr>';
		//temp_html += '<td colspan="10" style="height:23px; font-family: arial; font-size:11px; border: solid 1px #f9f8f7;" onMouseOver="" onMouseOut="" onClick="" align=center>&nbsp;More Colors...</td>';
		//temp_html += '</tr>';
		temp_html += '</table>';
		temp_html += '</td></tr>';
		if(ShowMoreColors)
		{
			temp_html += '<tr>';
			temp_html += '<td colspan=10 align=center style="padding:1px;border:solid 1px #f9f8f7;" onmouseover="CuteEditor_ColorPicker_ButtonOver(this);" onmouseup="document.all.'+element.uniqueID+'._cphtc_dlg();">';
			temp_html += '<table cellspacing=0 cellpadding=0 border=0 width=90% style="font-size:3px">';
			temp_html += '<tr><td width=18><div style="background-color:#000000; border:solid 1px #808080; width:12px; height:12px;font-size: 3px;"></div></td><td align=center style="font-size:11px"><%= GetString("MoreColors") %></td></tr>';
			temp_html += '</table>';
			temp_html += '</td>';
			temp_html += '</tr>';
		}
		temp_html += '</table>';
		
		div.innerHTML=temp_html;
		
		element.document.body.appendChild(div);
		
		div.onclick=CloseDiv;
	}
	
	if(isopen)CloseDiv();
	
	isopen=true;
	
	selects=[];
	var coll=element.document.all.tags("SELECT");
	for(var i=0;i<coll.length;i++)
	{
		var sel=coll[i];
		if(sel.currentStyle.visibility!='hidden')
		{
			selects[selects.length]=sel;
			var style=sel.runtimeStyle||sel.style;
			style._visibility=style.visibility;
			style.visibility='hidden';
		}
	}
	
	div.style.top=0;
	div.style.left=0;
	div.style.display='block';
	var pos=CalcPosition(div,element);
	pos.top+=element.offsetHeight;
	AdjustMirror(div,element,pos);
	div.style.left=pos.left+"px";
	div.style.top=pos.top+"px";
	
	var coll=div.all;
	for(var i=0;i<coll.length;i++)
		coll[i].unselectable='on';
		
	div.focus();
	
	var manager=new CaptureManager(element,handlelosecapture);
	manager.AddElement(div);
}
function handlelosecapture()
{
	CloseDiv();
}
function CloseDiv()
{
	CaptureManager.Unregister(element);
	
	isopen=false;
	div.style.display='none';
	for(var i=0;i<selects.length;i++)
	{
		var sel=selects[i];
		sel.runtimeStyle.visibility=sel.runtimeStyle._visibility;
	}
	
}

</script>

<script type="text/javascript">


/****************************************************************\
	Position Functions
\****************************************************************/
//get the position of a element ( by the scroll offset )
function GetScrollPostion(e)
{
	var b=window.document.body;
	var p=b;
	if(window.document.compatMode=='CSS1Compat')
	{
		p=window.document.documentElement;
	}
	
	if(e==b)return {left:0,top:0};
	with(e.getBoundingClientRect())
	{
		return {left:p.scrollLeft+left,top:p.scrollTop+top};
	}
}
//get the position of a element ( by the client offset )
function GetClientPosition(e)
{
	var b=window.document.body;
	var p=b;
	if(window.document.compatMode=='CSS1Compat')
	{
		p=window.document.documentElement;
	}
	
	if(e==b)return {left:-p.scrollLeft,top:-p.scrollTop};
	with(e.getBoundingClientRect())
	{
		return {left:left-p.clientLeft,top:top-p.clientTop};
	}
}
//get absolute or relative parent
function GetStandParent(e)
{
	//Adam: this doesn't work-- for(var pe=e.parentNode;pe!=null;pe=pe.parentNode)
	for(var pe=e.parentElement;pe!=null;pe=pe.parentElement)
	{
		var sp=pe.currentStyle.position;
		if(sp=='absolute'||sp=='relative')
		return pe;
	}
	
	return window.document.body;
}
//calc the position of floate that relative to e
function CalcPosition(floate,e)
{
	//var b=window.document.body;
	var epos=GetScrollPostion(e);
	var spos=GetScrollPostion(GetStandParent(floate));
	var s=GetStandParent(floate);
	return {left:epos.left-spos.left-s.clientLeft,top:epos.top-spos.top-s.clientTop};
}

//get the best position to put the floate
function AdjustMirror(floate,e,pos)
{
	//c:Client,f:floate,e:e,p:floate's StandParent,m:Mirror

	//get the size of window
	var cw=window.document.body.clientWidth;
	var ch=window.document.body.clientHeight;
	if(window.document.compatMode=='CSS1Compat')
	{
		cw=window.document.documentElement.clientWidth;
		ch=window.document.documentElement.clientHeight;
	}
	
	//get the size of float element
 	var fw=floate.offsetWidth;
	var fh=floate.offsetHeight;
	
	var pcpos=GetClientPosition(GetStandParent(floate));
	
	//get the center of float element
	var fmpos={left:pcpos.left+pos.left+fw/2,top:pcpos.top+pos.top+fh/2};//

	var empos={left:pcpos.left+pos.left,top:pcpos.top+pos.top};

	if(e!=null)
	{
		var ecpos=GetClientPosition(e);
		
		//get the center of the relative element
		empos={left:ecpos.left+e.offsetWidth/2,top:ecpos.top+e.offsetHeight/2};//
	}
	
	var allowmove=true;
 
	//left<-->right

	if(fmpos.left-fw/2<0)
	{
		if((empos.left*2-fmpos.left)+fw/2<=cw)
		{
			fmpos.left=empos.left*2-fmpos.left;
		}
		else if(allowmove)
		{
			fmpos.left=fw/2+4;
		}
	}
	else if(fmpos.left+fw/2>cw)
	{
		if((empos.left*2-fmpos.left)-fw/2>=0)
		{
			fmpos.left=empos.left*2-fmpos.left;
		}
		else if(allowmove)
		{
			fmpos.left=cw-fw/2-4;
		}
	}
	

	//top<-->bottom

	if(fmpos.top-fh/2<0)
	{
		if((empos.top*2-fmpos.top)+fh/2<=ch)
		{
			fmpos.top=empos.top*2-fmpos.top;
		}
		else if(allowmove)
		{
			fmpos.top=fh/2+4;
		}
	}
	else if(fmpos.top+fh/2>ch)
	{
		if((empos.top*2-fmpos.top)-fh/2>=0)
		{
			fmpos.top=empos.top*2-fmpos.top;
		}
		else if(allowmove)
		{
			fmpos.top=ch-fh/2-4;
		}
	}
 
	pos.left=fmpos.left-pcpos.left-fw/2;
	pos.top=fmpos.top-pcpos.top-fh/2;
}




/****************************************************************\
	Capture Functions
	this manager collect the elements that capture the mouse
	if the mouse is in the element , the capture should be close ,
	if the mouse is out of any element , the capture should be open .
\****************************************************************/
function CaptureManager(element,handlelosecapture)
{
	if(CaptureManager.element&&CaptureManager.element.capturemanager)
	{
		CaptureManager.element.capturemanager.Unregister();
	}
	
	var enabled=true;
	var elements=[];
	var isout=true;
	var iscap=false;
	
	element.capturemanager=Manager;
	CaptureManager.element=element;
	
	Manager.AddElement(element);

	var elementForCapture=element.document.createElement("<DIV style='width:0px;height:0px;left:0px;top:0px;position:absolute'>");
	element.document.body.insertAdjacentElement('afterBegin',elementForCapture);
	elementForCapture.attachEvent('onlosecapture',onlosecapture);
	AttachEvents(elementForCapture);

	elementForCapture.setCapture(true);
	iscap=true;

	return Manager;
	
	function AttachEvents(subelement)
	{
		subelement.attachEvent('onmousedown',onmousedown);
		subelement.attachEvent('onmousemove',onmousemove);
		subelement.attachEvent('onmouseover',onmouseover);
		subelement.attachEvent('onmouseout',onmouseout);
	}
	function DetachEvents(subelement)
	{
		subelement.detachEvent('onmousedown',onmousedown);
		subelement.detachEvent('onmousemove',onmousemove);
		subelement.detachEvent('onmouseover',onmouseover);
		subelement.detachEvent('onmouseout',onmouseout);
	}

	function Manager()
	{
	}
	function Manager.Unregister()
	{
		elementForCapture.detachEvent('onlosecapture',onlosecapture);
		DetachEvents(elementForCapture);
		elementForCapture.removeNode(true);
		
		for(var i=0;i<elements.length;i++)
		{
			var subelement=elements[i];
			DetachEvents(subelement);
		}
		
		enabled=false;
		element.capturemanager=null;
		CaptureManager.element=null;
		if(iscap)
		{
			//element.document.title="r @ Unregister";
			iscap=false;
			elementForCapture.releaseCapture();
			Manager.FireLoseCapture();
		}
	}
	function Manager.AddElement(subelement)
	{
		AttachEvents(subelement);
		elements[elements.length]=subelement;
	}
	function Manager.DelElement(subelement)
	{
		var len=elements.length;
		for(var i=0;i<len;i++)
		{
			if(elements[i]==subelement)
			{
				DetachEvents(subelement);
				for(var j=i;j<len-1;j++)
				{
					elements[j]=elements[j+1];
				}
				elements.length=elements.length-1;
				return;
			}
		}
	}
	function Manager.FireLoseCapture()
	{
		handlelosecapture();
	}
	function onlosecapture()
	{
		if(iscap)//if fired by user
		{
			iscap=false;
			try
			{
				Manager.FireLoseCapture();
			}
			finally
			{
				Manager.Unregister();
			}
		}
	}
	
	function onmousedown()
	{
		var currentElement=element.document.elementFromPoint(event.clientX,event.clientY);
		for(var i=0;i<elements.length;i++)
		{
			var subelement=elements[i];
			if(subelement.contains(currentElement))
				return;
		}
		//if mouse down on other elements
		Manager.Unregister();
	}
	
	function onmousemove()
	{
		var currentElement=element.document.elementFromPoint(event.clientX,event.clientY);
		
		HookForElement(currentElement);
	}
	
	function HookForElement(currentElement)
	{
		for(var i=0;i<elements.length;i++)
		{
			var subelement=elements[i];
			if(subelement.contains(currentElement))
			{
				if(iscap)
				{
					iscap=false;//set fire by Manager
					elementForCapture.releaseCapture();
				}
				return;
			}
		}
		
		//if move on other elements
		if(!iscap)
		{
			iscap=true;
			elementForCapture.setCapture(true);
		}
	}
	
	function onmouseover()
	{
		var currentElement=element.document.elementFromPoint(event.clientX,event.clientY);
		
		isout=false;
		for(var i=0;i<elements.length;i++)
		{
			var subelement=elements[i];
			if(subelement.contains(event.fromElement))
				return;
			
			if(subelement.contains(currentElement))
			{
				if(iscap)
				{
					iscap=false;//set fire by Manager
					elementForCapture.releaseCapture();
				}
			}
		}
		
	}
	function onmouseout()
	{
		var currentElement=element.document.elementFromPoint(event.clientX,event.clientY);

		isout=false;
		for(var i=0;i<elements.length;i++)
		{
			var subelement=elements[i];
			if(subelement.contains(event.toElement))
				return;
		}
		
		if(!iscap)
		{
			iscap=true;
			elementForCapture.setCapture(true);
		}
	}
}
function CaptureManager.Register(element,handlelosecapture)
{
	return new CaptureManager(element,handlelosecapture);
}
function CaptureManager.Unregister(element)
{
	if(element&&element.capturemanager)
	{
		element.capturemanager.Unregister();
	}
}
</script>
