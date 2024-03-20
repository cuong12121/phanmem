<?php
global $tmpl,$config; 
	$tmpl -> addStylesheet('strengths','blocks/strengths/assets/css');
	FSFactory::include_class('fsstring');
	?>
<div class='strengths_block cls'>
<?php if($summary){ ?>
	<div class="pos-sum"><span><?php echo $summary; ?></span></div>
<?php } ?>
<div class="product_star">
	<span class="line-thought"></span>
	<span class="star_small"><i class="fa fa-star"></i></span>
	<span class="star_large"><i class="fa fa-star"></i></span>
	<span class="star_small"><i class="fa fa-star"></i></span>
	<span class="line-thought"></span>
</div>

<ul>	
	<?php echo $config['strengths']; ?>
       
 </div>

