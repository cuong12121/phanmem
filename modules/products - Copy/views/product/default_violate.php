<div class='violate'>
	<?php if(isset($_COOKIE['user_id'])){?> 
		<a href='javascript:void(0)' class = 'report_violate'>Báo cáo vi phạm</a>
		<div class='violate_area '  style="display: none;">
			<div class='violate_label'><?php echo FSText::_('Hãy cho chúng tôi biết lý do bạn muốn thông báo. Chúng tôi sẽ khắc phục vấn đề này trong thời gian ngắn nhất.'); ?></div>
			<form action="#" method="post" name="violate_form" id='violate_form' class='violate_form'>
				<?php 
					$array_violate = array(2=>'Link hỏng',
											3=>'Có Nội dung khiêu dâm',
											4=>'Có nội dung chính trị, phản động',
											5=>'Spam',
											6=>'Vi phạm bản quyền',
											7=>'Nội dung không đúng tiêu đề.',
											8=>'Spam'
											)
				?>
				<?php foreach($array_violate as $item => $label){?>
					<p><input type="radio" name="violate_type" value="<?php echo $item; ?>"  /> <?php echo $label; ?></p>
				<?php }?>
				<p><input type="radio" name="violate_type" value="1"  id='violate_other' checked="checked" /> Hoặc bạn có thể nhập những lý do khác vào ô bên dưới (100 ký tự):
				</p>
				<textarea id="text" cols="64" rows="5" name="violate_content" id="violate_content" ></textarea>
				<p class='button_area'>
					<input type="submit" id="violate_submitbt" value="Gửi" class="botton" />
					<input type="reset" id="violate_resetbt" value="Làm lại" class="botton" />
					<div class='clear'></div>
				</p>
				<input type="hidden" value="1" name='raw' />
				<input type="hidden" value="products" name='module' />
				<input type="hidden" value="product" name='view' />
				<input type="hidden" value="save_violate" name='task' />
				<input type="hidden" value="<?php echo $data->id; ?>" name='record_id' id='record_id'  />
				<input type="hidden" value="<?php echo $return;?>" name='return'  />
			</form>
		</div>
	<?php }else{ ?>
		<a  href='javascript:void(0)' onclick="javascript: if(confirm('Bạn phải đăng nhập để sử dụng tính năng này. Bạn có muốn đăng nhập không?')){window.location='<?php echo FSRoute::_('index.php?module=users&view=users&task=login'); ?>'}"  class = 'report_violate'>Báo cáo vi phạm</a>
	<?php } ?>
	
</div>