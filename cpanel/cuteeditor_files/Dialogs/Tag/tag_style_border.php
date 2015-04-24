
<style type="text/css">
#div_selector_event
{
	width:45;height:45;padding:5px;border:1px solid white;
}
#div_selector
{
	width:40;height:40;border:4px solid white;
}
</style>
<fieldset>
	<legend>
		<?php echo GetString("Borders") ; ?></legend>
	<table border="0" cellspacing="0" cellpadding="2" class="normal">
		<tr>
			<td style="width:48">
				<div id="div_selector_event">
					<div id="div_selector">
					</div>
				</div>
			</td>
			<td>
				<select id="sel_part">
					<option value=""><?php echo GetString("All") ; ?></option>
					<option value="Top"><?php echo GetString("Top") ; ?></option>
					<option value="Left"><?php echo GetString("Left") ; ?></option>
					<option value="Right"><?php echo GetString("Right") ; ?></option>
					<option value="Bottom"><?php echo GetString("Bottom") ; ?></option>
				</select>
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<legend>
		<?php echo GetString("Border") ; ?></legend>
	<table border="0" cellspacing="0" cellpadding="2" class="normal">
		<tr>
			<td style="width:48"><?php echo GetString("Margin") ; ?></td>
			<td>
				<input type="text" id="tb_margin" style="width:80px" />
				<select id="sel_margin_unit">
					<option value="px">px</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select></td>
		</tr>
		<tr>
			<td><?php echo GetString("Padding") ; ?></td>
			<td><input type="text" id="tb_padding" style="width:80px" />
				<select id="sel_padding_unit">
					<option value="px">px</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select></td>
		</tr>
		<tr>
			<td><?php echo GetString("Border") ; ?></td>
			<td><input type="text" id="tb_border" style="width:80px" />
				<select id="sel_border_unit">
					<option value="px">px</option>
					<option value="pt">pt</option>
					<option value="pc">pc</option>
					<option value="em">em</option>
					<option value="cm">cm</option>
					<option value="mm">mm</option>
					<option value="in">in</option>
				</select>
				<?php echo GetString("OR") ; ?>
				<select id="sel_border">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="medium"><?php echo GetString("Medium") ; ?></option>
					<option value="thin"><?php echo GetString("Thin") ; ?></option>
					<option value="thick"><?php echo GetString("Thick") ; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo GetString("Style") ; ?></td>
			<td><select id="sel_style">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="none"><?php echo GetString("None") ; ?></option>
					<option value="solid">solid</option>
					<option value="inset">inset</option>
					<option value="outset">outset</option>
					<option value="ridge">ridge</option>
					<option value="dotted">dotted</option>
					<option value="dashed">dashed</option>
					<option value="groove">groove</option>
					<option value="double">double</option>
				</select></td>
		</tr>
		<tr>
			<td><?php echo GetString("Color") ; ?></td>
			<td>
				<input autocomplete="off" size="7" type="text" id="inp_color" style="width:57px"/>
				<img alt="" id="inp_color_Preview" src="../Images/colorpicker.gif" style="margin-bottom:-2px"/>
			</td>
		</tr>
	</table>
</fieldset>
<div id="outer"><div id="div_demo"><?php echo GetString("DemoText") ; ?></div>
</div>
<script type="text/javascript" src="../Scripts/Dialog/Dialog_Tag_Style_Border.js"></script>