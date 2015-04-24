<style type="text/css">
	.codebutton
	{
		width:110px; 
	}
</style>
<fieldset><legend><?php echo GetString("Input") ; ?></legend>
	<table class="normal">
		<tr>
			<td style="width:60"><?php echo GetString("Name") ; ?>:</td>
			<td><input type="text" id="inp_name" style="width:100px" /></td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td><?php echo GetString("AccessKey") ; ?>:</td>
			<td>
				<input type="text" id="inp_access" size="1" maxlength="1" />
			</td>
		</tr>
		<tr>
			<td><?php echo GetString("ID") ; ?>:</td>
			<td><input type="text" id="inp_id" style="width:100px" /></td>
			<td>&nbsp;&nbsp;</td>
			<td>
				<?php echo GetString("TabIndex") ; ?>:
			</td>
			<td>
				<input type="text" id="inp_index" size="5" value="" maxlength="5" onkeypress="return CancelEventIfNotDigit()" />&nbsp;
			</td>
		</tr>
		<tr>
			<td><?php echo GetString("Size") ; ?>:</td>
			<td colspan="4"><input type="text" id="inp_size" style="width:100px" /></td>
		</tr>
		<tr>
			<td>
			</td>
			<td colspan="4"><input type="checkbox" id="inp_Multiple" /><label for="inp_Multiple"><?php echo GetString("AllowMultipleSelections") ; ?></label>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td colspan="4"><input type="checkbox" id="inp_Disabled" /><label for="inp_Disabled"><?php echo GetString("Disabled") ; ?></label>
			</td>
		</tr>
	</table>
	<?php echo GetString("Items") ; ?>:
	<br />
	<table class="normal">
		<tr>
			<td><?php echo GetString("Text") ; ?>:
				<br />
				<input type="text" id="inp_item_text" style="width:130px" />
			</td>
			<td><?php echo GetString("Value") ; ?>:
				<br />
				<input type="text" id="inp_item_value" style="width:130px" />
			</td>
			<td rowspan="3" valign="top">
				<table>
					<tr>
						<td colspan="2"><button class="codebutton" onclick="Insert();" id="btnInsertItem"><?php echo GetString("Insert") ; ?></button>
						</td>
					</tr>
					<tr>
						<td colspan="2"><button class="codebutton" onclick="Update();" id="btnUpdateItem"><?php echo GetString("Update") ; ?></button>
						</td>
					</tr>
					<tr>
						<td colspan="2"><button class="codebutton" onclick="Delete();" id="btnDeleteItem"><?php echo GetString("Delete") ; ?></button>
						</td>
					</tr>
					<tr>
						<td colspan="2"><button class="codebutton" onclick="Move(1);" id="btnMoveUpItem"><?php echo GetString("MoveUp") ; ?></button>
						</td>
					</tr>
					<tr>
						<td colspan="2"><button class="codebutton" onclick="Move(-1);" id="btnMoveDownItem"><?php echo GetString("MoveDown") ; ?></button>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><select size="6" id="list_options" style="width:130px" onchange="document.getElementById('list_options2').selectedIndex = this.selectedIndex;Select(this);FireUIChanged();"></select></td>
			<td><select size="6" id="list_options2" style="width:130px" onchange="document.getElementById('list_options').selectedIndex = this.selectedIndex;Select(this);FireUIChanged();"></select></td>
		</tr>
		<tr>
			<td><?php echo GetString("Color") ; ?>:&nbsp;<input autocomplete="off" size="7" type="text" id="inp_item_forecolor" />
			<img alt="" id="inp_item_forecolor_Preview" src="../Images/colorpicker.gif" style="margin-bottom:-2px"/>
			</td>
			<td><?php echo GetString("BackColor") ; ?>:&nbsp;<input autocomplete="off" size="7" type="text" id="inp_item_backcolor" />
			<img alt="" id="inp_item_backcolor_Preview" src="../Images/colorpicker.gif" style="margin-bottom:-2px"/>
			</td>
		</tr>
	</table>
</fieldset>
<script type="text/javascript" src="../Scripts/Dialog/Dialog_Tag_Select.js"></script>