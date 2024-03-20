<?php
global $tmpl,$config,$is_mobile; 

$tmpl -> addStylesheet('slideshow_hot','blocks/saleoff/assets/css');
if(!$is_mobile){
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addScript('slideshow_hot','blocks/saleoff/assets/js');
}
FSFactory::include_class('fsstring');
?>
<?php if(isset($list) && !empty($list)){?>
	<div class="products_blocks_wrapper  block slideshow-hot">
		<div class="block_title cls">
			<div class="block_title_wrap">
				<div class="block_title_inner cls">
					<span><?php echo $title; ?></span>

					<div class="time-dow-hotdeal" id="text-time-dow-hotdeal" >
						<!-- <?php if($sale-> status == 'now'){ echo 'Kết thúc:';  } ?> -->
						<?php if($sale-> status == 'coming'){ echo 'Sẽ bắt đầu:';  } ?>
						<div id="time-dow-hotdeal">
							<div class="time">
								<div id="day_h" class="time_1"></div>
							</div>
							<div class="time">
								<div id="hours_h" class="time_1"></div>
							</div>
							<div class="time">
								<div id="min_h" class="time_1"></div>
							</div>
							<div class="time">
								<div id="sec_h" class="time_1"></div>
							</div>
						</div>
					</div>
				
					<a rel="nofollow" href="<?php echo  FSRoute::_("index.php?module=products&view=hotdeal&Itemid=9") ?>" class="view-all" title="Xem tất cả">Xem tất cả ></a>
				</div>
			</div>
		</div>

		<div class="slideshow-hot-list product_grid <?php echo !$is_mobile ? 'products_blocks_slideshow_hot' : 'products_blocks_slideshow_hot_mobile' ?>">
			<?php if($is_mobile){
				$w = count($list) * 155; 
			?>
			<div class="slideshow-hot-list-inner" style="width: <?php echo $w.'px'; ?>">
			<?php } ?>
			<?php $i = 0; ?>
			<?php foreach($list as $item){?>
				<?php $link = FSRoute::_("index.php?module=products&view=product&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias.'&cid='.$item -> category_id); ?>
				<?php if(!$is_mobile){ ?>
				<div class="item <?php echo $i > 5 ? 'hide':''; ?> <?php echo $i < 6 ? 'item-block':''; ?> " >
				<?php }else{ ?>
				<div class="item">
				<?php } ?>
					<div class="frame_inner">
						<figure class="product_image "  >
							<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
							<a href="<?php echo $link;?>" title='<?php echo htmlspecialchars($item->name);?>'>
								<?php echo set_image_webp($item->image,'resized',@$item->name,'',0,''); ?>
							</a>
							<?php  if(!empty($item->type) && !empty($types) && !empty($types[$item->type]) ){ ?>
								<div class="type"><span><?php echo $types[$item->type]->name ?></span></div>
							<?php } ?>
						</figure>
						<?php if($item-> is_hot == 1){ ?>
							<span class="icon_hot">Hot</span>
						<?php } ?>
		
						<?php if($item-> price_old > $item-> price) { ?>
							<span class='price_discount'><?php echo round(($item -> price  - $item -> price_old) * 100 / $item-> price_old);?>%</span>
						<?php }?>
						<h3><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
							<?php echo FSString::getWord(15,$item -> name); ?>
						</a></h3>	
						<div class='price_arae'>
							 
							<span class='price_current'><?php echo format_money($item -> price).''?></span> 
							<?php if($item-> price_old > $item-> price) { ?>
								<span class='price_old'><?php echo format_money($item -> price_old).''?></span>
							<?php }?>
						</div>

						<div class="clear"></div>
						<!-- Số lượng sản phẩm đã bán< -->
						<div class="quantity_sold cls">
							<?php 
								$c = (int)$item-> total_item_buy; // đã bán
								$t = (int)$item-> total_item; // tổn
								$p = number_format((float)($c/$t *100),2,'.','');
							?>
							<div class="progress">
								<div class="bar">
									 <div class="percent" role="progressbar" style="background: <?php echo $sale->code_color ?>; width:<?php echo $p;?>%;"></div>
									 <div class="text">
									 	<?php if($c < $t){ ?>
									 		Đã bán <?php echo (int)$item-> total_item_buy ?>
									 	<?php }else{ ?>
									 		Đã bán hết
									 	<?php } ?>
									 </div>
								</div>
							</div>
						</div>


					</div>	
				</div>
				<?php $i ++; ?>
			<?php }?>

			<?php if($is_mobile){ ?>
				</div>
			<?php } ?>
		</div>
		
		<div class="view-all-mobile">
			<a rel="nofollow" href="<?php echo  FSRoute::_("index.php?module=products&view=hotdeal&Itemid=9") ?>"  title="Xem tất cả">Xem tất cả ></a>
		</div>
		


	</div>		
<?php } ?>

<?php if($sale-> status == 'now') { ?>
	<?php if($sale-> finished_time) { 
		$date_finished_time = new DateTime($sale-> finished_time);
		$sale-> finished_time = date_format($date_finished_time,'m/d/yy H:i:s');
		?>
		<script>
// Set the date we're counting down to
var set_time_h = '<?php echo $sale-> finished_time; ?>';
var countDownDate_h = new Date(set_time_h).getTime();
// Update the count down every 1 second
var x_h = setInterval(function() {
  // Get todays date and time
  var now_h = new Date().getTime();
  // Find the distance between now and the count down date
  var distance_h = countDownDate_h - now_h;
  // Time calculations for days, hours, minutes and seconds
  var days_h = Math.floor(distance_h / (1000 * 60 * 60 * 24));
  var hours_h = Math.floor((distance_h % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes_h = Math.floor((distance_h % (1000 * 60 * 60)) / (1000 * 60));
  var seconds_h = Math.floor((distance_h % (1000 * 60)) / 1000);
  // Display the result in the element with id="demo"
  if(parseInt(days_h)<10) {
  	days_h = '0' + days_h;
  }
  if(parseInt(hours_h)<10) {
  	hours_h = '0' + hours_h;
  }
  if(parseInt(minutes_h)<10) {
  	minutes_h = '0' + minutes_h;
  }
  if(parseInt(seconds_h)<10) {
  	// alert('xx');
  	seconds_h = '0'+seconds_h;
  }
  document.getElementById("day_h").innerHTML = days_h;
  document.getElementById("hours_h").innerHTML = hours_h;
  document.getElementById("min_h").innerHTML = minutes_h;
  document.getElementById("sec_h").innerHTML = seconds_h;
  // If the count down is finished, write some text 
  if (distance_h < 0) {
  	clearInterval(x_h);
  	document.getElementById("text-time-dow-hotdeal").innerHTML = "Đã kết thúc";
  }
}, 1000);
</script>
<?php } ?>
<?php } ?>

<?php if($sale-> status == 'coming') { ?>
	<?php if($sale-> started_time) { 
		$date_started_time = new DateTime($sale-> started_time);
		$sale-> started_time = date_format($date_started_time,'m/d/yy H:i:s');?>
		<script>
// Set the date we're counting down to
var set_time_h = '<?php echo $sale-> started_time; ?>';
var countDownDate_h = new Date(set_time_h).getTime();
// Update the count down every 1 second
var x_h = setInterval(function() {
  // Get todays date and time
  var now_h = new Date().getTime();
  // Find the distance between now and the count down date
  var distance_h = countDownDate_h - now_h;
  // Time calculations for days, hours, minutes and seconds
  var days_h = Math.floor(distance_h / (1000 * 60 * 60 * 24));
  var hours_h = Math.floor((distance_h % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes_h = Math.floor((distance_h % (1000 * 60 * 60)) / (1000 * 60));
  var seconds_h = Math.floor((distance_h % (1000 * 60)) / 1000);
  // Display the result in the element with id="demo"
  if(parseInt(days_h)<10) {
  	days_h = '0' + days_h;
  }
  if(parseInt(hours_h)<10) {
  	hours_h = '0' + hours_h;
  }
  if(parseInt(minutes_h)<10) {
  	minutes_h = '0' + minutes_h;
  }
  if(parseInt(seconds_h)<10) {
  	// alert('xx');
  	seconds_h = '0'+seconds_h;
  }
  document.getElementById("day_h").innerHTML = days_h;
  document.getElementById("hours_h").innerHTML = hours_h;
  document.getElementById("min_h").innerHTML = minutes_h;
  document.getElementById("sec_h").innerHTML = seconds_h;
  // If the count down is finished, write some text 
  if (distance_h < 0) {
  	clearInterval(x_h);
  	document.getElementById("text-time-dow-hotdeal").innerHTML = "Đã kết thúc";
  }
}, 1000);
</script>
<?php } ?>
<?php } ?>