<table cellspacing="1" class="admintable">
	<?php if(!empty($data) AND $data->published == 1 ){
		$link = FSRoute::_('index.php?module=products&view=product&code='.$data -> alias.'&ccode='.$data->category_alias.'&id='.$data->id.'&cid='.$data->category_id);
	?>	
		<div>Link xem sản phẩm: <a target="_blank" style="color: blue" href="<?php echo $link; ?>"><?php echo $data->name ?></a></div>
		<br /> 
	<?php } ?>

	<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name,'',60,1,0,FSText::_("Không được để trống"));

	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	// TemplateHelper::dt_edit_text(FSText :: _('Tên gốc'),'name_core',@$data -> name_core);
	// TemplateHelper::dt_edit_text(FSText :: _('Tên hiển thị'),'name_display',@$data -> name_display);
	// TemplateHelper::dt_edit_text(FSText :: _('Tên hiển thị SP đặc biệt'),'name_special',@$data -> name_special);
	// TemplateHelper::dt_edit_text(FSText :: _('Tình trạng ở SP đặc biệt'),'status_special',@$data -> status_special);
	TemplateHelper::dt_edit_text(FSText :: _('Mã combo'),'code',@$data -> code,'',60,1,0,FSText::_("Không được để trống"));
	//TemplateHelper::dt_edit_text(FSText :: _('Part number'),'partnumber',@$data -> partnumber);
	//if(@$data -> code)
//		TemplateHelper::dt_text(FSText :: _('Mã'),@$data -> code,'');
	?>
	<div class="form-group">
        <label class="col-md-2 col-xs-12 control-label">Chú ý:</label>
        <div class="col-md-10 col-xs-12 red">
            Nếu nhập % Giảm giá thì Giá bán không cần nhập.
        </div>
    </div>
	<?php
	TemplateHelper::dt_edit_text(FSText :: _('Giá cũ'),'price_old',@$data -> price_old,'',20,1,0);
	// TemplateHelper::dt_edit_selectbox('Loại giảm giá','discount_unit',@$data -> discount_unit,0,array('percent'=>'Phần trăm','price'=>'Giá trị'),$field_value = '', $field_label='');
	TemplateHelper::dt_edit_text(FSText :: _('% Giảm giá'),'discount',@$data -> discount,'',20,1,0,FSText::_(""));
	TemplateHelper::dt_edit_text(FSText :: _('Giá bán'),'price',@$data -> price,'',20,1,0);
	TemplateHelper::dt_edit_text(FSText :: _('Bảo hành'),'warranty',@$data -> warranty,'',20,1,0);
	// TemplateHelper::dt_edit_text(FSText :: _('Số lượng'),'quantity',@$data -> quantity,10,20,1,0);
	// TemplateHelper::dt_edit_text(FSText :: _('Số lượng đã bán'),'sale',@$data -> sale,0,20,1,0);
	// TemplateHelper::dt_edit_text(FSText :: _('Bảo hành'),'gift',@$data -> gift,'',650,450,1);

	// TemplateHelper::dt_edit_text(FSText :: _('Quà tặng đặc biệt'),'gift_accessories',@$data -> gift_accessories,'',650,450,1);
	TemplateHelper::dt_edit_selectbox('Tình trạng','status',@$data -> status,1,$style_status,'id', 'name',$size = 1,0);
	TemplateHelper::dt_edit_selectbox('Hỗ trợ online','support_id',@$data -> support_id,1,$support,'id', 'name',$size = 1,0,1);
	

	
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),100,100,'Kích cỡ ảnh: 800x800 px');

	// TemplateHelper::dt_edit_image(FSText :: _('Image Hot'),'image_hot',str_replace('/original/','/resized/',URL_ROOT.@$data->image_hot));
