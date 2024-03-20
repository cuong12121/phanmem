<?php
TemplateHelper::dt_edit_text(FSText :: _('Khuyến mại (hiển thị trang danh sách)'),'promotion_info',@$data -> promotion_info,'',650,450,1);
TemplateHelper::dt_edit_text(FSText :: _('Khuyến mại (hiển thị trang chi tiết)'),'promotion',@$data -> promotion,'',650,450,1);
TemplateHelper::dt_edit_text(FSText :: _('Khuyến mại không dịch vụ (hiển thị trang chi tiết)'),'promotion2',@$data -> promotion2,'',650,450,1);
TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề khuyến mãi'),'promotion_title',@$data -> promotion_title,'',60,1,0);
TemplateHelper::dt_edit_text(FSText :: _('Chú thích khuyến mãi'),'promotion_note',@$data -> promotion_note,'',60,1,0);

TemplateHelper::dt_edit_text(FSText :: _('Bộ sản phẩm'),'sets',@$data -> sets,'',650,450,1);
TemplateHelper::dt_edit_text(FSText :: _('Bộ sản phẩm không dịch vụ'),'sets2',@$data -> sets2,'',650,450,1);

// TemplateHelper::dt_edit_text(FSText :: _('Bảo hành'),'warranty_info',@$data -> warranty_info,'',650,450,1);
// TemplateHelper::dt_edit_text(FSText :: _('Bảo hành không dịch vụ'),'warranty_info2',@$data -> warranty_info2,'',650,450,1);

// TemplateHelper::dt_edit_text(FSText :: _('Đổi trả'),'change_return',@$data -> change_return,'',650,450,1);
// TemplateHelper::dt_edit_text(FSText :: _('Đổi trả không dịch vụ'),'change_return2',@$data -> change_return2,'',650,450,1);

TemplateHelper::dt_edit_text(FSText :: _('Ưu đãi thêm'),'promotion_more',@$data -> promotion_more,'',650,450,1);
TemplateHelper::dt_edit_text(FSText :: _('Ưu đãi thêm không dịch vụ'),'promotion_more2',@$data -> promotion_more2,'',650,450,1);
TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề ưu đãi thêm'),'promotion_more_note',@$data -> promotion_more_note,'',60,1,0);

TemplateHelper::dt_edit_text(FSText :: _('Xem thêm'),'read_more',@$data -> read_more,'',650,450,1);

?>