<div class="seo_manu">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='seo_manu_l' style="display:none" >
				<div class='seo_manu_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='seo_manu_keyword' value='' id='seo_manu_keyword' />
					<select style="display: none" name="seo_manu_category_id"  id="seo_manu_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($categories as $item) {
							?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='seo_manu_search' value='Tìm kiếm' id='seo_manu_search' />
				</div>
				<div id='seo_manu_search_list'>
				</div>
			</td>
			<td width="100%" id='seo_manu_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Hãng sản xuất</div>
				<ul id='seo_manu_sortable'>	
					<?php
					$i = 0; 
					if(!empty($seo_manu))
						foreach ($seo_manu as $item) { 
							?>
							<li class="record_seo_manu" id='record_seo_manu_<?php echo $item ->manufactory_id?>'>
								<span class="name_products"><?php echo $item -> manufactory_name; ?> </span>
								
								
							
								<a class='products_remove_relate_bt'  onclick="javascript: remove_seo_manu(<?php echo $item->manufactory_id;?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>


								<div class="item_price"><p>Seo title:</p> <input type="text" name="seo_title_<?php echo $item ->manufactory_id?>" value="<?php echo ($item -> seo_title); ?>"/></div>
								<div class="item_price"><p>Seo keyword:</p> <input type="text" name="seo_keyword_<?php echo $item ->manufactory_id?>" value="<?php echo ($item -> seo_keyword); ?>"/></div>
								<div class="item_price"><p>Seo description:</p> 
								
									<textarea name="seo_description_<?php echo $item ->manufactory_id?>"><?php echo ($item -> seo_description); ?></textarea>
								</div>


								<input type="hidden" name='products_record_seo_manu[]' value="<?php echo $item -> manufactory_id;?>" /></li>







							<?php }?>
						</ul>
						<!--	end LIST RELATE			-->
						<div id='seo_manu_continue'></div>
					</td>
				</tr>
			</table>
			<div class='seo_manu_close' style="display:none">
				<a href="javascript:seo_manu_close()"><strong class='red'>Đóng</strong></a>
			</div>
			<div class='seo_manu_add'>
				<a href="javascript:seo_manu_add()"><strong class='red'>Thêm</strong></a>
			</div>
		</div>
		<script type="text/javascript" >
			search_seo_manu();
			$( "#seo_manu_sortable" ).sortable();
			function seo_manu_add(){
				$('#seo_manu_l').show();
				$('#seo_manu_l').attr('width','50%');
				$('#seo_manu_r').attr('width','50%');		
				$('.seo_manu_close').show();
				$('.seo_manu_add').hide();
			}
			function seo_manu_close(){
				$('#seo_manu_l').hide();
				$('#seo_manu_l').attr('width','0%');
				$('#seo_manu_r').attr('width','100%');		
				$('.seo_manu_add').show();
				$('.seo_manu_close').hide();
			}
			function search_seo_manu(){
				
				var keyword = $('#seo_manu_keyword').val();
				var category_id = $('#seo_manu_category_id').val();
				var tablename = "<?php echo @$data -> tablename ?>";
				var str_exist = '';
				$( "#seo_manu_sortable li input" ).each(function( index ) {
					if(str_exist != '')
						str_exist += ',';
					str_exist += 	$( this ).val();
				});
				$.get("index2.php?module=products&view=categories&task=ajax_get_seo_manu&raw=1",{tablename:tablename,category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
					$('#seo_manu_search_list').html(html);
				});
				
			}
			function set_seo_manu(id){
				var max_compatable = 100;
				var length_children = $( "#seo_manu_sortable li" ).length;
				if(length_children >= max_compatable ){
					alert('Tối đa chỉ có '+max_compatable+' hãng'	);
					return;
				}

				var title = $('.seo_manu_item_'+id).html();
				var price = $('#price_seo_manu_'+id).html();

				var html2 = '<li class="record_seo_manu" id="record_seo_manu_'+id+'">'+title+'<input type="hidden" name="products_record_seo_manu[]" value="'+id+'" />';
				
				html2 += '<a class="products_remove_relate_bt"  onclick="javascript: remove_seo_manu('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';

				html2 += '<div class="item_price"><p>Seo title:</p> <input type="text" name="seo_title_'+id+'" value="" /></div>';
				html2 += '<div class="item_price"><p>Seo keyword:</p> <input type="text" name="seo_keyword_'+id+'" value="" /></div>';
				html2 += '<div class="item_price"><p>Seo description:</p> <textarea name="seo_description_'+id+'" ></textarea></div>';

				html2 += '</li>';
				$('#seo_manu_sortable').append(html2);
				$('.seo_manu_item_'+id).hide();	

			}
			function remove_seo_manu(id){
				$('#record_seo_manu_'+id).remove();
				$('.seo_manu_item_'+id).show().addClass('red');	
			}
		</script>
		<style>
		.products_record_compatable .item_price_old input{
			width: 90px;
		}
		.seo_manu_search, #seo_manu_r .title{
			background: none repeat scroll 0 0 #F0F1F5;
			font-weight: bold;
			margin-bottom: 4px;
			padding: 2px 0 4px;
			text-align: center;
		}
		#seo_manu_search_list{
			height: 400px;
			overflow: scroll;
		}
		.seo_manu_item{
			background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
			border-bottom: 1px solid #EEEEEE;
			cursor: pointer;
			margin: 2px 10px;
			padding: 5px;
		}
		#seo_manu_sortable li{
			cursor: move;
			list-style: decimal outside none;
			margin-bottom: 8px;
		}
		.products_remove_relate_bt{
			padding-left: 10px;
		}
		.seo_manu table{
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
		.record_seo_manu .item_price{
			margin-top: 10px;
		}
		.record_seo_manu .item_price p{
			margin-bottom: 0px;
		}
		.record_seo_manu .item_price input,.record_seo_manu .item_price textarea{
			width: 450px;
		    max-width: 100%;
		    padding: 5px;
		    border: 1px solid #cccc;
		}
	</style>