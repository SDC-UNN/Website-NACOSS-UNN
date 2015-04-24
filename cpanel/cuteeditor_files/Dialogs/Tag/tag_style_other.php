
<fieldset>
	<legend>
	<?php echo GetString("Cursor") ; ?>
	</legend>
	<select id="sel_cursor">
		<option value=""><?php echo GetString("NotSet") ; ?></option>
		<option value="Default"><?php echo GetString("Default") ; ?></option>
		<option value="Move"><?php echo GetString("Move") ; ?></option>
		<option value="Text">Text</option>
		<option value="Wait">Wait</option>
		<option value="Help">Help</option>
		<!-- x-resize -->
	</select>
</fieldset>

<fieldset>
	<legend>
	<?php echo GetString("Filter") ; ?>
	</legend>
	<input type="text" id="inp_filter" style="width:240px" /> <!--button filter builder-->
</fieldset>
<div id="outer"><div id="div_demo"><?php echo GetString("DemoText") ; ?></div></div>

<script type="text/javascript">

var sel_cursor=Window_GetElement(window,"sel_cursor",true);
var inp_filter=Window_GetElement(window,"inp_filter",true);
var outer=Window_GetElement(window,"outer",true);
var div_demo=Window_GetElement(window,"div_demo",true);

function UpdateState()
{
	div_demo.style.cssText=element.style.cssText;
}

function SyncToView()
{
	sel_cursor.value=element.style.cursor;
	if(Browser_IsWinIE())
	{
		inp_filter.value=element.style.filter;
	}
}
function SyncTo(element)
{
	element.style.cursor=sel_cursor.value;
	if(Browser_IsWinIE())
	{
		element.style.filter=inp_filter.value;
	}
}

</script>