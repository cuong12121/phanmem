<?php 
global $tmpl;
$tmpl -> addScript('form');
?>
<?php $fsform = FSFactory::getClass('fsform','form'); ?>

<div class="form_user_body">
	
	<div class="form_user_body_inner">
	
		<!--		FORM MAIN - MESSAGE						-->
		<div class='email-head'>
			<div class='email-head-left'>
				<p class='email-subject'><strong><?php echo $data -> subject; ?></strong></p>
				<p class='email-sender'> Ng&#432;&#7901;i g&#7917;i: 
					<?php
						$senderid = str_replace("'","",$data -> sender_id);
						if(!@$arr_fullname[$senderid])
							echo "Kh&#244;ng bi&#7871;t";
						else 
							echo @$arr_fullname[$senderid];
						?>
				</p>
				<p class='email-recipient'> Ng&#432;&#7901;i nh&#7853;n: 
					<?php
						$str_recipients = $data ->recipients_id;
						$str_recipients = str_replace("'","",$str_recipients);
						$arr_recipients  = explode(",",$str_recipients);
						if(count($arr_recipients))
						{
							foreach ($arr_recipients as $recipient) {
								if(!@$arr_fullname[$recipient])
									echo "Kh&#244;ng bi&#7871;t";
								else 
									echo @$arr_fullname[$recipient];
							}
						}
					?>
				</p>
			</div>
			<div class='email-head-right'>
				<p class='created_time'><?php echo show_datetime($data -> created_time); ?></p>
				
			</div>
		</div>
		<div class='email-body'>
			<div class='email-body-inner'>
				<?php echo $data -> message; ?>
			</div>
		</div>
		<!--		end FORM MAIN - MESSAGE						-->
		
	</div>
</div>
							
