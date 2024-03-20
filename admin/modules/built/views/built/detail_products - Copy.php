<?php $max_ordering = 1; ?>
	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					Tên
				</th>
				<th align="center" >
					Giá
				</th>
				<th align="center" >
					Số lượng
				</th>
				<th align="center" >
					Trường thêm
				</th>
				<th align="center" >
					Tổng tiền
				</th>
				<th align="center"  width="15" >
					Xóa
				</th>
			</tr>
		</thead>

		<tbody>
		<?php
			$i = 0;

			if(isset($order_items) && !empty($order_items)){

				foreach ($order_items as $item) { 
		?>
				<tr id='change_record_<?php echo $item -> id; ?>' class='change_record'>
					

					<input autocomplete="off" type="hidden" size="20" name="change_pro_id_<?php echo $i;?>" value="<?php echo $item -> product_id ;?>">

					<td width="250px">
						<input disabled type="text" size="30" data_i = "<?php echo $item -> id ?>" class="product_id" name="change_product_<?php echo $item -> id;?>" value="<?php echo $item -> product_name; ?>" > 
					</td>

					<td width="90px">
						<input disabled value="<?php echo $item -> price; ?>" type="text" size="8" name="change_price_<?php echo $i;?>">
					</td>
			
					<td width="70px"> 
						<input class="change_count_item" data_order_id="<?php echo $item -> order_id; ?>" data_id="<?php echo $item -> id; ?>" data_price="<?php echo $item -> price; ?>" value="<?php echo $item -> count; ?>" type="text" size="4" name="change_count_<?php echo $i?>">
					</td>
					<td>
						<div class="_color">
							<?php 
								$price_by_color = $model->get_price_by_colors($item-> product_id);
							?>
							<div>Chọn màu: </div>
							<select class="boxcolor" name="color" onchange="load_quick(this);">
 								<option value="0" data-price="0" data-type="color">Chọn màu</option>
 								<?php foreach ($price_by_color as $item_color){ ?>
									<option value="<?php echo $item_color -> id;?>" data-price="<?php echo $item_color -> price;?>" data-type="color"><?php echo $item_color -> color_name;?></option>
								<?php }	?>
							</select>
						</div>
						<div class="_attributes">
							<?php 
								$price_by_extend_group = $model->get_price_by_extend_group ( $item->product_id );
								$extends_groups_data =  $model->get_records('','fs_extends_groups','*','','','id');
								$price_by_extend =array();
								$price_by_extend_group = $model->get_price_by_extend_group ( $item->product_id );
								if(!empty($price_by_extend_group)) {
									foreach ($price_by_extend_group as $extend_group) {
										$price_by_extend[$extend_group -> group_extend_id] = $model->get_price_by_extend ( $item->product_id , $extend_group -> group_extend_id);
									}
								}
							?>

							<?php if(!empty($price_by_extend_group)){ ?>
								<div class="all_ground_extend">

									<?php foreach ($price_by_extend_group as $price_extend_group){ ?>
										<div class="ground_extend_name ground_extend_name_select"><?php echo $price_extend_group-> ground_extend_name?>:</div>
										<select class="onchange_trigger">
											<option>Chọn <?php echo strtolower($price_extend_group-> ground_extend_name) ?></option>
											<?php foreach ($price_by_extend[$price_extend_group -> group_extend_id]   as $item_ex){?>
												<option <?php echo $item_ex->is_default == 1 ? 'selected' : '' ?> class="data-style-select-<?php echo $item->id ?>" data-group-id = "<?php echo $price_extend_group->group_extend_id ?>" value="<?php echo $item->id ?>"><?php echo $item_ex -> extend_name;?></option>
											<?php }	?>
											
										</select>
									<?php } ?>
								</div>
							<?php  } ?>
						</div>
					</td>
					<td width="90px">
						<input disabled class="change_total_<?php echo $item->id;?>" value="<?php echo $item -> total; ?>" type="text" size="10" name="change_total_<?php echo $i;?>">
					</td>
					<td>
						<a href="javascript: void(0)" onclick="javascript: remove_order_item('<?php echo $item -> id; ?>')" ><?php echo  FSText :: _("Xóa")?></a>
					</td>
				</tr>


		<?php
			$i++; 
				}
			}
		?>

		<?php for($i = 0; $i < 20; $i ++ ) { ?>
			<tr id='new_record_<?php echo $i?>' class='new_record closed'>
				<input type="hidden" size="20" id="pro_id_<?php echo $i;?>" name="pro_id_<?php echo $i;?>" value="">
				<td>
					<input autocomplete="off" type="text" size="30" data_i = "<?php echo $i ?>" id="product_<?php echo $i;?>" class="product_id" name="product_<?php echo $i;?>">
				</td>
				<td>
					<input type="text" size="8" id="price_<?php echo $i;?>" name="price_<?php echo $i;?>">
				</td>
				<td>
					<input type="text" size="4" id="count_<?php echo $i;?>" name="count_<?php echo $i;?>" onclick="javascript: change_count_pro('<?php echo $i; ?>')">
				</td>
				<td>
					
				</td>
				<td>
					<input disabled type="text" size="20" id="total_<?php echo $i;?>" name="total_<?php echo $i;?>">
				</td>
				<td>
					
				</td>
			</tr>
	<?php } ?>
	</tbody>		
	</table>

	<div class='add_record'>
		<a href="javascript:add_price()"><strong class='red'>Thêm</strong></a>
	</div>
	<input type="hidden" value="<?php echo isset($prices)?count($prices):0; ?>" name="price_exist_total" id="price_exist_total" />
	<input type="hidden" value="" name="price_ids_remove" id="price_ids_remove" />

	
	<div id="popup-products" class="">
		<div class="products_related">
			<div class='products_related_search'>
				<span>Tìm kiếm: </span>
				<input type="text" name='products_related_keyword' value='' id='products_related_keyword' />
				<select name="products_related_category_id"  id="products_related_category_id">
					<option value="">Danh mục</option>
					<?php 
					foreach ($categories as $item) {
					?>
						<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
					<?php }?>
				</select>
				<input type="button" name='products_related_search' value='Tìm kiếm' id='products_related_search' />
			</div>
			<div id="products_related_search_list">
				
			</div>
		</div>
	</div>
	<div style="clear: both;"></div>

	
