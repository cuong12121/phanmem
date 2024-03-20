<?php $max_ordering = 1; ?>
	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="">
		<thead>
			<tr>
				<th align="center" >
					Tên
				</th>
	
				<th align="center" >
					Số lượng
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

		
			
					<td width="70px"> 
						<input id="change_count_<?php echo $item -> id; ?>" onkeyup="javascript: change_item(<?php echo $item -> id; ?>,<?php echo $item -> order_id; ?>)" class="change_count_item" data_order_id="<?php echo $item -> order_id; ?>" data_id="<?php echo $item -> id; ?>" data_price="<?php echo $item -> price; ?>" value="<?php echo $item -> count; ?>" type="text" size="4" name="change_count_<?php echo $i?>">
					</td>
			
				
					<td width="50px">
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
				<td width="250px">
					<input autocomplete="off" type="text" size="30" data_i = "<?php echo $i ?>" id="product_<?php echo $i;?>" class="product_id" name="product_<?php echo $i;?>">
				</td>
			
				<td  width="70px">
					<input class="new_count" type="text" size="4" id="count_<?php echo $i;?>" name="count_<?php echo $i;?>" onkeyup="javascript: change_item_new(<?php echo $i; ?>)">
				</td>
				
				<td width="50px">
					<a href="javascript:void(0)" data_i = "<?php echo $i ?>" onclick="remove_input_new(this)">Xóa</a>
				</td>
			</tr>
	<?php } ?>
	</tbody>		
	</table>

	<!-- <div class='add_record'> -->
		<!-- <a href="javascript:add_price()"><strong class='red'>Thêm</strong></a> -->
	<!-- </div> -->
	<input type="hidden" value="<?php echo isset($prices)?count($prices):0; ?>" name="price_exist_total" id="price_exist_total" />
	<input type="hidden" value="" name="price_ids_remove" id="price_ids_remove" />

	
	<div id="popup-products" class="">
		<div class="products_related cls">
			<div class='products_related_search cls'>
				<div class="form-group">
					<input placeholder="Nhập tên sản phẩm hoặc mã" type="text" name='products_related_keyword' value='' id='products_related_keyword' />
				</div>
			
				<?php 
				//TemplateHelper::dt_edit_selectbox(FSText::_('Chọn danh mục'),'products_related_category_id',@$cid,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0,1);
				?>
				<input type="button" name='products_related_search' value='Tìm kiếm' id='products_related_search' />
			</div>
			<div style="clear:bold"></div>
			<div id="products_related_search_list">
		</div>

		
				
		</div>
	</div>





	<div style="clear: both;"></div>

	
