<div class="model_text description">
	<?php echo $data-> model_text; ?>
</div>
<table class='compare_table' border="0" cellpadding="5px" width="100%" >
	<?php 
	// echo 'mmmmmmmmmmmm';
	// print_r($arr_news_name_core);die;
	if(!empty($arr_ext_fileds_by_group)){?>
		<?php foreach($arr_ext_fileds_by_group as $group_id => $fileds_in_group){?>
			<?php $i = 0;?>
			<?php if(isset($ext_group_fields[$group_id])) { ?>
				<?php $group_field = $ext_group_fields[$group_id];?>
			<?php } ?>
			<?php foreach($fileds_in_group as $item){?>
				<?php 
				$field_name = $item -> field_name;
				$field_type = $item -> field_type;
				$field_price =  $item -> is_price;
				?>
				<?php if(!$i){?>
					<tr>
						<td class='group_field' colspan="2" valign="top">
							<b><?php echo @$group_field -> name; ?></b>
						</td>
					</tr>
				<?php }?>
				<tr <?php if($i%2==0){?> class="tr-0" <?php }else{?> class="tr-1" <?php }?>  valign="top">
					<td class='title_charactestic' width="30%">
						<?php echo $item->field_name_display ?$item->field_name_display: $item->field_name; ?>:
					</td>
					<td class='content_charactestic' >
						<?php if($field_type == 'image'){?>
							<?php if(@$item->$field_name){?>
								<img alt="<?php echo $data -> name;?>" src="<?php echo URL_ROOT.@$extend->$field_name; ?>" />
							<?php }?>	
						<?php }elseif($field_type == 'foreign_one' && $field_price == 0){?>
							<?php foreach($data_extends as $ex){?>
								<?php if($ex ->id == @$extend->$field_name){?>
									<?php $ch =  isset($ex->name)?nl2br($ex->name):'-'; ?>
									<?php $ch = $this -> insert_tags_to_charactestic($ch,$arr_news_name_core,$ex-> link_new) ; ?>
									<?php echo $ch; ?>	
									<?php break; ?>
								<?php }?>
							<?php }?>
						<?php }elseif($field_type == 'foreign_multi'){?>
							<?php foreach($data_extends as $ex){?>
								<?php if(strpos(@$extend->$field_name, ','.$ex ->id.',') !== false){?>
									<p class='field_extend'>
										<?php //echo $ex ->name;die; ?>
										<?php $ch =  isset($ex->name)?nl2br($ex->name):'-'; ?>
										<?php $ch = $this -> insert_tags_to_charactestic($ch,$arr_news_name_core,$ex-> link_new) ; ?>
										<?php echo $ch; ?>	
									</p>
								<?php }?>
							<?php }?>
							<?php // echo  $this -> get_data_foreign($item -> foreign_tablename,$extend -> $field_name,$field_type); ?>
						<?php } else {?>
							<?php // echo isset($extend->$field_name)?nl2br($extend->$field_name):'-'; ?>
							<?php $ch =  isset($extend->$field_name)?nl2br($extend->$field_name):'-'; ?>
							<?php $ch = $this -> insert_tags_to_charactestic($ch,$arr_news_name_core) ; ?>
							<?php echo $ch; ?>

						<?php }?>
					</td>
				</tr>
				<?php $i ++; ?>
			<?php } // end. foreach($fileds_in_group as $filed) ?>
		<?php }// end. foreach($arr_ext_fileds_by_group as $group_id => $fileds_in_group)?>
	<?php } // end .if(count($arr_ext_fileds_by_group))?>
</table>

