<?php $alias_table = str_replace('fs_products', '', $tablename); ?>
<?php $alias_table = str_replace('_', '-', $alias_table); ?>
<!--	FIELD	-->
<?php 
// echo 'fs_products_'.$tablename;
// die;
	// echo "<pre>";
	// print_r($foreign);
	// die();

 ?>




		<fieldset>
			<legend>Bộ lọc trong trường</legend>
			<div id="tabs">
		        <table cellpadding="5"  cellspacing="0" class="field_tbl" width="100%" border="1" bordercolor="#CCC">
		        	<tr>
		        		<td> Tên hiển thị</td>
		        		<td> Tên hiệu
		        			<br/><span>(duy nhất)</span></td>
		        		<td width="22%"> SEO </td>
		        		<td width="42%"> Description </td>
		        		<td> Thứ tự </td>
		        		<!-- <td> Trang chủ </td> -->
		        		<td>
		        			Published
		        			<span class="check_all">Check</span>
		        			<span class="un_check_all">UnCheck</span>
		        		</td>
		        		<td> 
		        			SEO
		        			<span class="check_all_seo">Check</span>
		        			<span class="un_check_all_seo">UnCheck</span> 
		        		</td>
		        	</tr>
		        	<?php if(count($foreign)) { ?>
						<?php 
							// printr($foreign);
						 ?>

		        		<?php foreach ($foreign as $item) {
		        			$str = $item->tablenames;
							$char = 'fs_products_'.$tablename;
							$pos = strpos($str, $char);
							if ($pos == false) {
							   continue;
							}
							// echo $item->tablenames;
		     //    			die;

		        		?>
		        			<?php $i = $item -> id; ?>
		        			<?php $field = null;?>
			        		<?php if(count($filters)) { ?>
			        			<?php 
			        		
			        			foreach ($filters as $f) {
			        				if($f -> filter_value == $item -> id){
			        					$field = $f;
			        					break;
			        				}
			        			}	
			        			?>
		        			<?php }?>
			        			<?php if($field){?>
				        			<tr id="filter_exist_<?php echo $i; ?>">
										<td>
											<input type="text" name='filter_show_<?php echo $i;?>' value="<?php echo $field->filter_show; ?>" />
										</td>
										<td>
											<input type="text" name='alias_<?php echo $i;?>' value="<?php echo $field->alias; ?>" />
										</td>
										<td>
											<span class='seo_label'>Title:&nbsp;&nbsp;&nbsp;</span><br/><input type="text" name='seo_title_<?php echo $i;?>' value="<?php echo $field->seo_title; ?>" />
											<br/>
											<br/>
											<span class='seo_label'>Meta key:</span><input type="text" name='seo_meta_key_<?php echo $i;?>' value="<?php echo $field->seo_meta_key; ?>" />
											<br/>
											<br/>
											<span class='seo_label'>Meta des:</span><br/><input type="text" name='seo_meta_des_<?php echo $i;?>' value="<?php echo $field->seo_meta_des; ?>" />
											<br/>
										</td>
										<td>
											<div class="des-off-on">
												<span class="des-off" data="<?php echo $i; ?>">Đóng</span> - <span class="des-on" data="<?php echo $i; ?>">Mở</span>
											</div>
											<div class="hide description_<?php echo $i; ?>">
												Mổ tả lọc trên
													<?php
														$oFCKeditor1 = new FCKeditor('description_'.$i) ;
														$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
														$oFCKeditor1->Value		= stripslashes(@$field->description);
														$oFCKeditor1->Width = 350;
														$oFCKeditor1->Height = 150;
														$oFCKeditor1->Create() ;
													?>
												Mổ tả lọc chi tiết
													<?php
														$oFCKeditor1 = new FCKeditor('description_cat_'.$i) ;
														$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
														$oFCKeditor1->Value		= stripslashes(@$field->description_cat);
														$oFCKeditor1->Width = 350;
														$oFCKeditor1->Height = 150;
														$oFCKeditor1->Create() ;
													?>
											</div>
										</td>

										<td>
											<input type="text" name='ordering_<?php echo $i;?>' value="<?php echo $field->ordering; ?>" size="4"/>
										</td>
										<!-- <td>
											<input type="checkbox" name='is_home_<?php// echo $i;?>' <?php //echo $field->is_home?"checked='checked'":""; ?> value="1" />
										</td> -->
										<td>
											<input class="checkbox_published" type="checkbox" name='published_<?php echo $i;?>' <?php echo $field->published?"checked='checked'":""; ?> value="1" />
										</td>
										<td>
											<input class="checkbox_seo" type="checkbox" name='is_seo_<?php echo $i;?>' <?php echo $field->is_seo?"checked='checked'":""; ?> value="1" />
										</td>
									</tr>
			        			<?php }else{?>
			        				<tr id="filter_<?php echo $i; ?>">
										<td>
											<input type="text" name='filter_show_<?php echo $i;?>' value="<?php echo $item->name; ?>" />
										</td>
										<td>
											<input type="text" name='alias_<?php echo $i;?>' value="<?php echo $item->alias; ?>" />
										</td>
										
										<td>
											<span class='seo_label'>Title:&nbsp;&nbsp;&nbsp;</span><br/><input type="text" name='seo_title_<?php echo $i;?>' value="<?php echo $item->seo_title; ?>" />
											<br/>
											<br/>
											<span class='seo_label'>Meta key:</span><br/><input type="text" name='seo_meta_key_<?php echo $i;?>' value="<?php echo $item->seo_keyword; ?>" />
											<br/>
											<br/>
											<span class='seo_label'>Meta des:</span><br/><input type="text" name='seo_meta_des_<?php echo $i;?>' value="<?php echo $item->seo_description; ?>" />
											
										</td>
										<td>
											<div class="des-off-on">
												<span class="des-off" data="<?php echo $i; ?>">Đóng</span> - <span class="des-on" data="<?php echo $i; ?>">Mở</span>
											</div>
											<div class="hide description_<?php echo $i; ?>">	
												Mổ tả lọc trên
												<?php
													$oFCKeditor1 = new FCKeditor('description_'.$i) ;
													$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
													$oFCKeditor1->Value		= stripslashes(@$field->description);
													$oFCKeditor1->Width = 350;
													$oFCKeditor1->Height = 150;
													$oFCKeditor1->Create() ;
												?>
												
												Mổ tả lọc chi tiết
												<?php
													$oFCKeditor1 = new FCKeditor('description_cat_'.$i) ;
													$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
													$oFCKeditor1->Value		= stripslashes(@$field->description_cat);
													$oFCKeditor1->Width = 350;
													$oFCKeditor1->Height = 150;
													$oFCKeditor1->Create() ;
												?>
											</div>

										</td>
										<td>
											<input type="text" name='ordering_<?php echo $i;?>' value="<?php echo $i; ?>" size="4"/>
										</td>

										<!-- <td> -->
											<!-- <input type="checkbox" name='is_home_<?php //echo $i;?>'   value="1" /> -->
										<!-- </td> -->
										<td>
											<input class="checkbox_published" type="checkbox" name='published_<?php echo $i;?>'   value="1" />
										</td>
										<td>
											<input class="checkbox_seo" type="checkbox" name='is_seo_<?php echo $i;?>'   value="1" />
										</td>
									</tr>
			        			<?php }?>
		        		<?php }?>
	        		<?php }?>
	        		
				</table>
			</div>
		</fieldset>
