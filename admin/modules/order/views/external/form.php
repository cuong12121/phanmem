<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

//  $this -> dt_form_begin();
    
//  TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
// //   TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
//  TemplateHelper::dt_edit_text(FSText :: _('Url'),'link',@$data -> link,'',80,1,0);
//  TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
// //   TemplateHelper::dt_checkbox(FSText::_('Bôi đậm'),'is_bold',@$data -> is_bold,1);
//  TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
//  $this -> dt_form_end(@$data);

?>

<form class="form-horizontal" role="form" action="https://dienmayai.com/admin/tags/tags" name="adminForm" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class=" col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group ">
                        <label class="col-md-2 col-xs-12 control-label">Tên12121</label>
                        <div class="col-md-10 col-xs-12">
                            <input type="text" class="form-control" name="name" id="name" value="" size="60">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-2 col-xs-12 control-label">Url</label>
                        <div class="col-md-10 col-xs-12">
                            <input type="text" class="form-control" name="link" id="link" value="" size="80">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">Kích hoạt</label>
                        <div class="col-md-10 col-xs-12">
                            <input class="radio-custom" type="radio" name="published" value="1" checked="checked" id="published_1">
                            <label for="published_1" class="radio-custom-label">Có&nbsp;&nbsp;</label>
                            <input class="radio-custom" type="radio" name="published" value="0" id="published_0">
                            <label for="published_0" class="radio-custom-label">Không&nbsp;&nbsp;</label>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="col-md-2 col-xs-12 control-label">Thứ tự</label>
                        <div class="col-md-10 col-xs-12">
                            <input type="text" class="form-control" name="ordering" id="ordering" value="" size="20">
                        </div>
                    </div>
                </div>
            </div>
            <!--end: .form-contents-->
        </div>
        <input type="hidden" value="tags" name="module"><input type="hidden" value="tags" name="view"><input type="hidden" value="" name="task"><input type="hidden" value="0" name="boxchecked"><input type="hidden" value="0" name="page"><input type="hidden" value="L2FkbWluL3RhZ3MvdGFncy9hZGQ=" name="return">
    </div>
</form>
        
