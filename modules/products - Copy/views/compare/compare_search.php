<div id="cmobile-search" class="compar_search jqtransformdone">
	<div id="cw_br">
		<label for="c_br">Nhà sản xuất:</label>
		<select id='manu_id' size="1" name="manu_id">
			<option  value="0">-- Tất cả --</option>
			<?php foreach ($manu_fac as $manu) {	?>
				<option value="<?php echo $manu->id ; ?>"><?php echo  $manu->name;?></option>
			<?php }	?>
		</select>
		<div class="clear"></div>
	</div>
	<div id="ss_bt">
	<label>&nbsp;</label>
		<div class="jqTransformButton" table_name="<?php echo $tablename;?>">Xem danh sách</div>
	</div>
	<div class="clear"></div>
</div>