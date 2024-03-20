<table cellspacing="1" class="admintable histornews">
<?php
	$this -> dt_form_begin();
	TemplateHelper::dt_text(FSText :: _('Title'),@$data -> title);
	TemplateHelper::dt_text(FSText :: _('Alias'),@$data -> alias);
	TemplateHelper::dt_text(FSText :: _('Trạng thái'),"<strong>".$arr_status[$data -> status]."</strong>",null,null,0);
	TemplateHelper::dt_text(FSText :: _('Categories'),@$data -> category_name);
	TemplateHelper::dt_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/small/' ,@$data->image));
	TemplateHelper::dt_text(FSText :: _('Summary'),@$data -> summary);
	TemplateHelper::dt_text(FSText :: _('Content'),@$data -> content,null,null,0);
	TemplateHelper::dt_text(FSText :: _('Tags'),@$data -> tags);
	
	TemplateHelper::dt_sepa();
	TemplateHelper::dt_text(FSText :: _('SEO title'),@$data -> seo_title);
	TemplateHelper::dt_text(FSText :: _('SEO meta keyword'),@$data -> seo_keyword);
	TemplateHelper::dt_text(FSText :: _('EO meta description'),@$data -> seo_description);
?>
</table>


<style type="text/css">
	.histornews .label{
		color:#000 !important;
	}
</style>