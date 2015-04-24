<fieldset><legend><?php echo GetString("Alignment") ; ?></legend>
	<table border="0" cellspacing="0" cellpadding="2" class="normal">
		<tr>
			<td><?php echo GetString("Horizontal") ; ?>:</td>
			<td>
				<select id="sel_align">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="left"><?php echo GetString("Left") ; ?></option>
					<option value="center"><?php echo GetString("Center") ; ?></option>
					<option value="right"><?php echo GetString("Right") ; ?></option>
					<option value="justify"><?php echo GetString("Justify") ; ?></option>
				</select>
			</td>
			<td style="white-space:nowrap;width:10" ></td>
			<td><?php echo GetString("Vertical") ; ?>:</td>
			<td>
				<select id="sel_valign" style="width:90px">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="sub"><?php echo GetString("Subscript") ; ?></option>
					<option value="super"><?php echo GetString("Superscript") ; ?></option>
					<option value="baseline"><?php echo GetString("Normal") ; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo GetString("Justification") ; ?>:</td>
			<td colspan="4">
				<select id="sel_justify">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="auto">Auto</option>
					<option value="newspaper">newspaper</option>
					<option value="distribute">distribute</option>
					<option value="distribute-all-lines">distribute-all-lines</option>
					<option value="inter-word">inter-word</option>
				</select>
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<legend>
		<?php echo GetString("Spacing") ; ?></legend>
	<table border="0" cellpadding="2" cellspacing="0" class="normal">
		<tr>
			<td><?php echo GetString("Letters") ; ?></td>
			<td><select style="width:64px" id="sel_letter">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="normal"><?php echo GetString("Normal") ; ?></option>
				</select>
				<?php echo GetString("OR") ; ?> <input type="text" id="tb_letter" style="width:70px" />
				<select id="sel_letter_unit">
					<option value="px">px</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo GetString("Height") ; ?></td>
			<td><select style="width:64px" id="sel_line">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="normal"><?php echo GetString("Normal") ; ?></option>
				</select>
				<?php echo GetString("OR") ; ?> <input type="text" id="tb_line" style="width:70px" />
				<select id="sel_line_unit">
					<option value="px">px</option>
					<option value="%">%</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select>
			</td>
		</tr>
	</table>
</fieldset>
<fieldset><legend><?php echo GetString("TextFlow") ; ?></legend>
	<table border="0" cellspacing="0" cellpadding="2" class="normal">
		<tr>
			<td style="width:80px"><?php echo GetString("Indentation") ; ?>:
			</td>
			<td><input type="text" id="tb_indent" style="width:70px" />
				<select id="sel_indent_unit">
					<option value="px">px</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo GetString("TextDirection") ; ?>:</td>
			<td><select id="sel_direction">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="ltr"><?php echo GetString("LTR") ; ?></option>
					<option value="rtl"><?php echo GetString("RTL") ; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo GetString("WritingMode") ; ?>:</td>
			<td>
				<select id="sel_writingmode">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="lr-tb"><?php echo GetString("lr-tb") ; ?></option>
					<option value="tb-rl"><?php echo GetString("tb-rl") ; ?></option>
				</select>
			</td>
		</tr>
	</table>
</fieldset>

<div id="outer"><div id="div_demo"><?php echo GetString("DemoText") ; ?></div></div>

<script type="text/javascript" src="../Scripts/Dialog/Dialog_Tag_Style_Text.js"></script>