//	$sub_time_start = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour_start',@$data -> date_start?date('H:i',strtotime(@$data -> date_start)):'','','5',1);
//	TemplateHelper::dt_edit_text(FSText :: _('Ngày bắt đầu'),'date_start',@$data -> date_start?date('d-m-Y',strtotime(@$data -> date_start)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY HH:mm</strong>.',$sub_time_start);
//	$sub_time_end = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour_end',@$data -> date_end?date('H:i',strtotime(@$data -> date_end)):'','','5',1);
//	TemplateHelper::dt_edit_text(FSText :: _('Ngày hết hạn'),'date_end',@$data -> date_end?date('d-m-Y',strtotime(@$data -> date_end)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY HH:mm</strong>.',$sub_time_end);
	// TemplateHelper::dt_checkbox(FSText::_('Sp mới'),'is_new',@$data -> is_new,0);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,$array_value = array(1 => 'Có', 0 => 'Không' ),$sub_item = '',$comment ='',$class_col1='col-md-2',$class_col2='col-md-10',$creator_id=@$data -> creator_id);
	TemplateHelper::dt_checkbox(FSText::_('Sản phẩm hot'),'is_hot',@$data -> is_hot,0);
	TemplateHelper::dt_checkbox(FSText::_('Sản phẩm bán chạy'),'is_sell',@$data -> is_sell,0);
	TemplateHelper::dt_checkbox(FSText::_('Hiện trang chủ'),'show_in_home',@$data -> show_in_home,0);
	
	TemplateHelper::dt_checkbox(FSText::_('Nofollow'),'nofollow',@$data -> nofollow,0,'',null,'Khi chọn CÓ thì google sẽ không index');
	// TemplateHelper::dt_checkbox(FSText::_('Sp đặc biệt'),'is_special',@$data -> is_special,0);
	// $style_status = array('1'=>'Còn hàng','0'=>'Hết hàng');
	// TemplateHelper::dt_sepa();
	// TemplateHelper::dt_checkbox(FSText::_('Hotdeal'),'is_hotdeal',@$data -> is_hotdeal,0);
	// TemplateHelper::dt_checkbox(FSText::_('Hotdeal show home?'),'is_hotdeal_show_home',@$data -> is_hotdeal_show_home,0);
	if(@$data -> is_hotdeal){
		$hotdeal_area = 'hotdeal_area_open';
	}else{
		$hotdeal_area = 'hotdeal_area_close';
	}
	?>
	<!--	<tr class='<?php echo $hotdeal_area?>'>-->
		<!--		<td class='label key' valign="top"><?php echo FSText::_("Giá hotdeal")?></td>-->
		<!--		<td class='value1'>-->
			<!--			<input id="h_price" type="text" size="20" value="<?php echo format_money(@$data -> h_price,'') ;?>" name="h_price">-->
			<!--		</td>-->
			<!--	</tr>-->
<!-- 
			<tr class='<?php echo $hotdeal_area?>'>
				<td class='label key' style="color: #000;" valign="top"><?php echo FSText::_("Ngày bắt đầu")?></td>
				<td class='value1'>
					<input type="text" name="date_start" id="date_start" value="<?php echo @$data -> date_start?date('d-m-Y',strtotime(@$data -> date_start)):''; ?>"/>
					<span>   </span>
					<input id="published_hour_start" type="text" size="5" value="<?php echo @$data -> date_start?date('H:i',strtotime(@$data -> date_start)):'';?>" name="published_hour_start">
				</td>
			</tr>
			<tr class='<?php echo $hotdeal_area?>'>
				<td class='label key' style="color: #000;" valign="top"><?php echo FSText::_("Ngày hết hạn")?></td>
				<td class='value1'>
					<input type="text" name="date_end" id="date_end" value="<?php echo @$data -> date_end?date('d-m-Y',strtotime(@$data -> date_end)):'';?>"/>
					<span>   </span>
					<input id="published_hour_end" type="text" size="5" value="<?php echo @$data -> date_end?date('H:i',strtotime(@$data -> date_end)):'' ?>" name="published_hour_end">
				</td>
			</tr>
			<tr class='<?php // echo $hotdeal_area?>'>
				<td class='label key' valign="top"><?php echo FSText::_("Thông tin khuyến mại")?></td>
				<td class='value1'>
					<textarea id="promotion_info" name="promotion_info" cols="60" rows="3"><?php echo @$data -> promotion_info;?></textarea>
				</td>
			</tr>
			<tr class='<?php echo $hotdeal_area?>'>
				<td class='label key' valign="top"><?php echo FSText::_("Số lượng")?></td>
				<td class='value1'>
					<input id="h_quantity" type="text" size="20" value="<?php echo @$data -> h_quantity;?>" name="h_quantity">
				</td>
			</tr> -->
			<?php
			TemplateHelper::dt_sepa();
			// TemplateHelper::dt_edit_selectbox(FSText::_('Nguồn gốc'),'origin',@$data -> origin,0,$origins,$field_value = 'id', $field_label='name',$size = 1,0);
