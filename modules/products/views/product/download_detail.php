<?php  	global $tmpl,$config;

$total_relative = count(@$relate_products_list);
$Itemid = 6;
$noWord = 80;
$tmpl -> addStylesheet('product_download','modules/products/assets/css');
//$tmpl -> addScript('tested','modules/products/assets/js');

	$url = $_SERVER['REQUEST_URI'];
	$return = base64_encode($url);
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
					</div>
					
					<div class='clear'></div>	
				</div>
				<div class='clear'></div>
			</div>
			<div class='download_area'>
				<?php if(count($files)){?>
					<div class='file_download_label'><?php echo FSText::_('Danh sách các file'); ?></div>
					<?php foreach($files as $item){?>
						<?php $link = FSRoute::_('index.php?module='.$this -> module.'&view=product&task=download_file&id='.base64_encode($data->id.'_'.$item->id)); ?>
						<div class='file_download_item'><a href="<?php echo $link ?>" title="<?php echo $item -> name?$item -> name:'Download'; ?>" target="_blink" > 
							<?php echo $item -> name?$item -> name:'Download'; ?>
						</a></div>
					<?php }?>
				<?php }?>
			</div>					
			<?php include_once 'related/default_related.php'; ?> 
	    </div>
	</div> 
</div>
<input type="hidden" value="<?php echo $data->id; ?>" name='product_id' id='product_id'  />
<input type="hidden" value="<?php echo $data->category_id; ?>" name='category_id' id='category_id'  />
