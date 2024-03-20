<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
		
	
?>

<?php
	TemplateHelper::dt_edit_text(FSText :: _('Subject'),'subject',@$data -> subject);
	TemplateHelper::dt_edit_text(FSText :: _('Message'),'message',@$data -> message,'',650,450,1);
	$this -> dt_form_end(@$data,1,0);
?>




<style type="text/css">
	#send_email_btn a{
		width: 125px;
	    background: #003150;
	    color: #fff !important;
	    height: 40px;
	    line-height: 40px;
	    display: inline-block;
	    text-align: center;
	    font-size: 16px;
	    cursor: pointer;
	}
</style>

<script type="text/javascript">

	function send_email(id){
		$.ajax({url: "index.php?module=members&view=messages&task=send_email&raw=1",
			data: {id:id},
			cache: false,
			type: "POST",
			success: function(html) {
				alert(html);
			}
		});
	}

	$('.check_b_it').click(function(){
		var str_id = ",";
		$(".check_b_it").each(function( index ) {
		    if($(this).prop("checked") == true){
                var id = $(this).val();
                str_id += id + ","; 
            }
		});

		$('#recipients_username_str').val(str_id);
		console.log(str_id);
	});
</script>