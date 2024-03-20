<!-- HEAD -->
	<?php 
	
	$title = "Tạo bộ lọc chung cho dược điển"; 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save',FSText::_('L&#432;u'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Tho&#225;t'),'','cancel.png');
	$field = FSInput::get('field');
	?>
<!-- END HEAD-->
<!-- BODY-->
<div class="form_body">

	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
				
		<!--	TABLE	-->
		<fieldset>
			<legend>B&#7843;ng</legend>
			<div id="tabs">
				<table width="100%" cellpadding="5">
					<tr>
						<td width="200"><strong class='red'>Trường tạo bộ lọc</strong></td>
						<td>
							<select name="field" onchange="changeField();" id = "field" >
								<option value=''> -- Chọn trường -- </option>
								<?php 
								if(@$fields)
								{
									foreach ($fields as $item) {
										if($field == $item ->field_name ){
											echo "<option value='".$item->field_name."' selected = 'selected'>".$item->field_name_display."</option>";
										} else {
											echo "<option value='".$item->field_name."' >".$item->field_name_display."</option>";
										}
									}
								}
								
								?>
							</select>
							
						 </td>
					</tr>
					
				</table>
			</div>
		</fieldset>
		<!--	end TABLE	-->
		<?php if(isset($field_current) && !empty($field_current) && ($field_current ->field_type == 'foreign_one' || $field_current ->field_type == 'foreign_multi')){?>
			<?php include_once 'default_filters_in_field_checkbox.php';?>
		<?php } else {?>
			<?php include_once 'default_filters_in_field.php';?>						
		<?php }?>
		<br/>
		<?php include_once 'default_filters_in_table.php';?>
		
		<input type="hidden" value="" name="filter_exist_remove" id="filter_exist_remove" />
		<input type="hidden" value="<?php if(!empty($filters)) echo count($filters); ?>" name="filter_exist_total" id="filter_exist_total" />
		<input type="hidden" value="" name="filter_new_total" id="filter_new_total" />
				
		<input type="hidden" value="<?php echo $this -> module;?>" name="module" id =  "module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view" id =  "view">
		<input type="hidden" value="<?php echo $this -> type;?>" name="type"  id =  "type"/>
		<input type="hidden" value="" name="task" />
		<input type="hidden" value="0" name="boxchecked" />
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
	function calculator_html(j)
	{
		html = "";
		html += "<select name='calculator_new_"+ j +"' >";
		<?php foreach ($calculators as $item) {?>
				html +=		"<option value='<?php echo $item[0]; ?>'  ><?php echo $item[1]; ?></option>";
		<?php } ?>
		html += "</select>";
		return html;
	}
	
	function   addField()
	{
		area_id = "#tr"+i;
		htmlString = "<td>" ;
		htmlString +=  "<input type=\"text\" name='filter_show_new_"+i+"' id='filter_show_new_"+i+"'  />";
		htmlString += "</td>";
		htmlString += "<td>" ;
		htmlString +=  "<input type=\"text\" name='alias_new_"+i+"' id='alias_new_"+i+"'  />";
		htmlString += "</td>";
		htmlString += "<td>";
		htmlString += calculator_html(i);
		
		htmlString += "</td>" ;
		htmlString += "<td>" ;
		htmlString +=  "<input type=\"text\" name='value_new_"+i+"' id='value_new_"+i+"'  />";
		htmlString += "</td>";
		htmlString += "<td>";
		htmlString +=  "<input type=\"checkbox\" name='published_new_"+i+"' id='value_new_"+i+"'  />";
		htmlString += "</td>";
		htmlString += "<td>";
		htmlString += "<a href=\"javascript: void(0)\" onclick=\"javascript: remove_new_filter("+ i +")\" >" + " X&#243;a" + "</a>";
		htmlString += "</td>";
		
		$(area_id).html(htmlString);		
		i++;
		$("#filter_new_total").val(i);
	}

	//remove extend field exits
	function remove_filter_exist(index,fieldid)
	{
		if(confirm("You certain want remove this fiels"))
		{
			remove_field = "";
			remove_field = $('#filter_exist_remove').val();
			remove_field += ","+fieldid;
			$('#filter_exist_remove').val(remove_field);
			$('#filter_exist_'+index).html("");
		}
		return false;
	}
	//remove new extend field 
	function remove_new_filter(area)
	{
		if(confirm("You certain want remove this fiels"))
		{
			area_id = "#tr"+area;
			$(area_id).html("");
		}
		return false;
	}

	function changeField()
	{
		field = $('#field').val();
		module = $('#module').val();
		view = $('#view').val();
		window.location = "index.php?module="+module+"&view="+view+"&field="+field;
	}
	
</script>