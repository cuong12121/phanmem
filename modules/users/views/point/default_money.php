<script src="<?php echo URL_ROOT.'libraries/jquery/thickbox/thickbox.js'; ?>" type="text/javascript" language="javascript" ></script>
<link rel="stylesheet" href="<?php  echo URL_ROOT.'libraries/jquery/thickbox/thickbox.css';?>" />
<div class="view-point-member">
	<div>Số tiền đã giao dịch của bạn: <strong class='red'><?php echo $data -> money?format_money($data -> money):'0 VNĐ'; ?></strong></div>
	<div>Hạng thành viên: <strong class='red'><?php echo isset($arr_level[$data -> level])? $arr_level[$data -> level] -> name : 'Thành viên thường'; ?></strong></div>
	<?php if($data -> level < 2){?>
		<?php $level = $data -> level; ?> 
		<?php if($data -> point < $arr_level[$level + 1] -> point){?>
			<div>Số tiền cần thiết để bạn lên hạng tiếp theo: <strong class='red'><?php echo format_money(($arr_level[$level + 1] -> money) - ($data -> money)). ' VNĐ'; ?></strong></div>
		<?php } else {?>
			<div>Bạn đã đạt điểm cần thiết để lên hạng. Hãy liên hệ với Ban quản trị website để yêu cầu</div>
		<?php }?>
	<?php }?>
	<a class="thickbox" href='<?php echo FSRoute::_('index.php?module=users&view=point&task=policy&raw=1');?>' target="_blank" >Tìm hiểu về chính sách điểm, quyền lợi của thành viên Nhà sách Hương Thủy</a>
</div>