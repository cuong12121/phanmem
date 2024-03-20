<?php  	global $tmpl;
// add jquery.stars

$tmpl -> addScript('jquery-ui.custom.min','libraries/jquery/jquery.ui.stars/js');
$tmpl -> addScript('jquery.ui.stars','libraries/jquery/jquery.ui.stars/js');
$tmpl -> addStylesheet('jquery.ui.stars','libraries/jquery/jquery.ui.stars/css');

$tmpl -> addScript('rate_star_digiworld','modules/products/assets/js');
?>
 <!--	STATISTIC RATE	-->
<div class="rate_panel" id="statistics_rate">
		<?php $point = $data -> rating_design_count ? round($data -> rating_design_sum /$data -> rating_design_count): 0 ; ?>
			<span id="statistics_ratesp">Thiết kế</span>
		<form id="ratings_design" action="demo1.php" method="post">
			<?php for($i = 0; $i < 5;$i ++){?>
				<input type="radio" name="rate" value="<?php echo ($i + 1)?>" title="<?php echo $i; ?>" id="rate<?php echo $i; ?>" <?php echo ($i+1) == $point?'checked="checked"':''?> /> 
			<?php }?>
			<?php
			
			// check cookies
			$disable_rating_design = 0; 
			$str_cookies_rating = isset($_COOKIE['rating_design'])?$_COOKIE['rating_design']:'';
			if($str_cookies_rating){
				$arr_cookies_rating = explode(',',$str_cookies_rating);
				if(in_array($data -> id,$arr_cookies_rating))
					$disable_rating_design = 1;		
			}
			?>
			<input type="hidden" name='rating_disable_design' id='rating_disable_design' value='<?php echo $disable_rating_design;?>'>	
		</form>

		<div class="clear"	></div>
</div>
<!--	end STATISTIC RATE	-->

 <!--	STATISTIC RATE	-->
	<div class="rate_panel" id="statistics_rate">
		<?php $point = $data -> rating_features_count ? round($data -> rating_features_sum /$data -> rating_features_count): 0 ; ?>
			<span id="statistics_ratesp">Chức năng</span>
		<form id="ratings_features" action="demo1.php" method="post">
			<?php for($i = 0; $i < 5;$i ++){?>
				<input type="radio" name="rate" value="<?php echo ($i + 1)?>" title="<?php echo $i; ?>" id="rate<?php echo $i; ?>" <?php echo ($i+1) == $point?'checked="checked"':''?> /> 
			<?php }?>
			<?php
			
			// check cookies
			$disable_rating_features = 0; 
			$str_cookies_rating = isset($_COOKIE['rating_features'])?$_COOKIE['rating_features']:'';
			if($str_cookies_rating){
				$arr_cookies_rating = explode(',',$str_cookies_rating);
				if(in_array($data -> id,$arr_cookies_rating))
					$disable_rating_features = 1;		
			}
			?>
			<input type="hidden" name='rating_disable_features' id='rating_disable_features' value='<?php echo $disable_rating_features;?>'>	
		</form>

		<div class="clear"	></div>
	</div>
<!--	end STATISTIC RATE	-->
<!--	STATISTIC RATE	-->
	<div class="rate_panel" id="statistics_rate">
		<?php $point = $data -> rating_performance_count ? round($data -> rating_performance_sum /$data -> rating_performance_count): 0 ; ?>
			<span id="statistics_ratesp">Hiệu suất</span>
		<form id="ratings_performance" action="demo1.php" method="post">
			<?php for($i = 0; $i < 5;$i ++){?>
				<input type="radio" name="rate" value="<?php echo ($i + 1)?>" title="<?php echo $i; ?>" id="rate<?php echo $i; ?>" <?php echo ($i+1) == $point?'checked="checked"':''?> /> 
			<?php }?>
			<?php
			
			// check cookies
			$disable_rating_performance = 0; 
			$str_cookies_rating = isset($_COOKIE['rating_performance'])?$_COOKIE['rating_performance']:'';
			if($str_cookies_rating){
				$arr_cookies_rating = explode(',',$str_cookies_rating);
				if(in_array($data -> id,$arr_cookies_rating))
					$disable_rating_performance = 1;		
			}
			?>
			<input type="hidden" name='rating_disable_performance' id='rating_disable_performance' value='<?php echo $disable_rating_performance;?>'>	
		</form>

		<div class="clear"	></div>
	</div>
<!--	end STATISTIC RATE	-->