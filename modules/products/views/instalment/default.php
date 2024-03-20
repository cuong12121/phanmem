<?php 
global $tmpl, $config;
$tmpl -> addStylesheet("instalment","modules/products/assets/css");
// $tmpl -> addStylesheet("jquery-ui","libraries/jquery/jquery.ui");
// $tmpl -> addScript("jquery-ui","libraries/jquery/jquery.ui");
$tmpl -> addScript("form");
$tmpl -> addScript("instalment","modules/products/assets/js");
$id = FSInput::get('id');
$link = FSRoute::_('index.php?module=products&view=product&code='.$data -> alias.'&ccode='.$data->category_alias.'&id='.$data->id.'&cid='.$data->category_id);
?>
<div class="product_instalment">
	
	<h1><?php echo $data -> installment_name? $data -> installment_name : 'Mua trả góp '. $data -> name.' lãi suất thấp'; ?></h1>
	<h2 class="link_product">Xem thông tin chi tiết về: <a href="<?php echo $link; ?>" target="_blank" title="<?php echo $data -> name; ?>"> <?php echo $data -> name; ?></a></h2> 
	<div  class="hotline_installment"><label>Tư vấn trả góp: <a href="tel:<?php echo $config['hotline_installment']; ?>" title="<?php echo $config['hotline_installment']; ?>"> <?php echo $config['hotline_installment']; ?></a></span></label></div>
	<form action="" name="eshopcart_info" method="post" id="eshopcart_info" >

		<div class="table_head">
			<label>Lựa chọn phương thức trả góp phù hợp:</label>
			<div class="method_instalment_wrapper cls">
				<div class="finance_method" id="finance_method">					
					<span>Công ty tài chính</span>
					<span>HD SAISON</span>

				</div>
				<div class="alepay_method" id="alepay_method">
					<span>Thẻ tín dụng</span>
					<span>Visa, master, alepay</span>
				</div>
			</div>
			<input type="hidden" name="method_instalment" id="method_instalment" value="finance" />
		</div>

		<div class="table_t" style="display: none" id="table_main">

			<div class="table_body cls">
				<div class="table_body_l">
					<label class="mt10">Mua trả góp <?php echo $data -> name; ?></label>
					<div class="clearfix"></div>
					
					<div id="product-content">
						<img id="product-icon" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $data -> image)?>"  alt="<?php echo $data -> name; ?>">
						
						<h3 class='price_modal'>
							<?php if(@$price_default) {
								echo format_money($price_default) ; 
							} else {echo format_money($price_by_region) ; }?>
						</h3>

					</div>
					<?php include 'default_prices.php'; ?>
					<div class="clearfix"></div>
					<br/><br/>
					<input id="product_text"  placeholder="Nhập tên sản phẩm cần mua">
					
				</div>
				<?php include 'finance.php'; ?>
				<?php   include 'alepay.php'; ?>
				
				

				<div class="clearfix"></div>
			</div><!--  .table_body -->
			
			
		</div>
		<input type="hidden" name='id' value="<?php echo $data->id;?>" />
		<input type="hidden" name='price' value="<?php echo $price;?>" />
		<input type="hidden" name='price_old' value="<?php echo $data->price_old;?>" />
		<input type="hidden" name='module' value="products" class="alepay_not_submit" />
		<input type="hidden" name='view' value="cart"  class="alepay_not_submit"/>
		<input type="hidden" name='task' value="eshopcart2_save" id = 'task'  class="alepay_not_submit"/>
		
	</form>	




</div>

<?php include 'default_note.php' ?>

<div class="description">
	<?php 
	if($data -> installment_descripttion){
		$installment_descripttion = $data -> installment_descripttion;
	}else{
		$installment_descripttion = $config['installment_descripttion'];
		$installment_descripttion = str_replace('{name}', $data -> name, $installment_descripttion);		
		
		$installment_descripttion = str_replace('{link_prd}', $link, $installment_descripttion);
		
	}


	$installment_descripttion = str_replace('<iframe','<div class="video_wrapper" ><iframe',$installment_descripttion);
	$installment_descripttion = str_replace('</iframe>','</iframe></div>',$installment_descripttion);
	echo $installment_descripttion;

	?>
</div>



<div class='tab_content_right'>
	<?php 	include 'plugins/comments/controllers/comments.php'; ?>
	<?php $pcomment = new CommentsPControllersComments(); ?>
	<?php		$pcomment->display($data); ?>

</div>



<?php 
if(isset($data) && $data ) 
	include 'default_remarketing.php';
?>

<?php $point = $data -> rating_count ? round($data -> rating_sum /$data -> rating_count): 4 ; ?>


<script type="application/ld+json">        
	{
		"@context": "http://schema.org/",
		"@type": "Product",
		"name": "<?php echo $data -> installment_name? $data -> installment_name : 'Mua trả góp '. $data -> name.' lãi suất thấp'; ?>", 
		"image": "<?php echo URL_ROOT.$data -> image; ?>",
		"description": "<?php echo "Mua trả góp ".$data -> name." lãi suất thấp. ".$data -> summary;?>" ,
		"mpn": "<?php echo 'tra-gop-'.$data -> id; ?>",
		"brand": {
		"@type": "Thing",
		"name": "<?php echo $data->manufactory_name; ?>"
	},
	"aggregateRating": {
	"@type": "AggregateRating",
	"ratingValue": "<?php echo $point; ?>",
	"reviewCount": "<?php echo $data -> rating_count?$data -> rating_count:1; ?>"
}
}


</script>

