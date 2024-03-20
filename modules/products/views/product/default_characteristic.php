

<?php if(!empty($ext_fields)) { ?>
	<div class='tab_content_right'>
		<div class='characteristic'>
			<div class="tab-title">
				<!-- <span>Thông số kỹ thuật</span> -->
				<span>Cấu hình <?php echo $data-> name_display?$data-> name_display:$data-> name; ?></span>
			</div>
			<table class='charactestic_table' border="0" bordercolor="#EEE" cellpadding="7" width="100%">
				<?php $i = 0; $j=0;?>

				<?php foreach($ext_fields as $item){ $j++?>
					<?php /*?><?php if($item->is_main){?><?php */?>
						<?php  if($j<10) { ?>
							<?php 
							$field_name = $item -> field_name;
							$field_type = $item -> field_type;
							?>
							<?php if(isset($extend->$field_name) && $extend->$field_name){?>
								<tr <?php if($i%2==0){?> class="tr-0" <?php }else{?> class="tr-1" <?php }?>>
									<td class='title_charactestic' width="40%">
										<?php echo $item->field_name_display ?$item->field_name_display: $item->field_name; ?>
									</td>
									<td class='content_charactestic'>
										<?php if($field_type == 'image'){?>
											<?php if(@$item->$field_name){?>
												<img alt="<?php echo $data -> name?>" src="<?php echo URL_ROOT.@$extend->$field_name; ?>" />
											<?php }?>	
										<?php }elseif($field_type == 'foreign_one'){?>
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
													<?php $ch =  isset($ex->name)?nl2br($ex->name):'-'; ?>
													<?php $ch = $this -> insert_tags_to_charactestic($ch,$arr_news_name_core,$ex-> link_new) ; ?>
													<?php echo $ch; ?>	
												<?php }?>
											<?php }?>
										<?php } else {?>
											<?php $ch =  isset($extend->$field_name)?nl2br($extend->$field_name):'-'; ?>
											<?php $ch = $this -> insert_tags_to_charactestic($ch,$arr_news_name_core) ; ?>
											<?php echo $ch; ?>
										<?php }?>
									</td>
								</tr>
								<?php $i ++; ?>
							<?php }?>
						<?php }?>
					<?php } // end. foreach($fileds_in_group as $filed) ?>
					<?php if(1==1){ ?>
						<tr class="tr-1">
							<td colspan="2" class="title_charactestic title_charactestic2"><span class="readmore readmore_chareactestic" onclick="open_popup_content(1)"> Xem thêm cấu hình chi tiết <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 494.148 494.148" style="enable-background:new 0 0 494.148 494.148;" xml:space="preserve">
				<g>
					<g>
						<path d="M405.284,201.188L130.804,13.28C118.128,4.596,105.356,0,94.74,0C74.216,0,61.52,16.472,61.52,44.044v406.124    c0,27.54,12.68,43.98,33.156,43.98c10.632,0,23.2-4.6,35.904-13.308l274.608-187.904c17.66-12.104,27.44-28.392,27.44-45.884    C432.632,229.572,422.964,213.288,405.284,201.188z"/>
					</g>
				</g>
			</svg></span></td>				
						</tr>
					<?php } ?>
				</table>

				<?php if(1==2) { ?>

<!-- 	<div id="charactestic_detail" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-full-screen"></div>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title"><span><?php echo  FSText::_('Chi tiết tính  năng')?> <?php echo $data->name;?></span></h3>
				</div>
				<div class="content">
					<?php //include_once 'default_characteristic_detail.php'; ?>
				</div>
			</div>	
		</div>		
	</div> -->
<?php } ?>

</div>
</div>
<?php } ?>

