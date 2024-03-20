<div class="product_incentives">
		<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCCCCC">
			<thead>
				<tr>
					<th align="center" >
						Phụ kiện ưu đãi
					</th>
					<th align="center" >
						Giá gốc
					</th>
					<th align="center" >
						Giá ưu đãi
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
				if(isset($products_incentives))
				foreach ($products_incentives as $item) { 
			?>
				<tr id='record_incentives_<?php echo $item ->id?>'>
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
						<a href="javascript: remove_incentives(<?php echo $data -> id; ?>,<?php echo $item -> product_incenty_id; ?>)">Xóa</a>
					</td>
						<td>
						<?php echo $item -> id;?>
					</td>
				</tr>
					<?php
						$i++; 
				}
				?>
				<tr class='record_incentives_continue'>
				</tr>
			</tbody>		
		</table>
		<div class='add_products'>
			<a href="javascript:add_product_incentives(<?php echo $data -> id; ?>)"><strong class='red'>Thêm phụ kiện</strong></a>
		</div>
</div>
<script type="text/javascript" >
function add_product_incentives(id){
	if(id)
		window.open("index2.php?module=products&view=products_incentives&id="+id, "","height=600,width=700,menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0");
}
function remove_incentives(id,product_incentives_id){
	$.get("index.php?module=products&view=products&task=remove_incentives&raw=1&id="+id,{product_incentives_id: product_incentives_id}, function(j){
		if(j == 0){
			alert('Không xóa được');
		} else {
			alert('Xóa thành công');
			$('#record_incentives_'+product_incentives_id).hide();
		}	
	})
}
</script>