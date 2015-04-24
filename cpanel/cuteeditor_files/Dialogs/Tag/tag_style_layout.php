
<fieldset><legend><?php echo GetString("Layout") ; ?></legend>
	<table border="0" cellspacing="0" cellpadding="2" class="normal">
		<tr>
			<td style="width:30px"><?php echo GetString("Position") ; ?>:
			</td>
			<td><select style="width:80px" id="sel_position">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="absolute"><?php echo GetString("Absolute") ; ?></option>
					<option value="relative"><?php echo GetString("Relative") ; ?></option>
				</select></td>
			<td style="width:30px"><?php echo GetString("Display") ; ?>:
			</td>
			<td><select style="width:80px" id="sel_display">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="block">block</option>
					<option value="inline">inline</option>
					<option value="inline-block">inline-block</option>
				</select></td>
		</tr>
		<tr>
			<td style="width:30px"><?php echo GetString("Float") ; ?>:
			</td>
			<td><select style="width:80px" id="sel_float">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="left"><?php echo GetString("FloatLeft") ; ?></option>
					<option value="right"><?php echo GetString("FloatRight") ; ?></option>
					<option value="none"><?php echo GetString("FloatNone") ; ?></option>
				</select></td>
			<td style="width:30px"><?php echo GetString("Clear") ; ?>:
			</td>
			<td><select style="width:80px" id="sel_clear">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="left"><?php echo GetString("ClearLeft") ; ?></option>
					<option value="right"><?php echo GetString("ClearRight") ; ?></option>
					<option value="both"><?php echo GetString("ClearBoth") ; ?></option>
					<option value="none"><?php echo GetString("ClearNone") ; ?></option>
				</select></td>
		</tr>
	</table>
</fieldset>
<fieldset><legend><?php echo GetString("Size") ; ?></legend>
	<table border="0" cellspacing="0" cellpadding="2" class="normal">
		<tr>
			<td style="width:30px"><?php echo GetString("Top") ; ?></td>
			<td><nobr><input type="text" id="tb_top" style="width:40px" />
				<select id="sel_top_unit">
					<option value="px">px</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select></nobr></td>
			<td style="width:30px"><?php echo GetString("Height") ; ?></td>
			<td><nobr><input type="text" id="tb_height" style="width:40px" />
				<select id="sel_height_unit">
					<option value="px">px</option>
					<option value="%">%</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select></nobr></td>
		</tr>
		<tr>
			<td style="width:30px"><?php echo GetString("Left") ; ?></td>
			<td><nobr><input type="text" id="tb_left" style="width:40px" />
				<select id="sel_left_unit">
					<option value="px">px</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select></nobr></td>
			<td style="width:30px"><?php echo GetString("Width") ; ?></td>
			<td><nobr><input type="text" id="tb_width" style="width:40px" />
				<select id="sel_width_unit">
					<option value="px">px</option>
					<option value="%">%</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select></nobr></td>
		</tr>
	</table>
</fieldset>
<fieldset><legend><?php echo GetString("Clipping") ; ?></legend>
	<table border="0" cellspacing="0" cellpadding="2" class="normal">
		<tr>
			<td style="width:30px"><?php echo GetString("Top") ; ?></td>
			<td><input type="text" id="tb_cliptop" style="width:40px" />
				<select id="sel_cliptop_unit">
					<option value="px">px</option>
					<option value="%">%</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select></td>
			<td style="width:30px"><?php echo GetString("Bottom") ; ?></td>
			<td><input type="text" id="tb_clipbottom" style="width:40px" />
				<select id="sel_clipbottom_unit">
					<option value="px">px</option>
					<option value="%">%</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select></td>
		</tr>
		<tr>
			<td style="width:30px"><?php echo GetString("Left") ; ?></td>
			<td><input type="text" id="tb_clipleft" style="width:40px" />
				<select id="sel_clipleft_unit">
					<option value="px">px</option>
					<option value="%">%</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select></td>
			<td style="width:30px"><?php echo GetString("Right") ; ?></td>
			<td><input type="text" id="tb_clipright" style="width:40px" />
				<select id="sel_clipright_unit">
					<option value="px">px</option>
					<option value="%">%</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select></td>
		</tr>
	</table>
</fieldset>
<fieldset><legend><?php echo GetString("Misc") ; ?></legend>
	<div><?php echo GetString("Overflow") ; ?>:
		<select id="sel_overflow">
			<option value=""><?php echo GetString("NotSet") ; ?></option>
			<option value="auto"><?php echo GetString("OverflowAuto") ; ?></option>
			<option value="scroll"><?php echo GetString("OverflowScroll") ; ?></option>
			<option value="visible"><?php echo GetString("OverflowVisible") ; ?></option>
			<option value="hidden"><?php echo GetString("OverflowHidden") ; ?></option>
		</select>
		z-index: <input type="text" style="width:60px" id="tb_zindex" />
	</div>
	<table border="0" cellspacing="0" cellpadding="0" class="normal">
		<tr>
			<td style="width:120"><?php echo GetString("PrintingBefore") ; ?>:</td>
			<td><select id="sel_pagebreakbefore"><option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="auto"><?php echo GetString("Auto") ; ?></option>
					<option value="always"><?php echo GetString("Always") ; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo GetString("PrintingAfter") ; ?>:
			</td>
			<td><select id="sel_pagebreakafter"><option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="auto"><?php echo GetString("Auto") ; ?></option>
					<option value="always"><?php echo GetString("Always") ; ?></option>
				</select></td>
		</tr>
	</table>
</fieldset>
<div id="outer" style="height:100px"><div id="div_demo"><?php echo GetString("DemoText") ; ?></div></div>
<br />
<script type="text/javascript" src="../Scripts/Dialog/Dialog_Tag_Style_Layout.js"></script>