//	TemplateHelper::dt_edit_text(FSText :: _('Thông tin khuyến mại'),'promotion_info',@$data -> promotion_info,'',60,3,0);
	//TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
			if($use_manufactory){
				TemplateHelper::dt_edit_selectbox(FSText::_('Thương hiệu'),'manufactory',@$data -> manufactory,0,$manufactories ,$field_value = 'id', $field_label='name',$size = 1,0);
				if($use_model)
					TemplateHelper::dt_edit_selectbox(FSText::_('Dòng sp'),'model',@$data -> model,0,$product_models,$field_value = 'id', $field_label='name',$size = 10,0);
			}

			// $category_id = isset($data -> category_id_wrapper)?$data -> category_id_wrapper:$cid;
			// TemplateHelper::dt_edit_selectbox2(FSText::_('Categories'),'category_id',$category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,1,1);

			?>
			<div class="form-group">
				<label class="col-md-2 col-xs-12 control-label">Lọc danh mục</label>
				<div class="col-md-10 col-xs-12">
					<select data-placeholder="Lọc danh mục" class="form-control " name="" id="categories_filter">
						<option value="0" selected="selected">--Lọc danh mục--</option>
						<?php foreach ($categories_filter as $vl): ?>
							<option value="<?php echo $vl->id ?>"><?php echo $vl->name ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<?php

			if(@$data -> category_id)
			{
				$category_id = isset($data -> category_id)?$data -> category_id:$cid;
				TemplateHelper::dt_edit_selectbox_parent(FSText::_('Categories'),'category_id',$category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
			}else{
				TemplateHelper::dt_edit_selectbox_parent(FSText::_('Categories'),'category_id',$cid,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
			}

			?>
				<div class="form-group">
			        <label class="col-md-2 col-xs-12 control-label">Chú ý:</label>
			        <div class="col-md-10 col-xs-12 red">
			            Danh mục phụ chỉ nhận có bảng mở rộng liên quan đến danh mục chính.(Hệ thống sẽ tự nhận thêm các danh mục cha và danh mục chính).
			        </div>
			    </div>
			    <div class="form-group">
			        <label class="col-md-2 col-xs-12 control-label">Danh mục phục đang chọn:</label>
			        <div class="col-md-10 col-xs-12 " id ="category_id_wrapper_select">
			        	<?php echo @$category_id_wrapper_select_name; ?>
			        </div>
			    </div>
			<?php

			$category_id_wrapper = isset($data -> category_id_wrapper)?$data -> category_id_wrapper:0;
			TemplateHelper::dt_edit_selectbox_parent(FSText::_('Danh mục phụ'),'category_id_wrapper',$category_id_wrapper,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,1,1,'Giữ phím ctrl để chọn nhiều danh mục');

			TemplateHelper::dt_edit_selectbox('Loại','type',@$data -> type,0,$types,'id', 'name');
			// $style_types = array('doi-1'=>'1 đổi 1 trong 13 tháng','gia-soc'=>'Giá sốc','tra-gop'=>'Trả góp 0%','bao-hanh-24'=>'Bảo hành 24 tháng','doi-1-24'=>'1 đổi 1 24 tháng','hot-sale'=>'Hot sale','bh-ca-roi-vo'=>'BH cả rơi vỡ');
			// TemplateHelper::dt_edit_selectbox('H/a nổi bật','style_types',@$data -> style_types,0,$style_types,'id', 'name',$size = 1,1,1);
	// TemplateHelper::dt_edit_text(FSText :: _('Khuyến mãi đặc biệt'),'gift_accessories',@$data -> gift_accessories,'',20,1,0);

//	TemplateHelper::dt_edit_image(FSText :: _('Ảnh video'),'image_video',str_replace('/original/','/resized/',URL_ROOT.@$data->image_video));
		//	TemplateHelper::dt_edit_text(FSText :: _('Video (link youtube)'),'video',@$data -> video,'',60,1,0,'1');
			//TemplateHelper::dt_edit_text(FSText :: _('Video (link youtube)'),'video_second',@$data -> video_second,'',60,1,0,'2');
		//	TemplateHelper::dt_edit_text(FSText :: _('Video (iframe)'),'video_3',@$data -> video_second,'',60,1,0,'3');
//	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),'','','400X460');
//	TemplateHelper::dt_edit_image(FSText :: _('Ảnh thông số kỹ thuật'),'image_spec',str_replace('/original/','/resized/',URL_ROOT.@$data->image_spec));
	// TemplateHelper::dt_edit_image(FSText :: _('Image x2'),'image_double',str_replace('/original/','/resized/',URL_ROOT.@$data->image_double),'','','Kích thước chuẩn 476x250');
			// TemplateHelper::dt_checkbox(FSText::_('Published double'),'published_double',@$data -> published_double,0);
			
//	TemplateHelper::dt_checkbox(FSText::_('Sản phẩm mới'),'is_new',@$data -> is_new,1);
// TemplateHelper::dt_checkbox(FSText::_('Sản phẩm cũ'),'is_old',@$data -> is_old,0);
			TemplateHelper::dt_edit_text(FSText :: _('Thứ tự danh mục cấp 1'),'ordering2',@$data -> ordering2,@$maxOrdering2,'20');
			
			TemplateHelper::dt_edit_text(FSText :: _('Thứ tự danh mục con'),'ordering',@$data -> ordering,@$maxOrdering,'20');
			
			TemplateHelper::dt_edit_text(FSText :: _('Quà tặng'),'gift',@$data -> gift,'',60,3,0);
			TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',650,450,1);
			
			// TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',650,450,1);
			TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'description',@$data -> description,'',650,450,1);
//	TemplateHelper::dt_edit_text(FSText :: _('Phụ kiện đi kèm'),'accessories',@$data -> accessories,'',60,3,0);

			?>
	 <!--<tr>
		<td valign="top" class="key">
			<?php  echo FSText :: _('File 360 độ'); ?>
		</td>
		<td>
			<?php if(@$data -> link_360){?>
			<embed height="150" width="100" wmode="opaque" quality="high" name="<?php  echo @$data->name;?>"  src="<?php echo URL_ROOT.'images/products/360/'.$data->link_360; ?>" type="application/x-shockwave-flash">
			<br/>
			<?php } ?>
			<input type="file" name='link_360' value="<?php echo (isset($data->link_360)) ? @$data->link_360 : ''; ?>"/>
		</td>
	</tr>
	--><?php 
	TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,2);
	TemplateHelper::dt_sepa();
	TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9);

	?>
	
	<input id="data_id" type="hidden" value="<?php echo isset($data) ? $data->id : 0  ?>">
	<input id="cid" type="hidden" value="<?php echo isset($data) ? $data -> category_id : $cid  ?>">