<script type="text/javascript" >

	$("select#categories_filter").change(function(){
		$("select#products_related_category_id").val('');
		
		var cat_ft_id = $(this).val();
		var cat_ft_str = ","+cat_ft_id+",";
		$( ".cate_option" ).removeClass('hidden');
		$( ".cate_option" ).each(function(index) {
		   var parent = $(this).attr('data_parents') ;
		   var has_string = parent.indexOf(cat_ft_str);
		  	if(has_string == -1){
		  		$(this).addClass('hidden');
		  	}
		});

		if(!cat_ft_id || cat_ft_id == 0){
			$(".cate_option").removeClass('hidden');
		}

		$('#products_related_category_id').css('border','red 1px solid');
		// $('#products_related_category_id option:first').val();
	});		


	function remove_input_new(el){
		var data_id = $(el).attr('data_i');
		$('#new_record_'+data_id).addClass('closed').removeClass('opened');
		$('#new_record_'+data_id + ' input').val('');

	}

	function change_item(id,order_id){
		var price = $('#change_price_'+id).val();
		var count = $('#change_count_'+id).val();
		var unit = $('#change_unit_'+id).val();
		var note = $('#change_note_'+id).val();

		// alert(id);
		
		$.ajax({url: "/admin/index.php?module=built&view=built&task=ajax_change_count_item&raw=1",
			data: {id: id,price:price,count:count,order_id:order_id,unit:unit,note:note},
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
	}

	function change_item_new(id){
		var price = $('#price_'+id).val();
		var count = $('#count_'+id).val();
		if(price && count){
			var total  = Number(price) * Number(count);
			$('#total_'+id).val(total);
		}
	}


	function add_price(){
	
		$('.active_input').removeClass('active_input');

		for(var i = 0; i < 20; i ++){
			tr_current = $('#new_record_'+i);
			if(tr_current.hasClass('closed')){
				tr_current.addClass('active_input');
				tr_current.addClass('opened').removeClass('closed');
				return;
			}
		}
	}

	function remove_order_item(id)
	{
		if(confirm("Bạn muốn xóa?"))
		{
			$.get("/admin/index2.php?module=built&view=built&task=ajax_remove_order_item&raw=1",{id:id}, function(html){
				$('#change_record_'+id).html("");
			});
		}
		return false;
	}


	

	////////////show products

	search_products_related()

	function search_products_related(){
		
		// $('.product_id').click(function(){
		// 	$('.product_id').removeClass('active_input')
		// 	$(this).addClass('active_input');
		// 	$('#popup-products').removeClass('hidden');
		// });
		 

		$('.new_record').click(function(){
			$('.new_record').removeClass('active_input');
			$(this).addClass('active_input');
		});


		$('#products_related_search').click(function(){
			
			var categories_filter = $('#categories_filter').val();
			var keyword = $('#products_related_keyword').val();
			var category_id = $('#products_related_category_id').val();
			var product_id = <?php echo @$data -> id?$data -> id:0?>;
			var str_exist = '';
			$( "#products_sortable_related li input" ).each(function( index ) {
				if(str_exist != '')
					str_exist += ',';
				str_exist += 	$( this ).val();
			});
			$.get("/admin/index2.php?module=built&view=built&task=ajax_get_products_related&raw=1",{product_id:product_id,category_id:category_id,keyword:keyword,str_exist:str_exist,categories_filter:categories_filter}, function(html){
				$('#products_related_search_list').html(html);
			});
		});
	}

	function set_products_to_input(el){
		add_price();
		var pro_id = $(el).attr('data-id');
		var price = $(el).attr('data-price');
		var name = $(el).attr('data-name');
		var data_i = $('.active_input .product_id').attr('data_i');
		$('#product_'+data_i).val(name);
		// $('#price_'+data_i).val(price);
		$('#pro_id_'+data_i).val(pro_id);

		$(el).hide();
		$('.active_input .new_count').focus();
		

	}


</script>

<style>

.add_record strong{
	background: #003150;
    padding: 10px 30px;
    margin-top: 10px;
    margin-bottom: 20px;
    display: inline-block;
    color: #fff;
    text-transform: uppercase;

}
.closed{
	display:none;
}

.active_input{
	border: 1px solid red;
}
/*#popup-products{
	width: 60%;
	float: left;
}*/

.products_related{
	display: flex;
    flex-wrap: wrap;
}

.products_item_select{
	line-height: 24px;
    cursor: pointer;
    transition: 0.2s;
    border: 1px solid #e4e4e4;
    padding: 5px;
    margin: 5px;
    width: calc(50% - 10px);
    min-width: 300px;
}

/*.products_item_select:nth-child(odd){
	float: left;
}

.products_item_select:nth-child(even){
	float: right;
}*/

.products_item_select:hover{
	color: blue;
	border: 1px solid blue;
}

.cls::after{
	content: '';
  display: block;
  clear: both;
}

.products_related_search{
	margin: 20px 0px;
	display: block;
    width: calc(100% - 100px);
}

#products_related_keyword{
	font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    height: 34px;
    padding: 5px;
    box-sizing: border-box;
    width: 100%;
}

.products_related_search .form-group { 
	width: calc(100% / 3 - 44px);
    margin: 0px 10px;
    float: left;
}

.products_related_search .form-group select { 
	width: 100%;
}

.products_related_search .col-md-10{ 
	width: 100%;
    padding: 0px;
}

.products_related_search .col-md-2{ 
	display: none;
}

.products_related_search .control-label{ 
    padding: 0px;
}


#products_related_search{
	width: 70px;
    float: left;
    height: 34px;
    border-radius: 4px;
    border: none;
    background: #003150;
    color: #fff;
    cursor: pointer;
}


</style>