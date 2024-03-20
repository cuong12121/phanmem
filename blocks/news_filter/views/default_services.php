<?php 
	$ccode = FSInput::get('ccode');
?>
<div class='services_categories sub_block' id = 'services_group_seat'>
	<div class="sub_block_title" data-id="sim-hop-menh">
		<div class="normal">
			<span>Dịch vụ</span>
		</div>
	</div>
	<div class="clear"></div>
	<div id="sim-hop-menh" class="panel-body services_categories_label"><!-- style="display: none;" -->
		<ul>
		<?php foreach($services as $item){?>
			<?php 
				$activate = 0;
				if($ccode && $ccode == $item -> alias){
					$link = FSRoute::addParameters('ccode',$item -> alias,'products','service');
					$activate = 1;
				}else{
					$link = FSRoute::addParameters('ccode',$item -> alias,'products','service');
				}	
				?>
			<li class='filter_item'>
				<a href="<?php echo $link; ?>" title="<?php echo $item -> name; ?>" id="<?php echo $activate?"activated":"" ?>">
					 <span><?php echo $item -> name; ?></span></label>
				</a>
			</li>
			<?php } ?>
		</ul>
		<div class="clear"></div>
	</div>
</div>