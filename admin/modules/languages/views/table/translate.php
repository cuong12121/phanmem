<!-- HEAD -->
<?php 
	$title = 'Dịch sang ngôn ngữ: '.$language -> language; 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png');  
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body translate">
	<div id="msg_error"></div>
	<form action="index.php?module=languages&view=table" name="adminForm" method="post" enctype="multipart/form-data">
			
	<!--	BASE FIELDS    -->
			<table cellspacing="5" class="admintable" width="100%" align="left"  >
				<?php 
				$j = 0;
				for($i = 0; $i < count($fields_in_table); $i ++){
					$item = $fields_in_table[$i];
					$type = $item -> Type;
					$field  = $item -> Field;
					if($field == 'images' || $field == 'image' || $field == 'picture' || $field == 'img'|| $field == 'pictures' )
						continue;
					if(strpos($table -> field_not_display, ','.$field.',') !== false)
						continue;
						
					if(strpos($type,'text') !== false){
						
				?>
				<!--	TYPE == TEXT			-->
				<tr class='row<?php echo $j%2;?>'  >
					<td valign="top"  colspan="3">
						<strong>Field: <?php echo FSText::_(ucfirst($field)); ?></strong>
					</td>
				</tr>
				<tr class='row<?php echo $j%2;?>'  >
					<td valign="top"  >
						<?php echo FSText::_('Original'); ?>
					</td>
					<td valign="top"  >
						<div id='<?php echo $field.'_old'; ?>'>
							<?php echo $data_old ->$field;  ?>
						</div>
					</td>
					<td valign="top"  >
<!--						<a href="javascript: copy_field('<?php echo $field; ?>')" >Copy</a>-->
					</td>
				</tr>
				<tr class='row<?php echo $j%2;?>'>
					<td valign="top"  >
						<?php echo FSText::_('Translate'); ?>
					</td>
					<td valign="top"  colspan="2" >
						<?php 
							$oFCKeditor = new FCKeditor("$field") ;
							$oFCKeditor->BasePath	=  '../libraries/wysiwyg_editor/' ;
							$oFCKeditor->Value		= @$data_new->$field;
							$oFCKeditor->Width = 150;
							$oFCKeditor->Height = 450;
							$oFCKeditor->Create() ;
						?>
					</td> 
				</tr>
				<tr class='row<?php echo $j%2;?>'>
					<td valign="top"   colspan="3" >
						<hr/>
					</td>
				</tr>
				<!--	end TYPE == TEXT			-->
						<?php $j++; ?>
					<?php } else if(strpos($type,'varchar') !== false){?>
					
				<!--	TYPE == VARCHAR			-->
				<tr class='row<?php echo $j%2;?>'  >
					<td valign="top"  colspan="1" align="left">
						<?php echo FSText::_('Field'); ?> :<strong> <?php echo FSText::_(ucfirst($field))?> </strong>
					</td>
					<td valign="top" align="left" >
						<a href="javascript: copy_field('<?php echo $field; ?>')" title="Copy" ><img src="templates/default/images/toolbar/copy.png" alt="Copy" /></a>
						<?php if($field == 'alias'){?>
							<a href="javascript: genarate_alias('<?php echo $field; ?>')" title="Genarate alias" >Tự động:<img src="templates/default/images/toolbar/auto.jpg" alt="Genarate alias" /></a>
						<?php }?>
						<?php if(array_key_exists($field,$arr_func)){?>
							<a href="javascript: call_function_support('<?php echo $field; ?>','<?php echo $arr_func[$field]; ?>','<?php echo $table -> table_name; ?>','<?php echo $id;?>')" title="Genarate alias" >Tự động:<img src="templates/default/images/toolbar/auto.jpg" alt="Genarate alias" /></a>
						<?php }?>
					</td>
				</tr>
				<tr class='row<?php echo $j%2;?>'  >
					<td valign="top"  align="left" width="150" >
						<?php echo FSText::_('Original'); ?>
					</td>
					<td valign="top"  align="left">
						<div class='<?php echo $field.'_old'; ?>'>
							<?php echo $data_old ->$field;  ?>
						</div>
						<input type="hidden" id='<?php echo $field.'_old'; ?>' value="<?php echo $data_old ->$field;  ?>">
					</td>
				</tr>
				<tr  class='row<?php echo $j%2;?>' >
					<td valign="top"  >
						<?php echo FSText::_('Translate'); ?>
					<td valign="top"  colspan="2" >
						<input type="text" value="<?php echo @$data_new ->$field;  ?>" name='<?php echo $field?>' id='<?php echo $field?>' size="80" />	
					</td>
					
				</tr>
				<tr  class='row<?php echo $j%2;?>' >
					<td valign="top"   colspan="3" >
						<hr/>
					</td>
				</tr>
				<!--	end TYPE == VARCHAR			-->
					<?php $j++; ?>
					<?php }?>
				<?php } ?>
			</table>
		
		<?php if(@$data->id) { ?> 
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="<?php echo $table_id;?>" name="table">
		<input type="hidden" value="<?php echo $language -> lang_sort;?>" name="lang_sort">
		<input type="hidden" value="<?php echo $language -> id;?>" name="lang_id">
		<input type="hidden" value="<?php echo $id;?>" name="id">
		<input type="hidden" value="<?php echo @$data_new -> rid;?>" name="rid">
		<input type="hidden" value="table" name="view">
		<input type="hidden" value="languages" name="module">
		<input type="hidden" value="<?php  echo FSInput::get('before_id',0,'int'); ?>" name="before_id">
			<input type="hidden" value="<?php  echo FSInput::get('before_page',0,'int'); ?>" name="before_page">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->
<script type="text/javascript">
	function copy_field(field){
		value = $('#'+field+'_old').val();
		$('#'+field).val(value);
	}
	function genarate_alias(field){
		var original ;
		if($('#name').length){
			original = $('#name').val();
		}else if($('#title').length){
			original = $('#title').val();
		}else{
			return;
		}
		$.ajax({url: "index.php?module=languages&view=table&task=genarate_alias&raw=1",
			data: {txt: original},
			dataType: "text",
			
			success: function(text) {
				if(text == '')
					return;
				$('#alias').val(text);
			}
		});
	}
	function call_function_support(field,function_support,table_name,record_id){
		var original ;
		if($('#name').length){
			original = $('#name').val();
		}else if($('#title').length){
			original = $('#title').val();
		}else{
			return;
		}
		$.ajax({url: "index.php?module=languages&view=table&task=function_support&raw=1",
			data: {field: field,table_name:table_name,table_name:table_name,function_support:function_support,record_id:record_id},
			dataType: "text",
			
			success: function(text) {
				if(text == '')
					return;
				$('#'+field).val(text);
			}
		});
	}
</script>


