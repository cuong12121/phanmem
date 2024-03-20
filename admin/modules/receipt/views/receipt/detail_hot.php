		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Mua vị trí video trên address'); ?>
				</td>
				<td>
					<input type="radio" name="is_pr" value="1" <?php if(@$data->is_pr) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('Yes'); ?>
					<input type="radio" name="is_pr" value="0" <?php if(!@$data->is_pr) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Trạng thái'); ?>
				</td>
				<td>
					<?php 
					$current_time = date("Y-m-d H:i:s");
					if(!@$data -> is_pr){
						$status = 'Chưa từng mua vị trí video trên address';	
						$class = 'never';	
					}else if(@$data -> pr_started_time > $current_time){
						$status = 'Đang đợi';	
						$class = 'pedding';
					} else if(@$data -> pr_expired_time < $current_time){
						$status = 'Hết hạn';
						$class = 'expire';
					} else {
						$status = 'Đang quảng cáo';
						$class = 'activated';
					}
					?>
					<strong class='red <?php echo $class?>'>
						<?php echo $status; ?>
					</strong>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Thời gian bắt đầu quảng cáo'); ?>
				</td>
				<td>
					<?php $pr_started_time = isset($data->pr_started_time)?strtotime($data->pr_started_time):time();?>
					Giờ <input type="text" name='pr_started_hour' id='pr_started_hour' value="<?php echo date('H',$pr_started_time); ?>"/>
					Phút <input type="text" name='pr_started_minute' id='pr_started_minute' value="<?php echo date('i',$pr_started_time); ?>"/>
					&nbsp;&nbsp;Ngày <input type="text" name='pr_started_time1' id='pr_started_time1' value="<?php echo date('m/d/Y',$pr_started_time); ?>"/>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Thời gian kết thúc quảng cáo'); ?>
				</td>
				<td>
					<?php $pr_expired_time = isset($data->pr_expired_time)?strtotime($data->pr_expired_time):time();?>
					Giờ <input type="text" name='pr_expired_hour' id='pr_expired_hour' value="<?php echo date('H',$pr_expired_time); ?>"/>
					Phút <input type="text" name='pr_expired_minute' id='pr_expired_minute' value="<?php echo date('i',$pr_expired_time); ?>"/>
					&nbsp;&nbsp;Ngày <input type="text" name='pr_expired_time1' id='pr_expired_time1' value="<?php echo date('m/d/Y',$pr_expired_time); ?>"/>
				</td>
			</tr>
		</table>
<script>
	$(function() {
		$( "#pr_started_time1" ).datepicker({clickInput:true});
		$( "#pr_started_time1").change(function() {
			document.formSearch.submit();
		});
		$( "#pr_expired_time1" ).datepicker({clickInput:true});
		$( "#pr_expired_time1").change(function() {
			document.formSearch.submit();
		});
	});
</script>