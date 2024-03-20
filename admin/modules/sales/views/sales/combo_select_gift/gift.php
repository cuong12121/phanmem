<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>

<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/eye.js"></script>

<!-- FOR TAB -->	
 <script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
	<?php
	$title =  FSText :: _('Chọn quà'); 
	global $toolbar;
	$toolbar->setTitle($title);
//	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
//	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('save_gifts_salenselectgift',FSText :: _('Save'),'','save.png'); 
//	$toolbar->addButton('gift_salenselectgift',FSText :: _('Chọn quà'),'','duplicate.png'); 
	$toolbar->addButton('back_sale',FSText :: _('Cancel'),'','back.png');   
	
	$this -> dt_form_begin(0);
	?>
	<?php if($products_in_sale){ ?>
	<div class="gift_head">
		<span> Chọn sản phẩm được add quà:</span> 
		<select name="sale_product_id_select" id="sale_product_id_select" onchange="javascript: if(confirm('Note: Bạn cần lưu lại trước khi chuyển sang add quà cho sp khác!')){location.href=$(this).val();}">
			<?php $link = "index.php?module=sales&view=sales&task=gift_salenselectgift&id=".$data -> id; ?>
			<option value="<?php echo $link; ?>"  >-- Chọn sản phẩm để add quà --</option>
			<?php foreach($products_in_sale as $item){?>
				<?php $link = "index.php?module=sales&view=sales&task=gift_salenselectgift&id=".$data -> id."&sale_product_id=".$item->sale_product_id; ?>
				<option value="<?php echo $link; ?>" <?php echo @$sale_product_select -> sale_product_id == $item -> sale_product_id ? 'selected="selected"':'' ?> ><?php echo $item -> name.' ('.$item->unit.')'; ?></option>	
			<?php }?>
		</select>
		<?php if($sale_product_select){?>
			<div class="title_gift">Bạn đang chọn quà cho sản phẩm:<strong><?php echo $sale_product_select -> name.' ( '.$sale_product_select -> unit.' ) - '.format_money($sale_product_select -> price) ; ?></strong></div>
		<?php }?>
		<input name="sale_product_id" value="<?php echo @$sale_product_select -> sale_product_id; ?>" type="hidden" /> 
	</div>
	<?php }else{?>
		<?php $link = "index.php?module=sales&view=sales&task=edit&id=".$data -> id; ?>
		Bạn chưa chọn sản phẩm cho chương trình sale này. <a href="<?php echo $link; ?>">Bấm vào đây để chọn</a>.
	<?php }?>
	<?php include_once 'default_gift.php';?>
<?php 
$this -> dt_form_end(@$data,0);
?>
<style>
	.title_gift{
		    margin: 10px 0;
	}
</style>