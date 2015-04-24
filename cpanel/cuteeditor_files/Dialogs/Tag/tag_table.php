<fieldset>
    <legend><?php echo GetString("Table") ; ?></legend>
	<table class="normal">
		<tr>
			<td><?php echo GetString("CellSpacing") ; ?>:</td>
			<td><input type="text" id="inp_cellspacing"  size="14" onkeypress="return CancelEventIfNotDigit()" /></td>
			<td><?php echo GetString("CellPadding") ; ?>:</td>
			<td><input type="text" id="inp_cellpadding"  size="14" onkeypress="return CancelEventIfNotDigit()" /></td>
		</tr>
		<tr>
			<td><?php echo GetString("ID") ; ?>:</td>
			<td><input type="text" id="inp_id" size="14" />&nbsp;&nbsp;</td>
			<td><?php echo GetString("Border") ; ?>:</td>
			<td><input type="text" id="inp_border"  size="14" onkeypress="return CancelEventIfNotDigit()" /></td>
		</tr>
		<tr>
			<td><?php echo GetString("Backgroundcolor") ; ?>:
			</td>
			<td><input autocomplete="off" type="text" id="inp_bgcolor"  size="14"/>
			</td>
			<td><?php echo GetString("BorderColor") ; ?>:
			</td>
			<td><input autocomplete="off" type="text" id="inp_bordercolor" size="14"/>
			</td>
		</tr>
		<tr>
			<td valign="middle" style="white-space:nowrap" ><?php echo GetString("Rules") ; ?>:</td>
			<td><select id="sel_rules">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="all">all</option>
					<option value="rows">rows</option>
					<option value="cols">cols</option>
					<option value="none">none</option>
				</select>
			</td>
			<td colspan="2">
				<input type="checkbox" id="inp_collapse" />
				<label for="inp_collapse"><?php echo GetString("CollapseBorder") ; ?></label>&nbsp;				
			</td>
		</tr>
	</table>
	<table class="normal">
		<tr>
			<td style='width:60px'><?php echo GetString("Summary") ; ?> :</td>
			<td>
				<textarea id="inp_summary" rows="3" cols="20" style="width:320px"></textarea>
			</td>
		</tr>
	</table>
	<table class="normal" id="CaptionTable">
		<tr>
			<td style='width:60px'><?php echo GetString("Caption") ; ?> :</td>
			<td>
             <button id="btn_editcaption"><?php echo GetString("Insert") ; ?></button>
             <button id="btn_delcaption"><?php echo GetString("Delete") ; ?> </button>
			</td>
			<td>&nbsp;</td>
			<td><?php echo GetString("THEAD") ; ?>:</td>
			<td>
            <button id="btn_insthead">
              <?php echo GetString("Insert") ; ?>
            </button>
			</td>
			
			<td>&nbsp;</td>
			<td><?php echo GetString("TFOOT") ; ?>:</td>
			<td>
            <button id="btn_instfoot">
              <?php echo GetString("Insert") ; ?>
            </button>	
			</td>
			<td style="width:5px"></td>
			<td><img src="../Images/Accessibility.gif" title="Accessibility" /></td>
		</tr>
	</table>
</fieldset>
<fieldset><legend><?php echo GetString("Common") ; ?></legend>
	<table class="normal">
		<tr>
			<td style='width:60px'><?php echo GetString("CssClass") ; ?>:</td>
			<td><input type="text" id="inp_class" style="width:80px" /></td>
			<td><?php echo GetString("Width") ; ?>:</td>
			<td style="white-space:nowrap">
				<input type="text" id="inp_width" style="width:42px" />
				<select id="sel_width_unit">
					<option value="px">px</option>
					<option value="%">%</option>
				</select>
			</td>
			<td><?php echo GetString("Height") ; ?>:</td>
			<td style="white-space:nowrap">
				<input type="text" id="inp_height" style="width:42px" />
				<select id="sel_height_unit">
					<option value="px">px</option>
					<option value="%">%</option>
				</select>
			</td>
		</tr>
	</table>
	<table class="normal">
		<tr>
			<td style='width:60px'><?php echo GetString("Alignment") ; ?>:</td>
			<td><select id="sel_align">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="left"><?php echo GetString("Left") ; ?></option>
					<option value="center"><?php echo GetString("Center") ; ?></option>
					<option value="right"><?php echo GetString("Right") ; ?></option>
				</select></td>
			<td>
				<?php echo GetString("Text-Align") ; ?> :</td>
			<td><select id="sel_textalign">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="left"><?php echo GetString("Left") ; ?></option>
					<option value="center"><?php echo GetString("Center") ; ?></option>
					<option value="right"><?php echo GetString("Right") ; ?></option>
					<option value="justify"><?php echo GetString("Justify") ; ?></option>
				</select></td>
			<td><?php echo GetString("Float") ; ?>:
			</td>
			<td><select id="sel_float">
					<option value=""><?php echo GetString("NotSet") ; ?></option>
					<option value="left"><?php echo GetString("Left") ; ?></option>
					<option value="right"><?php echo GetString("Right") ; ?></option>
				</select></td>
		</tr>
	</table>
	<table class="normal">
		<tr>
			<td style='width:60px'><?php echo GetString("Title") ; ?> :</td>
			<td>
				<textarea id="inp_tooltip" rows="3" cols="20" style="width:320px"></textarea>
			</td>
		</tr>
	</table>
</fieldset>
<script type="text/javascript" >
	    var Caption = "<?php echo GetString("Caption") ; ?>";
	    var Delete = "<?php echo GetString("Delete") ; ?>";
	    var Insert = "<?php echo GetString("Insert") ; ?>";
	    var Edit = "<?php echo GetString("Edit") ; ?>";
	    var ValidID = "<?php echo GetString("ValidID") ; ?>";
</script>
<script type="text/javascript" src="../Scripts/Dialog/Dialog_Tag_Table.js"></script>