</table>
<script>    CKEDITOR.replace( 'promotion_info' );</script>


<script  type="text/javascript" language="javascript">
	$(function(){
		$("#fragment-1 #name").keyup(function(){
			var name = $(this).val();
			var data_id = $('#data_id').val();
			// alert()
			// console.log(name);
			$.ajax({url: "index.php?module=products&view=products&task=ajax_check_name&raw=1",
				data: {name: name,data_id: data_id},
				dataType: "text",
				success: function(data) {
					// console.log(data);
					if(data == 1){
						$("#fragment-1 #name").css('border','red 1px solid');
						$("#fragment-1 #help-block-name").html('Tên này đã tồn tại !');
						$("#fragment-1 #help-block-name").css('color','red');
					}else{
						$("#fragment-1 #name").css('border','#ccc 1px solid');
						$("#fragment-1 #help-block-name").html('Tên này được chấp nhận');
						$("#fragment-1 #help-block-name").css('color','#a0a0a0');
					}
				}
			});
		});			
		
	});
</script>

<script  type="text/javascript" language="javascript">
	$(function(){
		$("#fragment-1 #code").keyup(function(){
			var code = $(this).val();
			var data_id = $('#data_id').val()
			$.ajax({url: "index.php?module=products&view=products&task=ajax_check_code&raw=1",
				data: {code: code,data_id: data_id},
				dataType: "text",
				success: function(data) {
					// console.log(data);
					if(data == 1){
						$("#fragment-1 #code").css('border','red 1px solid');
						$("#fragment-1 #help-block-code").html('Mã này đã tồn tại !');
						$("#fragment-1 #help-block-code").css('color','red');
					}else{
						$("#fragment-1 #code").css('border','#ccc 1px solid');
						$("#fragment-1 #help-block-code").html('Mã này được chấp nhận');
						$("#fragment-1 #help-block-code").css('color','#a0a0a0');
					}
				}
			});
		});

		//alias tự động

		$("#fragment-1 #name").keyup(function(){
			var name = $(this).val();
			
			$.ajax({url: "index.php?module=products&view=products&task=ajax_convert_alias&raw=1",
				data: {name: name},
				dataType: "text",
				success: function(data) {
					$("#fragment-1 #alias").val(data);
				}
			});
		});


		//show danh mục phụ

		$("#category_id_wrapper").change(function(){
			var category_id_wrapper_sl='';
			$('#category_id_wrapper :selected').each(function(){
		    	category_id_wrapper_sl += $(this).attr('data_name') + ', ';
		    });

		    $('#category_id_wrapper_select').html(category_id_wrapper_sl);
		   
			// console.log(category_id_wrapper_sl);
		});

		

	});
