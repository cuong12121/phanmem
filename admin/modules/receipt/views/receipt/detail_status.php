<table cellspacing="1" class="admintable">
    <?php
    TemplateHelper::dt_edit_text(FSText :: _('Màn hình hiển thị'),'status1',@$data -> status1,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Mặt kính / Cảm ứng'),'status2',@$data -> status2,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Wifi / Bluetooth / NFC / GPS'),'status3',@$data -> status3,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Sóng 2G / 3G'),'status4',@$data -> status4,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Bộ nhớ trong / Thẻ nhớ'),'status5',@$data -> status5,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Camera / Đèn Flash'),'status6',@$data -> status6,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Loa / Mic / Rung'),'status7',@$data -> status7,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Cảm biến tiệm cận / Xoay'),'status8',@$data -> status8,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Cảm biến vân tay (IP/SS)'),'status9',@$data -> status9,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Các phím cứng'),'status10',@$data -> status10,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Hình thức'),'status11',@$data -> status11,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Nội dung khác'),'status12',@$data -> status12,'Bình thường');
    TemplateHelper::dt_edit_text(FSText :: _('Tk iCloud (Apple)'),'status13',@$data -> status13);
    TemplateHelper::dt_edit_text(FSText :: _('Mật khẩu máy'),'status14',@$data -> status14);
    ?>
</table>
