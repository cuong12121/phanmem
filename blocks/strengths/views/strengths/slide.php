<?php
global $tmpl,$config,$is_mobile; 
$tmpl -> addStylesheet('slide','blocks/strengths/assets/css');
$tmpl -> addScript('slide','blocks/strengths/assets/js');
FSFactory::include_class('fsstring');
?>
<div class="bg_str">
	<?php $i = 0;?>
	<?php foreach ($list as $item){ ?>
	<div class="item_bg cls <?php if($i!=1) echo 'hide'; ?> " id="item_bg_<?php echo $item->id ?>">
	<img src="<?php echo $item-> image; ?>" alt="">
</div>

	<?php $i++ ;} ?>
</div>
<div class='strengths_slide_block strengths_slide_block_<?php echo count($list); ?> cls'>
	<?php $i=0; ?>
	<div class="menu_str">
				<?php $i = 0;?>
				<?php 	foreach ($list as $item){?>
					<div class="item item-label cls <?php if($i==1) echo 'item_yes'; else echo 'item_no'; ?> " id="item_str_<?php echo $item->id ?>">
						<div class="item-label" id='tab_str_<?php echo $item->id; ?>'><?php echo $item-> title; ?></div>
						<div class="content str_tab_wrapper body-introduce cls <?php echo $i?'content_no':''; ?> " id="<?php echo "str_tab_wrapper_".$item->id; ?>">
							<div class="item-inner">
								<div class="item-content">
									<div class="name">
										<?php echo $item -> title; ?>
									</div>
									<div class="summary">
										<?php echo $item -> summary; ?>
									</div>
								</div>
							</div>
							<div class="image"></div>
						</div>
					</div>
					<?php $i ++; ?>	
				<?php } ?>
			</div>
<!-- <?php foreach($list as $item){ $i++; ?>
	<div class="item">
		<div class="item-inner">
				<div class="image">
				 <img src='<?php echo URL_ROOT.str_replace('/original/','/large/',$item -> image)?>' alt="<?php echo $item -> title?>"/>
				</div>
			<div class="item-r">
				<div class="name">
					<?php echo $item -> title; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="item_break"></div>
	<?php } ?> -->

</div>

