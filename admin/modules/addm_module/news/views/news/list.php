<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('News') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">
		
		<!--	FILTER	-->
		<?php 
			$filter_config  = array();
			$fitler_config['search'] = 1; 
			$fitler_config['filter_count'] = 1;

			$filter_categories = array();
			$filter_categories['title'] = FSText::_('Categories'); 
			$filter_categories['list'] = @$categories; 
			$filter_categories['field'] = 'treename'; 
			
			$fitler_config['filter'][] = $filter_categories;																																																																																																																																																																																																																																																																																																																																																																																																																						
			
			echo $this -> create_filter($fitler_config);
		?>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" cellpadding="2" bordercolor="#CCC">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						<?php echo FSText :: _('Title'); ?>
					</th>
					<th class="title" width="30%">
						<?php echo FSText :: _('Summary'); ?>
					</th>
					<th class="title" width="10%">
						<?php echo  TemplateHelper::orderTable(FSText::_('Category'), 'a.cateogory_name',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title" width="3%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Ordering'), 'a.ordering',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title" width="3%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Published'), 'published',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title" width="2%">
						<?php echo FSText :: _('Edit'); ?>
					</th>
					
					<th class="title" width="7%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Created time'), 'created_time',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title" width="3%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Id'), 'id',@$sort_field,@$sort_direct) ; ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
							<?php $link_view = "index.php?module=".$this -> module."&view=".$this -> view."&task=edit&id=".$row->id; ?>
							<?php $link_view_font_end = URL_ROOT.'hot-girl-pic/'.$row-> category_alias.'/'.$row-> alias.'-'.$row->id.'.html';	?>
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?>
								    <input type="hidden" name='<?php echo "id_".$i; ?>' value="<?php echo $row->id; ?>"/>
								</td>
								<td>
									<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td align="left">
								 	<input type="text" name='<?php echo "title_".$i; ?>' value="<?php echo $row->title; ?>" size="50" />
								    <input type="hidden" name='<?php echo "title_".$i."_original"; ?>' value="<?php echo $row->title; ?>"/>
<!--								    <p style="text-align: center;"><a href="<?php echo $link_view_font_end; ?>" target="_blink" title="Xem tin b�i ngo�i font-end" >Xem</a></p>-->
								    
									<p style="text-align: center;"><img alt="<?php echo $row->title?>" src="<?php  echo URL_ROOT.str_replace('/original/','/small/',$row->image); ?>" /></p>
								</td>
								<td align="left">
									<textarea rows="8" cols="60" name="<?php echo "summary_".$i; ?>" ><?php echo $row->summary; ?></textarea>
								    <input type="hidden" name='<?php echo "summary_".$i."_original"; ?>' value="<?php echo $row->summary; ?>"/>
								</td>
								<td>
									<select name="category_id_<?php echo $i; ?>" id="category_id" size="10">
										<?php 
										// selected category
										$cat_compare  = 0;
										if(@$row->category_id)
										{
											$cat_compare = $row->category_id;
										} 
										$j = 0;
										foreach ($categories as $cat_item) {
											$checked = "";
											if(!$cat_compare && !$j){
												$checked = "selected=\"selected\"";
											} else {
												if($cat_compare == $cat_item->id)
													$checked = "selected=\"selected\"";
											}
												
										?>
											<option value="<?php echo $cat_item->id; ?>" <?php echo $checked; ?> ><?php echo $cat_item->treename;  ?> </option>	
										<?php 
											$j ++;
										}?>
									</select>
									<input type="hidden" name='<?php echo "category_id_".$i."_original"; ?>' value="<?php echo $row->category_id; ?>"/>
								</td>
								<td>
								    <input type="text" name='<?php echo "ordering_".$i; ?>' value="<?php echo $row->ordering; ?>" size="3"/>
                                    <input type="hidden" name='<?php echo "ordering_".$i."_original"; ?>' value="<?php echo $row->ordering; ?>"/>    
								</td>
								
								<td><?php echo TemplateHelper::published("cb".($i),$row->published?"unpublished":"published"); ?></td>
								
								<td> <?php echo TemplateHelper::edit($link_view); ?></td>
								<td> <?php echo date('d/m/Y H:i',strtotime($row->created_time))?></td>
								<td><?php echo $row->id; ?></td>
							</tr>
							<?php $i++; ?>
						<?php }?>
					<?php }?>
				</tbody>
			</table>
		</div>
		<div class="footer_form">
			<?php if(@$pagination) {?>
			<?php echo $pagination->showPagination();?>
			<?php } ?>
		</div>
		
		<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
		<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="<?php echo ($i+1);?>" name="total">
		<input type="hidden" value="<?php echo FSInput::get('page',0,'int');?>" name="page">
		<input type="hidden" value="<?php echo 'title,ordering,summary,category_id';?>" name="field_change">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>