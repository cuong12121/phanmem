<table cellspacing="1" class="admintable">
	<?php if(!empty($data)){
		$link = FSRoute::_('index.php?module=news&view=news&code='.$data -> alias.'&ccode='.$data->category_alias.'&id='.$data->id.'&cid='.$data->category_id);
		$link .= '?preview=1';
		?>	
		<div>Link xem trước: <a target="_blank" style="color: blue" href="<?php echo $link; ?>"><?php echo $data->title ?></a></div>
		<br /> 
	<?php } ?>
	<?php
	TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title,'',60,1,0,FSText::_("Không được để trống"));
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_text(FSText :: _('Tên thông số'),'name_core',@$data -> name_core,'',60,1,0);
	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0);
	?>
	<div class="form-group">
		<label class="col-md-2 col-xs-12 control-label">Chú ý:</label>
		<div class="col-md-10 col-xs-12 red">
			Danh mục phụ hệ thống sẽ tự nhận thêm các danh mục cha và danh mục chính.
		</div>
	</div>
	<?php
	$category_id_wrapper = isset($data -> category_id_wrapper)?$data -> category_id_wrapper:0;

	TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục phụ'),'category_id_wrapper',$category_id_wrapper,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,1,1,'Giữ phím ctrl để chọn nhiều danh mục');

	TemplateHelper::dt_edit_selectbox(FSText::_('Tác giả'),'author_id',@$data -> author_id,0,$author,$field_value = 'id', $field_label='name',$size = 1,0,1);
	//TemplateHelper::dt_edit_text(FSText :: _('Tác giả'),'editor',@$data -> editor);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),100,100,'Kích cỡ ảnh: 700x700');

	TemplateHelper::dt_edit_image(FSText :: _('Banner'),'banner',str_replace('/original/','/large/',URL_ROOT.@$data->banner),200,100,'Kích cỡ ảnh: 1920x800');

	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,$array_value = array(1 => 'Có', 0 => 'Không' ),$sub_item = '',$comment ='',$class_col1='col-md-2',$class_col2='col-md-10',$creator_id=@$data -> creator_id);
	TemplateHelper::dt_checkbox(FSText::_('Tin hot'),'is_hot',@$data -> is_hot,1);
	// TemplateHelper::dt_checkbox(FSText::_('Show trang chủ'),'show_in_homepage',@$data -> show_in_homepage,1);



