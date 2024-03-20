<table cellspacing="1" class="admintable">
	
<?php
 
TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
$idss= FSInput::get('id');
// TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image));
// if(!$idss){
// 	TemplateHelper::dt_edit_selectbox(FSText::_('Chọn mẫu có sẵn'),'template',@$data -> template,0,$content,$field_value = 'id', $field_label='title',$size = 1,0);
// }
// TemplateHelper::dt_edit_text(FSText :: _('Content'),'content',@$data -> content,'',650,450,1);
// 
// TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục slide(pc)'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0);
// TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục slide(mobile)'),'category_mb_id',@$data -> category_mb_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0);

// TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục hỏi đáp'),'category_aq',@$data -> category_aq,0,$aq_categories,$field_value = 'id', $field_label='name',$size = 1,0);
// TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
// TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
// TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề(trên tóm tắt video)'),'name_videoh2',@$data -> name_videoh2);
// TemplateHelper::dt_edit_text(FSText :: _('Tóm tắt(video liên quan)'),'summary_video',@$data -> summary_video,'',650,450,1);
// TemplateHelper::dt_edit_text(FSText :: _('Tên hiển thị video liên quan'),'name_video',@$data -> name_video);

// TemplateHelper::dt_edit_text(FSText :: _('Model slide(Ko sửa trường này nếu ko biết)'),'name_slide',@$data -> name_slide);


TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9);
TemplateHelper::dt_edit_text(FSText :: _('Schema'),'schema',@$data -> schema,'',100,4);
?>
<?php if(@$data-> id) { ?>
<div><a target="_blank" title="Sửa giao diện" href="/<?php echo LINK_AMIN; ?>/index.php?module=landingpages&view=landingpages&task=edit_grapesjs&raw=1&id=<?php echo $data-> id; ?>">Sửa giao diện</a></div>
<?php } ?>
</table>
