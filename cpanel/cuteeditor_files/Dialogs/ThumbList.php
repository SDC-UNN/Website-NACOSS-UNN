<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("Include_GetString.php") ;
?>

<ASP:DataList id="MyList" RepeatDirection="Horizontal" width="100%" height="300" RepeatColumns="4" CellSpacing="0" EnableViewState="true" OnItemDataBound="Item_DataBound">
	
	<ItemStyle horizontalalign="Center"></ItemStyle>
    <FooterStyle font-size="8pt" horizontalalign="Center"></FooterStyle>
   
    <ItemTemplate>
		<img style="BORDER: white 1px solid; text-align:center" alt="" src="<%# ThumbUrl((String)(DataBinder.Eval(Container.DataItem,"Path"))) ; ?>" onmouseover='Check(this,1); showTooltip("<nobr><%# String_Name; ?>: <%# DataBinder.Eval(Container.DataItem, "Name"); ?></nobr><br /><nobr><%# String_Size; ?>: <%# ( Convert.ToInt32(DataBinder.Eval(Container.DataItem, "Length")) /1024).ToString("n0"); ?> KB</nobr><br /><nobr><%# String_Createddate; ?>: <%# DataBinder.Eval(Container.DataItem, "CreationTime") ; ?></nobr><br /><nobr><%# String_Modifieddate; ?>: <%# DataBinder.Eval(Container.DataItem, "LastWriteTime"); ?></nobr>", this, event)' onmouseout="Check(this,0); delayhidetip()" onclick="insert('<%# DataBinder.Eval(Container.DataItem,"Url") ; ?>')"/>
	</ItemTemplate>
   
    <FooterTemplate>
		<%# NumImagesDisplayed(); ?> <asp:PlaceHolder id="plLinks" runat="server"></asp:PlaceHolder>
	</FooterTemplate>
</ASP:DataList>

<input id="hdnCurPage" type="hidden" />
<input id="hdnPrevPath" type="hidden" />