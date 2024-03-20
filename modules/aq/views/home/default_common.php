<?php if(count($list_common)){ ?>
	<div class="common">
		<div class='cat-title'>
			<h2><?php echo FSText::_('Câu hỏi thường gặp nhất'); ?></h2>
		</div>
		<div class="row">
	
		<?php
		foreach($list_common as $item){
			include 'default_item.php';
		}
		?>
		</div>
	</div>
<?php }?>
