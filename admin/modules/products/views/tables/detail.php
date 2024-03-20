
<!-- HEAD -->
<?php 

$title = isset($data)?"S&#7917;a b&#7843;ng":"Tạo mới bảng"; 
global $toolbar;
$toolbar->setTitle($title);
if(isset($data)){
	$toolbar->addButton('filter',FSText::_("B&#7897; l&#7885;c"),'','filter-export.png');
	$toolbar->addButton('apply_edit',FSText::_('L&#432;u t&#7841;m'),'','apply.png'); 
	$toolbar->addButton('save_edit',FSText::_('L&#432;u'),'','save.png'); 
	$tablename = FSInput::get('tablename');
} else {
	$toolbar->addButton('apply_new',FSText::_('L&#432;u t&#7841;m'),'','apply.png'); 
	$toolbar->addButton('save_new',FSText::_('L&#432;u'),'','save.png'); 
}
$toolbar->addButton('cancel',FSText::_('Tho&#225;t'),'','cancel.png');
$max_ordering = 0;
?>
<!-- END HEAD-->
<!-- BODY-->
<div class="form_body">
	

	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
		
		<!--	TABLE	-->
		<fieldset>
			<legend>T&#7841;o t&#234;n b&#7843;ng</legend>
			<div id="tabs">
				<br/>
				<p class="notice blue">Tên bảng chỉ chứa các : Chữ cái thường, số ,gạch dưới. Tránh các bảng đặc biệt gồm : <strong>tables,categories,filters,fields_groups</strong>
				</p>
				<br/>
				<table>
					<tr>
						<td> T&#234;n b&#7843;ng: </td>
						<td>
							<?php if(isset($data)){ ?> 	
								<?php if(strpos($tablename, 'fs_'.$this->type.'_') !== false){$tablename = str_replace('fs_'.$this->type.'_','',$tablename);}?>
								<input type="text" name = "table_name"  value = "<?php echo $tablename; ?>" />
								<input type="hidden" name = "table_name_begin"  value = "<?php echo $tablename; ?>" />
							<?php } else { ?>
								<input type="text" name = "table_name"  />
							<?php } ?>
						</td>
					</tr>
				</table>
			</div>
		</fieldset>
		<!--	end TABLE	-->
		
		
		<!--	FIELD	-->
		<fieldset>
			<legend>T&#7841;o field cho b&#7843;ng</legend>
			<div id="tabs">
				<p class="notice blue">Tên trường chỉ chứa các : Chữ cái, số ,gạch dưới. Không đặt tên trường là: <strong><?php echo $str_field_default; ?></strong>
				</p>
				<br/>
				<table cellpadding="5" class="field_tbl" width="100%" border="1" bordercolor="red">
					<tr>
						<td> Thứ tự</td>
						<td> T&#234;n hi&#7875;n th&#7883;</td>
						<td> T&#234;n tr&#432;&#7901;ng</td>
						<td> Nhóm trường </td>
						<td> Ki&#7875;u d&#7919; li&#7879;u </td>
						<td> Bảng tham chiếu</td>
						<td> Trường chính </td>
						<td> Chỉ để lọc </td>
						<td> Cấu hình TĐ </td>
						<td> Tính giá </td>
						<td> X&#243;a</td>
					</tr>
					<?php $i = 0;?>
					<?php if(isset($data) && count($data)) { 
						$array_default = array('id','productid','categoryid','manufactory','models');

						foreach ($data as $field) { 
							if( !in_array(strtolower($field->field_name),$array_default) ){
								$field_name = $field->field_name;
								$ordering = $field->ordering? $field->ordering: 0;
								$max_ordering = $max_ordering > $ordering ? $max_ordering:$ordering;
								?>

								<tr id="extend_field_exist_<?php echo $i; ?>">
									<td valign="top" class="left_col">
										<input type="text" name='ordering_exist_<?php echo $i;?>' value="<?php echo $ordering; ?>"  class='ordering' size="2"/>
										<input type="hidden" name='ordering_exist_<?php echo $i;?>_begin' value="<?php echo $field->ordering; ?>" />
									</td>
									<td valign="top" class="left_col">
										<input type="text" name='fshow_exist_<?php echo $i;?>' value="<?php echo $field->field_name_display; ?>" />
										<input type="hidden" name='fshow_exist_<?php echo $i;?>_begin' value="<?php echo $field->field_name_display; ?>" />
									</td>
									<td valign="top" class="left_col">
										<input type="text" name='fname_exist_<?php echo $i;?>' value="<?php echo $field_name; ?>" />
										<input type="hidden" name='fname_exist_<?php echo $i;?>_begin' value="<?php echo $field_name; ?>" />
									</td>
									<td class="right_col">
										<?php $cat_compare = isset($field->group_id)?$field->group_id:0; ?>
										<select name="group_id_exist_<?php echo $i;?>"  id="group_id" >
											<option value="0" >Chọn nhóm trường</option>
											<?php 
											foreach ($group_field as $item)
											{
												$checked = "";
												if($cat_compare == $item->id )
													$checked = "selected=\"selected\"";
												?>
												<option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name;  ?> </option>
												<?php 
											}?>
										</select>

										<input type="hidden" name='group_id_exist_<?php echo $i;?>_begin' value="<?php echo $field->group_id; ?>" />
									</td>
									<td class="right_col">
										<select name='ftype_exist_<?php echo $i;?>' class='ftype_exist' id='ftype_exist_<?php echo $i;?>' onchange="javascript: change_ftype(this);" >
											<option value="varchar" <?php echo  $field->field_type == "varchar" ? "selected=\"selected\"":""; ?>>Chuỗi ký tự</option>
											<option value="int" <?php echo  $field->field_type == "int" ? "selected=\"selected\"":""; ?>>Kiểu số</option>
											<option value="datetime" <?php echo  $field->field_type == "datetime" ? "selected=\"selected\"":""; ?>>Thời gian</option>
											<option value="text" <?php echo  $field->field_type == "text" ? "selected=\"selected\"":""; ?>>Soạn thảo Editor</option>
											<option value="foreign_one" <?php echo  $field->field_type == "foreign_one" ? "selected=\"selected\"":""; ?>>Chọn một </option>
											<option value="foreign_multi" <?php echo  $field->field_type == "foreign_multi" ? "selected=\"selected\"":""; ?>>Chọn nhiều </option>
										</select>
										<input type="hidden" name='ftype_exist_<?php echo $i;?>_begin' value="<?php echo $field->field_type; ?>" />
									</td>
									<td class="right_col">
										<?php $cat_compare = isset($field->foreign_id)?$field->foreign_id:0; ?>
										<?php 
										$display = 0;
										if($field->field_type == 'foreign_one' || $field->field_type == 'foreign_multi')
											$display = 1;
										?>
										<select name="foreign_id_exist_<?php echo $i;?>"   id='foreign_id_exist_<?php echo $i;?>'  <?php echo $display?'':'style="display:none"';?> >
											<?php 
											foreach ($foreign_data as $item)
											{
												$checked = "";
												if($cat_compare == $item->id )
													$checked = "selected=\"selected\"";
												?>
												<option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name;  ?> </option>
												<?php 
											}?>
										</select>

										<input type="hidden" name='foreign_id_exist_<?php echo $i;?>_begin' value="<?php echo $field->foreign_id; ?>" />
									</td>
									<td valign="top" class="left_col">

										<select name="is_main_exist_<?php echo $i;?>"   id='is_main_exist_<?php echo $i;?>' class='is_main_exist' >
											<option value="1" <?php if(@$field->is_main) echo "selected='selected'" ;?>  > Có</option>
											<option value="0" <?php if(!@$field->is_main) echo "selected='selected'" ;?>  >Không</option>
										</select>
										<input type="hidden" name='is_main_<?php echo $i;?>_begin' value="<?php echo @$field->is_main; ?>" />
									</td>
									<td valign="top" class="left_col">
										<select name="is_filter_exist_<?php echo $i;?>"   id='is_filter_exist_<?php echo $i;?>' class='is_filter_exist' >
											<option value="1" <?php if(@$field->is_filter) echo "selected='selected'" ;?>  > Có</option>
											<option value="0" <?php if(!@$field->is_filter) echo "selected='selected'" ;?>  >Không</option>
										</select>
										<input type="hidden" name='is_filter_<?php echo $i;?>_begin' value="<?php echo @$field->is_filter; ?>" />
									</td>
									<td valign="top" class="left_col">
										<select name="is_config_exist_<?php echo $i;?>"   id='is_config_exist_<?php echo $i;?>' class='is_config_exist' >
											<option value="1" <?php if(@$field->is_config) echo "selected='selected'" ;?>  > Có</option>
											<option value="0" <?php if(!@$field->is_config) echo "selected='selected'" ;?>  >Không</option>
										</select>
										<input type="hidden" name='is_config_<?php echo $i;?>_begin' value="<?php echo @$field->is_config; ?>" />
									</td>
									<td valign="top" class="left_col">
										<select name="is_price_exist_<?php echo $i;?>"   id='is_price_exist_<?php echo $i;?>' class='is_price_exist' >
											<option value="1" <?php if(@$field->is_price) echo "selected='selected'" ;?>  > Có</option>
											<option value="0" <?php if(!@$field->is_price) echo "selected='selected'" ;?>  >Không</option>
										</select>
										<input type="hidden" name='is_price_<?php echo $i;?>_begin' value="<?php echo @$field->is_price; ?>" />
									</td>
									<td>
										<a href="javascript: void(0)" onclick="javascript: remove_extend_field(<?php echo $i?>,'<?php echo $field_name; ?>')" ><?php echo  FSText :: _("Remove")?></a>
									</td>
								</tr>
								
							<?php } ?>

							<?php $i ++ ;?>
						<?php }?>
					<?php } ?>
					
					<?php for( $i = 0 ; $i< 10; $i ++ ) {?>
						<tr id="tr<?php echo $i; ?>" ></tr>
					<?php }?>
					
				</table>
				<a href="javascript:void(0);" onclick="addField()" > <?php echo FSText :: _("Th&#234;m tr&#432;&#7901;ng"); ?> </a>

			</div>
		</fieldset>
		
		<!--	end FIELD	-->
		<input type="hidden" value="" name="field_remove" id="field_remove" />
		<input type="hidden" value="<?php echo isset($data)?count($data):0; ?>" name="field_extend_exist_total" id="field_extend_exist_total" />
		<input type="hidden" value="" name="new_field_total" id="new_field_total" />

		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task" />
		<input type="hidden" value="0" name="boxchecked" />
		<input type="hidden" value="<?php echo $max_ordering?>" name="max_ordering" id = "max_ordering" />
	</form>
