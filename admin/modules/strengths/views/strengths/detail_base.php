<table cellspacing="1" class="admintable">


<?php


	TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
	TemplateHelper::dt_edit_text(FSText :: _('Title2'),'title2',@$data -> title2); 
	TemplateHelper::dt_edit_text(FSText :: _('Icon (SVG)'),'icon',@$data -> icon);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),150,150,'');
	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0);
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Link'),'link',@$data -> link);

?>
	<!-- <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label">Danh mục đang chọn:</label>
        <div class="col-md-10 col-xs-12 " id ="category_id_wrapper_select">
        	<?php //echo @$category_id_wrapper_select_name; ?>
        </div>
    </div>

	<div class="form-group">
		<label class="col-md-2 col-xs-12 control-label">Lọc danh mục</label>
		<div class="col-md-10 col-xs-12">
			<select data-placeholder="Lọc danh mục" class="form-control " name="" id="categories_filter">
				<option value="0" selected="selected">--Lọc danh mục--</option>
				<?php //foreach ($categories_filter as $vl): ?>
					<option value="<?php //echo $vl->id ?>"><?php //echo $vl->name ?></option>
				<?php //endforeach ?>
			</select>
		</div>
	</div>
 -->
<?php

// $category_id_wrapper = isset($data -> category_id_wrapper)?$data -> category_id_wrapper:0;
// TemplateHelper::dt_edit_selectbox_parent(FSText::_('Danh mục'),'category_id_wrapper',$category_id_wrapper,0,$categories_product,$field_value = 'id', $field_label='treename',$size = 1,1,1,'Giữ phím ctrl để chọn nhiều danh mục');

TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'summary',@$data -> summary,'',100,5,0);
TemplateHelper::dt_edit_text(FSText :: _('Mô tả ( khi lật)'),'summary_hover',@$data -> summary_hover,'',100,5,0);

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