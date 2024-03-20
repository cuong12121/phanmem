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
			<?php if($user -> point < $data -> price){?>
				<script type="text/javascript">
					alert('Tài khoản Bigz của bạn không đủ để download dữ liệu này. Hãy nạp thêm');
				</script>
				<div class="not_point">
					<div class="not_point_t">Tài khoản Bigz của bạn không đủ để download dữ liệu này. Hãy nạp thêm.</div> 
					<div class="not_point_tb"><a href="<?php echo FSRoute::_('index.php?module=content&view=cat&ccode=huong-dan&Itemid=363')?>" target="_blank"> Click vào đây để xem hướng dẫn cách nạp bigz.</a></div> 
				</div>
			<?php }else{?>
			<div class='download_area'>
				<form action="#" method="post" name="download_form" id='download_form' class='download_form'>
					<div class='download_label'>Vui lòng nhập mã xác nhận vào ô bên dưới</div>
					<p class='captcha'>
						<a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >
							<img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
						</a>
						<input type="text" id="txtCaptcha" value="" name="txtCaptcha"  maxlength="10" size="23" onfocus="if(this.value=='') this.value=''" onblur="if(this.value=='') this.value=''" />
						<input type="submit" value="" class='download_button'>
					</p>	
					<input type="hidden" value="1" name='raw' />
					<input type="hidden" value="products" name='module' />
					<input type="hidden" value="product" name='view' />
					<input type="hidden" value="download_verify" name='task' />
					<input type="hidden" value="<?php echo $data->id; ?>" name='record_id' id='record_id'  />
					<input type="hidden" value="<?php echo $return;?>" name='return'  />
				</form>
			</div>		
			<?php }?>			
			<?php include_once 'related/default_related.php'; ?> 
	    </div>
	</div> 
</div>
<input type="hidden" value="<?php echo $data->id; ?>" name='product_id' id='product_id'  />
<input type="hidden" value="<?php echo $data->category_id; ?>" name='category_id' id='category_id'  />
