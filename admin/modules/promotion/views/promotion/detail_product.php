<div class="promotion_product">
		<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCCCCC">
			<thead>
				<tr>
					<th align="center" >
						Sản phẩm khuyến mại
					</th>
					<th align="center" >
						Giá gốc
					</th>
					<th align="center" >
						Giá khuyến mại
					</th>
					<th align="center" >
						Xóa
					</th>
					<th align="center" >
						Id
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$i = 0; 
				if(isset($promotion_products))
				foreach ($promotion_products as $item) { 
			?>
				<tr id='record_product_<?php echo $item ->id?>'>
					<td>
						<?php echo $item -> name;?>
					</td>
				
					<td>
						<?php echo format_money($item -> price_old,'');?>
					</td>
					<td>
						<input type="text" name='<?php echo 'price_new_'.$item ->id?>' value='<?php echo $item -> price_new?>' >
						<input type="hidden" name='<?php echo 'price_new_'.$item ->id.'_begin'?>' value='<?php echo $item -> price_new?>' >
					</td>
					<td>
						<a href="javascript: remove_product(<?php echo $data -> id; ?>,<?php echo $item -> product_incenty_id; ?>)">Xóa</a>
					</td>
						<td>
						<?php echo $item -> id;?>
					</td>
				</tr>
					<?php
						$i++; 
				}
				?>
				<tr class='record_products_continue'>
				</tr>
			</tbody>		
		</table>
		<div class='add_products'>
			<a href="javascript:add_promotion_products(<?php echo $data -> id; ?>)"><strong class='red'>Thêm sản phẩm</strong></a>
		</div>
</div>
<script type="text/javascript" >
function add_promotion_products(id){
	if(id)
		window.open("index2.php?module=promotion&view=promotion_products&id="+id, "","height=600,width=700,menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0");
}
function remove_product(id,promotion_product_id){
	$.get("index.php?module=promotion&view=promotion&task=remove_product&raw=1&id="+id,{promotion_product_id: promotion_product_id}, function(j){
		if(j == 0){
			alert('Không xóa được');
		} else {
			alert('Xóa thành công');
			$('#record_product_'+promotion_product_id).hide();
		}	
	})
}
</script>