
			<table border="1" class="tbl_form_contents" width="100%" cellpadding="5" bordercolor="#cccccc">
				<thead>
					<tr>
						<th class="title" width="17%" rowspan="2">
							<?php echo FSText :: _('Module'); ?>
						</th>
						<th class="title" width="17%"  rowspan="2">
							<?php echo FSText :: _('Nhóm task vụ'); ?>
						</th>
						<th class="title" width="" colspan="" >
							<?php  echo FSText :: _('Chức năng'); ?>
						</th>

						<th class="title" width="" colspan="" >
							<span class="check_all_input_col check_all_input_col_3"><?php  echo FSText :: _('Chọn tất'); ?></span>
							<span class="check_all_input_col uncheck_all_input_col_3"><?php  echo FSText :: _('Bỏ tất'); ?></span>
						</th>
						
						<th class="title" width="" colspan="" >
							<span class="check_all_input_col check_all_input_col_5">
								<?php  echo FSText :: _('Chọn tất'); ?>
							</span>
							<span class="check_all_input_col uncheck_all_input_col_5">
								<?php  echo FSText :: _('Bỏ tất'); ?>
							</span>
						</th>
						<th class="title" width="" colspan="" >
							<span class="check_all_input_col check_all_input_col_6">
								<?php  echo FSText :: _('Chọn tất'); ?>
							</span>
							<span class="check_all_input_col uncheck_all_input_col_6">
								<?php  echo FSText :: _('Bỏ tất'); ?>
							</span>
						</th>
						<th class="title" width="" colspan="" >
							<span class="check_all_input_col check_all_input_col_7">
								<?php  echo FSText :: _('Chọn tất'); ?>
							</span>
							<span class="check_all_input_col uncheck_all_input_col_7">
								<?php  echo FSText :: _('Bỏ tất'); ?>
							</span>
						</th>



						<th class="title" width="" colspan="" >
							<span class="check_all_input_col check_all_input_col_3_other">
								<?php  echo FSText :: _('Chọn tất'); ?>
							</span>
							<span class="check_all_input_col uncheck_all_input_col_3_other">
								<?php  echo FSText :: _('Bỏ tất'); ?>
							</span>
						</th>
						
						<th class="title" width="" colspan="" >
							<span class="check_all_input_col check_all_input_col_5_other">
								<?php  echo FSText :: _('Chọn tất'); ?>
							</span>
							<span class="check_all_input_col uncheck_all_input_col_5_other">
								<?php  echo FSText :: _('Bỏ tất'); ?>
							</span>
						</th>
						
						<th class="title" width="" colspan="" >
							<span class="check_all_input_col check_all_input_col_6_other">
								<?php  echo FSText :: _('Chọn tất'); ?>
							</span>
							<span class="check_all_input_col uncheck_all_input_col_6_other">
								<?php  echo FSText :: _('Bỏ tất'); ?>
							</span>
						</th>
						
						<th class="title" width="" colspan="" >
							<span class="check_all_input_col check_all_input_col_7_other">
								<?php  echo FSText :: _('Chọn tất'); ?>
							</span>
							<span class="check_all_input_col uncheck_all_input_col_7_other">
								<?php  echo FSText :: _('Bỏ tất'); ?>
							</span>
						</th>
					</tr>

					<tr>
					
						<th></th>
						<th colspan="4" style="text-align: center;">Của mình</th>
						<th colspan="4" style="text-align: center;">Của người khác</th>
						
					</tr>

					<tr>
						<th></th>
						<th></th>
						<th><?php echo FSText :: _(''); ?> </th>
						<th><?php echo FSText :: _('Xem'); ?> </th>
						<th><?php echo FSText :: _('Sửa'); ?> </th>
						<th><?php echo FSText :: _('Duyệt'); ?> </th>
						<th><?php echo FSText :: _('Xóa'); ?> </th>

						<th><?php echo FSText :: _('Xem'); ?> </th>
						<th><?php echo FSText :: _('Sửa'); ?> </th>
						<th><?php echo FSText :: _('Duyệt'); ?> </th>
						<th><?php echo FSText :: _('Xóa'); ?> </th>
					</tr>
				
				</thead>
				<tbody>
					<?php foreach($arr_task as $module_name => $module):?>
						<tr class="row row_check">
							<td align="left" rowspan="<?php echo (count($module));?>">
								<strong><?php echo FSText::_(ucfirst($module_name));?></strong>
							</td>
						<?php $k = 0;?>	
						<?php foreach($module as $view_name => $view):?>
							<?php $perm = @$list_permission[$view -> id] -> permission?@$list_permission[$view -> id] -> permission : 0; ?>
							<?php 
							$name_box = "per_";
							$name_box .= $view -> id ?  ($view -> id): "0";
							$id_box = $name_box;
							$name_box .= "[]";
							?>
								
							<?php if($k){?>
							<tr class="row row_check">
							<?php }?>
								<?php 
									$arr_per = explode('.', @$perm);
								?>
								<td><?php echo $view -> description ?FSText::_($view -> description) : FSText::_(ucfirst($view_name));?>
								</td>

								<td>
									<input data_id = "<?php echo $view -> id; ?>" class="checkbox checkbox_<?php echo $view -> id; ?> checkbox_<?php echo $view -> id; ?>_3 checkbox_all_3" type="checkbox" value="3"  name="" <?php echo @$perm >= 3 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>"/>
								</td>
								
								<td>
									<input  data_id = "<?php echo $view -> id; ?>" class="checkbox checkbox_<?php echo $view -> id; ?> checkbox_<?php echo $view -> id; ?>_5 checkbox_all_5" type="checkbox" value="5"  name="" <?php echo @$perm >= 5 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>" />
								</td>

								<td>
									<input data_id = "<?php echo $view -> id; ?>" class="checkbox checkbox_<?php echo $view -> id; ?> checkbox_<?php echo $view -> id; ?>_6 checkbox_all_6" type="checkbox" value="6"  name="" <?php echo @$perm >= 6 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>" />	
								</td>

								<td>
									<input data_id = "<?php echo $view -> id; ?>" class="checkbox checkbox_<?php echo $view -> id; ?> checkbox_<?php echo $view -> id; ?>_7 checkbox_all_7" type="checkbox" value="7"  name="" <?php echo @$perm >= 7 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>" />	
								</td>
								
								
								<td>
									<?php if($view -> description =='Danh sách sản phẩm' || $view -> description =='Danh sách tin tức'){ ?>
									<input data_id = "<?php echo $view -> id; ?>" class="checkbox_other checkbox_other_<?php echo $view -> id; ?> checkbox_other_<?php echo $view -> id; ?>_3 checkbox_all_3_other" type="checkbox" value="3"  name="" <?php echo @(float)$arr_per[1] >= 3 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>"/>
									<?php } ?>
								</td>

								<td>
									<?php if($view -> description =='Danh sách sản phẩm' || $view -> description =='Danh sách tin tức'){ ?>
									<input  data_id = "<?php echo $view -> id; ?>" class="checkbox_other checkbox_other_<?php echo $view -> id; ?> checkbox_other_<?php echo $view -> id; ?>_5 checkbox_all_5_other" type="checkbox" value="5"  name="" <?php echo @(float)$arr_per[1] >= 5 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>" />
									<?php } ?>
								</td>
								
								<td>
									<?php if($view -> description =='Danh sách sản phẩm' || $view -> description =='Danh sách tin tức'){ ?>
									<input data_id = "<?php echo $view -> id; ?>" class="checkbox_other checkbox_other_<?php echo $view -> id; ?> checkbox_other_<?php echo $view -> id; ?>_6 checkbox_all_6_other" type="checkbox" value="6"  name="" <?php echo @(float)$arr_per[1] >= 6 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>" />
									<?php } ?>	
								</td>
								
								<td>
									<?php if($view -> description =='Danh sách sản phẩm' || $view -> description =='Danh sách tin tức'){ ?>
									<input data_id = "<?php echo $view -> id; ?>" class="checkbox_other checkbox_other_<?php echo $view -> id; ?> checkbox_other_<?php echo $view -> id; ?>_7 checkbox_all_7_other" type="checkbox" value="7"  name="" <?php echo @(float)$arr_per[1] >= 7 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>" />
									<?php } ?>
								</td>
								
								
								 
									
							
								<input value="<?php echo @$arr_per[0] ?>" type="hidden" id="ip_check_per_<?php echo $view -> id; ?>">
								<input value="<?php echo @$arr_per[1] ?>" type="hidden" id="ip_check_per_other_<?php echo $view -> id; ?>">
								<input value="<?php echo @(float)$perm > 0 ? $perm : 0  ?>" type="hidden" id="per_<?php echo $view -> id; ?>" name="<?php echo $name_box; ?>">
								
							</tr>
							<?php $k ++;?>
						<?php endforeach;?>
					<?php endforeach;?>
				</tbody>
			</table>
	

