<?php 
global $tmpl, $is_mobile, $config;
$tmpl -> addStylesheet('products');
$tmpl -> addStylesheet('hotdeal','modules/'.$this -> module.'/assets/css');
$tmpl -> addScript('hotdeal','modules/'.$this -> module.'/assets/js');
?>
<div class="box_product_cat">
	<div class="products-cat products_cat_full ">
		<h1 class="img-title-cat page_title display_off">
	      <span><?php echo FSText::_('Sản phẩm khuyến mãi') ?></span>
	    </h1>

	    <?php if(!empty($cat_default)){ ?>
	    	<div class="banner_big">
	    		<?php echo set_image_webp($cat_default->image2,'compress',@$cat_default->name,'',0,''); ?>
	    		<div class="time-dow-hotdeal" id="text-time-dow-hotdeal" >
					<div id="time-dow-hotdeal">
						<div class="time">
							<div id="day_h" class="time_1"></div>
							<span>Ngày</span>
						</div>
						<div class="time">
							<div id="hours_h" class="time_1"></div>
							<span>Giờ</span>
						</div>
						<div class="time">
							<div id="min_h" class="time_1"></div>
							<span>Phút</span>
						</div>
						<div class="time">
							<div id="sec_h" class="time_1"></div>
							<span>Giây</span>
						</div>
					</div>
				</div>
	    	</div>
	    <?php } ?>

	    <div class="container">
			<section class='products-cat-frame'> 
				<div class='products-cat-frame-inner '>	
				<?php 
					for($i = 0 ; $i < count( $array_cats) ; $i ++)
					{
						$cat2 = $array_cats[$i];
						if(!count($array_products[$cat2->id])){
							continue;
					}
				?>
					<div class="title_cat_item_store">
						<?php echo set_image_webp($cat2->image,'compress',@$cat2->name,'',0,''); ?>
					</div>
					<div class="cat_item_store">
						<?php include 'default_grid.php';?>
					</div>
					<div class="view-more-cat">
						<span data-id="<?php echo $cat2->id ?>">Xem thêm</span>
					</div>
					<div class="clear"></div>
				<?php 	
					} 
				?>		
				</div>
			</section>
		</div>

	</div>
	<div class="clear"></div>
</div>



<?php if($cat_default-> status == 'now') { ?>
	<?php if($cat_default-> finished_time) { 
		$date_finished_time = new DateTime($cat_default-> finished_time);
		$cat_default-> finished_time = date_format($date_finished_time,'m/d/yy H:i:s');
		?>
		<script>
// Set the date we're counting down to
var set_time_h = '<?php echo $cat_default-> finished_time; ?>';
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

<?php if($cat_default-> status == 'coming') { ?>
	<?php if($cat_default-> started_time) { 
		$date_started_time = new DateTime($cat_default-> started_time);
		$cat_default-> started_time = date_format($date_started_time,'m/d/yy H:i:s');?>
		<script>
// Set the date we're counting down to
var set_time_h = '<?php echo $cat_default-> started_time; ?>';
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