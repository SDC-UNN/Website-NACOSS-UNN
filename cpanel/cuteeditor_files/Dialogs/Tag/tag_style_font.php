
<fieldset>
    <legend><?php echo GetString("SystemFont") ; ?></legend>
	<select id="sel_font" style="width:240">
		<option value=""><?php echo GetString("NotSet") ; ?></option>
		<option value="caption"><?php echo GetString("Caption") ; ?></option>
		<option value="icon"><?php echo GetString("Icon") ; ?></option>
		<option value="menu"><?php echo GetString("Menu") ; ?></option>
		<option value="messagebox"><?php echo GetString("Messagebox") ; ?></option>
		<option value="smallcaption"><?php echo GetString("Smallcaption") ; ?></option>
		<option value="statusbar"><?php echo GetString("Statusbar") ; ?></option>
	</select>
</fieldset>
<div id="div_font_detail">
	<fieldset><legend><?php echo GetString("FontFamily") ; ?></legend>		
		<select id="sel_fontfamily" style="width:240" NAME="sel_fontfamily">
			<option value=""><?php echo GetString("NotSet") ; ?></option>
			<option value="Arial">Arial</option>
			<option value="Verdana">Verdana</option>
			<option value="Comic Sans MS">Comic Sans MS</option>
			<option value="Courier">Courier</option>
			<option value="Georgia">Georgia</option>
			<option value="Tahoma">Tahoma</option>
			<option value="Times New Roman">Times New Roman</option>
			<option value="Wingdings">Wingdings</option>
		</select>
	</fieldset>
	<fieldset><legend><?php echo GetString("Decoration") ; ?></legend>
		<input type="checkbox" id="cb_decoration_under" /><label for="cb_decoration_under"><?php echo GetString("Underline") ; ?></label>
		<input type="checkbox" id="cb_decoration_over" /><label for="cb_decoration_over"><?php echo GetString("Overline") ; ?></label>
		<input type="checkbox" id="cb_decoration_through" /><label for="cb_decoration_through"><?php echo GetString("Strikethrough") ; ?></label>
	</fieldset>
	<fieldset><legend><?php echo GetString("Style") ; ?></legend>
		<input type="checkbox" id="cb_style_bold" /><label for="cb_style_bold"><?php echo GetString("Bold") ; ?></label>
		<input type="checkbox" id="cb_style_italic" /><label for="cb_style_italic"><?php echo GetString("Italic") ; ?></label>
		&nbsp;&nbsp;<?php echo GetString("Capitalization") ; ?>:
		<select id="sel_fontTransform">
			<option value=""><?php echo GetString("NotSet") ; ?></option>
			<option value="uppercase"><?php echo GetString("uppercase") ; ?></option>
			<option value="lowercase"><?php echo GetString("lowercase") ; ?></option>
			<option value="capitalize"><?php echo GetString("InitialCap") ; ?></option>
		</select>
	</fieldset>
	<fieldset><legend><?php echo GetString("Size") ; ?></legend>
		<select id="sel_fontsize">
			<option value=""><?php echo GetString("NotSet") ; ?></option>
			<option value="xx-large">xx-large</option>
			<option value=" x-large">x-large</option>
			<option value="large">large</option>
			<option value="medium">medium</option>
			<option value="small">small</option>
			<option value="x-small">x-small</option>
			<option value="xx-small">xx-small</option>
			<option value="larger">larger</option>
			<option value="smaller">Smaller</option>
		</select>
		<?php echo GetString("OR") ; ?> <input type="text" id="inp_fontsize" style="width:56px" />
		<select id="sel_fontsize_unit">
			<option value="px">px</option>
			<option value="pt">pt</option>
			<option value="pc">pc</option>
			<option value="em">em</option>
			<option value="cm">cm</option>
			<option value="mm">mm</option>
			<option value="in">in</option>
		</select>
	</fieldset>
	<fieldset><legend><?php echo GetString("Color") ; ?></legend>
    <input autocomplete="off" size="7" type="text" id="inp_color" style="width:57px"/>
    <img alt="" id="inp_color_Preview" src="../Images/colorpicker.gif" style="margin-bottom:-2px"/>
	</fieldset>
</div>
<div id="outer"><div id="div_demo"><?php echo GetString("DemoText") ; ?></div>
</div>
<script type="text/javascript" src="../Scripts/Dialog/Dialog_Tag_Style_Font.js"></script>