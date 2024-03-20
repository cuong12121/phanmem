<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">
		
		<!--	FILTER	-->
		<div class="filter_area">	
			<table>		
				<tr>			
					<td nowrap="nowrap">	
						<select onchange="javascript: change_category()" class="type" name="filter" id='filter'>				
							<option value="0"> -- Danh mục -- </option>
								<?php 
								$cat_id = FSInput::get('cid',0,'int');
								
								if($categories)	{
									foreach($categories as $item){
										if($item->id == $cat_id){
											echo "<option value='" . $item->id . "'  selected='selected'> ". $item->treename . "</option>";
										}
										else{
											echo "<option value='" . $item->id . "'>" . $item->treename . "</option>";
										}
									}
								}
								?>
						</select>			
					</td>		
				</tr>	
			</table>
		</div>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						Tên
					</th>
					<th class="title">
						Danh mục
					</th>
					
					<th class="title" width="7%">
						<?php echo FSText::_('Thêm'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo  TemplateHelper::orderTable(FSText::_('Id'), 'id',$sort_field,$sort_direct) ; ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
							<?php $link_detail = "index.php?module=products&view=products&task=edit&id=".$row->id; ?>
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?></td>
								<td>
									<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td><?php echo $row->name; ?></td>
								<td><?php echo $row->category_name; ?></td>
								
								<td><a href="javascript: add_product(<?php echo $row ->id;?>)">Thêm</a></td>
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
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<script type="text/javascript">
	id = <?php echo FSInput::get('id',0,'int');?>;
	url=location.href;
	url = url.replace(/&cid=[0-9]+/, '');
	function change_category(){
		cat_id = $('#filter').val();
		
		if(cat_id != 0 ){
			url += '&cid='+cat_id;
		}
		window.location = url;
	}

	function add_product(promotion_product_id){
		$.get("index.php?module=promotion&view=promotion_products&task=add_products&raw=1",{promotion_product_id: promotion_product_id,id:id}, function(j){
			 j = eval("(" + j + ")");
			status = j['status'];
			if(status == 0){
				alert('Không thể thêm sản phẩm này');
			}else if(status == 1){
				html = j['html'];
				alert('Thêm thành công');
				row_continue = window.opener.$(".record_products_continue");
				row_continue.before(html);
			} else {
				alert('Sản phẩm này đã được add, bạn không thể thêm.');
			}
		})	
	}
</script>