<script type="text/javascript" >

	$('.change_count_item').keyup(function(){
		var order_id =  $(this).attr('data_order_id');
		var price = $(this).attr('data_price');
		var id = $(this).attr('data_id');
		var count  = $(this).val();
		// if(count < 1){
			// alert("Số lượng phải nhập lớn hơn 0");
			// return false;
		// }
		// if(Number.isInteger(count) == false){
		// 	alert("Số lượng phải là số");
		// 	return false;
		// }
		// console.log(order_id);
		// console.log(price);
		// console.log(id);
		// console.log(count);

		$.ajax({url: "index.php?module=built&view=built&task=ajax_change_count_item&raw=1",
			data: {id: id,price:price,count:count,order_id:order_id},
			dataType: "text",
			success: function(data) {
				if(data != 0){
					var total  = Number(price) * Number(count);
					// console.log(total);
					$('.change_total_'+id).val(total);
					// $(".change_record").load(location.href+" .change_record>*","");
				}
			}
		});
	});
	



	function add_price(){
		for(var i = 0; i < 20; i ++){
			tr_current = $('#new_record_'+i);
			if(tr_current.hasClass('closed')){
				tr_current.addClass('opened').removeClass('closed');
				return;
			}
		}
	}

	function remove_order_item(id)
	{
		if(confirm("Bạn muốn xóa?"))
		{
			$.get("index2.php?module=built&view=built&task=ajax_remove_order_item&raw=1",{id:id}, function(html){
				$('#change_record_'+id).html("");
			});
		}
		return false;
	}


	

	////////////show products

	search_products_related()

	function search_products_related(){
		
		$('.product_id').click(function(){
			$('.product_id').removeClass('active_input')
			$(this).addClass('active_input');
			$('#popup-products').removeClass('hidden');
		});



		$('#products_related_search').click(function(){
			var keyword = $('#products_related_keyword').val();
			var category_id = $('#products_related_category_id').val();
			var product_id = <?php echo @$data -> id?$data -> id:0?>;
			var str_exist = '';
			$( "#products_sortable_related li input" ).each(function( index ) {
				if(str_exist != '')
					str_exist += ',';
				str_exist += 	$( this ).val();
			});
			$.get("index2.php?module=built&view=built&task=ajax_get_products_related&raw=1",{product_id:product_id,category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
				$('#products_related_search_list').html(html);
			});
		});
	}

	function set_products_to_input(pro_id,price, name){
		var data_i = $('.active_input').attr('data_i');
		$('#product_'+data_i).val(name);
		$('#price_'+data_i).val(price);
		$('#pro_id_'+data_i).val(pro_id);

	}


</script>

<style>
.closed{
	display:none;
}

.active_input{
	border: 1px solid red;
}
#popup-products{
	width: 60%;
	float: left;
}

.products_item_select{
	line-height: 24px;
    cursor: pointer;
    transition: 0.2s;

}

.products_item_select:hover{
	color: blue;
}


</style>