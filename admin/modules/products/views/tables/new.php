
<!-- HEAD -->
	<?php 
	
	$title = "T&#7841;o b&#7843;ng s&#7843;n ph&#7849;m"; 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply_new',FSText::_('L&#432;u t&#7841;m'),'','apply.png'); 
	$toolbar->addButton('save_new',FSText::_('L&#432;u'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Tho&#225;t'),'','cancel.png');
	?>
<!-- END HEAD-->
<!-- BODY-->
<div class="form_body">
	

	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
		
		<!--	TABLE	-->
		<fieldset>
			<legend>T&#7841;o t&#234;n b&#7843;ng</legend>
			<div id="tabs">
				<p class="notice">T&#234;n b&#7843;ng  ch&#7881; ch&#7913;a c&#225;c : Ch&#7919; c&#225;i, s&#7889; ,g&#7841;ch d&#432;&#7899;i. Tr&#225;nh c&#225;c b&#7843;ng &#273;&#7863;c bi&#7879;t g&#7891;m : <strong>tables,categories,filters,favourites, images</strong>
				</p>
				<table>
					<tr>
						<td> T&#234;n b&#7843;ng: </td>
						<td> <input type="text" name = "table_name"  /></td>
					</tr>
				</table>
			</div>
		</fieldset>
		<!--	end TABLE	-->
		
		
		<!--	FIELD	-->
		<fieldset>
			<legend>T&#7841;o field cho b&#7843;ng</legend>
			<div id="tabs">
		    	<p class="notice">T&#234;n tr&#432;&#7901;ng  ch&#7881; ch&#7913;a c&#225;c : Ch&#7919; c&#225;i, s&#7889; ,g&#7841;ch d&#432;&#7899;i. Kh&#244;ng &#273;&#7863;t t&#234;n tr&#432;&#7901;ng l&#224; ID, id, ho&#7863;c Id.</p>
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
		        		<td> X&#243;a tr&#432;&#7901;ng </td>
		        	</tr>
					
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
		area_id = "#tr"+i;
		
		htmlString = "<td>" ;
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
		htmlString += "<td>";
		htmlString += "<select name='new_ftype_"+i+"'  class='new_ftype'>";
		htmlString += "<option value=\"varchar\" >VARCHAR</option>";
		htmlString += "<option value=\"int\" >INT</option>";
		htmlString += "<option value=\"datetime\" >DATETIME</option>";
		htmlString += "<option value=\"text\" >TEXT</option>";
		htmlString += "</select>";
		htmlString += "</td>";

		// copare
		htmlString += "<td>";
		htmlString += "<input type=\"radio\" name='new_is_compare_"+i+"' id='new_is_compare_"+i+"' value='1' checked='checked' />Có";
		htmlString += "<input type=\"radio\" name='new_is_compare_"+i+"' id='new_is_compare_"+i+"' value='0' />Không";
		htmlString += "</td>";
		
		htmlString += "<td>";
		htmlString += "<a href=\"javascript: void(0)\" onclick=\"javascript: remove_new_field("+ i +")\" >" + " X&#243;a" + "</a>";
		htmlString += "</td>";
		
		$(area_id).html(htmlString);		
		i++;
		$("#new_field_total").val(i);
	}	

	//remove extend field exits
	function remove_extend_field(area,fieldname)
	{
		if(confirm("You certain want remove this fiels"))
		{
			remove_field = "";
			remove_field = $('#field_remove').val();
			remove_field += ","+fieldname;
			$('#field_remove').val(remove_field);
			$('#extend_field_exist_'+area).html("");
		}
		return false;
	}
	//remove new extend field 
	function remove_new_field(area)
	{
		if(confirm("You certain want remove this fiels"))
		{
			area_id = "#tr"+area;
			$(area_id).html("");
		}
		return false;
	}
	
</script>