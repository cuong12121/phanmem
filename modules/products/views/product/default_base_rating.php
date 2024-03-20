<?php  	global $tmpl;
// add jquery.stars

$tmpl -> addScript('jquery-ui.custom.min','libraries/jquery/jquery.ui.stars/js');
$tmpl -> addScript('jquery.ui.stars','libraries/jquery/jquery.ui.stars/js');
$tmpl -> addStylesheet('jquery.ui.stars','libraries/jquery/jquery.ui.stars/css');

$tmpl -> addScript('rate_star','modules/products/assets/js');
?>
 <!--	STATISTIC RATE	-->
			<div class="rate_panel" id="statistics_rate">
				<?php $point = $data -> rating_count ? round($data -> rating_sum /$data -> rating_count): 0 ; ?>
<!--				<span id="statistics_ratesp">Đánh giá</span>-->
					<form id="ratings" action="demo1.php" method="post">
						<?php for($i = 0; $i < 5;$i ++){?>
							<input type="radio" name="rate" value="<?php echo ($i + 1)?>" title="<?php echo $i; ?>" id="rate<?php echo $i; ?>" <?php echo ($i+1) == $point?'checked="checked"':''?> /> 
						<?php }?>
						<?php
						
						// check cookies
						$disable_rating = 0; 
						$str_cookies_rating = isset($_COOKIE['rating_product'])?$_COOKIE['rating_product']:'';
						if($str_cookies_rating){
							$arr_cookies_rating = explode(',',$str_cookies_rating);
							if(in_array($data -> id,$arr_cookies_rating))
								$disable_rating = 1;		
						}
						?>
						<input type="hidden" name='rating_disable' id='rating_disable' value='<?php echo $disable_rating;?>'>	
					</form>

				<div class="clear"	></div>
			</div>
			<!--	end STATISTIC RATE	-->