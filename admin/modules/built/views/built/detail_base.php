
<?php
TemplateHelper::dt_edit_text(FSText :: _('Tên'),'name',@$data -> name,'',80,1,0);
// TemplateHelper::dt_edit_text(FSText :: _('Kính gửi'),'sender_title',@$data -> sender_title,'',80,1,0);
// TemplateHelper::dt_edit_text(FSText :: _('Người liên hệ'),'sender_name',@$data -> sender_name,'',80,1,0);
// TemplateHelper::dt_edit_text(FSText :: _('Số điện thoại'),'sender_telephone',@$data -> sender_telephone,'',80,1,0);
// TemplateHelper::dt_edit_text(FSText :: _('Email'),'sender_email',@$data -> sender_email,'',80,1,0);
// TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ'),'sender_address',@$data -> sender_address,'',80,1,0);
?>


<script>
	$(function() {
		$( "#delivery_date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});

		$('#earliest_time').timepicker({
			timeFormat: 'h:mm p',
			interval: 60,
			minTime: '24',
			maxTime: '23:00pm',
			// defaultTime: '07',
			startTime: '00:00',
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});

		$('#latest_time').timepicker({
			timeFormat: 'h:mm p',
			interval: 60,
			minTime: '24',
			maxTime: '23:00pm',
			// defaultTime: '07',
			startTime: '00:00',
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});
	});


</script>