<?php 
	if(!empty($data)){
	foreach ($data as $item) {
?>
	<a href="javascript:void(0)" class="item cls" data-id = "<?php echo $item->id ?>"  onclick="set_product_search(this)">
        <span class="image">
        	<?php if($item->image){ ?>
            <img src="<?php echo URL_ROOT.str_replace('/original/', '/small/', $item->image) ?>" >
        	<?php } ?>
        </span>
        <span class="info">
            <span class="code"><?php echo $item->code ?></span> - 
            <span class="name"><?php echo $item->name ?></span>
            <span class="price"><?php echo format_money($item -> price)?></span>
            <span class="quanlity">(Tồn kho: 1)</span>
        </span>
    </a>
<?php }}else{ ?>
	<a href="javascript:void(0)" class="item cls">
		Không có kết quả nào được tìm thấy
	</a>
<?php } ?>