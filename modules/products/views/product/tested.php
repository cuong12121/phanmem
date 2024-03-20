<?php  	global $tmpl,$config;

$total_relative = count(@$relate_products_list);
$Itemid = 6;
$noWord = 80;

$tmpl -> addStylesheet('product_tested','modules/products/assets/css');
//$tmpl -> addScript('tested','modules/products/assets/js');
?>
<div class='product'>
	<div class='thread-details'>
		<div class="container">
			<h1><span>Download: </span><?php echo $data -> name; ?></h1>
			<div class="row row-1">
				<div class="product_image">	
					<img src="<?php echo URL_ROOT.str_replace('/original/','/large/', $data->image); ?>" alt="<?php echo htmlspecialchars ($data -> name); ?>"  width="165" />
				</div>
				<div class="product_head_right">	
					
					<div class='characteristic'>
					<?php include_once 'default_characteristic.php'; ?>
					</div>
					<div class='product_right_col'>
						<div class='tested_bt'>
							<?php if($data -> is_tested){?>
								<?php $link = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$data->alias.'&task=tested&ccode='.$data->category_alias.'&id='.$data->id.'&Itemid=5'); ?>
								<a href="<?php echo $link ?>" title="Tested" > 
									<img src='<?php echo URL_ROOT.'modules/products/assets/images/tested.png'?>' alt="Tested" />
								</a>					
							<?php }?>
						</div>
						<div class='product_button'>
							<?php $link_prd = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$data->alias.'&ccode='.$data->category_alias.'&id='.$data->id.'&Itemid=5'); ?>
							<a href="<?php echo $link_prd ?>" title="Download" class='download_bt'> 
								Quay lại
							</a>
							<?php $link_download = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$data->alias.'&task=download&ccode='.$data->category_alias.'&id='.$data->id.'&Itemid=5'); ?>
							<a href="<?php echo $link_download; ?>" title="Download" class='download_bt'> 
								Download
							</a>
						</div>
					</div>
					
					<div class='clear'></div>	
					
				</div>
				<div class='clear'></div>
			</div>
			<div class='description'>
				<div class='description_label'><?php echo FSText::_('Nội dung tested'); ?>:</div>
				 <?php echo $data -> tested_content; ?>
			 </div>
			<div class='notice'>
				<div class='notice_label'>Ghi chú:</div>
				<div class='notice_content'>
					<?php echo $tested_content; ?>
				</div>
			</div>
	    </div>
	</div> 
</div>
<input type="hidden" value="<?php echo $data->id; ?>" name='product_id' id='product_id'  />
<input type="hidden" value="<?php echo $data->category_id; ?>" name='category_id' id='category_id'  />