//	$sub_time = TemplateHelper::sub_edit_text('&nbsp;&nbsp;&nbsp;','published_hour',@$data -> published_time?date('H:i',strtotime(@$data -> published_time)):'','','5',1);
//	TemplateHelper::dt_edit_text(FSText :: _('Thời gian Xuất bản'),'published_date',@$data -> published_time?date('d-m-Y',strtotime(@$data -> published_time)):'','','12',1,0,'Nhập dạng <strong>d-m-Y H:i</strong>. Nếu thời gian Xuất bản để trống => Hệ thống sẽ lấy tự động',$sub_time);
//	TemplateHelper::dt_checkbox(FSText::_('Tin nhanh'),'news_fast',@$data -> news_fast,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin tiêu điểm'),'news_focus',@$data -> news_focus,1);
//	TemplateHelper::dt_checkbox(FSText::_('Tin slideshow'),'news_slide',@$data -> news_slide,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
	TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1);
	TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,2,0,FSText::_("Mỗi tag cách nhau bằng dấu phẩy. Ví dụ : Khuyến mãi,Bồn cầu"));

	TemplateHelper::dt_edit_text(FSText :: _('Mã schema'),'schema',@$data -> schema,'',60,6,0);
	
	?>
	<div class="form-group">
		<label class="col-md-2 col-xs-12 control-label">Tags gợi ý:</label>
		<div class="col-md-10 col-xs-12" id='ajax_get_tags'>

		</div>
	</div>
	<?php
	TemplateHelper::dt_sepa();
	TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9);

	?>

	<div class="form-group" id="form_main_keyword">
	<label class="col-md-2 col-xs-12 control-label">Main keyword</label>
	<div class="col-md-10 col-xs-12">
	<input type="text" class="form-control" name="main_keyword" id="main_keyword" value="<?php echo @$data-> main_keyword; ?>" size="60">
	<span class="count_character"></span>
	</div>
	</div> 
	<div class="form-group" id="form_check_keyword">
	<label class="col-md-2 col-xs-12 control-label">Check keyword</label>
	<div class="col-md-10 col-xs-12 list_keyword cls">

	<?php 
	$point_seo = @$data-> point_seo;
	$point_seos = explode(",", $point_seo);

	$main_keyword = @$data-> main_keyword; 
	if($main_keyword) {
		$main_keywords = explode(",", $main_keyword);
		if(!empty($main_keywords)) {
			$i=0;
			foreach ($main_keywords as $keyword) { 
				$class_name = '';
				if(@$point_seos[$i]) {
					if(@$point_seos[$i] >= 80) {
						$class_name  = 'text_success';
					} else if (@$point_seos[$i] >= 50) {
						$class_name  = 'text_warning';
					} else {
						$class_name  = 'text_danger';
					}
				}

				?>
				<span class="item keyword_item <?php if(!$i) echo 'item_active';?> <?php echo $class_name; ?>" id="keyword_<?php echo $i; ?>" data-stt="<?php echo $i; ?>" keyword="<?php echo trim($keyword,' ');?>" onclick="click_keyword_item(<?php echo $i; ?>);"><?php echo trim($keyword,' ');?></span>
				<?php $i++; }
			}
		}?>
	</div>
	<div class="col-md-10 col-xs-12">
		<input type="hidden" class="form-control" name="check_keyword" id="check_keyword" value="<?php echo trim(@$main_keywords[0],' '); ?>" size="60">
		<input type="hidden" id="check_keyword_active" value="0">
	</div>
</div>
<?php
global $path;
include( $path.'/libraries/yoastseo/index.php'); 
?>
<input id="data_id" type="hidden" value="<?php echo isset($data) ? $data->id : 0  ?>">
</table>
<script type="text/javascript" >
	$(function() {
		$( "#published_date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true});
		$( "#published_date").change(function() {
			document.formSearch.submit();
		});
	});
</script>	


<script  type="text/javascript" language="javascript">
	$(function(){
		$("#fragment-1 #title").keyup(function(){
			var name = $(this).val();
			var data_id = $('#data_id').val()
			// alert()
			// console.log(name);
			$.ajax({url: "index.php?module=news&view=news&task=ajax_check_name&raw=1",
				data: {name: name,data_id: data_id},
				dataType: "text",
				success: function(data) {
					// console.log(data);
					if(data == 1){
						$("#fragment-1 #title").css('border','red 1px solid');
						$("#fragment-1 #help-block-title").html('Tiêu đề này đã tồn tại !');
						$("#fragment-1 #help-block-title").css('color','red');
					}else{
						$("#fragment-1 #title").css('border','#ccc 1px solid');
						$("#fragment-1 #help-block-title").html('Tiêu đề này được chấp nhận');
						$("#fragment-1 #help-block-title").css('color','#a0a0a0');
					}
				}
			});
		});

		//gợi ý tags

		$("#fragment-1 #tags").keyup(function(){
			var tags = $(this).val();
			$.ajax({url: "index.php?module=products&view=products&task=ajax_get_tags&raw=1",
				data: {tags: tags},
				dataType: "text",
				success: function(data) {
					if(data){
						$('#ajax_get_tags').html(data);
					}
				}
			});
		});			
		
	});


	function re_news_tags(tags) {
		$("#fragment-1 #tags").val(tags);
	}


	limit_charactor($('#title'),75,0);
	$('#title').keyup(function(){
		limit_charactor($(this),75,0);
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
</script>


<style type="text/css">
#ajax_get_tags .item-tag{
	cursor: pointer;
	background: #ddd;
	padding: 6px;
	margin-right: 8px;
}
</style>