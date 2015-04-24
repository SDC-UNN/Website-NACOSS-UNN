<fieldset>
	<legend><?php echo GetString("Attributes") ; ?></legend>
	<div align="left" style="padding-left:12px">
		<table class="normal">
			<tr>		
				<td><?php echo GetString("CssClass") ; ?>:</td>
				<td><input type="text" id="inp_class" style="width:100px" /></td>	
			</tr>
			<tr>
			<td><?php echo GetString("Width") ; ?> :</td>
				<td><input type="text" id="inp_width" style="width:100px" onkeypress="return CancelEventIfNotDigit()" /></td>
				
			</tr>
			<tr>
				<td><?php echo GetString("Height") ; ?> :</td>
				<td><input type="text" id="inp_height" style="width:100px" onkeypress="return CancelEventIfNotDigit()" /></td>
			</tr>
			<tr>		
				<td><?php echo GetString("Alignment") ; ?>:</td>
				<td><select id="sel_align" style="width:100px">
						<option value=""><?php echo GetString("NotSet") ; ?></option>
						<option value="left"><?php echo GetString("Left") ; ?></option>
						<option value="center"><?php echo GetString("Center") ; ?></option>
						<option value="right"><?php echo GetString("Right") ; ?></option>
					</select>
				</td>
			</tr>
			<tr>		
				<td><?php echo GetString("Text-Align") ; ?>:</td>
				<td><select id="sel_textalign" style="width:100px">
						<option value=""><?php echo GetString("NotSet") ; ?></option>
						<option value="left"><?php echo GetString("Left") ; ?></option>
						<option value="center"><?php echo GetString("Center") ; ?></option>
						<option value="right"><?php echo GetString("Right") ; ?></option>
						<option value="justify"><?php echo GetString("Justify") ; ?></option>
					</select>
				</td>
			</tr>
			<tr>		
				<td><?php echo GetString("Float") ; ?>:</td>
				<td><select id="sel_float" style="width:100px">
						<option value=""><?php echo GetString("NotSet") ; ?></option>
						<option value="left"><?php echo GetString("Left") ; ?></option>
						<option value="right"><?php echo GetString("Right") ; ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php echo GetString("Color") ; ?></td>
				<td>
<input autocomplete="off" type="text" id="inp_forecolor" name="inp_forecolor" size="7" style="width:57px;" />
<img alt="" src="../Images/colorpicker.gif" id="img_forecolor" style="vertical-align:top;" />
				</td>
			</tr>
			<tr>
				<td><?php echo GetString("BackColor") ; ?></td>
				<td>
<input autocomplete="off" type="text" id="inp_backcolor" name="inp_forecolor" size="7" style="width:57px;" />
<img alt="" src="../Images/colorpicker.gif" id="img_backcolor" style="vertical-align:top;" />
				</td>
			</tr>
			<tr>		
				<td style='width:100px'><?php echo GetString("Title") ; ?>:</td>
				<td>
					<textarea id="inp_tooltip" rows="3" cols="20" style="width:200px"></textarea>
				</td>
			</tr>
		</table>
	</div>
</fieldset>
<script type="text/javascript" src="../Scripts/Dialog/Dialog_Tag_Common.js"></script>