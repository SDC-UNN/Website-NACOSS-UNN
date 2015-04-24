<fieldset><legend><?php echo GetString("EditRow") ; ?></legend>
	<table class="normal">
		<tr>
			<td colspan="2">
				<table class="normal" cellpadding="2" cellspacing="1">
					<tr>
						<td style="white-space:nowrap; width:80;" ><?php echo GetString("Width") ; ?> :</td>
						<td><input type="text" id="inp_width" onkeypress="return CancelEventIfNotDigit()" size="14" /></td>
						<td>&nbsp;</td>
						<td style="white-space:nowrap; width:80;" ><?php echo GetString("Height") ; ?> :</td>
						<td><input type="text" id="inp_height" onkeypress="return CancelEventIfNotDigit()" size="14" /></td>
					</tr>
					<tr>
						<td><?php echo GetString("Alignment") ; ?>:</td>
						<td>
							<select id="sel_align" style="width:90px">
								<option value=""><?php echo GetString("NotSet") ; ?></option>
								<option value="left"><?php echo GetString("Left") ; ?></option>
								<option value="center"><?php echo GetString("Center") ; ?></option>
								<option value="right"><?php echo GetString("Right") ; ?></option>
							</select>
						</td>
						<td></td>
						<td><?php echo GetString("Vertical") ; ?> <?php echo GetString("Alignment") ; ?>:</td>
						<td><select id="sel_valign" style="width:90px">
								<option value=""><?php echo GetString("NotSet") ; ?></option>
								<option value="top"><?php echo GetString("Top") ; ?></option>
								<option value="middle"><?php echo GetString("Middle") ; ?></option>
								<option value="baseline"><?php echo GetString("Baseline") ; ?></option>
								<option value="bottom"><?php echo GetString("Bottom") ; ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td width="100"><?php echo GetString("Backgroundcolor") ; ?>:</td>
						<td>
 <input autocomplete="off" type="text" id="inp_bgColor" name="inp_bgColor" size="14" />
					   </td>
						<td></td>
						<td><?php echo GetString("BackColor") ; ?>:</td>
						<td>
 <input autocomplete="off" type="text" id="inp_borderColor" name="inp_borderColor" size="14" />
						</td>
					</tr>
					<tr>
						<td><?php echo GetString("BorderColorLight") ; ?>:</td>
						<td>
 <input autocomplete="off" type="text" id="inp_borderColorLight" name="inp_borderColorLight" size="14" />
						</td>
						<td></td>
						<td><?php echo GetString("BorderColorDark") ; ?>:</td>
						<td>
<input autocomplete="off" type="text" id="inp_borderColorDark" name="inp_borderColorDark" size="14" />
						</td>
					</tr>
					<tr>
						<td><?php echo GetString("CssClass") ; ?>:</td>
						<td><input size="14" type="text" id="inp_class" /></td>
						<td></td>
						<td valign="middle" style="white-space:nowrap"><?php echo GetString("ID") ; ?>:</td>
						<td><input type="text" id="inp_id" size="14" /></td>
					</tr>
					<tr>
						<td><?php echo GetString("Title") ; ?>:</td>
						<td colspan="4"><textarea id="inp_tooltip" rows="6" cols="53"></textarea></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</fieldset>
<script type="text/javascript" src="../Scripts/Dialog/Dialog_Tag_Tr.js"></script>
