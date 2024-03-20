
    <input type="hidden" id="warehouses_id" name="warehouses_id" value="<?php echo @$warehouses -> id; ?>">
    <?php 

    TemplateHelper::dt_notedit_text(FSText :: _('Kho hàng'),'warehouses_name',@$warehouses -> name);
    TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    TemplateHelper::dt_edit_text(FSText :: _('Mã'),'code',@$data -> code);
    TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);
?>

