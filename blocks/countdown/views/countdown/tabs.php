<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('tabs','blocks/products_list/assets/css');
?>
<div class="block_content products_list_tabs">
	<ul class="nav nav-tabs">
		<li class="active">
			<a data-toggle="tab" href="#section_newst">Sản phẩm mới </a>
		</li>
		<li>
			<a data-toggle="tab" href="#section_selling">Sản phẩm bán chạy</a>
		</li>
		<li><a data-toggle="tab" href="#section_old">Sản phẩm cũ</a></li>
	</ul>
	<div class="clear"></div>
	<div class="tab-content">
		<div class="img_instead hidden-md hidden-sm hidden-xs">
			<?php echo $tmpl -> load_direct_blocks('banners',array('style'=>'default_2','category_id'=>35)); ?>
		</div>
		<div id="section_newst" class="tab-pane fade in active">
				<?php echo $html['new']; ?>
		</div>
		<div id="section_selling" class="tab-pane fade">
				<?php echo $html['selling']; ?>
			
		</div>
		<div id="section_old" class="tab-pane fade">
				<?php echo $html['old']; ?>
		</div>
		<div class="clear"></div>
	</div>
</div>