<style>
	.seo_label{
		display: inline-flex;
	    width: 60px;		
	}
	.des-off,.des-on,.check_all,.un_check_all,.check_all_seo,.un_check_all_seo{
		padding: 5px 10px;
	    color: #fff;
	    cursor: pointer;
	    background: #2196F3;
	    border-radius: 3px;
	    margin-bottom: 5px;
    	display: inline-block;
	}
	.des-off-on{
		margin-bottom: 15px;
	}

</style>

<script type="text/javascript">
	$('.des-off').click(function(){
		var stt = $(this).attr('data');
		$('.description_'+ stt).addClass('hide');
	});
	$('.des-on').click(function(){
		var stt = $(this).attr('data');
		$('.description_'+ stt).removeClass('hide');
	});

	$('.check_all').click(function(){
		$(".checkbox_published").each(function( index ) {
		    if($(this).prop("checked") == false){
                $(this).trigger( "click" );
            }
		});
	});

	$('.un_check_all').click(function(){
		$(".checkbox_published").each(function( index ) {
		    if($(this).prop("checked") == true){
                $(this).trigger( "click" );
            }
		});
	});


	$('.check_all_seo').click(function(){
		$(".checkbox_seo").each(function( index ) {
		    if($(this).prop("checked") == false){
                $(this).trigger( "click" );
            }
		});
	});

	$('.un_check_all_seo').click(function(){
		$(".checkbox_seo").each(function( index ) {
		    if($(this).prop("checked") == true){
                $(this).trigger( "click" );
            }
		});
	});

</script>