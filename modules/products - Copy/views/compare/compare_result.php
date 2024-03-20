<?php $total = count($data);?>
<?php $cols = $total >= 4?5:($total + 2) ?>
<table class='compare_table compare_detail' border="1" bordercolor="#EEE" cellspacing="0px" cellpadding="8px" width="100%">
	<tr class="tr-1 tr_first">
		<td colspan="<?php echo ($cols + 2)?>">
			<span class='compare_label'><h2><?php echo $h2; ?></h2></span>
		</td>
	</tr>
	<!--	name			-->
	<tr class="tr-1" >
		<td class='title' width="<?php echo 50/($cols); ?>%" colspan="2">Hình ảnh</td>
		<?php 
		for($i  = 0; $i < $total; $i ++ ){
			@$item = $data[$i]; 
			$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->record_id.'&cid='.$item->category_id.'&Itemid='.$Itemid);
			$sub_str_codes = '';
			$sub_str_ids = '';
			for($j  = 0; $j < $total; $j ++ ){
				@$sub = $data[$j]; 
				if($sub -> record_id == $item -> record_id)
					continue;
				if($sub_str_codes){
					$sub_str_codes .= '-';
					$sub_str_ids .= '-';
				}
				$sub_str_codes .= $sub -> alias;
				$sub_str_ids .= $sub -> record_id;
			}
			$link_remove = FSRoute::_('index.php?module=products&view=compare&codes='.$sub_str_codes.'&ids='.$sub_str_ids);
		?>
			<td class='cp_content' width='<?php echo 100/($cols); ?>%' align="center">
					<div class="picture_small">
						<?php if(@$item->image){?>
							<a href="<?php echo $link;?>">
								<img  alt="<?php echo $item->name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$item->image); ?>" />
							</a>
						<?php } else {?>
							<a href="<?php echo $link_detail;?>">
								<img alt="<?php echo @$item->name; ?>" src="<?php echo URL_ROOT.'images/no-img.gif'; ?>"/>
							</a>
						<?php }?>
						<a href="<?php echo $link_remove;?>" title="Xóa" class="remove_compare">
							X
						</a>
					</div>
					<a href="<?php echo $link;?>" class="name">
						<?php echo @$item -> name; ?>
					</a>
			</td>


		<?php }?>


		<?php if($total < 4){?>
		<td class='cp_content 1' width='<?php echo 100/($cols); ?>%' align="center">
			<?php include 'compare_box.php';?>
		</td>
		<?php }?>
	</tr>
	<!--	end name			-->
	<!--	PRICE			-->
	<tr class="tr-0">
		<td class='title' width="<?php echo 50/($cols); ?>%" colspan="2">
			Giá
		</td>
		<?php 
		for($i  = 0; $i  < $total; $i ++ ){
			$item = @$data[$i]; 
		?>
		<td class='cp_content' width='<?php echo 100/($cols); ?>%' align="left">
		<?php @$vat= $item -> price+$item -> price*$cat->vat/100; ?>
			<strong class='red'><?php echo @$vat? format_money(@$vat) : ''; ?></strong>
		</td>		
		<?php }?>
		<?php if($total < 4){?>
		<td class='cp_content' width='<?php echo 100/($cols); ?>%' align="center">
					
		</td>
		<?php }?>
	</tr>
	<tr class="tr-1">
		<td class='title' width="<?php echo 50/($cols); ?>%" colspan="2">
			Khuyến mại
		</td>
		<?php 
		for($i  = 0; $i  < $total; $i ++ ){
			$item = @$data[$i]; 
		?>
		<td class='cp_content' width='<?php echo 100/($cols); ?>%' align="left">
			<?php 
				$promotion_info = $model->get_record('id = ' . $item->record_id,'fs_products','promotion_info');

				if(!empty($promotion_info)){
					echo $promotion_info -> promotion_info;
				}
				
			?>
			
		</td>		
		<?php }?>
		<?php if($total < 4){?>
		<td class='cp_content' width='<?php echo 100/($cols); ?>%' align="center">
					
		</td>
		<?php }?>
	</tr>
	
	<!--	EXTENSION FIELDS			-->
	<?php $j = 0; ?>
	<?php if(!empty($arr_ext_fileds_by_group)){?>
		<?php
		// $ext_group_fields[0]
		@$ext_group_fields[0]-> name = 'Thông số kỹ thuật';
		// echo '<pre>';
		// print_r($arr_ext_fileds_by_group);
		// print_r($ext_group_fields) ;die; ?>
		<?php foreach($arr_ext_fileds_by_group as $group_id => $fileds_in_group){?>
			<?php $k = 0;?>
			<?php //print_r($fileds_in_group);die; ?>
			<?php $group_field = @$ext_group_fields[$group_id];?>
			<?php foreach($fileds_in_group as $row){?>
			<?php $field_name = $row -> field_name; 
				  $field_type = $row -> field_type;
			?>
			<tr <?php if($j%2==0){?> class="tr-0" <?php }else{?> class="tr-1" <?php }?>>
					<?php if(!$k){?>
						<td class='group_field' rowspan="<?php echo count($fileds_in_group); ?>" width="<?php echo 40/($cols); ?>%">
							<?php echo @$group_field -> name; ?>
						</td>
					<?php } // end.if(!$j)?>
					<td class='title' width="<?php echo 60/($cols); ?>%">
						<?php echo $row->field_name_display ?$row->field_name_display: $row->field_name; ?>
					</td>
					<?php 
					
					for($i  = 0; $i  < $total; $i ++ ){
						$item = @$data[$i]; 
						// echo $field_type;
						// print_r($data_extends);
					?>
					<td class='cp_content'  width='<?php echo 100/($cols); ?>%'>
						<?php if($field_type == 'image'){?>
							<?php if(@$item->$field_name){?>
								<img alt="<?php echo $data -> name?>" src="<?php echo URL_ROOT.@$item->$field_name; ?>" />
							<?php }?>	
						<?php }elseif($field_type == 'foreign_one' && !empty($data_extends)){?>
							<?php foreach($data_extends as $ex){?>
								<?php if($ex ->id == @$item->$field_name){?>
									<?php echo $ex ->name; ?>
									<?php break; ?>
								<?php }?>
							<?php }?>

						<?php }elseif($field_type == 'foreign_multi' && !empty($data_extends)){?>
							<?php foreach($data_extends as $ex){?>
								<?php if(strpos(@$item->$field_name, ','.$ex ->id.',') !== false){?>
									<?php echo $ex ->name .','; ?>
								<?php }?>
							<?php }?>
					
						<?php } else {?>
							<?php echo isset($item->$field_name)?nl2br($item->$field_name):''; ?>
						<?php }?>
					</td>		
					<?php }?>
					<?php if($total < 4){?>
					<td class='cp_content' width='<?php echo 100/($cols); ?>%' align="center">
								
					</td>
					<?php }?>
				</tr>
				<?php $k ++;?>
				<?php $j ++;?>
			<?php } // end. foreach($fileds_in_group as $filed) ?>
		<?php }// end. foreach($arr_ext_fileds_by_group as $group_id => $fileds_in_group)?>
	<?php } // end .if(count($arr_ext_fileds_by_group))?>
	<!--	end EXTENSION FIELDS	 		-->
	
</table>
<!--	end COMPARE TABLE			-->