</script>


<script  type="text/javascript" language="javascript">

	

	limit_charactor($('#name'),75,1);
	$('#name').keyup(function(){
		limit_charactor($(this),75,1);
	});
	// SEO
	limit_charactor($('#seo_title'),60,1);
	$('#seo_title').keyup(function(){
		
		limit_charactor($(this),60,1);
	});
	$('#seo_title').change(function(){
		limit_charactor($(this),60,1);
	});
	
	limit_charactor($('#seo_keyword'),160,1);
	$('#seo_keyword').keyup(function(){
		limit_charactor($(this),160,1);
	});
	$('#seo_keyword').change(function(){
		limit_charactor($(this),160,1);
	});	
	
	limit_charactor($('#seo_description'),165,1);
	$('#seo_description').keyup(function(){
		limit_charactor($(this),165,1);
	});
	$('#seo_description').change(function(){
		limit_charactor($(this),165,1);
	});

	function limit_charactor(element,limit,require){
		var length_ch = element.val().length;
		element.next('.count_character').remove();
		if(require == 1){
			if(length_ch > limit){
				var str = element.val();
				// element.val(str.substr(0, limit));
				element.after('<span class="count_character">Số kí tự đã vượt quá giới hạn '+length_ch+'/'+limit+'<br/></span>');
				element.css('border','1px solid red');
			}else{
				element.after('<span class="count_character">Số kí tự '+length_ch+'/'+limit+'<br/></span>');
				
			}
		}else{
			element.after('<span class="count_character">Số kí tự '+length_ch+'/'+limit+'<br/></span>');
			
		}
	}



	$(function(){
		$("select#manufactory").change(function(){
			$.ajax({url: "index.php?module=products&view=products&task=ajax_get_product_models&raw=1",
				data: {cid: $(this).val()},
				dataType: "text",
				success: function(text) {
					j = eval("(" + text + ")");
					var options = '';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
					}
					$("#model").html(options);
					$('#model option:first').attr('selected', 'selected');
				}
			});
		});


		$("select#categories_filter").change(function(){
			
			var cat_ft_id = $(this).val();
			var cat_ft_str = ","+cat_ft_id+",";
			// alert(cat_ft_id);
			
			$( ".cate_option" ).removeClass('hidden');
			$( ".cate_option" ).each(function(index) {
			   var parent = $(this).attr('data_parents') ;
			   var has_string = parent.indexOf(cat_ft_str);
			  	if(has_string == -1){
			  		$(this).addClass('hidden');
			  	}
			   // console.log(has_string);
			});

			if(!cat_ft_id || cat_ft_id == 0){
				$(".cate_option").removeClass('hidden');
			}
			// $.ajax({url: "index.php?module=products&view=products&task=ajax_getCategories_filter&raw=1",
			// 	data: {cat_ft_id:cat_ft_id},
			// 	cache: false,
			// 	success: function(html) {
			// 		console.log(html);
			// 		// if(html != 1 || html != '1'){
			// 		// 	$("#fragment-2").html(html);
			// 		// }
			// 	}
			// });
		});			
		
	});