</div>
<!-- END BODY-->

<script>
	var i = 0;
	// check 
//	var fieldsname = new Array();
//	< ?php foreach ($fields_fixed as $field) {?>
//		fieldsname.push('< ?php echo $field[0];?>');
//	< ?php }?>

function   addField()
{
	max_ordering = $('#max_ordering').val();
	area_id = "#tr"+i;
	ordering = parseInt(max_ordering) + i + 1;
	htmlString = "<td>" ;
	htmlString +=  "<input type=\"text\" name='new_ordering_"+i+"' id='new_ordering_"+i+"' value='"+ordering+"' class='ordering' size='2' />";
	htmlString += "</td>";
	htmlString += "<td>" ;
	htmlString +=  "<input type=\"text\" name='new_fshow_"+i+"' id='new_fshow_"+i+"'  />";
	htmlString += "</td>";
	htmlString += "<td>" ;
	htmlString +=  "<input type=\"text\" name='new_fname_"+i+"' id='new_fname_"+i+"'  />";
	htmlString += "</td>";
	htmlString += "<td>";
	htmlString += "<select name='new_group_id_"+i+"'>";
	htmlString += "<option value=\"0\" >Chọn nhóm trường</option>";
	<?php foreach ($group_field as $item) {?>
		htmlString += "<option value=\"<?php echo $item->id; ?>\" ><?php echo $item->name;  ?></option>";
	<?php }?>
	htmlString += "</select>";
	htmlString += "</td>";
	htmlString += "<td>";
	htmlString += "<select name='new_ftype_"+i+"'  id='new_ftype_"+i+"' class='new_ftype' onchange='javascript: change_ftype(this);'>";
	htmlString += "<option value=\"varchar\" >Chuỗi ký tự</option>";
	htmlString += "<option value=\"int\" >Kiểu số</option>";
	htmlString += "<option value=\"datetime\" >Thời gian</option>";
	htmlString += "<option value=\"text\" >Soạn thảo Editor</option>";
	htmlString += "<option value=\"foreign_one\" >Chọn một</option>";
	htmlString += "<option value=\"foreign_multi\" >Chọn nhiều</option>";
	htmlString += "</select>";
	htmlString += "</td>";

		// foreign_data
		htmlString += "<td>";
		htmlString += "<select name='new_foreign_id_"+i+"' id='new_foreign_id_"+i+"' style='display:none' >";
		<?php foreach ($foreign_data as $item) {?>
			htmlString += "<option value=\"<?php echo $item->id; ?>\" ><?php echo $item->name;  ?></option>";
		<?php }?>
		htmlString += "</select>";
		htmlString += "</td>";

		// compare
		htmlString += "<td>";
		htmlString += "<select name='new_is_main_"+i+"' id='new_is_main_"+i+"' class='new_is_main'>";
		htmlString += "<option value=\"1\"  >Có</option>";
		htmlString += "<option value=\"0\" selected='selected'>Không</option>";
		htmlString += "</select>";
		htmlString += "</td>";

		// filter
		htmlString += "<td>";
		htmlString += "<select name='new_is_filter_"+i+"' id='new_is_filter_"+i+"' class='new_is_filter'>";
		htmlString += "<option value=\"1\"  >Có</option>";
		htmlString += "<option value=\"0\" selected='selected' >Không</option>";
		htmlString += "</select>";
		htmlString += "</td>";
		
		// lọc cấu hình tương đương
		htmlString += "<td>";
		htmlString += "<select name='new_is_config_"+i+"' id='new_is_config_"+i+"' class='new_is_config'>";
		htmlString += "<option value=\"1\"  >Có</option>";
		htmlString += "<option value=\"0\" selected='selected' >Không</option>";
		htmlString += "</select>";
		htmlString += "</td>";


				// is_price
		htmlString += "<td>";
		htmlString += "<select name='new_is_price_"+i+"' id='new_is_price_"+i+"' class='new_is_price'>";
		htmlString += "<option value=\"1\"  >Có</option>";
		htmlString += "<option value=\"0\" selected='selected' >Không</option>";
		htmlString += "</select>";
		htmlString += "</td>";
		
		htmlString += "<td>";
		htmlString += "<a href=\"javascript: void(0)\" onclick=\"javascript: remove_new_field("+ i +")\" >" + " X&#243;a" + "</a>";
		htmlString += "</td>";
		
		$(area_id).html(htmlString);		
		i++;
		$("#new_field_total").val(i);
	}

	//remove extend field exits
	function remove_extend_field(area,fieldid)
	{
		if(confirm("Bạn chắc chắn muốn xóa fiels này"))
		{
			remove_field = "";
			remove_field = $('#field_remove').val();
			remove_field += ","+fieldid;
			$('#field_remove').val(remove_field);
			$('#extend_field_exist_'+area).html("");
		}
		return false;
	}
	//remove new extend field 
	function remove_new_field(area)
	{
		if(confirm("Bạn chắc chắn muốn xóa fiels này"))
		{
			area_id = "#tr"+area;
			$(area_id).html("");
		}
		return false;
	}

	function change_ftype(element){
		type_id = $(element).attr('id');
		foreign_id = type_id.replace("ftype","foreign_id"); 
		val = $(element).val();
		if(val == 'foreign_one' || val == 'foreign_multi'){
			$('#'+foreign_id).show();
		}else{
			$('#'+foreign_id).hide();
		}
	}
	
</script>
<style>
.field_tbl select{
	width: 120px;
}
.field_tbl select.ftype_exist,.field_tbl select.new_ftype{
	width: 90px;
}
.field_tbl select.is_main_exist, .field_tbl select.new_is_main,
.field_tbl select.is_filter_exist, .field_tbl select.new_is_filter,
.field_tbl select.is_config_exist, .field_tbl select.new_is_config {
	width: 60px;
}
</style>