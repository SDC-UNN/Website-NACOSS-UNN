<fieldset><legend><?php echo GetString("Input") ; ?></legend>
	<table class="normal">
		<tr>
			<td><?php echo GetString("Type") ; ?>:</td>
			<td colspan="3"><input type="text" id="inp_type" readonly="readonly" disabled="disabled" style="width:100px" /></td>
		</tr>
		<tr>
			<td style="width:60"><?php echo GetString("Name") ; ?>:</td>
			<td colspan="3"><input type="text" id="inp_name" style="width:100px" /></td>
		</tr>
		<tr>
			<td><?php echo GetString("Value") ; ?>:</td>
			<td colspan="3"><input type="text" id="inp_value" style="width:250px" /></td>
		</tr>
		<tr id="row_txt1">
			<td><?php echo GetString("Size") ; ?>:</td>
			<td colspan="3"><input type="text" id="inp_Size" style="width:100px" onkeypress="return CancelEventIfNotDigit()" /></td>
		</tr>
		<tr id="row_txt2">
			<td><?php echo GetString("MaxLength") ; ?>:</td>
			<td colspan="3"><input type="text" id="inp_MaxLength" style="width:100px" maxlength="9" onkeypress="return CancelEventIfNotDigit()" /></td>
		</tr>
		<tr id="row_img">
			<td><?php echo GetString("Src") ; ?>:</td>
			<td colspan="3">
			    <input type="text" id="inp_src" style="width:250px" />&nbsp; 
			    <input id="btnbrowse" value="<?php echo GetString("Browse") ; ?>" type="button" />
			</td>
		</tr>
		<tr id="row_img2">
			<td><?php echo GetString("Alignment") ; ?>:</td>
			<td>
				<select name="inp_Align" style="width:80px" id="sel_Align">
					<option id="optNotSet" value=""><?php echo GetString("NotSet") ; ?></option>
					<option id="optLeft" value="left"><?php echo GetString("Left") ; ?></option>
					<option id="optRight" value="right"><?php echo GetString("Right") ; ?></option>
					<option id="optTexttop" value="textTop"><?php echo GetString("Texttop") ; ?></option>
					<option id="optAbsMiddle" value="absMiddle"><?php echo GetString("Absmiddle") ; ?></option>
					<option id="optBaseline" value="baseline" selected="selected"><?php echo GetString("Baseline") ; ?></option>
					<option id="optAbsBottom" value="absBottom"><?php echo GetString("Absbottom") ; ?></option>
					<option id="optBottom" value="bottom"><?php echo GetString("Bottom") ; ?></option>
					<option id="optMiddle" value="middle"><?php echo GetString("Middle") ; ?></option>
					<option id="optTop" value="top"><?php echo GetString("Top") ; ?></option>
				</select>
			</td>
			<td><?php echo GetString("Bordersize") ; ?>:</td>
			<td>
<input type="text" size="2" name="inp_Border" onkeypress="return CancelEventIfNotDigit()" style="width:80px" id="inp_Border" />
			</td>
		</tr>
		<tr id="row_img3">
			<td><?php echo GetString("Width") ; ?>:</td>
			<td>
				<input type="text" onkeypress="return CancelEventIfNotDigit()" style="width:80px" size="2"
					id="inp_width" />
			</td>
			<td><?php echo GetString("Height") ; ?>:</td>
			<td>
				<input type="text" onkeypress="return CancelEventIfNotDigit()" style="width:80px" size="2"
					id="inp_height" />
			</td>
		</tr>
		<tr id="row_img4">
			<td><?php echo GetString("Horizontal") ; ?>:</td>
			<td>
				<input type="text" onkeypress="return CancelEventIfNotDigit()" style="width:80px" size="2"
					id="inp_HSpace" />
			</td>
			<td><?php echo GetString("Vertical") ; ?>:</td>
			<td>
				<input type="text" onkeypress="return CancelEventIfNotDigit()" style="width:80px" size="2"
					id="inp_VSpace" />
			</td>
		</tr>
		<tr id="row_img5">
			<td valign="middle" style="white-space:nowrap" ><?php echo GetString("Alternate") ; ?>:</td>
			<td colspan="3"><input type="text" id="AlternateText" size="24" name="AlternateText" style="width:250px" /></td>
		</tr>
		<tr>
			<td><?php echo GetString("ID") ; ?>:</td>
			<td colspan="3"><input type="text" id="inp_id" style="width:100px" /></td>
		</tr>
		<tr id="row_txt3">
			<td><?php echo GetString("AccessKey") ; ?>:</td>
			<td colspan="3">
				<input type="text" id="inp_access" size="1" maxlength="1" />
			</td>
		</tr>
		<tr id="row_txt4">
			<td>
				<?php echo GetString("TabIndex") ; ?>:
			</td>
			<td colspan="3">
				<input type="text" id="inp_index" size="5" value="" maxlength="5" onkeypress="return CancelEventIfNotDigit()" />&nbsp;
			</td>
		</tr>
		<tr id="row_chk">
			<td></td>
			<td><input type="checkbox" id="inp_checked" /><label for="inp_checked"><?php echo GetString("Checked") ; ?></label></td>
		</tr>
		<tr id="row_txt5">
			<td>
			</td>
			<td colspan="3"><input type="checkbox" id="inp_Disabled" /><label for="inp_Disabled"><?php echo GetString("Disabled") ; ?></label>
			</td>
		</tr>
		<tr id="row_txt6">
			<td>
			</td>
			<td colspan="3"><input type="checkbox" id="inp_Readonly" /><label for="inp_Readonly"><?php echo GetString("Readonly") ; ?></label>
			</td>
		</tr>
	</table>
</fieldset>
<script type="text/javascript" src="../Scripts/Dialog/Dialog_Tag_Input.js"></script>