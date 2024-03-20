<div class="products_compatable">
	Nhập số kg. VD: 10 - Nếu là số lẻ thì nhập 10.5
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='products_compatable_l' style="display:none" >
				<div class='products_compatable_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='products_compatable_keyword' value='' id='products_compatable_keyword' />
					<select style="display: none" name="products_compatable_category_id"  id="products_compatable_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($categories as $item) {
							?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='products_compatable_search' value='Tìm kiếm' id='products_compatable_search' />
				</div>
				<div id='products_compatable_search_list'>
				</div>
			</td>
			<td width="100%" id='products_compatable_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Hãng sản xuất</div>
				<ul id='products_sortable_compatable'>	
					<?php
					$i = 0; 
					if(!empty($products_categories_kilogam))
						foreach ($products_categories_kilogam as $item) { 
							?>
							<li class="products_record_compatable" id='products_record_compatable_<?php echo $item ->manufactory_id?>'>
								<span class="name_products"><?php echo $item -> manufactory_name; ?> </span>
								
								<span class="item_price_old">Cân nặng: <input type="text" name="price_value_<?php echo $item ->manufactory_id?>" value="<?php echo ($item -> kilogam); ?>"/></span>
							
								<a class='products_remove_relate_bt'  onclick="javascript: remove_products_compatable(<?php echo $item->manufactory_id;?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> 
								<input type="hidden" name='products_record_compatable[]' value="<?php echo $item -> manufactory_id;?>" /></li>
							<?php }?>
						</ul>
						<!--	end LIST RELATE			-->
						<div id='products_record_compatable_continue'></div>
					</td>
				</tr>
			</table>
			<div class='products_close_compatable' style="display:none">
				<a href="javascript:products_close_compatable()"><strong class='red'>Đóng</strong></a>
			</div>
			<div class='products_add_compatable'>
				<a href="javascript:products_add_compatable()"><strong class='red'>Thêm</strong></a>
			</div>
		</div>
		<script type="text/javascript" >
			search_products_compatable();
			$( "#products_sortable_compatable" ).sortable();
			function products_add_compatable(){
				$('#products_compatable_l').show();
				$('#products_compatable_l').attr('width','50%');
				$('#products_compatable_r').attr('width','50%');		
				$('.products_close_compatable').show();
				$('.products_add_compatable').hide();
			}
			function products_close_compatable(){
				$('#products_compatable_l').hide();
				$('#products_compatable_l').attr('width','0%');
				$('#products_compatable_r').attr('width','100%');		
				$('.products_add_compatable').show();
				$('.products_close_compatable').hide();
			}
			function search_products_compatable(){
				
				var keyword = $('#products_compatable_keyword').val();
				var category_id = $('#products_compatable_category_id').val();
				var tablename = "<?php echo @$data -> tablename ?>";
				var str_exist = '';
				$( "#products_sortable_compatable li input" ).each(function( index ) {
					if(str_exist != '')
						str_exist += ',';
					str_exist += 	$( this ).val();
				});
				$.get("index2.php?module=products&view=categories&task=ajax_get_products_compatable&raw=1",{tablename:tablename,category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
					$('#products_compatable_search_list').html(html);
				});
				
			}
			function set_products_compatable(id){
				var max_compatable = 100;
				var length_children = $( "#products_sortable_compatable li" ).length;
				if(length_children >= max_compatable ){
					alert('Tối đa chỉ có '+max_compatable+' sản phẩm liên quan'	);
					return;
				}

				var title = $('.products_compatable_item_'+id).html();
				var price = $('#price_compatable_'+id).html();

				var html2 = '<li id="products_record_compatable_'+id+'">'+title+'<input type="hidden" name="products_record_compatable[]" value="'+id+'" />';
				
				html2 += '<span class="item_price"> - Cân nặng: <input type="text" name="price_value_'+id+'" value="" /></span>';
	
				html2 += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_compatable('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
				html2 += '</li>';
				$('#products_sortable_compatable').append(html2);
				$('.products_compatable_item_'+id).hide();	

			}
			function remove_products_compatable(id){
				$('#products_record_compatable_'+id).remove();
				$('.products_compatable_item_'+id).show().addClass('red');	
			}
		</script>
		<style>
		.products_record_compatable .item_price_old input{
			width: 90px;
		}
		.products_compatable_search, #products_compatable_r .title{
			background: none repeat scroll 0 0 #F0F1F5;
			font-weight: bold;
			margin-bottom: 4px;
			padding: 2px 0 4px;
			text-align: center;
		}
		#products_compatable_search_list{
			height: 400px;
			overflow: scroll;
		}
		.products_compatable_item{
			background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
			border-bottom: 1px solid #EEEEEE;
			cursor: pointer;
			margin: 2px 10px;
			padding: 5px;
		}
		#products_sortable_compatable li{
			cursor: move;
			list-style: decimal outside none;
			margin-bottom: 8px;
		}
		.products_remove_relate_bt{
			padding-left: 10px;
		}
		.products_compatable table{
			margin-bottom: 5px;
		}

		.name_products {
			width: 43%;
			float:left;
			display: inline-block;
			margin-right: 10px;
		}
		.products_record_compatable {
			clear: both;
		}
		.red {
		    color: red;
		}
	</style>