<div class='charactestic_summary' >
	<p class='charactestic_summary_item manufactory'>
		<span class='title_charactestic'>Hãng sản xuất:</span>
		<span class='content_charactestic' ><a href="<?php echo FSRoute::_('index.php?module=products&view=manufactory&id='.$data ->manufactory.'&code='.$data->manufactory_alias); ?>" title="<?php echo $data -> manufactory_name; ?>"><?php echo $data -> manufactory_name; ?></a></span>
			<?php $i = 0;?>
			<?php foreach($ext_fields as $item){?>
				<?php if($item->is_main){?>
					<?php 
					$field_name = $item -> field_name;
					$field_type = $item -> field_type;
					?>
					<p class='charactestic_summary_item'>
						<span class='title_charactestic'>
							<?php echo $item->field_name_display ?$item->field_name_display: $item->field_name; ?>:
						</span>
						<span class='content_charactestic' >
							<?php if($field_type == 'image'){?>
								<?php if(@$item->$field_name){?>
									<img alt="<?php echo $data -> name?>" src="<?php echo URL_ROOT.@$extend->$field_name; ?>" />
								<?php }?>	
							<?php }elseif($field_type == 'foreign_one'){?>
								<?php foreach($data_extends as $ex){?>
									<?php if($ex ->id == @$extend->$field_name){?>
										<?php echo $ex ->name; ?>
									<?php break; ?>
									<?php }?>
								<?php }?>
							<?php }elseif($field_type == 'foreign_multi'){?>
								<?php foreach($data_extends as $ex){?>
									<?php if(strpos(@$extend->$field_name, ','.$ex ->id.',') !== false){?>
										<p class='field_extend'><?php echo $ex ->name; ?></p>
									<?php }?>
								<?php }?>
								<?php // echo  $this -> get_data_foreign($item -> foreign_tablename,$extend -> $field_name,$field_type); ?>
							<?php } else {?>
								<?php echo isset($extend->$field_name)?nl2br($extend->$field_name):'-'; ?>
							<?php }?>
						</span>
				</p><!-- .charactestic_summary_item -->
				<?php $i ++; ?>
				<?php }?>
			<?php } // end. foreach($fileds_in_group as $filed) ?>
</div>