</script>

<script  type="text/javascript" language="javascript">
	$(function(){
		$("select#category_id").change(function(){
			var cid_before = $('#cid').val();
			var cid_after = $(this).val();
			var data_id = $('#data_id').val();
			// if(cid_before != cid_after){
				// alert("Bạn đang chuyển danh mục khác bảng nếu Có trường mở rộng thì sẽ bị xóa !");
				// if(confirm('Bạn chắc chắn chuyển danh mục khác bảng, chấp nhận chuyển nếu Có trường mở rộng thì sẽ bị xóa ?')){
					$.ajax({url: "index.php?module=products&view=products&task=ajax_getExtendFields&raw=1",
						data: {cid_before:cid_before,cid_after:cid_after,data_id:data_id},
						cache: false,
						success: function(html) {
							console.log(html);
							if(html != 1 || html != '1'){
								$("#fragment-2").html(html);
							}
						}
					});
				// }else{
				// 	$("select#category_id").load(location.href+" select#category_id>*","");
				// 	$("select#category_id option" ).each(function() {
				//        var vl =  $(this).val();
				//        if(vl == cid_before){
				//        		$(this).attr('selected', 'selected');
				//        }
				//     });
				// }
			// }

					// load lại danh mục
					// $.ajax({url: "index.php?module=products&view=products&task=ajax_getCategoriesTables&raw=1",
					// 	data: {cid_before:cid_before,cid_after:cid_after,data_id:data_id},
					// 	cache: false,
					// 	success: function(html) {
					// 		console.log(html);
					// 		if(html != 1 || html != '1'){
					// 			$("#fragment-2").html(html);
					// 		}
					// 	}
					// });
		});			
	});
</script>



<script  type="text/javascript" language="javascript">
	$(function() {
		$( "#date_end" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
		$( "#date_end").change(function() {
			document.formSearch.submit();
		});
		$( "#date_start" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
		$( "#date_start").change(function() {
			document.formSearch.submit();
		});
		$('.hotdeal_area_close').hide();
		$('#is_hotdeal_0').click(function(){
			$('.hotdeal_area_open').hide();
			$('.hotdeal_area_close').hide();
		});
		$('#is_hotdeal_1').click(function(){
			$('.hotdeal_area_open').show();
			$('.hotdeal_area_close').show();
		});
	});
</script>

<style type="text/css">
	#category_id_wrapper{
		width: 600px;
    	height: 250px;
	}
</style>