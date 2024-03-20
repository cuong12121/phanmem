<table cellspacing="1" class="admintable">
<?php 

	TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
	// TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	// $sub_time_start = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour_start',@$data -> date_start?date('H:i',strtotime(@$data -> date_start)):'','','5',1);
	// TemplateHelper::dt_edit_text(FSText :: _('Ngày bắt đầu'),'date_start',@$data -> date_start?date('d-m-Y',strtotime(@$data -> date_start)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY HH:mm</strong>.',$sub_time_start);
	// $sub_time_end = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour_end',@$data -> date_end?date('H:i',strtotime(@$data -> date_end)):'','','5',1);
	// TemplateHelper::dt_edit_text(FSText :: _('Ngày hết hạn'),'date_end',@$data -> date_end?date('d-m-Y',strtotime(@$data -> date_end)):'','','12',1,0,'Nhập dạng <strong>dd-mm-YYYY HH:mm</strong>.',$sub_time_end);
	// TemplateHelper::dt_edit_text(FSText :: _('Giá trị % khuyến mại'),'sale',@$data -> sale);
	// TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image));
	?>
	<div class="form-group">
        <label class="col-md-2 col-xs-12 control-label">Danh mục đang chọn:</label>
        <div class="col-md-10 col-xs-12 " id ="category_id_wrapper_select">
        	<?php echo @$category_id_wrapper_select_name; ?>
        </div>
    </div>

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

	$category_id_wrapper = isset($data -> category_id_wrapper)?$data -> category_id_wrapper:0;
	TemplateHelper::dt_edit_selectbox_parent(FSText::_('Danh mục'),'category_id_wrapper',$category_id_wrapper,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,1,1,'Giữ phím ctrl để chọn nhiều danh mục');
	// TemplateHelper::dt_edit_text(FSText :: _('Số tiền từ'),'price_min',@$data -> price_min);
	// TemplateHelper::dt_edit_text(FSText :: _('Số tiền đến'),'price_max',@$data -> price_max);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Độ ưu tiên'),'priority',@$data -> priority,0);
//	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',60,3,0);
	// TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1);
	// TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,2);
	// TemplateHelper::dt_sepa();
	// TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1);
	// TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1);
	// TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9);
?>
</table>

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

		$("select#categories_filter").change(function(){
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
		});

		//show danh mục phụ
		$("#category_id_wrapper").change(function(){
			var category_id_wrapper_sl='';
			$('#category_id_wrapper :selected').each(function(){
		    	category_id_wrapper_sl += $(this).attr('data_name') + ', ';
		    });
		    $('#category_id_wrapper_select').html(category_id_wrapper_sl);
		});	



	});
</script>


<style type="text/css">
	#category_id_wrapper {
	    width: 600px;
	    height: 250px;
	}
</style>