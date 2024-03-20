<table cellspacing="1" class="admintable">
<?php 

	TemplateHelper::dt_edit_text(FSText :: _('Tên (trả góp)'),'installment_name',@$data -> installment_name);

	TemplateHelper::dt_edit_text(FSText :: _('Mô tả  (trả góp)'),'installment_descripttion',@$data -> installment_descripttion,'',650,450,1);

	TemplateHelper::dt_sepa();
	TemplateHelper::dt_edit_text(FSText :: _('SEO title  (trả góp)'),'installment_seo_title',@$data -> installment_seo_title,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword  (trả góp)'),'installment_seo_keyword',@$data -> installment_seo_keyword,'',100,1);
	TemplateHelper::dt_edit_text(FSText :: _('SEO meta description  (trả góp)'),'installment_seo_description',@$data -> installment_seo_description,'',100,9);
?>
</table>