<script type="text/javascript">
	
	$('.check_all_input_col_3').click(function(){
		$(".checkbox_all_3").each(function( index ) {
		    if($(this).prop("checked") == false){
                $(this).trigger( "click" );
            }
		});
	});
	$('.check_all_input_col_5').click(function(){
		$(".checkbox_all_5").each(function( index ) {
		    if($(this).prop("checked") == false){
                $(this).trigger( "click" );
            }
		});
	});
	$('.check_all_input_col_6').click(function(){
		$(".checkbox_all_6").each(function( index ) {
		    if($(this).prop("checked") == false){
                $(this).trigger( "click" );
            }
		});
	});
	$('.check_all_input_col_7').click(function(){
		$(".checkbox_all_7").each(function( index ) {
		    if($(this).prop("checked") == false){
                $(this).trigger( "click" );
            }
		});
	});
	$('.check_all_input_col_3_other').click(function(){
		$(".checkbox_all_3_other").each(function( index ) {
		    if($(this).prop("checked") == false){
                $(this).trigger( "click" );
            }
		});
	});
	$('.check_all_input_col_5_other').click(function(){
		$(".checkbox_all_5_other").each(function( index ) {
		    if($(this).prop("checked") == false){
                $(this).trigger( "click" );
            }
		});
	});
	$('.check_all_input_col_6_other').click(function(){
		$(".checkbox_all_6_other").each(function( index ) {
		    if($(this).prop("checked") == false){
                $(this).trigger( "click" );
            }
		});
	});
	$('.check_all_input_col_7_other').click(function(){
		$(".checkbox_all_7_other").each(function( index ) {
		    if($(this).prop("checked") == false){
                $(this).trigger( "click" );
            }
		});
	});

	
	$('.uncheck_all_input_col_3').click(function(){
		$(".checkbox_all_3").each(function( index ) {
		    if($(this).prop("checked") == true){
                $(this).trigger( "click" );
            }
		});
	});
	$('.uncheck_all_input_col_5').click(function(){
		$(".checkbox_all_5").each(function( index ) {
		    if($(this).prop("checked") == true){
                $(this).trigger( "click" );
            }
		});
	});
	$('.uncheck_all_input_col_6').click(function(){
		$(".checkbox_all_6").each(function( index ) {
		    if($(this).prop("checked") == true){
                $(this).trigger( "click" );
            }
		});
	});
	$('.uncheck_all_input_col_7').click(function(){
		$(".checkbox_all_7").each(function( index ) {
		    if($(this).prop("checked") == true){
                $(this).trigger( "click" );
            }
		});
	});
	$('.uncheck_all_input_col_3_other').click(function(){
		$(".checkbox_all_3_other").each(function( index ) {
		    if($(this).prop("checked") == true){
                $(this).trigger( "click" );
            }
		});
	});
	$('.uncheck_all_input_col_5_other').click(function(){
		$(".checkbox_all_5_other").each(function( index ) {
		    if($(this).prop("checked") == true){
                $(this).trigger( "click" );
            }
		});
	});
	$('.uncheck_all_input_col_6_other').click(function(){
		$(".checkbox_all_6_other").each(function( index ) {
		    if($(this).prop("checked") == true){
                $(this).trigger( "click" );
            }
		});
	});
	$('.uncheck_all_input_col_7_other').click(function(){
		$(".checkbox_all_7_other").each(function( index ) {
		    if($(this).prop("checked") == true){
                $(this).trigger( "click" );
            }
		});
	});




	$('.row_check .checkbox').click(function(){
		var id = $(this).attr('data_id');

		var per_val = $(this).val();

		if($(this).prop("checked") == false){
			if($('.row_check .checkbox_other_'+id+'_'+per_val).prop("checked") == true){
				$('.row_check .checkbox_other_'+id+'_'+per_val).trigger( "click" );
			}
		}

		var number = 0;
		$('.row_check .checkbox_'+id).each(function( index ) {
		    if($(this).prop("checked") == true){

                var checkbox = $(this).val();
                if(Number(checkbox) > Number(number)){
                	number = checkbox;
                }
            }
		});

		$('#ip_check_per_'+id).val(number);
		var checkbox_other_curent = $('#ip_check_per_other_'+id).val();
		var set_per = number + '.' + checkbox_other_curent;
		$('#per_'+id).val(set_per);
	});



	$('.row_check .checkbox_other').click(function(){
		// console.log(11);
		var id = $(this).attr('data_id');
		var per_val = $(this).val();

		if($(this).prop("checked") == true){
			if($('.row_check .checkbox_'+id+'_'+per_val).prop("checked") == false){
				$('.row_check .checkbox_'+id+'_'+per_val).trigger( "click" );
			}
		}

		var number = 0;
		$('.row_check .checkbox_other_'+id).each(function( index ) {

		    if($(this).prop("checked") == true){
		    	console.log(index);
                var checkbox = $(this).val();
                if(Number(checkbox) > Number(number)){
                	number = checkbox;
                }
            }
		});

		$('#ip_check_per_other_'+id).val(number);
		var checkbox_curent = $('#ip_check_per_'+id).val();
		var set_per = checkbox_curent + '.' + number;
		$('#per_'+id).val(set_per);
	});

</script>

<style type="text/css">
	.check_all_input_col{
		cursor: pointer;
		color: blue;
	}
	.check_all_input_col:hover{
		color: red;
	}	
</style>