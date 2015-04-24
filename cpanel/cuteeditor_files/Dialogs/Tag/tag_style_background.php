<fieldset style="padding: 3px;"><legend><?php echo GetString("Backgroundcolor") ; ?></legend>
	<input type="text" id="inp_color" name="inp_color" size="7" style="width:57px" />
	<img alt="" src="../Images/colorpicker.gif" id="inp_color_Preview" style='vertical-align:top;' />
	
</fieldset>
<fieldset style="padding: 3px;"><legend><?php echo GetString("Backgroundimage") ; ?></legend>
	<div>
		<?php echo GetString("Url") ; ?>: <input id="tb_image" type="text" style="width:220px" />
		<input type="button" id="btnbrowse" value=" ... "/>
	</div>
	<div style="padding-left: 32px;">
		<table border="0" cellpadding="2" cellspacing="0" class="normal">
			<tr>
				<td style="width:80px"><?php echo GetString("Tiling") ; ?>: </td>
				<td><select id="sel_bgrepeat" style="width:140px">
						<option value=""><?php echo GetString("NotSet") ; ?></option>
						<option value="repeat"><?php echo GetString("Tilingboth") ; ?></option>
						<option value="repeat-x"><?php echo GetString("Tilingorizontal") ; ?></option>
						<option value="repeat-y"><?php echo GetString("Tilingvertical") ; ?></option>
						<option value="no-repeat"><?php echo GetString("NoTiling") ; ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php echo GetString("Scrolling") ; ?>: </td>
				<td><select id="sel_bgattach" style="width:140px">
						<option value=""><?php echo GetString("NotSet") ; ?></option>
						<option value="scroll"><?php echo GetString("Scrollingbackground") ; ?></option>
						<option value="fixed"><?php echo GetString("ScrollingFixed") ; ?></option>
					</select>
				</td>
			</tr>
		</table>
	</div>
	<fieldset><legend><?php echo GetString("Position") ; ?></legend>
		<table border="0" cellpadding="2" cellspacing="0" class="normal">
			<tr>
				<td><?php echo GetString("Horizontal") ; ?></td>
				<td><select style="width:80px" id="sel_hor">
						<option value=""><?php echo GetString("NotSet") ; ?></option>
						<option value="left"><?php echo GetString("Left") ; ?></option>
						<option value="center"><?php echo GetString("Center") ; ?></option>
						<option value="right"><?php echo GetString("Right") ; ?></option>
					</select>
					<?php echo GetString("OR") ; ?> <input type="text" id="tb_hor" style="width:60px" />
					<select id="sel_hor_unit">
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
				<td><?php echo GetString("Vertical") ; ?></td>
				<td><select style="width:80px" id="sel_ver">
						<option value=""><?php echo GetString("NotSet") ; ?></option>
						<option value="top"><?php echo GetString("top") ; ?></option>
						<option value="center"><?php echo GetString("Center") ; ?></option>
						<option value="bottom"><?php echo GetString("Bottom") ; ?></option>
					</select>
					<?php echo GetString("OR") ; ?> <input type="text" id="tb_ver" style="width:60px" />
					<select id="sel_ver_unit">
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
		</table>
	</fieldset>
</fieldset>
<div id="outer"><div id="div_demo"><?php echo GetString("DemoText") ; ?></div></div>

<script type="text/javascript" src="../Scripts/Dialog/Dialog_Tag_Style_Background.js"></script>