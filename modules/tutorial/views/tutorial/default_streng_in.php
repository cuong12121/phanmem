<?php 
global $tmpl,$config; 
	$tmpl -> addStylesheet('streng','modules/tutorial/assets/css');
	//$tmpl -> addScript('streng','modules/tutorial/assets/js');
?>
<div class="streng_content">
	<?php if(!empty($list)){
		foreach ($list as $key => $item) {?>
			<div class="item cls">
				<?php if( $item-> summary_hover){?>
					<div class="summary_hover">
						<span><?php echo $item-> summary_hover;?></span>					
					</div>
				<?php }?>
				<div class="title_st">
					<?php echo $item-> title;?>
				</div>
			</div>
		<?php }
	?>
	<?php }?>
</div>