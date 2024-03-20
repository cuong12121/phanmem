	<td nowrap="nowrap">				
		<select name="ofmonth" id="ofmonth" class="type" onchange="filter_orders_affi(<?php echo $data-> id; ?>)">
			<option value="0"> -- Tháng -- </option>
			<?php for($i=1;$i<=12;$i++){ ?>
				<option value="<?php echo $i; ?>">Tháng <?php echo $i; ?></option>
			<?php } ?>			
		</select>			
	</td>
	<td nowrap="nowrap">				
		<select name="ofmonth" id="ofyear" class="type" onchange="filter_orders_affi(<?php echo $data-> id; ?>)">
			<?php for($j=date("Y");$j>=2020-1;$j--){ ?>
				<option value="<?php echo $j; ?>">Năm <?php echo $j; ?></option>
			<?php } ?>			
		</select>			
	</td>
	<input type="hidden" value="<?php echo $data-> id ?>" id="user_id">
	<div class="orders_affi_inner">
		<?php 
	//	CONFIG	

		$fitler_config  = array();

		$list_config = array();
		$list_config[] = array('title'=>'Mã đơn hàng','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=> 'view_code_order'));
		$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
		$list_config[] = array('title'=>'Thành tiền','field'=>'total_after_discount','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=> 'view_total_after_discount'));
		$list_config[] = array('title'=>'Trạng thái','field'=>'status','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=> 'view_status'));
		$list_config[] = array('title'=>'Xem chi tiết','field'=>'id','ordering'=> 1, 'type'=>'text','arr_params'=>array('function'=> 'view_views'));
// 	$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('search'=>'/original/','replace'=>'/small/'));
// 	$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=>30,'rows'=>8));
// 	$list_config[] = array('title'=>'Category','field'=>'category_id','ordering'=> 1, 'type'=>'edit_selectbox','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'treename','size'=>10));
// 	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
// 	$list_config[] = array('title'=>'Tổng views','field'=>'hits','ordering'=> 1, 'type'=>'text');
// 	// $list_config[] = array('title'=>'Xóa cache','field'=>'id','type'=>'remove','arr_params'=>array('function'=>'remove_cache'));
// 	$list_config[] = array('title'=>'Tin hot','field'=>'is_hot','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_hot'));
// 	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
// 	$list_config[] = array('title'=>'Seo đạt','field'=>'point_seo','ordering'=> 1,'type'=>'point_seo');
// 	$list_config[] = array('title'=>'Edit','type'=>'edit');
// 	// $list_config[] = array('title'=>'Comment','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_comment'));
// 	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
// //	$list_config[] = array('title'=>'Người tạo tin','field'=>'user_post','ordering'=> 1, 'type'=>'text');
// 	$list_config[] = array('title'=>'Người sửa','field'=>'action_username','ordering'=> 1, 'type'=>'action');
	// $list_config[] = array('title'=>'Lịch sử','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_history'));
		$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');

		TemplateHelper::genarate_form_liting2($this, $this->module,$this -> view,$orders_affi,$fitler_config,$list_config,@$sort_field,@$sort_direct,@$pagination);


	 // print_r($orders);die;
		?>
	</div>


	<script>
		function filter_orders_affi(user_id){
			var month = $('#ofmonth').val();
			var year = $('#ofyear').val();
			$.ajax({
				type : 'get',
				url : 'index.php?module=members&view=members&raw=1&task=load_orderaffi_monthyear',
				dataType : 'html',
				data: {month:month,year:year,user_id:user_id},
				success : function(data){
					$('.orders_affi_inner').html(data);
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {}
			});
		}
	</script>

	<script>
		function submit_price_affi(){
			var r = confirm("Xác nhận thanh toán cho thành viên!");
			if (r == true) {
				var month = $('#ofmonth').val();
				var year = $('#ofyear').val();
				var user_id =  $('#user_id').val();
				var value = $('#price_affi').val();

				$.ajax({
					type : 'get',
					url : 'index.php?module=members&view=members&raw=1&task=save_price_affi',
					dataType : 'html',
					data: {month:month,year:year,user_id:user_id,value:value},
					success : function(data){
						alert('Xác thực thành công!');
						// $('.orders_affi_inner').html(data);
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						alert('Có lỗi khi xác thực! Vui lòng thử lại!');
					}
				});
			} else {
			}
		}
	</script>

	<style> 
	#ofmonth {
		line-height: 36px;
		border-radius: 5px;
		border: 1px solid #d6d6d6;
		padding: 0 15px;
		box-sizing: border-box;
		height: 36px;
		margin-bottom: 10px;
	}
	#ofyear {
		line-height: 36px;
		border-radius: 5px;
		border: 1px solid #d6d6d6;
		padding: 0 15px;
		box-sizing: border-box;
		height: 36px;
		margin-bottom: 10px;
	}
</style>
